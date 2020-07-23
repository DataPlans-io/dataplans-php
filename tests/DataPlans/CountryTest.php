<?php
require_once dirname(__FILE__).'/TestConfig.php';

class CountryTest extends TestConfig
{
    /**
     * @test
     * DataPlansCountry class must be contain some method below.
     */
    public function method_exists()
    {
        $this->assertTrue(method_exists('DataPlansCountry', 'retrieve'), 'Method retrieve not exists');
        $this->assertTrue(method_exists('DataPlansCountry', 'reload'), 'Method reload not exists');
        $this->assertTrue(method_exists('DataPlansCountry', 'getUrl'), 'Method getUrl not exists');
    }

    /**
     * @test
     * Assert that a country object is returned after a successful retrieve.
     */
    public function retrieve_object()
    {
        $object = DataPlansCountry::retrieve();

        $this->assertInstanceOf('DataPlansCountry', $object, 'Retrieve data is invalid');
        if (!empty($object)) {
            $this->assertArrayHasKey('countryCode', $object[0]);
        }
    }

    /**
     * @test
     * Assert that a country object is returned after a successful reload.
     */
    public function reload()
    {
        $object = DataPlansCountry::retrieve();
        $object->reload();

        $this->assertInstanceOf('DataPlansCountry', $object, 'Retrieve data is invalid');
        if (!empty($object)) {
            $this->assertArrayHasKey('countryCode', $object[0]);
        }
    }

    /**
     * @test
     * Assert that a country object is has correct endpoint
     */
    public function endpoint()
    {
        $endpoint = DataPlansCountry::getUrl();

        $this->assertStringEndsWith('v1/countries', $endpoint, 'Endpoint not correct');
    }
}
