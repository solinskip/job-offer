<?

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

Yii::setAlias('@base', dirname(__DIR__));
Yii::setAlias('@app', dirname(__DIR__ . '/../../'));
Yii::setAlias('@webroot', dirname(__DIR__ . '/../../'));
Yii::setAlias('@anyname', realpath(dirname(__FILE__)));

Yii::setAlias('@storage', dirname(__DIR__) . '//storage');

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();