<?php

/**
 * Model_Base_Project
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property text $description
 * @property tinyint $status
 * @property integer $authorId
 * @property timestamp $dateCreated
 * @property timestamp $dateApproved
 * @property timestamp $dateDeclined
 * @property timestamp $dateCompleted
 * @property Model_User $User
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $UserProjects
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Model_Base_Project extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('project');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('description', 'text', null, array(
             'type' => 'text',
             ));
        $this->hasColumn('status', 'tinyint', null, array(
             'type' => 'tinyint',
             ));
        $this->hasColumn('authorId', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('dateCreated', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('dateApproved', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('dateDeclined', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('dateCompleted', 'timestamp', null, array(
             'type' => 'timestamp',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Model_User as User', array(
             'local' => 'authorId',
             'foreign' => 'id'));

        $this->hasMany('Model_User as Users', array(
             'refClass' => 'Model_UserProjects',
             'local' => 'project_id',
             'foreign' => 'user_id'));

        $this->hasMany('Model_UserProjects as UserProjects', array(
             'local' => 'id',
             'foreign' => 'project_id'));

        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'unique' => true,
             'fields' => 
             array(
              0 => 'id',
              1 => 'name',
             ),
             'canUpdate' => true,
             ));
        $this->actAs($sluggable0);
    }
}