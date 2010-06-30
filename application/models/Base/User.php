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
 * @property Doctrine_Collection $Project
 * @property Doctrine_Collection $Projects
 * @property Doctrine_Collection $UserProjects
 * @property Doctrine_Collection $Task
 * @property Doctrine_Collection $TaskNote
 * @property Doctrine_Collection $Issue
 * @property Doctrine_Collection $Conversation
 * @property Doctrine_Collection $ConversationPost
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
        $this->hasMany('Model_Project as Project', array(
             'local' => 'id',
             'foreign' => 'authorId'));

        $this->hasMany('Model_Project as Projects', array(
             'refClass' => 'Model_UserProjects',
             'local' => 'user_id',
             'foreign' => 'project_id'));

        $this->hasMany('Model_UserProjects as UserProjects', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Model_Task as Task', array(
             'local' => 'id',
             'foreign' => 'author_id'));

        $this->hasMany('Model_TaskNote as TaskNote', array(
             'local' => 'id',
             'foreign' => 'author_id'));

        $this->hasMany('Model_Issue as Issue', array(
             'local' => 'id',
             'foreign' => 'author_id'));

        $this->hasMany('Model_Conversation as Conversation', array(
             'local' => 'id',
             'foreign' => 'author_id'));

        $this->hasMany('Model_ConversationPost as ConversationPost', array(
             'local' => 'id',
             'foreign' => 'author_id'));
    }
}