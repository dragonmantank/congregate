<?php

/**
 * Model_User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_User extends Model_Base_User
{
    const AUTH_WRONG_PASSWORD = 1;
    const AUTH_NOT_FOUND = 2;

    public function fetchProjects()
    {
        $q = Doctrine_Query::create();
        $q->from('Model_UserProjects up')
          ->leftJoin('Model_User u ON up.id = u.id')
          ->leftJoin('u.Projects p');

        $projects = $q->fetchArray();
Zend_Debug::dump($projects);
        return $projects;
    }

    /**
     *
     * @param <type> $username
     * @param <type> $password
     * @return <type>
     */
    public static function authenticate($username, $password)
    {
        $user = Doctrine_Core::getTable('Model_User')->findOneByUsername($username);
        if($user) {
            if($user->password == sha1(sha1($password))) {
                return $user;
            } else {
                throw new Exception(self::AUTH_WRONG_PASSWORD);
            }
        } else {
            throw new Exception(self::AUTH_NOT_FOUND);
        }
        
    }

    public function setPassword($password)
    {
        return $this->_set('password', sha1($password));
    }
}