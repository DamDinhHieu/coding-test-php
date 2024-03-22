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

    public function flow($following_id){
        $user = $this->Authentication->getIdentity();

        //check exist flow
        $flowed = $this->Users->FlowUsers->find('all')->where(['follower_id' => $user->id, 'following_id' => $following_id,])->first();

        if($flowed){
            $message = 'You flowed this account before.';
            $this->set('message', $message);
            $this->viewBuilder()->setOption('serialize', ['message']);
            return;
        }

        // flow account
        $flow = $this->Users->FlowUsers->newEntity(['follower_id' => $user->id, 'following_id' => $following_id,]);
        $this->Users->FlowUsers->save($flow);
        $message = 'You have flowed this account successfully.';
        $this->set('message', $message);
        $this->viewBuilder()->setOption('serialize', ['message']);

    }

    public function removefl($following_id){
        $user = $this->Authentication->getIdentity();

        //check exist flow
        $flowed = $this->Users->FlowUsers->find('all')->where(['follower_id' => $user->id, 'following_id' => $following_id,])->first();

        if($flowed){
            $this->Users->FlowUsers->delete($flowed);
            $message = 'You have successfully unfollowed this account.';
        } else {
            $message = 'You do not follow this account yet.';
        }
        $this->set('message', $message);
        $this->viewBuilder()->setOption('serialize', ['message']);
    }

    public function listfl(){
        $user = $this->Authentication->getIdentity();

        $list = $this->Users->FlowUsers->find('all')->where(['following_id' => $user->id,])->all();

        $this->set(compact('list'));
        $this->viewBuilder()->setOption('serialize', ['list']);
    }
}
