<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->autoRender = false;
        $this->response->cors($this->request)
            ->allowOrigin(['*'])
            ->allowMethods(['GET', 'POST', 'PUT', 'DELETE'])
            ->build();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        if($this->request->is(['GET'])) {
            echo 'index';
        } else if ($this->request->is(['POST'])) {
            $this->add($this->request->data);
        } else if ($this->request->is(['PUT'])) {
            $this->edit($this->request->data);
        } else if ($this->request->is(['DELETE'])) {
            $this->delete($this->request->data);
        }
    }

    /**
     * View method
     * Used to log in users
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        echo "view:";
        echo json_encode($this->request->data);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        echo 'add';
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        echo 'edit:';
        echo json_encode($this->request->data);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        echo 'delete:';
        echo json_encode($this->request->data);
    }
}
