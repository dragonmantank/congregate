<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $user = Zend_Auth::getInstance()->getIdentity();

        $this->view->projects = $user->Projects;
        $this->view->messages = $user->UserMessages;
    }


}

