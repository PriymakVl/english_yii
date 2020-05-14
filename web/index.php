<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

//for model delete item
define('STATUS_ACTIVE', 1);
define('STATUS_INACTIVE', 0);
//for model set state item
define('STATE_NOT_LEARNED', 0);
define('STATE_LEARNED', 1);
define('STATE_ALL', 2);
//for model set type item
define("TYPE_WORD", 1);
define("TYPE_SUBSTRING", 2);
define("TYPE_STRING", 3);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';
require '../functions.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
