<?php

class Project_TasksController extends Zend_Controller_Action
{
    public function addnoteAction()
    {
        $form = new Project_Form_AddNote();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $note = new Model_TaskNote();
                $task = $_SESSION['CurrentProject']['task'];
                
                $note->task_id = $task;
                $note->note = $form->getValue('note');
                $note->dateAdded = date('Y-m-d H:i:s');
                $note->author_id = Zend_Auth::getInstance()->getIdentity();
                $note->save();

                Model_Message::addMessage(
                        Zend_Auth::getInstance()->getIdentity()->name.' updated a Task, '.$task->title,
                        'project/tasks/view/task/'.$task->id,
                        Zend_Auth::getInstance()->getIdentity(),
                        $_SESSION['CurrentProject']['project']);

                $this->_redirect('project/tasks/view/task/'.$task->id);
            }
        }

        $this->view->form = $form;
    }
    
    public function createAction()
    {
        $form = new Project_Form_CreateTask();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $task = new Model_Task();
                $task->project_id = $_SESSION['CurrentProject']['project'];
                $task->title = $form->getValue('title');
                $task->description = $form->getValue('description');
                $task->dateAdded = date('Y-m-d');
                $task->deadline = date('Y-m-d', strtotime($form->getValue('deadline')));
                $task->author_id = Zend_Auth::getInstance()->getIdentity();
                $task->assignedTo = Zend_Auth::getInstance()->getIdentity();
                $task->save();

                Model_Message::addMessage(
                        Zend_Auth::getInstance()->getIdentity()->name.' created a new Task, '.$task->title,
                        'project/tasks/view/task/'.$task->id,
                        Zend_Auth::getInstance()->getIdentity(),
                        $_SESSION['CurrentProject']['project']);

                $this->_redirect('project/tasks');
            }
        }

        $this->view->form = $form;
    }

    public function indexAction()
    {
        $project = $_SESSION['CurrentProject']['project'];

        $this->view->tasks = $project->Tasks;
    }

    public function viewAction()
    {
        $task = Doctrine_Core::getTable('Model_Task')->findOneById($this->getRequest()->getParam('task'));
        $_SESSION['CurrentProject']['task'] = $task;
        
        $this->view->task = $task;
    }
}