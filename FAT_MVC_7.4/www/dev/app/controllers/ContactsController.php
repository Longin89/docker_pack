<?php

namespace App\Controllers;

use Core\Controller;
use Core\Session;
use Core\Router;
use App\Models\Contacts;
use App\Models\Users;

class ContactsController extends Controller
{
    public function __construct($controller, $action)
    {
        parent::__construct($controller, $action);
        $this->view->setLayout('default');
        $this->load_model('Contacts');
    }

    public function indexAction()
    {
        $contacts = $this->ContactsModel->findAllByUserId(Users::currentUser()->id, ['order' => 'lname, fname']);
        $this->view->contacts = $contacts;
        $this->view->render('contacts/index');
    }

    public function addAction()
    {
        $contact = new Contacts();
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $contact->assign($this->request->get());
            $contact->user_id = Users::currentUser()->id;
            $contact->deleted = 0;
            if ($contact->save()) {
                Router::redirect('contacts');
            }
        }
        $this->view->contact = $contact;
        $this->view->displayErrors = $contact->getErrorMessages();
        $this->view->postAction = PROOT . 'contacts' . DS . 'add';
        $this->view->render('contacts/add');
    }

    public function editAction($id)
    {
        $contact = $this->ContactsModel->findByIdAndUserId((int)$id, Users::currentUser()->id);
        if (!$contact) Router::redirect('contacts');
        if ($this->request->isPost()) {
            $this->request->csrfCheck();
            $contact->assign($this->request->get());
            if ($contact->save()) {
                Router::redirect('contacts');
            }
        }
        $this->view->displayErrors = $contact->getErrorMessages();
        $this->view->contact = $contact;
        $this->view->postAction = PROOT . 'contacts' . DS . 'edit' . DS . $contact->id;
        $this->view->render('contacts/edit');
    }



    public function detailsAction($id)
    {
        $contact = $this->ContactsModel->findByIdAndUserId((int)$id, Users::currentUser()->id);
        if (!$contact) {
            Router::redirect('contacts');
        }
        $this->view->contact = $contact;
        $this->view->render('contacts/details');
    }

    public function deleteAction($id)
    {
        $contact = $this->ContactsModel->findByIdAndUserId((int)$id, Users::currentUser()->id);
        if ($contact) {
            $contact->delete();
            Session::addMsg('success', 'Contact deleted');
        }
        Router::redirect('contacts');
    }
}
