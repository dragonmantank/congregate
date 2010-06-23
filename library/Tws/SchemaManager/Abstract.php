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
 * Abstract class for Tws_SchemaManager handlers
 *
 * Contains most of the base code for doing installs and upgrades
 *
 * @class Tws_SchemaManager
 * @package Tws_SchemaManager
 */
abstract class Tws_SchemaManager_Abstract
{
    /**
     * Database connection
     * @var Zend_Db_Adapter_Abstract
     */
    protected $_db;
    
    /**
     * Driver name
     * @var string
     */
    protected $_driver;
    
    /**
     * Namespace where the Base and Delta files are stored
     * @var string
     */
    protected $_namespace;

    /**
     * Constructor
     *
     * @param Zend_Db_Adapter_Abstract $db
     */
    public function __construct(Zend_Db_Adapter_Abstract $db)
    {
        $this->_db = $db;
    }

    /**
     * Returns the current version from the Database
     *
     * @return int
     */
    public function getCurrentVersion()
    {
        $select = $this->_db->select()->from('config', array('value'))->where('key = ?', 'version');
        $result = $this->_db->fetchCol($select);

        return $result[0];
    }

    /**
     * Returns the driver name for the handler
     *
     * @return string
     */
    public function getDriver()
    {
        if($this->_driver == null) {
            throw new Exception('Driver has not been set for Schema Manager');
        }

        return $this->_driver;
    }

    /**
     * Returns the namespace that the Base and Delta files are stored in
     *
     * @return string
     */
    public function getNamespace()
    {
        if( $this->_namespace == null ) {
            throw new Exception('Namespace has not been set for Schema Manager');
        }

        return $this->_namespace;
    }

    /**
     * Runs the base installer
     */
    public function install()
    {
        $path = realpath(APPLICATION_PATH.'/../library/'.str_replace('_', '/', $this->getNamespace()).'/Base').'/'.$this->getDriver().'.php';
        require_once($path);
        $class = $this->getDriver();
        $installer = new $class($this->_db);
        $installer->upgrade();
    }

    /**
     * Sets the namespace for the Base and Delta files
     *
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->_namespace = $namespace;
    }

    /**
     * Splits a file path into a delta number and class name
     *
     * @param string $path
     * @return array
     */
    protected function _split($path)
    {
        $file = end(explode('/', $path));
        preg_match('/^([0-9]+)\-(.*)\.php/', $file, $matches);
        
        return $matches;
    }

    /**
     * Upgrades a database to a specified (or newest) level
     *
     * Reads through the available deltas and applies each delta as needed
     *
     * @param int $version
     */
    public function upgrade($version = null)
    {
        $currentVersion = $this->getCurrentVersion();
        $path = realpath(APPLICATION_PATH.'/../library/'.str_replace('_', '/', $this->getNamespace()).'/Delta/'.$this->getDriver());
        $deltas = glob($path.'/*.php');
        
        if(count($deltas)) {
            if($version == null) {
                list(, $version,) = $this->_split(end($deltas));
                reset($deltas);
            }

            if($version > $currentVersion) {
                foreach($deltas as $file) {
                    $data = $this->_split($file);
                    if((int)$data[1] > $currentVersion && (int)$data[1] <= $version) {
                        require_once($file);
                        $changeset = new $data[2]($this->_db);
                        $changeset->upgrade();
                    }
                }
            }
        } else {
            throw new Exception('There are no deltas available!');
        }
    }
}
