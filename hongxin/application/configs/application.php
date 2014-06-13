<?php
return array(
    /**
     * 库文件路径
     */
    'includePaths' => array(
        'library'=> APPLICATION_PATH . '/../library'
    ),

    /**
     * 类自动加载的前缀
     */
    'autoloadernamespaces' => array(
        '0' => 'Zend_',
        '1' => 'PHPExcel_'
    ),
    
    /**
     * App
     */
    'appnamespace' => 'Application',

    /**
     * 引导类路径信息
     */
    'bootstrap' => array(
        'path' => APPLICATION_PATH . '/Bootstrap.php',
        'class' => 'Bootstrap',
    ),

    /**
     * resource配置 
     */
    'resources' => array(
        'frontController' => array(
            'moduleDirectory' => APPLICATION_PATH . '/modules',
            'moduleControllerDirectoryName' => 'controllers',
            'defaultModule' => 'default',
            'noErrorHandler' => 0,
            'throwExceptions' => 0,
            //'baseurl' => '/index.php',
            'baseurl' => '',
        ), 
        'session' => array(
            'save_path' => APPLICATION_PATH . '/data/session',
            'remember_me_seconds' => 864000
        ),
        'view' => array(
            'encoding' => 'utf-8',
            'helperPathPrefix' => 'Project_View_Helper_',
            'helperPath' => APPLICATION_PATH . '/../library/Project/View/Helper',
            'frontPublicScriptPath' => APPLICATION_PATH . '/modules/frontPublic/views/scripts'
        ),
        'db' => require 'db.php'
    ),

    /**
     * 项目配置 
     */
    'project' => array(
        'baseUrl' => '', //基本路径
        'configCachePath' => PUBLIC_PATH . '/data/configCache', //配置文件缓存路径，永久数据
        'cookieDomain' => '', //域名，不要随便修改,cookie也用到
        'cookiePrefix' => 'sys_',
        'authKey' => '上3来看对5dsd方  2383（3（）凡3_)事dksd+', //;验证的加密码
        'uploadPath' => PUBLIC_PATH . '/files/upload', //上传路径
        'uploadUrl' => '/files/upload', //上传文件访问的URL
        'admin' => array(
            'effectiveOnlineTime' => '10', //系统管理-有效在线时间，单位秒
            'loginTimeoutTime' => '3600', //系统管理-登录后的超时时间，单位秒
            'master' => 'cdlei'
        ),
        'zendCachePath' => PUBLIC_PATH . '/data/zendCache',

    	'ysbVars' => array(
    		'merchantId' => '1120070601142112001',
    		'merchantKey' => '123456',
    		'smsId' => 42,
    		'smsPlatform' => 'uns_fyjr',
    		'smsPlatformPwd' => '546279',
			'url' => array(
				'sms' => 'http://211.147.83.237/Smsg/sms/send',
    			'register' => 'http://180.166.114.155:8082/p2bServer-lgjr/p2p/registerAction.action',
				'payment' => 'http://180.166.114.155:8082/p2bServer-lgjr/p2p/rechargeReqAction.action',
				'freeze' => 'http://180.166.114.155:8082/p2bServer-lgjr/p2p/freezeMoneyAction.action',
				'thaw' => 'http://180.166.114.155:8082/p2bServer-lgjr/p2p/thawMoneyAction.action',
				'refund' => 'http://180.166.114.155:8082/p2bServer-lgjr/p2p/refundAction.action',
				'queryBalance' => 'http://180.166.114.155:8082/p2bServer-lgjr/p2p/queryBalanceAction.action',
    		),
        ),

        'memberVars' => array(
            'marriageStatus' => array('1'=>'未婚', '2'=>'已婚', '3'=>'离婚', '4'=>'丧偶'),
            'childrenStatus' => array('1'=>'无子女', '2'=>'一个', '3'=>'两个', '4'=>'两个以上'),
            'education' => array('1'=>'小学/初中', '2'=>'高中/中专', '3'=>'大专/本科', '4'=>'硕士', '5'=>'博士', '6'=>'其他'),
            'companyType' => array('1'=>'政府机关', '2'=>'事业单位', '3'=>'大型国有企业', '4'=>'大型私营企业', '5'=>'外资企业', '6'=>'小型企业', '7'=>'个体户'),
            'workCharacter' => array('1'=>'普通员工', '2'=>'管理人员', '3'=>'股东', '4'=>'私营业主'),
            'preTaxIncome' => array('1'=>'3000~5000', '2'=>'5000~8000', '3'=>'8000~12000', '4'=>'12000~18000', '5'=>'18000~25000', '6'=>'25000以上'),
            'isHaveSocialInsurance' => array('1'=>'有', '2'=>'无'),

        	'orderType' => array('10'=>'等待付款', '20'=>'冻结成功', '25'=>'投资成功', '30'=>'已取消', '40'=>'已退款'),	
        	
            'houseType' => array('1'=>'自有房屋无按揭', '2'=>'自有房屋有按揭', '3'=>'租房'),
            'isHaveAuto' => array('1'=>'有', '0'=>'无'),
            'autoIsMortgage' => array('1'=>'是', '0'=>'否'),
            'creditCardIsHaveExpired' => array('1'=>'有', '0'=>'无'),

            'industry' => array('1'=>'农林牧渔业', '1'=>'农林牧渔业', '2'=>'制造业', '3'=>'电力、燃气，水生产和供用', '4'=>'建筑业', '5'=>'交通运输、仓储和邮政业', '6'=>'信息传输、计算机服务和软件开发', 
                        '7'=>'批发和零售业', '8'=>'金融业', '9'=>'房地产业', '10'=>'采矿业', '11'=>'租赁和商务服务业', '12'=>'科学研究、技术服务', '13'=>'水利环境和公共设施管理', '14'=>'居民服务和其他服务业', '15'=>'教育业', '16'=>'卫生、社会保障和社会服务'
                        , '17'=>'文化体育和娱乐', '18'=>'公共管理和社会组织', '19'=>'国际组织'),
            'premises' => array('1'=>'租用', '2'=>'自有'),
            'contactRelationships' => array('1'=>'父亲', '2'=>'母亲', '3'=>'配偶', '4'=>'兄弟姐妹', '5'=>'子女', '6'=>'朋友/同事'),
        ),
        'memberAvatarBasePath' => PUBLIC_PATH . '/files/upload/member-avatar',
        'memberAvatarBaseUrl' => '/files/upload/member-avatar',
        'memberAvatarDefaultUrl' => '/files/default/images/no-avatar.jpg',
        'serviceAvatarBasePath' => PUBLIC_PATH . '/files/upload/service-avatar',
        'serviceAvatarBaseUrl' => '/files/upload/service-avatar',
        'serviceAvatarDefaultUrl' => '/files/default/images/no-avatar.jpg',
        'certificateCopyBasePath' => PUBLIC_PATH . '/files/upload/certificate-copy',
    	'certificateCopyBaseUrl' => '/files/upload/certificate-copy',
    	'ticketCopyBasePath' => PUBLIC_PATH . '/files/upload/ticket-copy',
    	'ticketCopyBaseUrl' => '/files/upload/ticket-copy',
    	'uploadPath' => PUBLIC_PATH . '/files/upload',
        'uploadUrl' => '/files/upload',
    ),

    /**
     * PHP配置 
     */
    'phpSettings' => array(
        'date' => array(
            'timezone' => 'Asia/Shanghai'
        ),
        'display_startup_errors' => 1,
        'display_errors' => '1'
    )
);