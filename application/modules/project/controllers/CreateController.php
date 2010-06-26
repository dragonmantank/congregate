<?php

class Project_CreateController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $form = new Project_Form_Add();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $project = new Model_Project();
                $project->name = $form->getValue('name');
                $project->description = $form->getValue('description');
                $project->authorId = Zend_Auth::getInstance()->getIdentity();
                $project->dateCreated = date('Y-m-d H:i:s');
                $project->dateApproved = date('Y-m-d H:i:s');
                $project->status = 1;
                $project->Users[] = Zend_Auth::getInstance()->getIdentity();
                $project->save();

                $this->_redirect('/');
            }
        }
        $this->view->form = $form;
    }
}