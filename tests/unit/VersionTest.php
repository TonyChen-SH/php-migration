<?php

use Tony\Migration\CreateVersionTable;

class VersionTest extends TestBase
{
    /**
     * 测试插入版本号.
     *
     */
    public function testInsertLastVersion()
    {
        if ((new CreateVersionTable($this->version))->hasVersionTable())
        {
            $currentVersion = $this->version->pickOutUpdateVersion() + 1;
            static::assertTrue($this->version->insertLastVersion($currentVersion, 'test comment-' . $currentVersion));
        }
    }

    /**
     * 测试查找版本号.
     *
     * @depends testInsertLastVersion
     */
    public function testPickOutUpdateVersion()
    {
        static::assertGreaterThan(0, $this->version->pickOutUpdateVersion());
    }
}
