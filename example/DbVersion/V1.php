<?php

use Tony\Migration\AbstractMigration;

/**
 * User: Tony Chen
 * Date: 2017/6/3.
 */

/**
 * 数据库初始化的版本
 * 类型命名规则：V+数字，如V1代表的是版本号1,会在version数据库的version字段插入新值1
 */
class V1 extends AbstractMigration
{
    /**
     * 数据库操作的实现此方法
     * @return mixed
     */
    function change()
    {
        $sql = "CREATE TABLE babel
        (
	      player_id BIGINT NOT NULL
		  PRIMARY KEY,
	      babel_info TEXT NOT NULL
        );";

        $this->getPdo()->exec($sql);
    }
}