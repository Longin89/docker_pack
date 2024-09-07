<?php

namespace App\Controllers;

use Core\Controller;
use Core\Router;
use App\Models\Users;
use App\Models\Login;

class RegisterController extends Controller
{

    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->load_model('Users');
        $this->view->setLayout('default');
    }

    public function loginAction()
    {
        $loginModel = new Login();
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $loginModel->assign($this->request->get());
            $loginModel->validator();
            if ($loginModel->validationPassed()) {
                $user = $this->UsersModel->findByUsername($_POST['username']);
                if ($user && password_verify($this->request->get('password'), $user->password)) {
                    $remember = $loginModel->getRememberMeChecked();
                    $user->login($remember);
                    Router::redirect('');
                } else {
                    $loginModel->addErrorMessage('username', 'Incorrect username or password');
                }
            }
        }
        $this->view->login = $loginModel;
        $this->view->displayErrors = $loginModel->getErrorMessages();
        $this->view->render('register/login');
    }

    public function logoutAction()
    {
        if (Users::currentUser()) {
            Users::currentUser()->logout();
        }
        Router::redirect('register/login');
    }

    public function RegisterAction()
    {
        $newUser = new Users();
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $newUser->assign($this->request->get());
            $newUser->setConfirm($this->request->get('confirm'));
            if ($newUser->save()) {
                Router::redirect('register/login');
            }
        }
        $this->view->newUser = $newUser;
        $this->view->displayErrors = $newUser->getErrorMessages();
        $this->view->render('register/register');
    }
}
