<?php

class Project_SettingsController extends Zend_Controller_Action
{
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
}