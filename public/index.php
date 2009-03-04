<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
date_default_timezone_set('America/New_York');

define("INSTALL_PATH", dirname(dirname(__FILE__)));

// Directory setup and class loading
set_include_path(
	'.' . 
	PATH_SEPARATOR . INSTALL_PATH . '/application' . 
	PATH_SEPARATOR . INSTALL_PATH . '/library/' . 
	PATH_SEPARATOR . INSTALL_PATH . '/application/models' . 
	PATH_SEPARATOR . INSTALL_PATH . '/application/forms' .
	PATH_SEPARATOR . get_include_path() );
	
include 'Zend/Loader.php';
include 'Tws/Bootstrap.php';

$bootstrap = new Tws_Bootstrap();
$bootstrap->startSessions();

// Load configuration
$environment	= strtolower( array_key_exists('ENVIRONMENT', $_SERVER) ? $_SERVER['ENVIRONMENT'] : 'production' );
$config 		= new Zend_Config_Xml('../application/config/config.xml', $environment);
$registry		= Zend_Registry::getInstance();
$registry->set('config', $config);

// Setup the database
$db = Zend_Db::factory($config->database);
Zend_Db_Table::setDefaultAdapter($db);
Zend_Registry::set('db', $db);

// Set up the cache
//$frontendOptions	= array('lifeTime'	=> '3600');
//$backendOptions		= array('cacheDir'	=> '../tmp/cache/');
//$cache				= Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
//$registry->set('cache', $cache);

// Setup the controller
$bootstrap->throwExceptions(true);
$bootstrap->registerPlugin('Zend_Controller_Plugin_ErrorHandler');
$bootstrap->setControllerDirectory(array(
	'default'		=> '../application/modules/default/controllers',
));
$bootstrap->setParam('useDefaultControllerAlways', true);

// Add in our custom routes

// Load our layout paths
Zend_Layout::startMvc( array('layoutPath'	=> '../application/layouts/scripts') );

// Add View Helpers
//$viewRenderer	= Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
//$viewRenderer->initView();
//$viewRenderer->view->addHelperPath('Zng/View/Helper', 'Zng_View_Helper');

// Add some routes
//$bootstrap->addRoute('game', new Zend_Controller_Router_Route('/game/:game', array('controller'=>'games', 'action'=>'play')));
//$bootstrap->addRoute('category', new Zend_Controller_Router_Route('/category/:category', array('controller'=>'category', 'action'=>'view')));

// Run!
$bootstrap->dispatch();
