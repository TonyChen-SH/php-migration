## php migration 
[![StyleCI](https://styleci.io/repos/93504337/shield?branch=develop)](https://styleci.io/repos/93504337)

### Install
```php
  // 把下面的代码片段，加入到composer.json文件里面
  // 由于tony这个命名空间在packagist已经有人用了，我的加不进去，暂代用直连方式
  "require": {
    "tony/migration": "0.1"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/TonyChen-SH/migration.git"
    }
  ]
```

### Usage

```php

// 引入自动加载
require '../vendor/autoload.php';
require '../password.php';

use Tony\Migration\DbUpdate;

define('APP_PATH', __DIR__.'/../');
// 设置数据库版本文件路径。
define('DB_VERSION_PATH', APP_PATH.'example/DbVersion/');

$path = DB_VERSION_PATH;
// 初始化数据库版本工具[数据库配置,数据库版本文件文件夹路径]
$dbUpdate = new DbUpdate(['dsn' => 'mysql:host=127.0.0.1;dbname=migration', 'user' => 'root', 'password' => '123456'], $path);
// 开始数据库版本升级
$dbUpdate->update();

// 具体的可以看下example底下有使用示例
// 数据库版本文件名，命名格式：V1.php ，V(大写)是必须有的字符，1代表当前版本号。 可以是>=1的任意整数，不可以重复
//    1.首先这是一个类文件
//    2.文件夹名与类名相同
//    3.集成与实现migration接口

````

````php

````
