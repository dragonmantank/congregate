<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $user = Doctrine_Core::getTable('Model_User')->findOneById(Zend_Auth::getInstance()->getIdentity()->id);
        //$projects = $user->fetchProjects();
        $projects = $user->projects;
        
        $this->view->projects = $projects[0]['Projects'];
    }


}

