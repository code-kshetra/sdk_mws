<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 27/07/16
 * Time: 01:02 PM
 */

namespace Osom\Sdk_Mws\ProductManagement\Dummies;


class DummieRelationshipRequest
{
    private $dataRelationshipStructure =
        [
            "MessageID" => "?",
            "OperationType" => "Update|Delete|PartialUpdate",
            "Relationship" => [
                "ParentSKU" => "?",
                "Relation" => "Array SKUs and Types"
            ]
        ];

    public function __construct(){
        return $this;
    }

    public function getStructure(){
        return $this->dataRelationshipStructure;
    }
}