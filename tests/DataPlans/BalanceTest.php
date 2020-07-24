<?php
require_once dirname(__FILE__).'/TestConfig.php';

class BalanceTest extends TestConfig
{
    /**
     * @test
     * DataPlansBalance class must be contain some method below.
     */
    public function method_exists()
    {
        $this->assertTrue(method_exists('DataPlansBalance', 'retrieve'));
        $this->assertTrue(method_exists('DataPlansBalance', 'reload'));
        $this->assertTrue(method_exists('DataPlansBalance', 'getUrl'));
    }

    /**
     * @test
     * Assert that a balance object is returned after a successful retrieve.
     */
    public function retrieve_object()
    {
        $balance = DataPlansBalance::retrieve();

        $this->assertArrayHasKey('availableBalance', $balance, 'Key availableBalance not exist');
        $this->assertFinite(floatval($balance['availableBalance']), 'availableBalance value must be finite value');
    }

    /**
     * @test
     * Assert that a balance object is returned after a successful reload.
     */
    public function reload()
    {
        $balance = DataPlansBalance::retrieve();
        $balance->reload();

        $this->assertArrayHasKey('availableBalance', $balance, 'Key availableBalance not exist');
        $this->assertFinite(floatval($balance['availableBalance']), 'availableBalance value must be finite value');
    }
}
