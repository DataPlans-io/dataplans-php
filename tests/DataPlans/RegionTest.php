<?php
require_once dirname(__FILE__).'/TestConfig.php';

class RegionTest extends TestConfig
{
    /**
     * @test
     * DataPlansRegion class must be contain some method below.
     */
    public function method_exists()
    {
        $this->assertTrue(method_exists('DataPlansRegion', 'retrieve'), 'Method retrieve not exists');
        $this->assertTrue(method_exists('DataPlansRegion', 'reload'), 'Method reload not exists');
        $this->assertTrue(method_exists('DataPlansRegion', 'getUrl'), 'Method getUrl not exists');
    }

    /**
     * @test
     * Assert that a country object is returned after a successful retrieve.
     */
    public function retrieve_object()
    {
        $object = DataPlansRegion::retrieve();

        $this->assertInstanceOf('DataPlansRegion', $object, 'Retrieve data is invalid');
        if (!empty($object)) {
            $this->assertArrayHasKey('slug', $object[0], 'Key slug not exist');
        }
    }

    /**
     * @test
     * Assert that a country object is returned after a successful reload.
     */
    public function reload()
    {
        $object = DataPlansRegion::retrieve();
        $object->reload();

        $this->assertInstanceOf('DataPlansRegion', $object, 'Retrieve data is invalid');
        if (!empty($object)) {
            $this->assertArrayHasKey('slug', $object[0], 'Key slug not exist');
        }
    }
}
