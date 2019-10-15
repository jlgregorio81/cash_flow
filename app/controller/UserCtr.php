<?php
namespace app\controller;

use core\mvc\Controller;
use app\view\user\NewUserView;
use app\view\user\UserView;
use app\dao\UserDao;
use app\model\UserModel;
use core\Application;
use core\mvc\view\Message;
use core\util\Session;
use app\view\Home;

final class UserCtr extends Controller
{

    private $newUserView;
    private $action; //..determine if show NewUserView or UserView

    public function __construct()
    {
        parent::__construct();
        $this->view = new UserView();
        $this->newUserView = new NewUserView();
        $this->dao = new UserDao();
        $this->list = null; //..view to query the users
        //..verify if show a view do perform a new user or update a user
        $this->action = isset($this->get['action']) ? $this->get['action'] : 'update';
    }

    public function showView()
    {
        if ($this->action == 'new')
            $this->newUserView->show();
        else
            parent::showView();
    }

    public function getModelFromView()
    {
        if (!empty($this->post)) {
            return new UserModel(
                $this->post['id'],
                $this->post['name'],
                $this->post['gender'],
                $this->post['email'],
                $this->post['password'],
                'I',
                'U',
                null
            );
        }
    }

    public function activateUser()
    {
        try {
            $email = $this->get['email'];
            (new UserDao())->activateUser($email);
            (new Message(Application::$MSG_TITLE, Application::$MSG_ACTIVATE, Application::$ICON_SUCCESS))->show();
        } catch (\Exception $ex) {
            (new Message(Application::$MSG_TITLE, Application::$MSG_ERROR, Application::$MSG_ERROR))->show();
        }
    }

    public function insertUpdate()
    {
        if ($this->get['action'] == 'new') {
            try {
                $model = $this->getModelFromView();
                $link = Application::$HOST . "Request.php?class=UserCtr&method=activateUser&email={$model->getEmail()}";
                $msg = "<h1>" . Application::$APP_NAME . "</h1><hr>";
                $msg .= "<h2>Ativação de cadastro - não responda!</h2>";
                $msg .= "<p><a href=\"$link\">Clique Aqui para ativar o cadastro</a></p>";
                Application::sendEmail($model->getEmail(), 'Ativação de Cadastro', $msg);
                (new UserDao())->insert($model);
                (new Message('Mensagem', 'Cadastro efetuado com sucesso! Verifique seu e-mail!', Application::$ICON_SUCCESS))->show();
            } catch (\Exception $ex) {
                (new Message(null, Application::$MSG_ERROR, Application::$ICON_ERROR))->show();
            }
        } else {
            parent::insertUpdate();
        }
    }

    public function doLogin()
    {
        if (!empty($this->get) && $this->get['method'] == 'doLogin') {
            try {
                $email = $this->post['email'];
                $password = $this->post['password'];
                $user = (new UserDao())->doLogin($email, $password);
                if ($user){
                    Session::createSession('active_user', $user);
                    Application::start();
                }
                else (new Message(
                        Application::$MSG_TITLE,
                        Application::$MSG_INCORRECT_LOGIN,
                        Application::$ICON_ERROR
                    ))->show();
            } catch (\Exception $ex) { }
        } else {
            Application::start();
        }
    }

    public function doLogout(){
        if(!empty($this->get) && $this->get['method'] == 'doLogout'){
            Session::destroySession('active_user');
            Application::start();
        }
    }

}
