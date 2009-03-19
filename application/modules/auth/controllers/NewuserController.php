<?php

class Auth_Newusercontroller extends Zend_Controller_Action
{
	public function confirmAction()
	{
		if(array_key_exists('register', $_SESSION)) {
			unset($_SESSION['register']);
		}

		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$email	= $this->_request->getParam('email');
		$conf	= $this->_request->getParam('conf');
		$u		= new Users();

		if($u->isValidConfirmation($email, $conf)) {
			$status 				= 1;
			$message				= 'Confirmation matches';
			$user					= $u->fetchByEmail($email);
			$_SESSION['register']	= $user->id;
		} else {
			$status		= 0;
			$message	= 'Email and Confirmation do not match.';
		}

		echo json_encode(array('status' => $status, 'message' => $message));
	}

	public function indexAction()
	{
		$u		= new Users();
		$user	= $u->find($_SESSION['register'])->current();

		$this->view->username	= $user->username;
		$this->view->email		= $user->email;
		$this->view->name		= $user->name;
	}
}