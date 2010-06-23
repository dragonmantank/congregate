<?php

/**
 * SchemaManager Database Installer and Upgrade Mechanism
 *
 * @license http://ctankersley.com/licenses/bsd.txt New BSD License
 * @author Chris Tankersley <chris@ctankersley.com>
 * @copyright Chris Tankersley 2010
 * @version 0.1
 */

/**
 * Abstract class for a Changeset
 *
 * @class Tws_SchemeManager_Changeset
 * @package Tws_SchemaManager
 */
abstract class Tws_SchemaManager_Changeset_Abstract
{
    /**
     * Database connection
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;

    /**
     * Constructor
     *
     * @param Zend_Db_Adapater_Abstract $db
     */
    public function __construct(Zend_Db_Adapter_Abstract $db)
    {
        $this->_db  = $db;
    }

    /**
     * Upgrade instructions for a changeset
     */
    abstract public function upgrade();
}
