## php migration 
[![StyleCI](https://styleci.io/repos/93504337/shield?branch=develop)](https://styleci.io/repos/93504337)

### 如果有以下几种问题，那么你就来对地方了
- 每次部署程序，都要手动导入数据？
- 每次数据库字段更新，都要手动去执行一遍？
- 服务器辣么多，更新数据库要一个一个的手动去执行？
- 团队协作，同事更新了数据库结构，我们用的不是同一个测试数据库，程序报错？

### 一个小工具，解决你的难题：
> migration是一个数据版本管理工具，每次的数据库结构的更改，都用sql语句的形式写下来，让php程序去执行。当前数据库版本执行完毕，version表对记录当前执行的数据库版本号，当下次执行的时候会进行比对。如果当前执行的版本小于等于version表的最近版本，就不做执行更新操作，如果大于最新版本，就执行更新操作

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
    },
    {
      "type": "vcs",
      "url": "https://github.com/TonyChen-SH/php-db.git"
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

### 许可
本项目采用Apache License 2.0协议，了解更多请看协议文件。
