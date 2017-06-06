<?php
/**
 * User: Tony Chen
 * Date: 2017/6/3.
 */

require '../vendor/autoload.php';
require '../password.php';

use Tony\Migration\DbUpdate;

define('APP_PATH', __DIR__ . '/../');
define('DB_VERSION_PATH', APP_PATH . 'example/DbVersion/');

$path = DB_VERSION_PATH;
$dbUpdate = new DbUpdate(getDbConfig(), $path);
$dbUpdate->update();