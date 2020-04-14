<?php
declare(strict_types=1);

namespace Cms\Controller;

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
		$article = $this->Articles->newEmptyEntity();
		$this->Authorization->authorize($article);
		$search = $this->Articles->newEmptyEntity();
		
		if($this->request->is('get')) {
			$title = '%'.$this->request->getQuery('title').'%';
			$published = $this->request->getQuery('published');
			if(!empty($title) AND $published <> null) {
				$articles = $this->paginate($this->Articles
													->find()
													->where(['Articles.published' => $published])
													->where(['Articles.title LIKE' => $title])
													->contain(['Users'])
													->order(['Articles.created' => 'DESC']) );
			} else {
				$articles = $this->paginate($this->Articles
											->find()
											->contain(['Users'])
											->order(['Articles.created' => 'DESC']) );
			}
		} else {
			$articles = $this->paginate($this->Articles
												->find()
												->contain('Users')
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
    public function view($id = null) {
		$article = $this->Articles->newEmptyEntity();
		$this->Authorization->authorize($article);
		
        $article = $this->Articles->get($id, [
            'contain' => ['Users', 'Tags', 'Comments', 'Comments.Users', 'Pics'],
        ]);
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

                return $this->redirect(['action' => 'view', $article->id]);
            }
            $this->Flash->error(__('Erro ao salvar, tente novamente.'));
        }
        #$users = $this->Articles->Users->find('list');
        $tags = $this->Articles->Tags->find('list');
        $this->set(compact('article', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
		$article = $this->Articles->newEmptyEntity();
		$this->Authorization->authorize($article);
		
        $article = $this->Articles->get($id, ['contain' => ['Tags']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->getData(), ['accessibleFields' => ['user_id' => false]]);
			
			if($this->request->getData('attachment')->getSize() > 0) {
				$article->pic = $this->request->getData('attachment');
			};
			
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('Salvo com sucesso.'));

                return $this->redirect(['action' => 'view', $article->id]);
            }
            $this->Flash->error(__('Erro ao salvar, tente novamente.'));
        }
        $users = $this->Articles->Users->find('list');
        $tags = $this->Articles->Tags->find('list');
        $this->set(compact('article', 'users', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
		$article = $this->Articles->newEmptyEntity();
		$this->Authorization->authorize($article);
		
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('Apagado com sucesso.'));
        } else {
            $this->Flash->error(__('Erro ao apagar, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	
	public function export() {
		$article = $this->Articles->newEmptyEntity();
		$this->Authorization->authorize($article)
		;
		$this->response->download("artigos.csv");
		$data = $this->Articles->find();
		$this->set(compact('data'));
		$this->layout = 'ajax';
		return;
	}

}
