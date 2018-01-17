<?php

use Tony\DB\DbFactory;
use Tony\DB\Exception\ConnectionException;
use Tony\Migration\Version;

/**
 * User: Tony Chen
 * Contact me: QQ329037122
 */
class TestBase extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private   $pdo;
    /**
     * @var Version
     */
    protected $version;

    protected function _before()
    {
        try
        {
            $this->pdo     = DbFactory::getInstance(getDbConfig());
            $this->version = new Version($this->pdo);
        } catch (ConnectionException $e)
        {
        }
    }

    protected function _after()
    {
    }
}