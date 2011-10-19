<?php
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

return array(
    'basePath' => dirname(__FILE__) . DS . '..',
    'id' => 'onenote.me',
    'name' => 'onenote.me',
    'language' => 'zh_cn',
    'charset' => 'utf-8',

    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.apis.*',
        'application.libs.*',
    ),
    'preload' => array('log'),
    'components' => array(
        'log' => array(
            'class' => 'CLogRouter',
			'routes' => array(
				array(
					'class' => 'CFileLogRoute',
					'levels' => 'trace, info, error, warning, watch',
				    'categories' => 'system.*',
				),
            ),
        ),
        'db' => array(
            'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=127.0.0.1; port=3306; dbname=cd_onenote',
			'username' => 'root',
		    'password' => '123',
		    'charset' => 'utf8',
		    'persistent' => true,
		    'tablePrefix' => 'cd_',
		    //'schemaCacheID' => 'cache',
		    //'schemaCachingDuration' => 3600,    // metadata 缓存超时时间(s)
        ),
        'cache' => array(
            'class' => 'CFileCache',
		    'directoryLevel' => 2,
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
		    'showScriptName' => false,
            'cacheID' => 'cache',
        ),
    ),
    
    'params' => array(
        'myname' => 'chen dong',
    ),
);