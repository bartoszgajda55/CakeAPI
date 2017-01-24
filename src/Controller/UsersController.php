<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;
use Firebase\JWT\JWT;

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
            ->allowHeaders(['Content-Type'])
            ->build();
        $this->Auth->allow(['register', 'token']);
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        echo 'index';
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
     * Register method
     *
     * @return \Cake\Network\Response|null
     */
    public function register()
    {
        $data = $this->request->data;
        $result = $this->Users->createUser($data);
        if ($result[0]) {
            $this->response->body(json_encode([
                'success' => 'true',
                'id' => $result[1],
                'token' => JWT::encode(
                    [
                        'sub' => $result[1],
                        'exp' => time() + 604800
                    ],
                    Security::salt()
                )
            ]));
            $this->response->statusCode(201);
            $this->response->type('application/json');
        } else {
            $this->response->body(json_encode([
                'success' => 'false'
            ]));
            $this->response->statusCode(400);
            $this->response->type('application/json');
        }
        $this->response->send();
    }

    /**
     * Token method
     *
     * @return \Cake\Network\Response|null Returns JWT token if logged successfully
     */
    public function token()
    {
        echo 'token';
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $this->request->data;
        if ($this->Users->logIn($data)) {
            $this->response->body(json_encode(['status' => 'logged']));
            $this->response->statusCode(200);
            $this->response->type('application/json');
        } else {
            $this->response->body(json_encode(['status' => 'error']));
            $this->response->statusCode(200);
            $this->response->type('application/json');
        }
        return $this->response;
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
