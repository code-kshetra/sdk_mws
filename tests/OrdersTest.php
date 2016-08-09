<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 22/07/16
 * Time: 10:22 AM
 */
use Osom\Sdk_Mws\OrdersManagement\Orders;
use Osom\Sdk_Mws\ProductManagement\MappingAttributesProducts;
use Osom\Sdk_Mws\ProductManagement\Feeds;

class OrdersTest extends PHPUnit_Framework_TestCase
{
    /*
    public function testListOrders(){
        $orders = new Orders();
        //OrderStatus "" | "Pending" | "Unshipped" | "PartiallyShipped" | "Shipped" | "Canceled" | "Unfulfillable" | "PendingAvailability"
        //$parameters = array('CreatedAfter' => date('c',strtotime('2016-07-01 00:00:00')),'OrderStatus'=>'Pending');
        $parameters = array('CreatedAfter' => date('c',strtotime('2016-07-01 00:00:00')),'CreatedBefore' => date('c',strtotime('2016-07-02 00:00:00')),'OrderStatus'=>'Pending');
        $operation = 'ListOrders';
        $response = json_decode($orders->createRequestOrders($operation,$parameters));
        $this->assertTrue($response->success);
    }

    public function testListOrderItems(){
        $orders = new Orders();
        $parameters = array('AmazonOrderId'=>'058-1233752-8214740');
        $operation = 'ListOrderItems';
        $response = json_decode($orders->createRequestOrders($operation,$parameters));
        var_dump($response);
        $this->assertTrue($response->success);
    }

    public function testOrderAcknowledgementSuccess(){
        $mapping = new MappingAttributesProducts();
        $feedOrders = new Feeds();

        $data = [
            [
                "AmazonOrderID" => "050-1234567-1234567",
                "StatusCode" => "Success",
                "Item" => [
                    ["AmazonOrderItemCode" => "1"],
                    ["AmazonOrderItemCode" => "2"]
                ]
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'OrderAcknowledgementSuccess');

        $feed = $mapping->createXmlfromJson($data);
        
        $feedType = '_POST_ORDER_ACKNOWLEDGEMENT_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feedOrders->createRequestFeed($feed,$feedType,$operation));
        $this->assertTrue($response->success);
    }

    public function testOrderAcknowledgementFailed(){
        $mapping = new MappingAttributesProducts();
        $feedOrders = new Feeds();

        $data = [
            [
                "AmazonOrderID" => "050-1234567-1234567",
                "StatusCode" => "Failure",
                "Item" => [
                    [
                        "AmazonOrderItemCode" => "1",
                        "CancelReason" => "NoInventory"
                    ],
                    [
                        "AmazonOrderItemCode" => "2",
                        "CancelReason" => "NoInventory"
                    ]
                ]
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'OrderAcknowledgementSuccess');

        $feed = $mapping->createXmlfromJson($data);

        $feedType = '_POST_ORDER_ACKNOWLEDGEMENT_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feedOrders->createRequestFeed($feed,$feedType,$operation));
        $this->assertTrue($response->success);
    }


    public function testGetFeedSubmissionListByIdsAndTypeFeed(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionList';
        $parameters = array('SubmissionId' => '50324017004', 'FeedType'=>'_POST_ORDER_ACKNOWLEDGEMENT_DATA_');
        $response = json_decode($feeds->createRequestFeed('','',$operation, $parameters));
        var_dump($response);
        $this->assertTrue($response->success);
    }

    public function testOrderAcknowledgementResult(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionResult';
        $parameters = array('SubmissionId' => '50324017004');
        $response = json_decode($feeds->createRequestFeed('','',$operation,$parameters));
        var_dump($response);
        $this->assertTrue($response->success);
    }
    */
    public function testOrderFulfillment(){
        $mapping = new MappingAttributesProducts();
        $feedOrders = new Feeds();

        $data = [
            [
                "AmazonOrderID" => "1234567",
                "FulfillmentDate" => date('c',strtotime('2016-07-01 00:00:00')),
                "FulfillmentData_CarrierName" => "UPS",
                "FulfillmentData_ShippingMethod" => "Standar",
                "FulfillmentData_ShipperTrackingNumber" => "1234567890",
                "Item" => [
                    [
                        "AmazonOrderItemCode" => "1",
                        "Quantity" => "1"
                    ],
                    [
                        "AmazonOrderItemCode" => "2",
                        "Quantity" => "1"
                    ]
                ]
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'OrderFulfillment');
        $feed = $mapping->createXmlfromJson($data);


        $feedType = '_POST_ORDER_FULFILLMENT_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feedOrders->createRequestFeed($feed,$feedType,$operation));
        $this->assertTrue($response->success);
    }
    /*

    public function testGetFeedSubmissionListOrderFulfillment(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionList';
        $parameters = array('SubmissionId' => '50324017004', 'FeedType'=>'_POST_ORDER_FULFILLMENT_DATA_');
        $response = json_decode($feeds->createRequestFeed('','',$operation, $parameters));
        var_dump($response);
        $this->assertTrue($response->success);
    }


    public function testOrderFulfillmentResult(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionResult';
        $parameters = array('SubmissionId' => '50324017004');
        $response = json_decode($feeds->createRequestFeed('','',$operation,$parameters));
        var_dump($response);
        $this->assertTrue($response->success);
    }

    public function testOrderAdjustment(){
        $mapping = new MappingAttributesProducts();
        $feedOrders = new Feeds();

        $data = [
            [
                "MerchantOrderID" => "23456",
                "AdjustedItem_MerchantOrderItemID" => "23456",
                "AdjustedItem_MerchantAdjustmentItemID" => "23456",
                "AdjustedItem_AdjustmentReason" => "CustomerReturn",
                "ItemPriceAdjustments_Principal" => "10.00",
                "ItemPriceAdjustments_Shipping" => "3.50",
                "ItemPriceAdjustments_Tax" => "1.30",
                "ItemPriceAdjustments_Shipping_Tax" => "0.285",
                "PromotionAdjustments_PromotionClaimCode" => "AA12456",
                "PromotionAdjustments_MerchantPromotionID" => "12345678",
                "PromotionAdjustments_Principal" => "-10.00"
            ]
        ];

        (object)$data = json_decode(json_encode($data), FALSE);
        $data = $mapping->buildRequestFeed($data,'OrderAdjustment');

        $feed = $mapping->createXmlfromJson($data);

        $feedType = '_POST_PAYMENT_ADJUSTMENT_DATA_';
        $operation = 'SubmitFeed';
        $response = json_decode($feedOrders->createRequestFeed($feed,$feedType,$operation));
        var_dump($response);
        $this->assertTrue($response->success);
    }

    public function testGetFeedSubmissionListtestOrderAdjustment(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionList';
        $parameters = array('SubmissionId' => '50324017004', 'FeedType'=>'_POST_PAYMENT_ADJUSTMENT_DATA_');
        $response = json_decode($feeds->createRequestFeed('','',$operation, $parameters));
        var_dump($response);
        $this->assertTrue($response->success);
    }

    public function testOrderAdjustmentResult(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionResult';
        $parameters = array('SubmissionId' => '50324017004');
        $response = json_decode($feeds->createRequestFeed('','',$operation,$parameters));
        var_dump($response);
        $this->assertTrue($response->success);
    }
    */
}
