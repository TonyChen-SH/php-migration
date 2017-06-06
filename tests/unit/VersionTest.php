<?php

use Tony\DB\DbFactory;
use Tony\Migration\Version;

class VersionTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $pdo;
    /**
     * @var Version
     */
    private $version;

    protected function _before()
    {
        $this->pdo = DbFactory::getInstance(getDbConfig());
        $this->version = new Version($this->pdo);
    }

    protected function _after()
    {
    }

    // tests
    public function testHasVersionTable()
    {
        if ($this->version->hasVersionTable()) {
            $this->assertTrue($this->version->hasVersionTable());

            return true;
        }

        return false;
    }

    /**
     * 测试创建表.
     *
     * @depends testHasVersionTable
     */
    public function testCreateVersionTable($hasTable)
    {
        if (!$hasTable) {
            $this->assertTrue($this->version->createVersionTable());
        }
    }

    /**
     * 测试插入版本号.
     *
     * @depends testHasVersionTable
     */
    public function testInsertLastVersion($hasTable)
    {
        if ($hasTable) {
            $this->assertTrue($this->version->insertLastVersion($this->version->pickOutUpdateVersion() + 1));

            return true;
        }

        return false;
    }

    /**
     * 测试查找版本号.
     *
     * @depends testInsertLastVersion
     */
    public function testPickOutUpdateVersion($bool)
    {
        if ($bool) {
            $this->assertGreaterThan(0, $this->version->pickOutUpdateVersion());
        }
    }
}
