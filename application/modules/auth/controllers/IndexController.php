<?php

class Auth_IndexController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$this->_forward('login', 'index', 'auth');
	}

	public function loginAction()
	{

	}

	public function logoutAction()
	{
		session_destroy();
		$auth 	= Zend_Auth::getInstance();
		$auth->clearIdentity();

		$this->_forward('login', 'index', 'auth');
	}

	public function processAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$success	= 0;
		$message	= '';
		$username	= $this->_request->getParam('username');
		$password	= md5($this->_request->getParam('password'));

		$authAdapter = new Zend_Auth_Adapter_DbTable( Zend_Registry::get('db') );

		try {
			$authAdapter->setTableName('u_Users');
			$authAdapter->setIdentityColumn('username');
			$authAdapter->setCredentialColumn('password');
			$authAdapter->setIdentity($username);
			$authAdapter->setCredential($password);

			$auth	= Zend_Auth::getInstance();
			$result	= $auth->authenticate($authAdapter);

			if( $result->isValid() ) {
				$auth->getStorage()->write( $authAdapter->getResultRowObject(null, 'password') );
				$success			= 1;
			} else {
				$message	= 'An invalid username or password was entered.';
			}
		} catch (Exception $e) {
			$message	= $e->getMessage();
			$status		= -1;
		}

		echo json_encode(array('status' => $success, 'message' => $message));
	}
}