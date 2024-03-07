<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\View\JsonView;
use Cake\Http\Exception\UnauthorizedException;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'Users' => function ($q) {
                    return $q
                        ->select(['Users.email']);
                }
            ],
        ];
        $articles = $this->paginate($this->Articles);

        $this->set(compact('articles'));
        $this->viewBuilder()->setOption('serialize', ['articles']);
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => [
                'Users' => function ($q) {
                    return $q
                        ->select(['Users.email']);
                },
            ],
        ]);

        $this->set(compact('article'));
        $this->viewBuilder()->setOption('serialize', ['article']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);
        $article = $this->Articles->newEntity($this->request->getData());
        $article->user_id = $this->request->getAttribute('identity')->getIdentifier();

        if ($this->Articles->save($article)) {
            $this->set(
                [
                    'success' => true,
                    'data' => $article->toArray(),
                ]
            );
        } else {
            $this->set(
                [
                    'success' => false,
                    'errors' => $article->getErrors(),
                ]
            );
        }
        $this->viewBuilder()->setOption('serialize', ['success', 'data', 'errors']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->request->allowMethod(['patch', 'put']);

        $article = $this->Articles->get($id);
        $user = $this->Authentication->getIdentity();

        if ($user->id !== $article->user_id) {
            throw new UnauthorizedException(__('Unauthorized. You have no permission'));
        }

        $article = $this->Articles->patchEntity(
            $article,
            $this->request->getData(),
            [
                'accessibleFields' => ['user_id' => false]
            ]
        );
        if ($this->Articles->save($article)) {
            $this->set(
                [
                    'success' => true,
                    'data' => $article->toArray(),
                ]
            );
        } else {
            $this->set(
                [
                    'success' => false,
                    'errors' => $article->getErrors(),
                ]
            );
        }
        $this->viewBuilder()->setOption('serialize', ['success', 'data', 'errors']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['delete']);
        $user = $this->Authentication->getIdentity();

        $article = $this->Articles->get($id);
        if ($user->id !== $article->user_id) {
            throw new UnauthorizedException(__('Unauthorized. You have not permission'));
        }

        $message = 'Deleted article successfully';
        if (!$this->Articles->delete($article)) {
            $message = 'Error when delete article';
        }
        $this->set('message', $message);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['index', 'view']);
    }
}
