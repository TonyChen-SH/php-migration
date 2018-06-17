<?php

use Tony\Migration\CreateVersionTable;

/**
 * User: Tony Chen
 * Contact me: QQ329037122
 */
class CreateVersionTableTest extends TestBase
{
    /**
     * @var CreateVersionTable
     */
    protected $obj;

    protected function _before()
    {
        parent::_before();
        $this->obj = new CreateVersionTable($this->version);
    }

    /**
     * @depends testHasVersionTable
     * @param $hasTable
     */
    public function testCheckAndCreateTable($hasTable)
    {
        if (!$hasTable)
        {
            static::assertTrue($this->obj->checkAndCreateTable());
        }

        self::assertFalse(false);
    }

    /**
     * 是否有version表
     * @return bool
     */
    public function testHasVersionTable()
    {
        if ($this->obj->hasVersionTable())
        {
            static::assertTrue($this->obj->hasVersionTable());

            return true;
        }

        static::assertFalse($this->obj->hasVersionTable());
        return false;
    }

    /**
     * @depends testCheckAndCreateTable
     */
    public function testHasTableColumn()
    {
        self::assertTrue($this->obj->hasTableColumn('comment'));
    }
}
