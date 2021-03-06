## php-migration 数据库更新维护管理库
[![StyleCI](https://styleci.io/repos/93504337/shield?branch=develop)](https://styleci.io/repos/93504337)

### 如果有以下几种问题，那么你就来对地方了
- 每次部署程序，都要手动导入数据？
- 每次数据库字段更新，都要手动去执行一遍？
- 服务器辣么多，更新数据库要一个一个的手动去执行？
- 团队协作，同事更新了数据库结构，我们用的不是同一个测试数据库，程序报错？

### 一个小工具，解决你的难题：
> php-migration是一个数据库更新维护管理库，每次的数据库结构的更改，都用sql语句的形式写下来，让php程序去执行。当前数据库版本执行完毕，version表对当前执行的数据库版本号进行记录，当下次执行的时候会进行比对。如果当前执行的版本小于等于version表的最近版本，就不做执行更新操作，如果大于最新版本，就执行更新操作

### Install
```bash
$ composer require tonychen/php-migration
```
或者
```php
  // 把下面的代码片段，加入到composer.json文件里面
  "require": {
    "tonychen/php-migration": "^0.1.0"
  }
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
$dbUpdate = new DbUpdate(['dsn' => 'mysql:host=127.0.0.1;dbname=migration;charset=utf8', 'user' => 'root', 'password' => '123456'], $path);
// 开始数据库版本升级
$dbUpdate->update();

// 具体的可以看下example底下有使用示例
// 数据库版本文件名，命名格式：V1.php ，V(大写)是必须有的字符，1代表当前版本号。 可以是>=1的任意整数，不可以重复
//    1.首先这是一个类文件
//    2.文件夹名与类名相同
//    3.集成与实现migration接口
````
![table show](images/2018/01/table-show.png)

### TODO
- [x] 删除指定版本的版本号以后，可以把该版本号重新执行一遍
- [x] 每个版本号，数据内需要更新内容的备注

### 许可
本项目采用Apache License 2.0协议，了解更多请看协议文件。
