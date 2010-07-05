<?php

class MessagesController extends Zend_Controller_Action
{
    public function init()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('messageId');
        $message = Doctrine_Core::getTable('Model_UserMessages')->findOneBy('id', $id);

        $message->delete();
    }
}