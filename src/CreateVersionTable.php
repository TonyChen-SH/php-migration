<?php
/**
 * User: Tony Chen
 * Contact me: QQ329037122
 */

namespace Tony\Migration;

/**
 * Class CreateVersionTable
 * @package Tony\Migration
 */
class CreateVersionTable
{
    /**
     * @var Version
     */
    private $version;

    /**
     * CreateVersionTable constructor.
     * @param Version $version
     */
    public function __construct(Version $version)
    {
        $this->version = $version;
    }

    /**
     * 创建version表
     */
    public function checkAndCreateTable()
    {
        // 判断是否有表
        if (!$this->hasVersionTable())
        {
            $this->createVersionTable();
        }

        // version表新增新的字段
        // 加入comment(备注)字段
        $this->updateTableForComment();
        return true;
    }

    /**
     * 创建version表.
     *
     * @return bool
     */
    public function createVersionTable()
    {
        $sql = "CREATE TABLE `version` (
  `version` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        return $this->version->getPdo()->execute($sql);
    }

    /**
     * 新增一个comment表字段
     *
     * @return boolean
     */
    public function updateTableForComment()
    {
        if ($this->hasTableColumn('comment'))
        {
            return false;
        }

        return $this->version->getPdo()->execute("ALTER TABLE `version` ADD COLUMN `comment`  VARCHAR(255) NOT NULL DEFAULT '' AFTER `update_time`");
    }

    /**
     * 检查数据库中是否有version表.
     *
     * @return bool
     */
    public function hasVersionTable()
    {
        $ret   = false;
        $count = count($this->version->getPdo()->fetchAll("SHOW TABLES LIKE 'version'"));

        if ($count > 0)
        {
            $ret = true;
        }

        return $ret;
    }

    /**
     * 是否有表字段
     * @param $columnName
     * @return bool
     */
    public function hasTableColumn($columnName)
    {
        $sql = sprintf("SHOW COLUMNS FROM `version` LIKE '%s';", $columnName);

        return !$this->version->getPdo()->fetchRow($sql) ? false : true;
    }
}