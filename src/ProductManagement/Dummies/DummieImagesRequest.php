<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 14/07/16
 * Time: 06:10 PM
 */

namespace Osom\Sdk_Mws\ProductManagement\Dummies;


class DummieImagesRequest
{
    private $dataImagesStructure =
        [
            "MessageID" => "?",
            "OperationType" => "Update|Delete|PartialUpdate",
            "ProductImage"=>[
                "SKU" => "?",
                "ImageType" => "?",
                "ImageLocation" => "?"
            ]
        ];

    public function __construct(){
        return $this;
    }

    public function getStructure(){
        return $this->dataImagesStructure;
    }
}