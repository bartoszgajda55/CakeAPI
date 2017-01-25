<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\UnauthorizedException;
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

        $this->Auth->allow(['register', 'token']);

        $this->response->header('Access-Control-Allow-Origin', '*');
        //$this->response->header('Access-Control-Allow-Methods','*');
        //$this->response->header('Access-Control-Allow-Credentials', 'true');
        //$this->response->header('Access-Control-Allow-Request-Method', '*');
        $this->response->header('Access-Control-Allow-Headers','Origin, X-Requested-With, Content-Type, Accept, Authorization');
        $this->response->sendHeaders();
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->response->body(json_encode($this->Users->getAll()));
        $this->response->statusCode(200);
        $this->response->type('application/json');
        return $this->response;
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
            return $this->response;
        } else {
            throw new BadRequestException();
        }
    }

    /**
     * Token method
     *
     * @return \Cake\Network\Response|null Returns JWT token if logged successfully
     */
    public function token()
    {
        if($this->request->is(['POST'])) {
            $data = $this->request->data;
            $user = $this->Users->getUser($data);
            if($user != null) {
                $this->response->body(json_encode([
                    'success' => 'true',
                    'id' => $user[0]['id'],
                    'token' => JWT::encode(
                        [
                            'sub' => $user[0]['id'],
                            'exp' => time() + 604800
                        ],
                        Security::salt()
                    )
                ]));
                $this->response->statusCode(200);
                $this->response->type('application/json');
                return $this->response;
            } else {
                throw new UnauthorizedException('Invalid username or password');
            }
        }
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
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
