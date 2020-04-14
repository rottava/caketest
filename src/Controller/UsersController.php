<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
		$this->Authorization->skipAuthorization();
		
		if ($this->request->getAttribute('identity') <> null) {
			$id = $this->request->getAttribute('identity')->getIdentifier();
		} else {
			$id = null;
		}
		
		if(isset($uid)) {
			return $this->redirect(['action' => 'view', $id]);
		} else {
			return $this->redirect(['action' => 'login']);
		}
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
		$this->Authorization->skipAuthorization();
		
		if ($this->request->getAttribute('identity') <> null) {
			$uid = $this->request->getAttribute('identity')->getIdentifier();
		} else {
			$uid = -1;
		}
		
		if($id == $uid) {
			$user = $this->Users->get($id, ['contain' => ['Articles']]);
		} else {
			$user = $this->Users->get($id, ['contain' => ['Articles']]);
			$articles = null;
			
			foreach($user->articles as $article) {
				if($article->published) {
					$articles[] = $article;
				}
			}
			
			$user->articles = $articles;
		}
        
        $this->set(compact('user', 'uid'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit() {
		$this->Authorization->skipAuthorization();
		
		$id = $this->request->getAttribute('identity')->getIdentifier();
		if(isset($id)) {
			$user = $this->Users->get($id, ['contain' => []]);
			
			if ($this->request->is(['patch', 'post', 'put'])) {
				$user = $this->Users->patchEntity($user, $this->request->getData());
				
				if ($this->Users->save($user)) {
					$this->Flash->success(__('Salvo com sucesso.'));
					return $this->redirect(['action' => 'index']);
				}
				
				$this->Flash->error(__('Erro ao salvar, tente novamente.'));
			}
			
			$this->set(compact('user'));;
		} else {
			return $this->redirect(['action' => 'login']);
		}
    }
	
	public function beforeFilter(\Cake\Event\EventInterface $event) {
		parent::beforeFilter($event);
		// Configure the login action to not require authentication, preventing
		// the infinite redirect loop issue
		$this->Authentication->addUnauthenticatedActions(['login', 'view', 'index']);
	}

	public function login() {
		$this->Authorization->skipAuthorization();
		$this->request->allowMethod(['get', 'post']);
		$result = $this->Authentication->getResult();
		// regardless of POST or GET, redirect if user is logged in
		if ($result->isValid()) {
			// redirect to /articles after login success
			if ($this->request->getAttribute('identity')->get('level')) {
				$redirect = $this->request->getQuery('redirect', '/cms/articles');
			} else {
				$redirect = $this->request->getQuery('redirect', ['controller' => 'Articles', 'action' => 'index']);
			}
			return $this->redirect($redirect);
		}
		// display error if user submitted and authentication failed
		if ($this->request->is('post') && !$result->isValid()) {
			$this->Flash->error(__('Combinaçao inválida, tente novamente.'));
		}
	}
	
	public function logout() {
		$this->Authorization->skipAuthorization();
		$result = $this->Authentication->getResult();
		// regardless of POST or GET, redirect if user is logged in
		if ($result->isValid()) {
			$this->Authentication->logout();
			return $this->redirect(['controller' => 'Users', 'action' => 'login']);
		}
	}
}
