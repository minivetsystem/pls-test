<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Blog Post',
	'theme'=>'Blog Post',
	//'language'=>'en',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.giix-components.*',
		'ext.chosen.Chosen',
		'ext.JsTrans.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'test',
			'generatorPaths'=>array("application.extensions.giix-core"),
			
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('172.*','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			//'urlFormat'=>'path',
			//'showScriptName'=>false,
    		//'caseSensitive'=>true,
			'rules'=>array(
				'gii' => 'gii',
				'gii/<_c>' => 'gii/<_c>',
				'gii/<_c>/<_a>' => 'gii/<_c>/<_a>',

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=mysql;dbname=blog',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'password', //
			'charset' => 'utf8'
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			//'errorAction'=>'site/error',
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

		'clientScript'=>array(
			'coreScriptPosition'=>CClientScript::POS_END,
			'packages'=>array(
				'jquery'=>array(
					'baseUrl'=>'themes/skillgrower/assets/js/',
					'js'=>array('jquery.min.js')
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com'
	),
);
