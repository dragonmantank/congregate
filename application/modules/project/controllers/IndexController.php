<?php

class Project_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $project = $_SESSION['CurrentProject']['project'];

        $this->view->project = $project;
        $this->view->messages = $project->fetchMessagesByUser(Zend_Auth::getInstance()->getIdentity()->id);
    }
}