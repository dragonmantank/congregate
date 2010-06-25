<?php

require_once APPLICATION_PATH."/models/Base/User.php";
require_once APPLICATION_PATH."/models/User.php";

class UserTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function testCanTest()
    {
        $user = new Model_User();
        $user->challenge = '1234';
        $user->save();

        $this->assertTrue($user->id > 0);
    }
}