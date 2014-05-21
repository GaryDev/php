<?php
error_reporting(E_ALL|E_STRICT);

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__) . '/library'),
    get_include_path(),
)));

/** 函数 */
require_once dirname(__FILE__) . '/library/Function/system.php';
cancelMagicQuotes($_POST);
cancelMagicQuotes($_GET);
cancelMagicQuotes($_COOKIE);

define('USE_INCLUDE', true);

// 定义应用程序目录的路�?
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// 定义应用程序环境
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
define('PUBLIC_PATH', rtrim(realpath('./'), DIRECTORY_SEPARATOR));

/** Zend_Application */
require_once 'Zend/Application.php';

// 创建应用程序，引导和运行
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.php');
$application->bootstrap();
$application->run();

/*
require_once 'Zend/Version.php';
echo Zend_Version::VERSION;
*/