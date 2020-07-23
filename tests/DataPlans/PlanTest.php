<?php
require_once dirname(__FILE__).'/TestConfig.php';

class PlanTest extends TestConfig
{
    /**
     * @test
     * DataPlansPlan class must be contain some method below.
     */
    public function method_exists()
    {
        $this->assertTrue(method_exists('DataPlansPlan', 'retrieve'), 'Method retrieve not exists');
        $this->assertTrue(method_exists('DataPlansPlan', 'reload'), 'Method reload not exists');
        $this->assertTrue(method_exists('DataPlansPlan', 'getUrl'), 'Method getUrl not exists');
    }

    /**
     * @test
     * Assert that a plan object is returned after a successful retrieve.
     */
    public function retrieve_object()
    {
        $object = DataPlansPlan::retrieve();

        $this->assertInstanceOf('DataPlansPlan', $object, 'Retrieve data is invalid');
        if (!empty($object)) {
            $this->assertArrayHasKey('slug', $object[0], 'Key slug not exist');
        }
    }

    /**
     * @test
     * Assert that a plan object is returned after a successful reload.
     */
    public function reload()
    {
        $object = DataPlansPlan::retrieve();
        $object->reload();

        $this->assertInstanceOf('DataPlansPlan', $object, 'Retrieve data is invalid');
        if (!empty($object)) {
            $this->assertArrayHasKey('slug', $object[0], 'Key slug not exist');
        }
    }

    /**
     * @test
     * Assert that a plan object is has correct endpoint
     */
    public function endpoint()
    {
        $endpoint = DataPlansPlan::getUrl();

        $this->assertStringEndsWith('v1/plans', $endpoint, 'Endpoint not correct');
    }
}
