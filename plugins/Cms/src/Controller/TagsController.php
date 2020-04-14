<?php
declare(strict_types=1);

namespace Cms\Controller;

/**
 * Tags Controller
 *
 * @property \App\Model\Table\TagsTable $Tags
 *
 * @method \App\Model\Entity\Tag[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TagsController extends AppController {
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
		$tag = $this->Tags->newEmptyEntity();
		$this->Authorization->authorize($tag);;
		
        $tags = $this->paginate($this->Tags->find()->contain('Articles'));
        $this->set(compact('tags'));
    }

    /**
     * View method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
		$tag = $this->Tags->newEmptyEntity();
		$this->Authorization->authorize($tag);
		
        $tag = $this->Tags->get($id, [
            'contain' => ['Articles', 'Articles.Users'],
        ]);
		
        $this->set('tag', $tag);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $tag = $this->Tags->newEmptyEntity();
		$this->Authorization->authorize($tag);;
		
        if ($this->request->is('post')) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
                $this->Flash->success(__('Salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar, tente novamente.'));
        }
        $articles = $this->Tags->Articles->find('list', ['limit' => 200]);
        $this->set(compact('tag', 'articles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
		$tag = $this->Tags->newEmptyEntity();
		$this->Authorization->authorize($tag);
		
        $tag = $this->Tags->get($id, ['contain' => ['Articles'],]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tag = $this->Tags->patchEntity($tag, $this->request->getData());
            if ($this->Tags->save($tag)) {
				$this->Flash->success(__('Salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Erro ao salvar, tente novamente.'));
        }
        $articles = $this->Tags->Articles->find('list', ['limit' => 200]);
        $this->set(compact('tag', 'articles'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tag id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
		$tag = $this->Tags->newEmptyEntity();
		$this->Authorization->authorize($tag);
		
        $this->request->allowMethod(['post', 'delete']);
        $tag = $this->Tags->get($id);
        if ($this->Tags->delete($tag)) {
            $this->Flash->success(__('Apagado com sucesso.'));
        } else {
            $this->Flash->error(__('Erro ao apagar, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
