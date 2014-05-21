<?php 
/**
 * 缓存模型
 *
 * @author niexing
 */
class Application_Model_Cache
{
    /**
     * cache对象
     *
     * @var object
     */
    protected $_cache;
    
    /**
     * 配置
     *
     * @var array
     */
    protected $_configs;
    
    /**
     * 构造函数
     *
     * @param $liveTime
     * @return void
     */
    public function __construct($lifeTime =  60) {
        //配置
        $this->_configs = Zend_Registry::get('configs');

        //设置可写的配置
        $frontendOptions = array(
            'lifeTime' => $lifeTime,
            'automatic_serialization' => true
        );
        // 放缓存文件的目录
        $backendOptions = array(
            'cache_dir' => $this->_configs['project']['cachePath'] . '/'
        ); 
        $this->_cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
    }

    /**
     * 获取配置的数据
     * 
     * @param string $name
     * @return array
     */
    public function get($name) {
        return $this->_cache->load($name);
    }

    /**
     * 编辑
     * 
     * @param string $name
     * @param array  $row
     * @return void
     */
    public function write($name, $row)
    {
        $this->_cache->save($row, $name);
    }
}