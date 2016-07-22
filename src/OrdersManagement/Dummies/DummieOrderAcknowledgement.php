<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 22/07/16
 * Time: 02:03 PM
 */
namespace Osom\Sdk_Mws\OrdersManagement\Dummies;

class DummieOrderAcknowledgement
{
    private $dataOrderAcknowledgementStructure =
        [
            "MessageID" => "?",
            "OrderAcknowledgement"=>[
                "AmazonOrderID" => "?",
                "MerchantOrderID" => "?",
                "StatusCode" => "?",
                "Item" => [
                    "AmazonOrderItemCode" => "?",
                    "MerchantOrderItemID" => "?"
                ]
            ]
        ];

    public function __construct(){
        return $this;
    }

    public function getStructure(){
        return $this->dataOrderAcknowledgementStructure;
    }
}