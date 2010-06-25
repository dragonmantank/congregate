<?php

require_once APPLICATION_PATH."/models/Base/User.php";
require_once APPLICATION_PATH."/models/User.php";

class UserTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $doctrine = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $doctrine->query('TRUNCATE TABLE `user`');
        unset($doctrine);
    }

    public function testCanCreate()
    {
        $user = new Model_User();
        $user->challenge = '1234';
        $user->save();

        $this->assertTrue($user->id > 0);
    }

    public function testCreatesSHA1Hash()
    {
        $user = new Model_User();
        $user->password = 'mypass';

        $this->assertEquals(sha1('mypass'), $user->password);
    }

    public function testFetchAll()
    {
        $users = Doctrine_Core::getTable('Model_User')->findAll();
        $this->assertEquals(0, count($users));

        $user = new Model_User();
        $user->name = "Chris";
        $user->save();

        $users = Doctrine_Core::getTable('Model_User')->findAll();
        $this->assertEquals(1, count($users));
    }
}