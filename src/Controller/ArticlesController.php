<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 *
 * @method \App\Model\Entity\Article[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ArticlesController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
		$this->Authorization->skipAuthorization();
		$search = $this->Articles->newEmptyEntity();
		
		if($this->request->is('get')) {
			$title = '%'.$this->request->getQuery('title').'%';
			if(!empty($title)) {
				$articles = $this->paginate($this->Articles
													->find()
													->where(['Articles.published'])
													->where(['Articles.title LIKE' => $title])
													->contain(['Users'])
													->order(['Articles.created' => 'DESC']) );
			} else {
				$articles = $this->paginate($this->Articles
											->find()
											->where(['Articles.published'])
											->contain(['Users'])
											->order(['Articles.created' => 'DESC']) );
			}
		} else {
			$articles = $this->paginate($this->Articles
											->find()
											->where(['Articles.published'])
											->contain(['Users'])
											->order(['Articles.created' => 'DESC']) );
		}
        
		
        $this->set(compact('articles', 'search'));
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($addr = null) {
		$this->Authorization->skipAuthorization();
		$id = $this->Articles->findByAddr($addr)->firstOrFail()->id;
        $article = $this->Articles->get($id, ['contain' => ['Users', 'Tags', 'Comments', 'Comments.Users', 'Pics']]);
		
		$article->views = $article->views + 1;
		$this->Articles->save($article);
		
		$this->set(compact('article'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $article = $this->Articles->newEmptyEntity();
		$this->Authorization->authorize($article);
		
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->getData());
			$article->user_id = $this->request->getAttribute('identity')->getIdentifier();
			
			if($this->request->getData('attachment')->getSize() > 0) {
				$article->pic = $this->request->getData('attachment');
			}
			
			if ($this->Articles->save($article)) {
                $this->Flash->success(__('Salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
			
			$this->Flash->error(__('Erro ao salvar, tente novamente.'));
        }
		
        #$users = $this->Articles->Users->find('list', ['limit' => 200]);
        $tags = $this->Articles->Tags->find('list', ['limit' => 200]);
        $this->set(compact('article', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function edit($addr = null) {
        $id = $this->Articles->findByAddr($addr)->firstOrFail()->id;
        $article = $this->Articles->get($id, ['contain' => ['Tags']]);
		$this->Authorization->authorize($article);
		
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData(), ['accessibleFields' => ['user_id' => false]]);
			
			if($this->request->getData('attachment')->getSize() > 0) {
				$article->pic = $this->request->getData('attachment');
			}
			
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
			
            $this->Flash->error(__('Erro ao salvar, tente novamente.'));
        }
		
        #$users = $this->Articles->Users->find('list', ['limit' => 200]);
        $tags = $this->Articles->Tags->find('list', ['limit' => 200]);
        $this->set(compact('article', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
		$this->Authorization->authorize($article);
		
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('Apagado com sucesso.'));
        } else {
            $this->Flash->error(__('Erro ao apagar, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function tagged(...$tags) {
		$this->Authorization->skipAuthorization();
		if (!empty($tags)) {
			$articles = $this->paginate($this->Articles
												->find('tagged', ['tags' => $tags])
												->where(['Articles.published'])
												->order(['Articles.created' => 'DESC']) );
			$tag = end($tags);
		} else {
			$articles = NULL;
			$tag = NULL;
		}
		
		$this->set(compact('articles', 'tag'));
	}
	
	public function comment($addr = null) {
		$this->Authorization->skipAuthorization();
		$article = $this->Articles->findByAddr($addr)->firstOrFail();
		$comment = $this->Articles->Comments->newEmptyEntity();
		
        if ($this->request->is('post')) {
            $comment = $this->Articles->Comments->patchEntity($comment, $this->request->getData());
			
			if($this->request->getAttribute('identity') <> null) {
				$comment->user_id = $this->request->getAttribute('identity')->getIdentifier();
			}
			
			if($article->published) {
				$comment->article_id = $article->id;
				
				if ($this->Articles->Comments->save($comment) AND $article->published) {
					$this->Flash->success(__('Salvo com sucesso.'));
					return $this->redirect(['action' => 'index']);
				}
			}
			
			$this->Flash->error(__('Erro ao salvar, tente novamente.'));
			stackTrace();
        }
		
        #$articles = $this->Articles->find('list');
        #$users = $this->Articles->Users->find('list');
        $this->set(compact('comment'));
	}
	
	public function beforeFilter(\Cake\Event\EventInterface $event) {
		parent::beforeFilter($event);
		// Configure the login action to not require authentication, preventing
		// the infinite redirect loop issue
		$this->Authentication->addUnauthenticatedActions(['index', 'view', 'tagged', 'comment']);
	}
	
}
