<?php
/**
 * User: Tony Chen
 * Date: 2017/6/2.
 */

namespace Tony\Migration;

use Tony\DB\DbFactory;

/**
 * Class DbUpdate
 * @package Tony\Migration
 */
class DbUpdate
{
    private $pdo;
    private $dbVersionPath;

    /**
     * DbUpdate constructor.
     *
     * @param array  $dbConfig
     * @param string $dbVersionPath
     * @throws \Tony\DB\Exception\ConnectionException
     */
    public function __construct($dbConfig, $dbVersionPath)
    {
        $this->pdo           = DbFactory::getInstance($dbConfig);
        $this->dbVersionPath = $dbVersionPath;
    }

    /**
     * 获取数据库对象.
     *
     * @return \Tony\DB\Database
     */
    public function getPdo()
    {
        return $this->pdo;
    }

    /**
     * 执行更新操作的入口.
     */
    public function update()
    {
        $versionList = $this->getVersionFileList();

        foreach ($versionList as $nextVer => $versionFile)
        {
            // 每次执行前，都获取一次最新的数据库版本号
            $curVerNumber = $this->getCurrentVersionNumber();
            if ($curVerNumber === false)
            {
                throw new \Exception('version表操作失败');
                exit();
            }

            // 如果没有按规定的规则给数据库版本文件起名，会报错
            // 文件夹格式： V1.php / V2.php / V3.php ......
            if (!is_numeric($nextVer))
            {
                throw new \Exception("version is not a number.--> {$nextVer}");
                exit();
            }

            // 如果数据库最新的版本比当前版本文件大，就不需要更新了(因为已经更新过了).
            // 如果当前版本号没有，就需要被更新掉(这样就可以删除指定版本号，进行指定更新操作)
            if ($curVerNumber >= $nextVer && $this->hasVersionNumber($nextVer))
            {
                continue;
            }

            // 数据版本不能跨版本号执行操作
            // 防止多次请求造成的跨版本号执行
            if (($nextVer - 1) > $curVerNumber)
            {
                continue;
            }

            include $this->dbVersionPath . $versionFile;
            // 类名同文件名一致
            $className = basename($versionFile, '.php');

            /**
             * @var $instance AbstractMigration
             */
            $instance = new $className();
            // 传递model
            $instance->setPdo($this->pdo);
            // 执行变动
            $instance->change();
            // 获取当次有关数据库变动的备注
            $comment = $instance->getComment();
            //更新版本号到最新
            $this->updateVersionNumber($nextVer, $comment);
        }
    }

    /**
     * 找出当前最新的版本号.
     *
     * @return int|false
     */
    protected function getCurrentVersionNumber()
    {
        $version = new Version($this->pdo);
        $version->checkAndCreateTable();

        //返回最新版本号
        return $version->pickOutUpdateVersion();
    }

    /**
     * 是否有指定版本号
     * @param $versionNumber
     * @return bool
     */
    protected function hasVersionNumber($versionNumber)
    {
        return (new Version($this->pdo))->hasVersionNumber($versionNumber);
    }

    /**
     * 更新数据库版本号.
     *
     * @param int    $value
     * @param string $comment 版本备注
     */
    protected function updateVersionNumber($value, $comment = '')
    {
        $version = new Version($this->pdo);
        $version->insertLastVersion($value, $comment);
    }

    /**
     * 根据根据路径取数据库版本文件.
     *
     * @throws \Exception
     *
     * @return array
     */
    public function getVersionFileList()
    {
        if (!is_dir($this->dbVersionPath))
        {
            throw new \Exception('dbVersionPath is not dir');
            exit();
        }

        $versionFileList = [];
        $iterator        = new \DirectoryIterator($this->dbVersionPath);
        foreach ($iterator as $versionFile)
        {
            if ($versionFile->isFile())
            {
                $fileName                                                    = $versionFile->getFilename();
                $versionFileList[substr(basename($fileName, '.php'), -1, 1)] = $fileName;
            }
        }

        return $versionFileList;
    }
}
