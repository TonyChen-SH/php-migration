<?php
/**
 * User: Tony Chen
 * Date: 2017/6/2.
 */

namespace Tony\Migration;

use Tony\DB\Database;

/**
 * Class AbstractMigration
 * @package Tony\Migration
 */
abstract class AbstractMigration
{
    private $pdo;

    /**
     * @return Database
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * @param mixed $pdo
     */
    public function setPdo($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 数据库操作的实现此方法.
     *
     * @return mixed
     */
    abstract public function change();

    /**
     * 数据库操作备注
     *
     * @return string
     */
    abstract public function getComment();
}
