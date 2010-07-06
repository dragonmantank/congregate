<?php

class Project_SettingsController extends Zend_Controller_Action
{
    public function archiveAction()
    {
    
    }

    public function  postDispatch() {
        $fc = Zend_Controller_Front::getInstance();
        $fc->unregisterPlugin('Tws_Controller_Plugin_ModuleLayout');

        $this->_helper->layout()->setLayout('project-settings-layout');
    }

    public function indexAction()
    {
        $project = $_SESSION['CurrentProject']['project'];
        $form = new Project_Form_ProjectSettings();

        $form->getElement('name')->setValue($project->name);
        $form->getElement('description')->setValue($project->description);

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $project->name = $form->getValue('name');
                $project->description = $form->getValue('description');
                $project->save();

                $_SESSION['CurrentProject']['project'] = $project;
            }
        }

        $this->view->form = $form;
    }

    public function membersAction()
    {
        $members = $_SESSION['CurrentProject']['project']->Users;

        $this->view->members = $members;
    }
}