<?php
require_once dirname(__FILE__).'/TestConfig.php';

class PurchaseTest extends TestConfig
{
    /**
     * @test
     * DataPlansPurchase class must be contain some method below.
     */
    public function method_exists()
    {
        $this->assertTrue(method_exists('DataPlansPurchase', 'retrieve'));
        $this->assertTrue(method_exists('DataPlansPurchase', 'create'));
        $this->assertTrue(method_exists('DataPlansPurchase', 'reload'));
        $this->assertTrue(method_exists('DataPlansPurchase', 'getUrl'));
    }

    /**
     * @test
     * Assert that a purchase is successfully created with the given parameters set.
     */
    public function create()
    {
        $purchase = DataPlansPurchase::create(array('slug' => 'sim2fly-asia'));

        $this->assertArrayHasKey('purchase', $purchase, 'Purchase not complete');
        $this->assertArrayHasKey('purchaseId', $purchase['purchase'], 'purchaseId not provide');
        $this->assertArrayHasKey('esim', $purchase['purchase'], 'eSim not provide');
    }

    /**
     * @test
     * Assert that a transfer object is returned after a successful retrieve.
     */
    public function retrieve()
    {
        $purchase = DataPlansPurchase::retrieve('30ee2a9b-d9ca-4b42-9a04-7fdc798e4237');

        $this->assertArrayHasKey('purchaseId', $purchase, 'Purchase response not has purtchaseId');
        $this->assertArrayHasKey('esim', $purchase, 'eSim not provide');
    }
}
