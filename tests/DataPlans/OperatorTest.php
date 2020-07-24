<?php
require_once dirname(__FILE__).'/TestConfig.php';

class OperatorTest extends TestConfig
{
    /**
     * @test
     * DataPlansOperator class must be contain some method below.
     */
    public function method_exists()
    {
        $this->assertTrue(method_exists('DataPlansOperator', 'retrieve'), 'Method retrieve not exists');
        $this->assertTrue(method_exists('DataPlansOperator', 'reload'), 'Method reload not exists');
        $this->assertTrue(method_exists('DataPlansOperator', 'getUrl'), 'Method getUrl not exists');
    }

    /**
     * @test
     * Assert that a operator object is returned after a successful retrieve.
     */
    public function retrieve_object()
    {
        $object = DataPlansOperator::retrieve();

        $this->assertInstanceOf('DataPlansOperator', $object, 'Retrieve data is invalid');
        if (!empty($object)) {
            $this->assertArrayHasKey('slug', $object[0], 'Key slug not exist');
        }
    }

    /**
     * @test
     * Assert that a operator object is returned after a successful reload.
     */
    public function reload()
    {
        $object = DataPlansOperator::retrieve();
        $object->reload();

        $this->assertInstanceOf('DataPlansOperator', $object, 'Retrieve data is invalid');
        if (!empty($object)) {
            $this->assertArrayHasKey('slug', $object[0], 'Key slug not exist');
        }
    }

    /**
     * @test
     * Assert that a operator object with slug is returned after a successful retrieve.
     */
    public function retrieve_object_by_slug()
    {
        $slug = 'ais';
        $object = DataPlansOperator::retrieve($slug);

        $this->assertInstanceOf('DataPlansOperator', $object, 'Retrieve data is invalid');
        if (!empty($object)) {
            $this->assertArrayHasKey('slug', $object[0], 'Key slug not exist');
            $this->assertArrayHasKey('retailPrice', $object[0], 'Key retailPrice not exist');
        }
    }
}
