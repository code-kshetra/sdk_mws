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
                        "attribute" => ["currency"=>"MXN"],
                        "value"=>"?",
                    ],
                    "Manufacturer" => "?",
                    "ItemType" => "?"
                ],
                "ProductData" => [
                    "ClothingAccessories" => [
                        "VariationData" => [
                            "Parentage" => "parent|child",
                            "Size" => "?",
                            "Color" => "?",
                            "VariationTheme" => "Size|Color|SizeColor|Color-Itempackagequantity|Color-Material|Color-Patternname|ColorSize|Itempackagequantity|Itempackagequantity-Color|Itempackagequantity-Material|Itempackagequantity-Size|Material|Material-Color|Material-Patternname|Material-Size|Patternname|Patternname-Color|Patternname-Material|Patternname-Size|Size-Material|Size-Patternname|Cupsize|Cupsize-Color|Cupsize-Color-Size|Cupsize-Size"
                        ],
                        "ClassificationData" => [
                            "Department" => "?"
                        ]
                    ]
                ]
            ]
        ];

    private $dataProductShoesStructure =
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
                        "attribute" => ["currency"=>"MXN"],
                        "value"=>"?",
                    ],
                    "Manufacturer" => "?",
                    "ItemType" => "?"
                ],
                "ProductData" => [
                    "Shoes" => [
                        "ClothingType" => "Accessory|Bag|Shoes|ShoeAccessory|Handbag|Eyewear",
                        "VariationData" => [
                            "Parentage" => "parent|child",
                            "Size" => "?",
                            "Color" => "?",
                            "VariationTheme" => "Size|Color|SizeColor|Color-Itempackagequantity|Color-Material|Color-Patternname|ColorSize|Itempackagequantity|Itempackagequantity-Color|Itempackagequantity-Material|Itempackagequantity-Size|Material|Material-Color|Material-Patternname|Material-Size|Patternname|Patternname-Color|Patternname-Material|Patternname-Size|Size-Material|Size-Patternname|Cupsize|Cupsize-Color|Cupsize-Color-Size|Cupsize-Size"
                        ],
                        "ClassificationData" => [
                            "Department" => "?"
                        ]
                    ]
                ]
            ]
        ];

    private $dataProductOwnBrandStructure =
        [
            "MessageID" => "?",
            "OperationType" => "Update|Delete|PartialUpdate",
            "Product" => [
                "SKU" => "?",
                "ProductTaxCode" => "A_GEN_NOTAX",
                "DescriptionData" => [
                    "Title" => "?",
                    "Brand" =>"?",
                    "Description" => "?",
                    "BulletPoint" => "?",
                    "MSRP" => [
                        "attribute" => ["currency"=>"MXN"],
                        "value"=>"?",
                    ],
                    "Manufacturer" => "?",
                    "MfrPartNumber" => "?",
                    "ItemType" => "?"
                ],
                "ProductData" => [
                    "ClothingAccessories" => [
                        "VariationData" => [
                            "Parentage" => "parent|child",
                            "Size" => "?",
                            "Color" => "?",
                            "VariationTheme" => "Size|Color|SizeColor|Color-Itempackagequantity|Color-Material|Color-Patternname|ColorSize|Itempackagequantity|Itempackagequantity-Color|Itempackagequantity-Material|Itempackagequantity-Size|Material|Material-Color|Material-Patternname|Material-Size|Patternname|Patternname-Color|Patternname-Material|Patternname-Size|Size-Material|Size-Patternname|Cupsize|Cupsize-Color|Cupsize-Color-Size|Cupsize-Size"
                        ],
                        "ClassificationData" => [
                            "Department" => "?"
                        ]
                    ]
                ]
            ]
        ];

    private $dataProductShoesOwnBrandStructure =
        [
            "MessageID" => "?",
            "OperationType" => "Update|Delete|PartialUpdate",
            "Product" => [
                "SKU" => "?",
                "ProductTaxCode" => "A_GEN_NOTAX",
                "DescriptionData" => [
                    "Title" => "?",
                    "Brand" =>"?",
                    "Description" => "?",
                    "BulletPoint" => "?",
                    "MSRP" => [
                        "attribute" => ["currency"=>"MXN"],
                        "value"=>"?",
                    ],
                    "Manufacturer" => "?",
                    "MfrPartNumber" => "?",
                    "ItemType" => "?"
                ],
                "ProductData" => [
                    "Shoes" => [
                        "ClothingType" => "Accessory|Bag|Shoes|ShoeAccessory|Handbag|Eyewear",
                        "VariationData" => [
                            "Parentage" => "parent|child",
                            "Size" => "?",
                            "Color" => "?",
                            "VariationTheme" => "Size|Color|SizeColor|Color-Itempackagequantity|Color-Material|Color-Patternname|ColorSize|Itempackagequantity|Itempackagequantity-Color|Itempackagequantity-Material|Itempackagequantity-Size|Material|Material-Color|Material-Patternname|Material-Size|Patternname|Patternname-Color|Patternname-Material|Patternname-Size|Size-Material|Size-Patternname|Cupsize|Cupsize-Color|Cupsize-Color-Size|Cupsize-Size"
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

    public function getStructureShoes(){
        return $this->dataProductShoesStructure;
    }

    public function getStructureOwnBrand(){
        return $this->dataProductOwnBrandStructure;
    }

    public function getStructureShoesOwnBrand(){
        return $this->dataProductShoesOwnBrandStructure;
    }
}