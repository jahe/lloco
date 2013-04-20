<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'lloco',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.YiiMongoDbSuite.*',
		//'ext.directmongosuite.components.*',
		'ext.LLoginForm.*',
		'ext.LUserMenu.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	/*
	'behaviors' => array(
		'edms' => array(
			'class'=>'EDMSBehavior',

			'connectionId' => 'mongodb' //if you work with yiimongodbsuite

			//see the application component 'EDMSConnection' below
			// 'connectionId' = 'edms' //default;
			//'debug'=>true //for extended logging
		)
	),
	*/
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'mongodb' => array(
			'class'            => 'EMongoDB',
			'connectionString' => 'mongodb://localhost',
			'dbName'           => 'lloco',
			'fsyncFlag'        => false,
			'safeFlag'         => false,
			'useCursor'        => false
		),
		/*'edms' => array(
			'class' => 'EDMSConnection',
			'dbname' => 'lloco'
		),*/
		/*
		//manage the httpsession in the collection 'edms_httpsession'
        'session'=>array(
			'class'=>'EDMSHttpSession',
			//set this explizit if you want to switch servers/databases
			//See below: Switching between servers and databases                        
			//'connectionId'=>'edms',
			//'dbName'=>'testdb',
		),

        //manage the cache in the collection 'edms_cache'
        'cache' => array(
            'class'=>'EDMSCache',
            //set to false after first use of the cache to increase performance
            'ensureIndex' => true,

            //Maybe set connectionId and dbName too: see Switching between servers and databases
        ),

        //log into the collection 'edms_log'
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'EDMSLogRoute',
                      'levels'=>'trace, info, error, warning, edms', //add the level edms
                      //Maybe set connectionId and dbName too: see Switching between servers and databases 
                    ),
            ),
        ),
 
        //uses the collection 'edms_authmanager' for the authmanager
        'authManager'=>array
        */
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'ekip@gmx.de',
	),
	// Meine Config
	'layout' => 'main',
);