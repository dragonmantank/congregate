<?php

class Project_BugsController extends Zend_Controller_Action
{
    public function createAction()
    {
        $form = new Project_Form_CreateBug();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $bug = new Model_Bug();
                $bug->project_id = $_SESSION['CurrentProject']['project'];
                $bug->title = $form->getValue('title');
                $bug->description = $form->getValue('description');
                $bug->reproduction = $form->getValue('reproduction');
                $bug->additionalInfo = $form->getValue('additionalInfo');
                $bug->author_id = Zend_Auth::getInstance()->getIdentity();
                $bug->assigned_id = Zend_Auth::getInstance()->getIdentity();
                $bug->dateCreated = date('Y-m-d H:i:s');
                $bug->status_id = Doctrine_Core::getTable('Model_BugStatus')->findOneByTitle('Entered');
                $bug->save();

                $this->_redirect('project/bugs');
            }
        }

        $this->view->form = $form;
    }
    
    public function indexAction()
    {
        $project = $_SESSION['CurrentProject']['project'];

        $this->view->bugs = $project->Bugs;
    }

    public function viewAction()
    {
        $bug = Doctrine_Core::getTable('Model_Bug')->findOneById($this->getRequest()->getParam('bug'));

        $this->view->bug = $bug;
    }
}