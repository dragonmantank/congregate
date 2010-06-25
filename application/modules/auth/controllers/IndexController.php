<?php

class Auth_IndexController extends Zend_Controller_Action
{
    public function loginAction()
    {
        $form = new Auth_Form_Login();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $username = $form->getValue('username');
                $password = $form->getValue('password');

                $adapter = new Tws_Auth_Adapter($username, $password);
                $result = Zend_Auth::getInstance()->authenticate($adapter);

                if($result->isValid()) {
                    $this->_redirect('/');
                } else {
                    echo implode(' ', $result->getMessages());
                }
            }
        }

        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('auth/index/login');
    }
}