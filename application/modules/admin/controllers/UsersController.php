<?php

class Admin_UsersController extends Zend_Controller_Action
{
    public function addAction()
    {
        $form = new Admin_Form_AddUser();

        if($this->_request->isPost()) {
            if($form->isValid($this->_request->getPost())) {
                $user = Doctrine_Core::getTable('Model_User')->getRecord();

                $user->username = $form->getValue('email');
                $user->name = $form->getValue('name');
                $user->email = $form->getValue('email');
                $user->password = sha1($form->getValue('password'));
                $user->primaryGroup = 1;
                $user->dateCreated = date('Y-m-d H:i:s');
                $user->status = -1;
                $user->challenge = substr(md5(rand().time().$user->name), 0, 10);

                $user->save();
                $this->_redirect('admin/users');
            }
        }

        $this->view->form = $form;
    }
    
    public function indexAction()
    {
        $users = Doctrine_Core::getTable('Model_User')->findAll();

        $this->view->users = $users;
    }
}
