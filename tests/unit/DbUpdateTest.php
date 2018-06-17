<?php

use Tony\Migration\DbUpdate;

/**
 * User: Tony Chen
 * Date: 2017/6/3.
 */
class DbUpdateTest extends TestBase
{
    /**
     * @var DbUpdate
     */
    protected $dbUpdate;

    protected function _before()
    {
        parent::_before();
        $path           = DB_VERSION_PATH;
        $this->dbUpdate = new DbUpdate(getDbConfig(), $path);
    }

    // tests
    public function testGetVersionFileList()
    {
        $files = $this->dbUpdate->getVersionFileList();

        static::assertGreaterThan(0, count($files));
    }

    /**
     * @depends testGetVersionFileList
     */
    public function testUpdate()
    {
        $this->dbUpdate->update();
    }
}
