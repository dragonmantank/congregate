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
  * Factory class for generating a valid DB Handler
  *
  * @class Tws_SchemaManager
  * @package Tws_SchemaManager
  */
class Tws_SchemaManager
{
    /**
     * Returns a valid DB Handler
     *
     * @param Zend_Db_Adapter_Abstract $db
     * @return Tws_SchemaManager_Abstract
     */
    static public function factory(Zend_Db_Adapter_Abstract $db)
    {
        switch(get_class($db)) {
            case 'Zend_Db_Adapter_Pdo_Sqlite':
                return new Tws_SchemaManager_Sqlite($db);
                break;
            default:
                throw new Exception('Unknown database adapter for Schema Manager.');
                break;
        }
    }
}
