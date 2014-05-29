<?php

/**
 * 配置模型
 *
 * @author cdlei
 */
class Application_Model_Config
{
    /**
     * cache对象
     *
     * @var object
     */
    protected $_cache;

    /**
     * 只读的配置(必须手工修改配置文件)
     *
     * @var array
     */
    protected $_onlyReadConfig;

    /**
     * 只读的配置(必须手工修改配置文件)
     *
     * @var array
     */
    protected $_canWriteConfig;
    
    /**
     * 构造函数
     * 
     * @return void
     */
    public function __construct()
    {
        //设置只读的配置(必须手工修改配置文件)
        $this->_onlyReadConfig = Zend_Registry::get('configs');
        
        //设置可写的配置
        $frontendOptions = array(
            'lifeTime' => NULL,
            'automatic_serialization' => true
        );
        $backendOptions = $this->getCacheBackendOptions();
        $this->_cache = Zend_Cache::factory('Core',
                             'File',
                             $frontendOptions,
                             $backendOptions);
        $this->_canWriteConfig = $this->getCanWriteConfigs();
    }

    /**
     * 获取配置的数据
     * 
     * @return array
     */
    public function getConfigs() {
        $config = $this->_onlyReadConfig;
        $project = array_merge($this->_onlyReadConfig['project'], $this->_canWriteConfig);
        $config['project'] = $project;
        return $config;
    }

    /**
     * 获取缓存的后端
     * 
     * @return array
     */
    public function getCacheBackendOptions() {
        $backendOptions = array(
            'cache_dir' => $this->_onlyReadConfig['project']['configCachePath'] . '/' // 放缓存文件的目录
        );
        return $backendOptions;
    }

    /**
     * 编辑
     * 
     * @return void
     */
    public function updateCanWriteConfigs($row)
    {
        $this->_cache->save($row, 'configs');
    }

    /**
     * 获取可写的配置记录
     * 
     * @return array
     */
    public function getCanWriteConfigs()
    {
        if (!($row = $this->_cache->load('configs'))) {
            $row = array();
            $allModels = $this->getAllCanWriteConfigModels();
            foreach ($allModels as $name => $model) {
                if ($model['dataType'] == 'string') {
                    $value = '';
                } else if ($model['dataType'] == 'number') {
                    $value = 0;
                } else {
                    $value = NULL;
                }
                $row[$name] = $value;
            }
            $this->updateCanWriteConfigs($row);
        }
        return $row;
    }

    /**
     * 获取数据模型
     * 
     * @return array
     */
    public function getAllCanWriteConfigModels()
    {
        $models = array();
        $models['systemName'] = array(
            'title' => '系统名称',//标题
            'description' => '',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );

        $models['siteTitle'] = array(
            'title' => '网站标题',//标题
            'description' => '显示在前台的标题。',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );

        $models['siteKeywords'] = array(
            'title' => '网站默认关键字',//标题
            'description' => '主要用于搜索引擎抓取',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );

        $models['copyRight'] = array(
            'title' => '网站底部版权信息',//标题
            'description' => '',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 5000, //长度
            'inputType' => 'editor', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );

        $models['siteDescription'] = array(
            'title' => '网站默认描述',//标题
            'description' => '主要用于搜索引擎抓取',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );

        $models['mailHost'] = array(
            'title' => '发送邮件的主机地址',//标题
            'description' => '',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        $models['mailHostPort'] = array(
            'title' => '发送邮件的主机端口',//标题
            'description' => '',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        $models['mailSendAccount'] = array(
            'title' => '发送邮件的帐号',//标题
            'description' => '',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        $models['mailSendPassword'] = array(
            'title' => '发送邮件的帐号密码',//标题
            'description' => '',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        $models['bankTypes'] = array(
            'title' => '开户银行选择',//标题
            'description' => '多个以英文逗号间隔',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 500, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        /*
        $models['vipPrice'] = array(
            'title' => 'VIP年费价格',//标题
            'description' => '单位：元',//描述
            'dataType' => 'number',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        $models['withdrawalsUnitAmount'] = array(
            'title' => '提现收费的单元金额',//标题
            'description' => '单位：元',//描述
            'dataType' => 'number',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        $models['withdrawalsUnitAmountFee'] = array(
            'title' => '提现收费的每单元金额手续费',//标题
            'description' => '单位：元',//描述
            'dataType' => 'number',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        */
        $models['pbcYearRate'] = array(
            'title' => '指导年利率',//标题
            'description' => '单位：%',//描述
            'dataType' => 'number',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        /*
        $models['borrowingMin'] = array(
            'title' => '借款最少金额',//标题
            'description' => '单位：元',//描述
            'dataType' => 'number',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        $models['borrowingUnitEnterMax1'] = array(
            'title' => '借款-客户填写投标最大限额范围（小）',//标题
            'description' => '单位：元',//描述
            'dataType' => 'number',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        $models['borrowingUnitEnterMax2'] = array(
            'title' => '借款-客户填写投标最大限额范围（大）',//标题
            'description' => '单位：元',//描述
            'dataType' => 'number',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        */
        $models['borrowingUnitMin'] = array(
            'title' => '最小投资份数',//标题
            'description' => '单位：份',//描述
            'dataType' => 'number',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        
        /*
        $models['systemIsOpen'] = array(
            'title' => '状态',//标题
            'description' => '',//描述
            'dataType' => 'number',//数据类型 string/number
            'maxlength' => 1, //长度
            'inputType' => 'radio', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array(
                array('key' => '开启', 'value' => 1),
                array('key' => '关闭', 'value' => 0)
            )//checkbox中的选项
        );

        //兴趣和爱好
        $models['like'] = array(
            'title' => '兴趣/爱好',//标题
            'description' => '',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 1, //长度
            'inputType' => 'checkbox', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array(
                array('key' => '爬山', 'value' => '爬山'),
                array('key' => '运动', 'value' => '运动'),
                array('key' => '逛街', 'value' => '逛街'),
                array('key' => '看电影', 'value' => '看电影')
            )//checkbox中的选项
        );
*/
        $models['productTitle'] = array(
            'title' => '融资产品标题',//标题
            'description' => '',//描述
            'dataType' => 'string',//数据类型 string/number
            'maxlength' => 50, //长度
            'inputType' => 'text', //输入的类型 text/editor/textarea/checkbox/radio
            'options' => array()//checkbox中的选项
        );
        
        return $models;
    }
}