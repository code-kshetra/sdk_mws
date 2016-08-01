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
                "DescriptionData_BulletPoint" => ["Example Bullet Point 1","Example Bullet Point 2","Example Bullet Point 3"],
                "DescriptionData_Currency" => "MXN",
                "DescriptionData_Msrp" => "200.00",
                "DescriptionData_Manufacturer" => "Example Product Manufacturer",
                "DescriptionData_ItemType" => "example-item-type",
                "ProductData_Parentage" => "child",
                "ProductData_Size" => "34",
                "ProductData_Color" => "Negro",
                "ProductData_VariationTheme" => "SizeColor",
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
                "DescriptionData_BulletPoint" => ["Example Bullet Point 1","Example Bullet Point 2","Example Bullet Point 3"],
                "DescriptionData_Currency" => "MXN",
                "DescriptionData_Msrp" => "250.00",
                "DescriptionData_Manufacturer" => "Example Product Manufacturer",
                "DescriptionData_ItemType" => "example-item-type",
                "ProductData_Parentage" => "child",
                "ProductData_Size" => "34",
                "ProductData_Color" => "Negro",
                "ProductData_VariationTheme" => "SizeColor",
                "ProductData_Gender" => "mujeres"
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'Product');
        //var_dump($data);
        //die();

        $feed = $mapping->createXmlfromJson($data);

        $feedType = '_POST_PRODUCT_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feeds->createRequestFeed($feed,$feedType,$operation));
        $this->assertTrue($response->success);
    }


    public function testSubmitRelationFeeds(){
        $mapping = new MappingAttributesProducts();
        $feeds = new Feeds();

        $data = [
            [
                "OperationType" => "Update",
                "Relationship_ParentSKU" => "LE063AB84KXFDFMX",
                "Relationship_RelationsArray" => [
                    [
                        "SKU" => "LE063AB84KXFDFMX-214914",
                        "Type" => "Variation"
                    ],
                    [
                        "SKU" => "LE063AB84KXFDFMX-214915",
                        "Type" => "Variation"
                    ],
                    [
                        "SKU" => "LE063AB84KXFDFMX-214916",
                        "Type" => "Variation"
                    ]
                ]
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'Relationship');

        $feed = $mapping->createXmlfromJson($data);

        $feedType = '_POST_PRODUCT_RELATIONSHIP_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feeds->createRequestFeed($feed,$feedType,$operation));
        $this->assertTrue($response->success);
    }


    public function testSubmitPriceFeeds(){
        $mapping = new MappingAttributesProducts();
        $feeds = new Feeds();

        $data = [
            [
                "OperationType" => "Update",
                "SKU" => "FL039SH43RUQDFMX-312919",
                "StandardPrice_Currency" => "MXN",
                "StandardPrice" => "200.00",
                "Sale_StartDate" => "2008-10-01T00:00:00Z",
                "Sale_EndDate" => "2009-10-01T00:00:00Z",
                "Sale_SalePrice_Currency" => "MXN",
                "Sale_SalePrice" => "150.00"
            ],
            [
                "OperationType" => "Update",
                "SKU" => "FL039SH43RUQDFMX-312920",
                "StandardPrice_Currency" => "MXN",
                "StandardPrice" => "250.00",
                "Sale_StartDate" => "2008-10-01T00:00:00Z",
                "Sale_EndDate" => "2009-10-01T00:00:00Z",
                "Sale_SalePrice_Currency" => "MXN",
                "Sale_SalePrice" => "120.00"
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'Price');

        $feed = $mapping->createXmlfromJson($data);

        $feedType = '_POST_PRODUCT_PRICING_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feeds->createRequestFeed($feed,$feedType,$operation));
        $this->assertTrue($response->success);
    }


    public function testSubmitStockFeeds(){
        $mapping = new MappingAttributesProducts();
        $feeds = new Feeds();

        $data = [
            [
                "OperationType" => "Update",
                "SKU" => "FL039SH43RUQDFMX-312919",
                "Quantity" => "1",
                "FulfillmentLatency" => "7"
            ],
            [
                "OperationType" => "Update",
                "SKU" => "FL039SH43RUQDFMX-312920",
                "Quantity" => "1",
                "FulfillmentLatency" => "7"
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'Inventory');

        $feed = $mapping->createXmlfromJson($data);

        $feedType = '_POST_INVENTORY_AVAILABILITY_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feeds->createRequestFeed($feed,$feedType,$operation));
        $this->assertTrue($response->success);
    }

    public function testSubmitImagesFeeds(){
        $mapping = new MappingAttributesProducts();
        $feeds = new Feeds();

        $data = [
            [
                "OperationType" => "Update",
                "SKU" => "FL039SH43RUQDFMX-312919",
                "ImageType" => "Main",
                "ImageLocation" => "http://static.dafiti.com.mx/p/calvin-klein-6965-312919-2-zoom2.jpg"
            ],
            [
                "OperationType" => "Update",
                "SKU" => "FL039SH43RUQDFMX-312920",
                "ImageType" => "Main",
                "ImageLocation" => "http://static.dafiti.com.mx/p/calvin-klein-6965-312920-2-zoom2.jpg"
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'ProductImage');

        $feed = $mapping->createXmlfromJson($data);

        $feedType = '_POST_PRODUCT_IMAGE_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feeds->createRequestFeed($feed,$feedType,$operation));
        $this->assertTrue($response->success);
    }

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

    public function testGetFeedSubmissionListByIdsAndTypeFeed(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionList';
        $parameters = array('SubmissionId' => '50220016997', 'FeedType'=>'_POST_INVENTORY_AVAILABILITY_DATA_');
        $response = json_decode($feeds->createRequestFeed('','',$operation, $parameters));
        $this->assertTrue($response->success);
    }

}
