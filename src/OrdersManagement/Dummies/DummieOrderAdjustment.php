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
                "MerchantOrderID" => "?",
                "AdjustedItem" => [
                    "MerchantOrderItemID" => "?",
                    "MerchantAdjustmentItemID" => "?",
                    "AdjustmentReason" => "?",
                    "ItemPriceAdjustments" => [
                        "Component" => [
                            [
                                "Type" => "Principal",
                                "Amount" => [
                                    "attribute" => ["currency"=>"MXN"],
                                    "value"=>"?",
                                ]
                            ],
                            [
                                "Type" => "Shipping",
                                "Amount" => [
                                    "attribute" => ["currency"=>"MXN"],
                                    "value"=>"?",
                                ]
                            ],
                            [
                                "Type" => "Tax",
                                "Amount" => [
                                    "attribute" => ["currency"=>"MXN"],
                                    "value"=>"?",
                                ]
                            ],
                            [
                                "Type" => "Shipping Tax",
                                "Amount" => [
                                    "attribute" => ["currency"=>"MXN"],
                                    "value"=>"?",
                                ]
                            ]
                        ]
                    ],
                    "PromotionAdjustments" => [
                        "PromotionClaimCode" => "?",
                        "MerchantPromotionID" => "?",
                        "Component" => [
                            [
                                "Type" => "Principal",
                                "Amount" => [
                                    "attribute" => ["currency"=>"MXN"],
                                    "value"=>"?",
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

    public function __construct(){
        return $this;
    }

    public function getStructure(){
        return $this->dataOrderAdjustmentStructure;
    }
}