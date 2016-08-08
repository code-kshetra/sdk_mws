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
    private $dataOrderAcknowledgementStructureFailed =
        [
            "MessageID" => "?",
            "OrderAcknowledgement"=>[
                "AmazonOrderID" => "?",
                "MerchantOrderID" => "?",
                "StatusCode" => "?",
                "Item" => "?"
            ]
        ];

    private $dataOrderAcknowledgementStructureSuccess =
        [
            "MessageID" => "?",
            "OrderAcknowledgement"=>[
                "AmazonOrderID" => "?",
                "StatusCode" => "?",
                "Item" => "?"
            ]
        ];

    public function __construct(){
        return $this;
    }

    public function getStructureFailed(){
        return $this->dataOrderAcknowledgementStructureFailed;
    }

    public function getStructureSuccess(){
        return $this->dataOrderAcknowledgementStructureSuccess;
    }
}