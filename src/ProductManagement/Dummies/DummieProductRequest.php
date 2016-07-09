<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 8/07/16
 * Time: 05:51 PM
 */

namespace Osom\Sdk_Mws\ProductManagement\Dummies;

class DummieProductRequest
{

    private $dataProductStructure =
        [
            "MessageID" => "?",
            "OperationType" => "Update|Delete|PartialUpdate",
            "Product" => [
                "SKU" => "?",
                "StandardProductID" => [
                    "Type" => "?",
                    "Value" => "?"
                ],
                "ProductTaxCode" => "A_GEN_NOTAX",
                "DescriptionData" => [
                    "Title" => "?",
                    "Brand" =>"?",
                    "Description" => "?",
                    "BulletPoint" => "?",
                    "MSRP" => [
                        "attribute" => ["currency"=>"MXN PESOS"],
                        "value"=>"?",
                    ],
                    "Manufacturer" => "?",
                    "ItemType" => "?"
                ],
                "ProductData" => [
                    "ClothingAccessories" => [
                        "VariationData" => [
                            "Parentage" => "child",
                            "Size" => "?",
                            "Color" => "?",
                            "VariationTheme" => "?"
                        ],
                        "ClassificationData" => [
                            "Department" => "?"
                        ]
                    ]
                ]
            ]
        ];

    public function __construct(){
        return $this;
    }

    public function getStructure(){
        return $this->dataProductStructure;
    }
}