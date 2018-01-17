<?php

/**
 * Created by PhpStorm.
 * User: chendan
 * Date: 2017/4/17
 * Time: 下午9:41.
 */

namespace Tony\Migration;

use Tony\DB\Database;

/**
 * Class Version
 * @package Tony\Migration
 */
class Version
{
    /**
     * @var Database
     */
    private $pdo;

    /**
     * Version constructor.
     * @param $pdo
     */
    public function __construct($pdo)
    {
        $this->setPdo($pdo);
    }

    /**
     * 创建version表
     */
    public function checkAndCreateTable()
    {
        (new CreateVersionTable($this))->checkAndCreateTable();
    }

    /**
     * 插入最后一个版本号.
     *
     * @param $value
     * @param $comment
     *
     * @return bool
     */
    public function insertLastVersion($value, $comment)
    {
        $time    = date('Y-m-d H:i:s');
        $comment = empty($comment) ? ' ' : $comment;

        $sql = sprintf("INSERT INTO `version` (`version`, `update_time`,`comment`) VALUES ($value, '%s','%s');", $time, $comment);
        return $this->pdo->execute($sql);
    }

    /**
     * 查找最后一次更新的版本.
     *
     * @return false|int
     */
    public function pickOutUpdateVersion()
    {
        $ret = $this->pdo->fetchAll('SELECT IFNULL(MAX(`version`),0) AS `version` FROM `version` LIMIT 1;');

        return $ret[0]['version'];
    }

    /**
     * 是否有指定版本号
     * @param $version
     * @return bool
     */
    public function hasVersionNumber($version)
    {
        $ret = $this->pdo->fetchAll("SELECT `version` FROM `version` WHERE `version`={$version} LIMIT 1;");

        return !empty($ret) ? true : false;
    }

    /**
     * @return Database
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param Database $pdo
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }
}
