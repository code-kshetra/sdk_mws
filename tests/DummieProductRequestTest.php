<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 8/07/16
 * Time: 06:29 PM
 */

use \Osom\Sdk_Mws\ProductManagement\Dummies\DummieProductRequest;
class DummieProductRequestTest extends PHPUnit_Framework_TestCase
{
    public function testDummieProductRequest(){
        $dummieProduct = new DummieProductRequest();
        $this->assertArrayHasKey("Product",$dummieProduct->getStructure());
    }
}
