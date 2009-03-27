<?php

class FilesController extends Zend_Controller_Action
{
	public function addcommentAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$f	= new Files();
		$f->addComment($this->_request->file, Zend_Auth::getInstance()->getIdentity()->id, $this->_request->comment);

		echo json_encode(array('status' => 1, 'message' => 'Comment Added'));
	}

	public function init()
	{
		$this->_helper->layout->setLayout('project-layout');
	}

	public function statsAction()
	{
		$f		= new Files();
		$fid	= $this->_request->getParam('file');
		$file	= $f->fetchFile($fid);

		$this->view->assign($file->toArray());
		$this->view->comments	= $f->fetchComments($fid);
	}
}