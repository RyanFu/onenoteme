<?php
define('CD_CONFIG_ROOT', dirname(__FILE__));
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

try {
    $params = require(CD_CONFIG_ROOT . DS . 'params_develop.php');
    $cachefile = $params['dataPath'] . DS . 'setting.config.php';
    if (file_exists($cachefile)) {
        $customSetting = require($cachefile);
        $params = array_merge($params, $customSetting);
    }
}
catch (Exception $e) {
    echo $e->getMessage();
    exit(0);
}

return array(
    'basePath' => dirname(__FILE__) . DS . '..',
    'id' => 'waduanzi.com',
    'name' => '挖段子',
    'language' => 'zh_cn',
    'charset' => 'utf-8',
    'timezone' => 'Asia/Shanghai',

    'import' => array(
        'application.dmodels.*',
        'application.models.*',
        'application.extensions.*',
        'application.components.*',
        'application.libs.*',
        'application.widgets.*',
    ),
    'modules' => array(
        'admin' => array(
            'layout' => 'main',
        ),
        'member' => array(
            'layout' => 'main',
        ),
        'mobile' => array(
            'layout' => 'main',
        ),
    ),
    'preload' => array('log'),
    'components' => array(
        'log' => array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'categories'=>'system.db.*',
                ),
                /* array(
                    'class'=>'CWebLogRoute',
                    'levels'=>'trace,info,error,notic',
                    'categories'=>'system.db.*',
                ), */
            ),
        ),
        'db' => array(
            'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1; port=3306; dbname=cd_waduanzi',
			'username' => 'root',
		    'password' => '123',
		    'charset' => 'utf8',
		    'persistent' => true,
		    'tablePrefix' => 'cd_',
            'enableParamLogging' => true,
            'enableProfiling' => true,
//		    'schemaCacheID' => 'cache',
//		    'schemaCachingDuration' => 3600,    // metadata 缓存超时时间(s)
//		    'queryCacheID' => 'cache',
//		    'queryCachingDuration' => 3600,
        ),
        'cache' => array(
            'class' => 'CFileCache',
		    'directoryLevel' => 2,
        ),
        'assetManager' => array(
            'basePath' => $params['resourceBasePath'] . 'assets',
            'baseUrl' => $params['resourceBaseUrl'] . 'assets',
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'assignmentTable' => '{{auth_assignment}}',
            'itemChildTable' => '{{auth_itemchild}}',
            'itemTable' => '{{auth_item}}',
        ),
        'widgetFactory'=>array(
            'enableSkin' => true,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
		    'showScriptName' => false,
//             'cacheID' => 'cache',
            'rules' => array(
                'http://wap.waduanzi.cn' => 'wap/index',
                'http://wap.waduanzi.cn/<_a>' => 'wap/<_a>',
                'http://m.waduanzi.cn' => 'mobile/default/index',
                'http://m.waduanzi.cn/<_c>' => 'mobile/<_c>',
                'http://m.waduanzi.cn/<_c>/<_a>' => 'mobile/<_c>/<_a>',
                    
                '/' => 'site/index',
                '<_a:(login|signup|logout)>' => 'site/<_a>',
                '<_a:(duanzi|lengtu|girl|video|focus)>-<page:\d+>' => 'channel/<_a>',
                '<_a:(duanzi|lengtu|girl|video|focus)>' => 'channel/<_a>',
                'post-<id:\d+>' => 'post/show',
                'originalpic/<id:\d+>' => 'post/bigpic',
                'tags' => 'tag/list',
                'tag-<name:.+>' => 'tag/posts',
                'feed/<cid:\d+>' => 'feed/channel',
            ),
        ),
        'session' => array(
            'autoStart' => true,
            'cookieParams' => array(
                'lifetime' => $params['autoLoginDuration'],
            ),
        ),
        'user' => array(
            'allowAutoLogin' => true,
            'loginUrl' => array('/site/login'),
            'guestName' => '匿名人士',
        ),
    ),
    
    'params' => $params,
);


    