<?php

class Project_LoadController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $project = Doctrine_Core::getTable('Model_Project')->findOneBySlug($this->getRequest()->getParam('project'));
        $_SESSION['CurrentProject']['project'] = $project;

        $this->_redirect('project/');
    }
}