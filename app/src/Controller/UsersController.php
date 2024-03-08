<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Security;
use Cake\View\JsonView;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->request->allowMethod(['post']);

        $user = $this->Users->newEntity($this->request->getData());
        if ($this->Users->save($user)) {
            $this->set(
                [
                    'success' => true,
                    'data' => $user->toArray(),
                ]
            );
        } else {
            $this->set(
                [
                    'success' => false,
                    'errors' => $user->getErrors(),
                ]
            );
        }
        $this->viewBuilder()->setOption('serialize', ['success', 'data', 'errors']);
    }

    /**
     *
     */
    public function login()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $userIdentity = $this->Authentication->getIdentity();

            $user = $userIdentity->getOriginalData();
            $user->token = $this->generateToken();
            $user = $this->Users->save($user);
            $user = $this->Users->get($user->id);

            $this->set(compact('user'));
            $this->viewBuilder()->setOption('serialize', ['user']);
        } else {
            throw new NotFoundException(__('User not found'));
        }
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function logout()
    {
        // $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $userIdentity = $this->Authentication->getIdentity();

            $user = $userIdentity->getOriginalData();
            $user->token = null;
            $user = $this->Users->save($user);

            $message = 'Logout';
            $this->set(compact('message'));
            $this->viewBuilder()->setOption('serialize', ['message']);
        }
    }

    /**
     * @param int $length
     * @return array|string|string[]|null
     */
    private function generateToken(int $length = 36)
    {
        $random = base64_encode(Security::randomBytes($length));
        $cleaned = preg_replace('/[^A-Za-z0-9]/', '', $random);
        return $cleaned;
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @return \Cake\Http\Response|void|null
     */
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['login', 'index']);
    }
}
