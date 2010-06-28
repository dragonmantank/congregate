<?php

class Project_IssuesController extends Zend_Controller_Action
{
    public function createAction()
    {
        $form = new Project_Form_CreateIssue();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $issue = new Model_issue();
                $issue->project_id = $_SESSION['CurrentProject']['project'];
                $issue->title = $form->getValue('title');
                $issue->description = $form->getValue('description');
                $issue->reproduction = $form->getValue('reproduction');
                $issue->additionalInfo = $form->getValue('additionalInfo');
                $issue->author_id = Zend_Auth::getInstance()->getIdentity();
                $issue->assigned_id = Zend_Auth::getInstance()->getIdentity();
                $issue->dateCreated = date('Y-m-d H:i:s');
                $issue->status_id = Doctrine_Core::getTable('Model_IssueStatus')->findOneByTitle('Entered');
                $issue->save();

                $this->_redirect('project/issues');
            }
        }

        $this->view->form = $form;
    }
    
    public function indexAction()
    {
        $project = $_SESSION['CurrentProject']['project'];

        $this->view->issues = $project->Issues;
    }

    public function viewAction()
    {
        $issue = Doctrine_Core::getTable('Model_Issue')->findOneById($this->getRequest()->getParam('issue'));

        $this->view->issue = $issue;
    }
}