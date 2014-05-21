<?php
/**
 * COOKIE模型
 *
 * @author cdlei
 */

class Application_Model_Cookie
{
    /**
     * 配置
     *
     * @var array
     */
    protected $_configs = array();

    /**
     * 构造函数
     * 
     * @return void
     */
    public function __construct() {
        $this->_configs = Zend_Registry::get('configs');
    }

    /**
     * 设置COOKIE
     * 
     * @param  string $name
     * @param  string $value
     * @param  integer $expire
     * @param  string $path
     * @param  string $domain
     * 
     * @return void
     */
    public function setCookie($name, $value, $expire, $path = '/', $domain = '')
    {
        if ($domain == '') {
            $domain = $this->_configs['project']['cookieDomain'];
        }
        $cookieName = "{$this->_configs['project']['cookiePrefix']}{$name}";
        $cookieAuthName = "{$cookieName}_auth";
        $authKey = md5("{$cookieName}{$value}{$this->_configs['project']['authKey']}");
        
        if (empty($domain)) {
            setcookie($cookieName, $value, $expire, $path);
            setcookie($cookieAuthName, $authKey, $expire, $path);
        } else {
            setcookie($cookieName, $value, $expire, $path, $domain);
            setcookie($cookieAuthName, $authKey, $expire, $path, $domain);
        }
    }

    /**
     * 获取COOKIE
     * 
     * @param  string $name
     * 
     * @return string
     */
    public function getCookie($name)
    {
        $value = NULL;
        
        $cookieName = "{$this->_configs['project']['cookiePrefix']}{$name}";
        $cookieAuthName = "{$cookieName}_auth";
        if (isset($_COOKIE[$cookieName]) && isset($_COOKIE[$cookieAuthName])) {
            $authKey = md5("{$cookieName}{$_COOKIE[$cookieName]}{$this->_configs['project']['authKey']}");
            if ($_COOKIE[$cookieAuthName] == $authKey) {
                $value = $_COOKIE[$cookieName];
            }
        }
        return $value;
    }
}