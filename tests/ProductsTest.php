<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 9/09/16
 * Time: 05:08 PM
 */
use Osom\Sdk_Mws\ProductManagement\Products;

class ProductsTest extends PHPUnit_Framework_TestCase
{
    public function testGetMatchingProductForIdSellerSKU(){
        $products = new Products();
        $parameters = array("SKU"=>"TO094AT40REHDFMX-510589");
        $operation = 'GetMatchingProductForId';
        $products->createRequestProduct($operation,$parameters);
        $response = json_decode($products->createRequestProduct($operation,$parameters));
        //var_dump($response->GetMatchingProductForIdResult->Error);
        //var_dump($response->GetMatchingProductForIdResult->Products);
        //die();
        $this->assertTrue($response->success);
    }
}
