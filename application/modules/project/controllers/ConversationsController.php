<?php

class Project_ConversationsController extends Zend_Controller_Action
{
    public function createAction()
    {
        $form = new Project_Form_CreateConversation();

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $author = Zend_Auth::getInstance()->getIdentity();
                
                $conversation = new Model_Conversation();
                $conversation->title = $form->getValue('title');
                $conversation->author_id = $author;
                $conversation->dateAdded = date('Y-m-d H:i:s');
                $conversation->lastUpdated = date('Y-m-d H:i:s');
                $conversation->project_id = $_SESSION['CurrentProject']['project'];
                $conversation->save();

                $post = new Model_ConversationPost();
                $post->conversation_id = $conversation;
                $post->author_id = $author;
                $post->remark = $form->getValue('remark');
                $post->dateAdded = date('Y-m-d H:i:s');
                $post->save();

                $this->_redirect('project/conversations');
            }
        }

        $this->view->form = $form;
    }

    public function indexAction()
    {
        $project = $_SESSION['CurrentProject']['project'];

        $this->view->conversations = $project->Conversations;
    }

    public function viewAction()
    {
        $form = new Project_Form_CreateConversationPost();
        $conversation = Doctrine_Core::getTable('Model_Conversation')->findOneBy('id', $this->getRequest()->getParam('conversation'));

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                $author = Zend_Auth::getInstance()->getIdentity();

                $post = new Model_ConversationPost();
                $post->conversation_id = $conversation;
                $post->author_id = $author;
                $post->remark = $form->getValue('remark');
                $post->dateAdded = date('Y-m-d H:i:s');
                $post->save();

                $this->_redirect('project/conversations/view/conversation/'.$conversation->id);
            }
        }

        $this->view->form = $form;
        $this->view->conversation = $conversation;
    }
}