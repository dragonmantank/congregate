<?php

class Tws_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    const MSG_NOT_FOUND = 'Account was not found';
    const MSG_BAD_PASSWORD = 'Password did not match';
    protected $_username;
    protected $_password;
    protected $_user;
    
    public function __construct($username, $password)
    {
        $this->_username = $username;
        $this->_password = $password;
    }

    public function authenticate()
    {
        try {
            $this->_user = Model_User::authenticate($this->_username, $this->_password);
            return $this->_createResult(Zend_Auth_Result::SUCCESS);
        } catch (Exception $e) {
            if($e->getMessage() == Model_User::AUTH_WRONG_PASSWORD) {
                return $this->_createResult(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, array(self::MSG_BAD_PASSWORD));
            }

            if($e->getMessage() == Model_User::AUTH_NOT_FOUND) {
                return $this->_createResult(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, array(self::MSG_NOT_FOUND));
            }
        }
    }

    private function _createResult($code, $messages = array())
    {
        return new Zend_Auth_Result($code, $this->_user, $messages);
    }
}