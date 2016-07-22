<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 22/07/16
 * Time: 10:22 AM
 */
use Osom\Sdk_Mws\OrdersManagement\Orders;

class OrdersTest extends PHPUnit_Framework_TestCase
{
    public function testListOrders(){
        $orders = new Orders();
        $parameters = array('CreatedAfter' => date('c',strtotime('2016-07-01 00:00:00')));
        $operation = 'ListOrders';
        $response = json_decode($orders->createRequestOrders($operation,$parameters));
        $this->assertTrue($response->success);
    }
}
