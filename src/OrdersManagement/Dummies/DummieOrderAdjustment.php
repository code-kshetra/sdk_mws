<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 22/07/16
 * Time: 05:28 PM
 */

namespace Osom\Sdk_Mws\OrdersManagement\Dummies;


class DummieOrderAdjustment
{
    private $dataOrderAdjustmentStructure =
        [
            "MessageID" => "?",
            "OrderAdjustment" => [
                "AmazonOrderID" => "?",
                "AdjustedItem" => []
            ]
        ];

    public function __construct(){
        return $this;
    }

    public function getStructure(){
        return $this->dataOrderAdjustmentStructure;
    }
}