<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 14/07/16
 * Time: 06:09 PM
 */

namespace Osom\Sdk_Mws\ProductManagement\Dummies;


class DummiePriceRequest
{
    private $dataPriceStructure =
        [
            "MessageID" => "?",
            "OperationType" => "Update|Delete|PartialUpdate",
            "Price"=>[
                "SKU" => "?",
                "StandardPrice" => [
                    "attribute" => ["currency"=>"MXN"],
                    "value"=>"?",
                ],
                "Sale" => [
                    "StartDate" => "?",
                    "EndDate" => "?",
                    "SalePrice" => [
                        "attribute" => ["currency"=>"MXN"],
                        "value"=>"?",
                    ]
                ]
            ]
        ];

    public function __construct(){
        return $this;
    }

    public function getStructure(){
        return $this->dataPriceStructure;
    }
}