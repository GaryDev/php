<?php
/**
 * Application bootstrap
 * 
 * @uses    Zend_Application_Bootstrap_Bootstrap
 * @package QuickStart
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * Bootstrap autoloader for application resources
     *
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initAutoload()
    {
        Zend_Registry::set('configs', $this->getOptions());
    }

    /**
     * Bootstrap the db
     *
     * @return void
     */
    protected function _initDb()
    {
        $resources = $this->getPluginResource('db');
        $db = $resources->getDbAdapter();
        Zend_Registry::set('db',$db);
    }

    /**
     * Bootstrap the request
     *
     * @return void
     */
    protected function _initRequest()
    {

    }

    /**
     * Bootstrap the router
     *
     * @return void
     */
    protected function _initRouter(){

    }

    /**
     * Bootstrap the session
     *
     * @return void
     */
    protected function _initSession()
    {
        if(!session_id()) session_start();
    }
}