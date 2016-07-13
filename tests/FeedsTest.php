<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 17/06/16
 * Time: 05:08 PM
 */

use Osom\Sdk_Mws\ProductManagement\Feeds;
use Osom\Sdk_Mws\ProductManagement\MappingAttributesProducts;
class FeedsTest extends PHPUnit_Framework_TestCase
{
    /*
    public function testSubmitProductFeeds(){
        $mapping = new MappingAttributesProducts();
        $feeds = new Feeds();

        $data = [
            [
                "OperationType" => "Update",
                "SKU" => "FL039SH43RUQDFMX-312919",
                "StandarProductID_Type" => "EAN",
                "StandarProductID_Value" => "7500421081204",
                "DescriptionData_Title" => "Example Product Title",
                "DescriptionData_Brand" => "Example Product Brand",
                "DescriptionData_Description" => "This is an example product description",
                "DescriptionData_BulletPoint" => "Example Bullet Point 1",
                "DescriptionData_Currency" => "MXN",
                "DescriptionData_Msrp" => "200.00",
                "DescriptionData_Manufacturer" => "Example Product Manufacturer",
                "DescriptionData_ItemType" => "example-item-type",
                "ProductData_Size" => "34",
                "ProductData_Color" => "Negro",
                "ProductData_Gender" => "mujeres"
            ],
            [
                "OperationType" => "Update",
                "SKU" => "FL039SH43RUQDFMX-312920",
                "StandarProductID_Type" => "EAN",
                "StandarProductID_Value" => "7500421081205",
                "DescriptionData_Title" => "Example Product Title",
                "DescriptionData_Brand" => "Example Product Brand",
                "DescriptionData_Description" => "This is an example product description",
                "DescriptionData_BulletPoint" => "Example Bullet Point 1",
                "DescriptionData_Currency" => "MXN",
                "DescriptionData_Msrp" => "250.00",
                "DescriptionData_Manufacturer" => "Example Product Manufacturer",
                "DescriptionData_ItemType" => "example-item-type",
                "ProductData_Size" => "34",
                "ProductData_Color" => "Negro",
                "ProductData_Gender" => "mujeres"
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'Product');

        $feed = $mapping->createXmlfromJson($data);

        $feedType = '_POST_PRODUCT_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feeds->createRequestFeed($feed,$feedType,$operation));
        $this->assertTrue($response->success);
    }
    */
    public function testGetFeedSubmissionList(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionList';
        $status = array('_SUBMITTED_', '_CANCELLED_', '_IN_SAFETY_NET_', '_IN_PROGRESS_', '_UNCONFIRMED_', '_AWAITING_ASYNCHRONOUS_REPLY_', '_DONE_');
        $parameters = array('Status' => $status[6]);
        $response = json_decode($feeds->createRequestFeed('','',$operation, $parameters));
        $this->assertTrue($response->success);
    }

    public function testGetFeedSubmissionResult(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionResult';
        $parameters = array('SubmissionId' => '50049016973');
        $response = json_decode($feeds->createRequestFeed('','',$operation,$parameters));
        $this->assertTrue($response->success);
    }

    public function testGetFeedSubmissionListByIds(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionList';
        $parameters = array('SubmissionId' => '50159016995');
        $response = json_decode($feeds->createRequestFeed('','',$operation, $parameters));
        $this->assertTrue($response->success);
    }

}
