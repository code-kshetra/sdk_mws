<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 22/07/16
 * Time: 04:14 PM
 */

namespace Osom\Sdk_Mws\OrdersManagement\Dummies;


class DummieOrderFulfillment
{
    private $dataOrderFulfillmentStructure =
        [
            "MessageID" => "?",
            "OrderFulfillment" => [
                "AmazonOrderID" => "?",
                "FulfillmentDate" => "?",
                "FulfillmentData" => [
                    "CarrierName" => "?",
                    "ShippingMethod" => "?",
                    "ShipperTrackingNumber" => "?"
                ],
                "Item" => "?"
            ]
        ];

    public function __construct(){
        return $this;
    }

    public function getStructure(){
        return $this->dataOrderFulfillmentStructure;
    }
}