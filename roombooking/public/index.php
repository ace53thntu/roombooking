<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
    
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../library/Swift/lib/classes'), 
    get_include_path(),
))
.":".realpath(APPLICATION_PATH.'/data')
.":".realpath(APPLICATION_PATH.'/models')
.":".realpath(APPLICATION_PATH.'/forms'));


require_once 'Zend/Application.php';

include_once('Zend/Loader/Autoloader.php');
$loader = Zend_Loader_Autoloader::getInstance();
$loader->setFallbackAutoloader(true);
$loader->suppressNotFoundWarnings(false);  

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);

Zend_Controller_Action_HelperBroker::addPath(
        APPLICATION_PATH .'/controllers/helpers');

$view = new Zend_View;
$view->addHelperPath(APPLICATION_PATH .'/views/helpers');       

// Initialise Zend_Layout's MVC helpers
Zend_Layout::startMvc(array('layoutPath' => APPLICATION_PATH.'/layouts/scripts'));
        
$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini','development');
Zend_Registry::set('config', $config);

$application->getBootstrap()->bootstrap();
//Zend_Session::rememberMe($config->resources->session->remember_me_seconds);
//$application->bootstrap()->run();
// set up database
$db = Zend_Db::factory($config->resources->db->adapter, $config->resources->db->params->toArray());
Zend_Db_Table::setDefaultAdapter($db);
Zend_Registry::set('db', $db);
$db->query("SET NAMES utf8");

// set base folder of index files
$config = Zend_Registry::get('config');
//SearchIndexer::setBaseDirectory($config->search_lucene_index);

$writer = new Zend_Log_Writer_Stream($config->logger->file);
$logger = new Zend_Log($writer);
Zend_Registry::set('logger', $logger);

// setup controller
$frontController = Zend_Controller_Front::getInstance();
$frontController->throwExceptions(false);//->registerPlugin(new Zend_Controller_Plugin_ErrorHandler());
$frontController->setControllerDirectory('../application/controllers');

// run!
$frontController->dispatch();
