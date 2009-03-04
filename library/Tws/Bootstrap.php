<?php

/**
 * Bootstrap object to simplify the bootstrapping process for Zend Framework
 *
 * This object allows an object-oriented interface for building the bootstrap
 * process for Zend Framework. 
 *
 * @author Chris Tankersley
 * @copyright 2008 Chris Tankersley
 * @package Tws_Bootstrap
 */
class Tws_Bootstrap
{
    /**
     * Main controller for the application
     *
     * @var Zend_Controller_Front
     */
    protected $_frontController;

    /**
     * Router used for custom routing
     *
     * @var Zend_Controller_Router
     */
    protected $_router          = null;

    /**
     * Turns on autoloading and creates the Front Controller
     */
    public function __construct()
    {
        Zend_Loader::registerAutoload();
        $this->_frontController = Zend_Controller_Front::getInstance();
        $this->_router          = $this->_frontController->getRouter();
    }

    /**
     * Adds a directory with controllers to the Front Controller
     *
     * @param string $path Path containing the controllers
     * @param string $name Name for this group of controllers
     */
    public function addControllerDirectory($path, $name)
    {
        $this->_frontController->addControllerDirectory($path, $name);
    }

    /**
     * Adds a new custom route to the router
     *
     * @param string $name Name of the 
     * @param Zend_Controller_Router_Route $route Route
     */
    public function addRoute($name, Zend_Controller_Router_Route $route)
    {
        $this->_router->addRoute($name, $route);
    }
    
    /**
     * Appends a path to the already defined include path
     *
     * @param string $path
     */
    static public function appendIncludePath($path)
    {
    	set_include_path( 
    		get_include_path() . 
    		$path . PATH_SEPARATOR
    	);
    }

    /**
     * Dispatches the front controller
     */
    public function dispatch()
    {
        $this->_frontController->dispatch();
    }
    
	/**
     * Prepends a path to the already defined include path
     *
     * @param string $path
     */
    static public function prependIncludePath($path)
    {
    	set_include_path(
    		$path . PATH_SEPARATOR .  
    		get_include_path()
    	);
    }

    /**
     * Registers a plugin with the front controller
     * 
     * @param string $plugin Name of the plugin class
     */
    public function registerPlugin($plugin)
    {
        $this->_frontController->registerPlugin( new $plugin );
    }

    /**
     * Sets a bulk of controller directories via an array
     *
     * @param array $dirs Array of names and directories of controllers
     */
    public function setControllerDirectory(array $dirs)
    {
        $this->_frontController->setControllerDirectory($dirs);
    }

    /**
     * Sets parameters on the front controller
     */
    public function setParam($key, $value)
    {
        $this->_frontController->setParam($key, $value);
    }

    /**
     * Starts sessions through Zend_Session
     */
    public function startSessions()
    {
        Zend_Session::start();
    }

    /**
     * Sets whether or not we throw exceptions in the controllers
     *
     * @param bool $state Yes or no to throw exceptions
     */
    public function throwExceptions($state)
    {
        $this->_frontController->throwExceptions($state);
    }
}
