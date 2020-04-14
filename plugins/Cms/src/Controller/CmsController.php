<?php
declare(strict_types=1);

namespace Cms\Controller;

use Cms\Controller\AppController;

/**
 * Cms Controller
 *
 *
 * @method \Cms\Model\Entity\Cm[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CmsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $cms = $this->paginate($this->Cms);

        $this->set(compact('cms'));
    }

    /**
     * View method
     *
     * @param string|null $id Cm id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cm = $this->Cms->get($id, [
            'contain' => [],
        ]);

        $this->set('cm', $cm);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cm = $this->Cms->newEmptyEntity();
        if ($this->request->is('post')) {
            $cm = $this->Cms->patchEntity($cm, $this->request->getData());
            if ($this->Cms->save($cm)) {
                $this->Flash->success(__('The cm has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cm could not be saved. Please, try again.'));
        }
        $this->set(compact('cm'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cm id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cm = $this->Cms->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cm = $this->Cms->patchEntity($cm, $this->request->getData());
            if ($this->Cms->save($cm)) {
                $this->Flash->success(__('The cm has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cm could not be saved. Please, try again.'));
        }
        $this->set(compact('cm'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cm id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cm = $this->Cms->get($id);
        if ($this->Cms->delete($cm)) {
            $this->Flash->success(__('The cm has been deleted.'));
        } else {
            $this->Flash->error(__('The cm could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
