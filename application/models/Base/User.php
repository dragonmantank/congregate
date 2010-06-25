<?php

/**
 * Model_Base_User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $email
 * @property integer $primaryGroup
 * @property timestamp $dateCreated
 * @property timestamp $dateActivated
 * @property tinyint $status
 * @property string $challenge
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Model_Base_User extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('username', 'string', 255, array(
             'type' => 'string',
             'unique' => true,
             'length' => '255',
             ));
        $this->hasColumn('password', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'unique' => true,
             'length' => '255',
             ));
        $this->hasColumn('primaryGroup', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('dateCreated', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('dateActivated', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('status', 'tinyint', null, array(
             'type' => 'tinyint',
             ));
        $this->hasColumn('challenge', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}