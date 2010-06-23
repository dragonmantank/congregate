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
 * SQLite Handler for Tws_SchemaManager
 *
 * @class Tws_SchemaManager
 * @package Tws_SchemaManager
 */
class Tws_SchemaManager_Sqlite extends Tws_SchemaManager_Abstract
{
    /**
     * Driver Name
     * @var string
     */
    protected $_driver = 'Sqlite';
}
