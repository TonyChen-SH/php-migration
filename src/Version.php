<?php

/**
 * Created by PhpStorm.
 * User: chendan
 * Date: 2017/4/17
 * Time: 下午9:41
 */

namespace Tony\Migration;

use Tony\DB\Database;

class Version
{
    /**
     * @var Database
     */
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 检查数据库中是否有version表
     * @return bool
     */
    public function hasVersionTable()
    {
        $ret = false;
        $count = count($this->pdo->fetchAll("SHOW TABLES LIKE 'version'"));

        if ($count > 0) {
            $ret = true;
        }

        return $ret;
    }

    /**
     * 创建version表
     * @return bool
     */
    public function createVersionTable()
    {
        $sql = "CREATE TABLE `version` (
  `version` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        return $this->pdo->execute($sql);

    }

    /**
     * 插入最后一个版本号
     *
     * @param $value
     * @return bool
     */
    public function insertLastVersion($value)
    {
        $time = date('Y-m-d H:i:s');
        $sql = sprintf("INSERT INTO `version` (`version`, `update_time`) VALUES ($value, '%s');", $time);

        return $this->pdo->execute($sql);
    }

    /**
     * 查找最后一次更新的版本
     * @return false|int
     */
    public function pickOutUpdateVersion()
    {
        $ret = $this->pdo->fetchAll("SELECT IFNULL(MAX(`version`),0) AS `version` FROM `version` LIMIT 1;");

        return $ret[0]['version'];
    }
}