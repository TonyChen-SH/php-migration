<?php
/**
 * User: Tony Chen
 * Date: 2017/6/2.
 */

namespace Tony\Migration;

use Tony\DB\DbFactory;

class DbUpdate
{
    private $pdo;
    private $dbVersionPath;

    public function __construct(array $dbConfig, $dbVersionPath)
    {
        $this->pdo = DbFactory::getInstance($dbConfig);
        $this->dbVersionPath = $dbVersionPath;
    }

    /**
     * 执行更新操作的入口.
     */
    public function update()
    {
        $version = $this->checkVersionTable();

        if ($version === false) {
            throw new \Exception('version表操作失败');
            exit();
        }

        $versionList = $this->getVersionFileList();

        foreach ($versionList as $ver => $versionFile) {
            // 如果没有按规定的规则给数据库版本文件起名，会报错
            // 文件夹格式： V1.php / V2.php / V3.php ......
            if (!is_numeric($ver)) {
                throw new \Exception("version is not a number.--> {$ver}");
                exit();
            }

            //如果数据库最新的版本比当前版本文件大，就不需要更新了(因为已经更新过了).
            if ($version >= $ver) {
                continue;
            }

            include $this->dbVersionPath.$versionFile;

            // 类名同文件名一致
            $className = basename($versionFile, '.php');

            /**
             * @var AbstractMigration
             */
            $instance = new $className();
            //传递model
            $instance->setPdo($this->pdo);
            //执行变动
            $instance->change();
            //更新版本号到最新
            $this->updateVersionNumber($ver);
        }
    }

    /**
     * 检查version表是否创建，并找出最新的版本号.
     *
     * @return int|false
     */
    protected function checkVersionTable()
    {
        $version = new Version($this->pdo);
        //不存在version的情况下就创建一个
        if ($version->hasVersionTable() === false) {
            $version->createVersionTable();
        }

        //返回最新版本号
        return $version->pickOutUpdateVersion();
    }

    /**
     * 更新数据库版本号.
     *
     * @param int $value
     */
    protected function updateVersionNumber($value)
    {
        $version = new Version($this->pdo);
        $version->insertLastVersion($value);
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
        if (!is_dir($this->dbVersionPath)) {
            throw new \Exception('dbVersionPath is not dir');
            exit();
        }

        $versionFileList = [];
        $iterator = new \DirectoryIterator($this->dbVersionPath);
        foreach ($iterator as $versionFile) {
            if ($versionFile->isFile()) {
                $fileName = $versionFile->getFilename();
                $versionFileList[substr(basename($fileName, '.php'), -1, 1)] = $fileName;
            }
        }

        return $versionFileList;
    }
}
