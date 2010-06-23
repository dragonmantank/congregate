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

	public function addrevisionAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$files	= new Files();
		$data	= array(
			'fileId'	=> $this->_request->getParam('fid'),
			'tmp_name'	=> $_FILES['file']['tmp_name'],
			'size'		=> $_FILES['file']['size'],
			'mimetype'	=> $_FILES['file']['type'],
			'fileName'	=> $_FILES['file']['name'],
			'author'	=> Zend_Auth::getInstance()->getIdentity()->id,
		);

		$files->addRevision($data);
		$this->_forward('stats', 'files', 'default', array('file' => $this->_request->getParam('fid')));

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
		$this->view->revisions	= $f->fetchAllVersions($fid);
	}

	public function viewAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$files	= new Files();
		$files->viewFile($this->_request->getParam('file'), $this->_request->getParam('type'));
	}
}