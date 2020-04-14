<?php
declare(strict_types=1);

namespace Cms\Controller;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 *
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommentsController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
		$search = $this->Comments->newEmptyEntity();
		$this->Authorization->authorize($search);
		$this->paginate = ['contain' => ['Articles', 'Users']];
		
		if($this->request->is('get')) {
			$published = $this->request->getQuery('published');
			
			if($published <> null) {
				$comments = $this->paginate($this->Comments
													->find()
													->where(['Comments.published' => $published])
													->order(['Comments.created' => 'DESC']) );
			} else {
				$comments = $this->paginate($this->Comments);
			}
		} else {
			$comments = $this->paginate($this->Comments);
        }

        $this->set(compact('comments', 'search'));
    }

    /**
     * View method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
		$comment = $this->Comments->newEmptyEntity();
		$this->Authorization->authorize($comment);
		
        $comment = $this->Comments->get($id, [
            'contain' => ['Articles', 'Users'],
        ]);

        $this->set('comment', $comment);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($article = null) {
		$comment = $this->Comments->newEmptyEntity();
		$this->Authorization->authorize($comment);
		
        if ($this->request->is('post')) {
            $comment = $this->Comments->patchEntity($comment, $this->request->getData());
			$comment->user_id = $this->request->getAttribute('identity')->getIdentifier();
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('Salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar, tente novamente.'));
        }
        $articles = $this->Comments->Articles->find('list');
        $users = $this->Comments->Users->find('list');
        $this->set(compact('comment', 'article', 'articles', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
		$comment = $this->Comments->newEmptyEntity();
		$this->Authorization->authorize($comment);
		
        $comment = $this->Comments->get($id, ['contain' => [],]);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
			$comment = $this->Comments->patchEntity($comment, $this->request->getData(), ['accessibleFields' => ['user_id' => false]]);
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('Salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar, tente novamente.'));
        }
        $articles = $this->Comments->Articles->find('list', ['limit' => 200]);
        $users = $this->Comments->Users->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'articles', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
		$comment = $this->Comments->newEmptyEntity();
		$this->Authorization->authorize($comment);
		
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__('Apagado com sucesso.'));
        } else {
			$this->Flash->error(__('Erro ao apagar, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function filter(...$filter) {
		$comment = $this->Comments->newEmptyEntity();
		$this->Authorization->authorize($comment);
		
		if (!empty($filter)) {
			$filter = end($filter);
			$comments = $this->paginate($this->Comments
												->find()
												->where(['Comments.published' => $filter])
												->contain('Articles', 'Users')
												->order(['Comments.created' => 'DESC']));
		} else {
			$comments = $this->paginate($this->Comments->find()->contain('Users'));
		}
		
		$this->set(compact('comments'));
	}
	
	public function statusChange($id = null, $status = null) {
		$comment = $this->Comments->newEmptyEntity();
		$this->Authorization->authorize($comment);
		
        $comment = $this->Comments->get($id);
		$comment->published = $status;
		
		if ($this->Comments->save($comment)) {
            $this->Flash->success(__('Salvo com sucesso.'));
        } else {
            $this->Flash->error(__('Erro ao salvar, tente novamente.'));
		}
		
		return $this->redirect(['action' => 'index']);
    }
}
