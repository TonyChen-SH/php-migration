<?php

use Tony\Migration\DbUpdate;

/**
 * User: Tony Chen
 * Date: 2017/6/3.
 */
class DbUpdateTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    /**
     * @var DbUpdate
     */
    protected $dbUpdate;

    protected function _before()
    {
        $path = DB_VERSION_PATH;
        $this->dbUpdate = new DbUpdate(getDbConfig(), $path);
    }

    protected function _after()
    {
    }

    // tests
    public function testGetVersionFileList()
    {
        $files = $this->dbUpdate->getVersionFileList();

        $this->assertGreaterThan(0, count($files));
    }
}