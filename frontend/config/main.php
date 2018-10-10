<?
use \kartik\datecontrol\Module;
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
	'modules' => [
	    'gridview' =>  ['class' => '\kartik\grid\Module'],
        'datecontrol' => [
            'class' => '\kartik\datecontrol\Module',
            'displaySettings' => [
                Module::FORMAT_DATE => 'dd-MM-yyyy',
                Module::FORMAT_TIME => 'hh:mm:ss a',
                Module::FORMAT_DATETIME => 'dd-MM-yyyy hh:mm:ss a',
            ],
            'saveSettings' => [
                Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
                Module::FORMAT_TIME => 'php:H:i:s',
                Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
        ],

	],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'bot' => [
            'class' => 'frontend\components\TelegramComponent',
            'apiToken' => '411890271:AAG234gsdf252!@3gdsgwwe',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
             'rules' => [
				'admin' => 'zakaz/admin',
				'view/<id:\d+>' => 'zakaz/view',
				'disain' => 'zakaz/disain',
				'master' => 'zakaz/master',
				'shop' => 'zakaz/shop',
				'courier' => 'courier/index',
				'todoist' => 'todoist/index',
				'helpdesk' => 'helpdesk/index',
				'custom' => 'custom/index',
				'versia' => 'zakaz/index',
				'create' => 'zakaz/create',
				'updete/<id:\d+>' => 'zakaz/update',
				'login' => 'site/login',
				'logout' => 'site/logout',
				'createzakaz/<id_zakaz:\d+>' => 'todoist/createzakaz',
				'view-todoist/<id:\d+>' => 'todoist/view',

            ],
        ],
    ],
    'params' => $params,
];
