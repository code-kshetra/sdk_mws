<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 29/06/16
 * Time: 05:47 PM
 */
use Osom\Sdk_Mws\ProductManagement\MappingAttributesProducts;
class MappingAttributesProductsTest extends PHPUnit_Framework_TestCase
{
    public function testCreateXmlfromJson(){

        $mapping = new MappingAttributesProducts();
        $data = [
            [
                "OperationType" => "Update",
                "SKU" => "56790",
                "StandarProductID_Type" => "ASIN",
                "StandarProductID_Value" => "B0EXAMPLEG",
                "DescriptionData_Title" => "Example Product Title",
                "DescriptionData_Brand" => "Example Product Brand",
                "DescriptionData_Description" => "This is an example product description",
                "DescriptionData_BulletPoint" => "Example Bullet Point 1",
                "DescriptionData_Currency" => "MXN",
                "DescriptionData_Msrp" => "200.00",
                "DescriptionData_Manufacturer" => "Example Product Manufacturer",
                "DescriptionData_ItemType" => "example-item-type",
                "ProductData_Size" => "34",
                "ProductData_Color" => "Negro",
                "ProductData_Gender" => "mujeres"
            ],
            [
                "OperationType" => "Update",
                "SKU" => "56791",
                "StandarProductID_Type" => "ASIN",
                "StandarProductID_Value" => "B0EXAMPLEG2",
                "DescriptionData_Title" => "Example Product Title",
                "DescriptionData_Brand" => "Example Product Brand",
                "DescriptionData_Description" => "This is an example product description",
                "DescriptionData_BulletPoint" => "Example Bullet Point 1",
                "DescriptionData_Currency" => "MXN",
                "DescriptionData_Msrp" => "250.00",
                "DescriptionData_Manufacturer" => "Example Product Manufacturer",
                "DescriptionData_ItemType" => "example-item-type",
                "ProductData_Size" => "34",
                "ProductData_Color" => "Negro",
                "ProductData_Gender" => "mujeres"
            ]
        ];
        
        (object)$data = json_decode(json_encode($data), FALSE);
        $json = $mapping->buildRequestFeed($data,'Product');
        
        $mapping = new MappingAttributesProducts();
        $this->assertXmlStringEqualsXmlFile('/var/www/sdk_mws/src/ProductManagement/tmp.xml',$mapping->createXmlfromJson($json));
    }

    public function testBuildRequestFeed(){
        $mapping = new MappingAttributesProducts();
        $data = [
            [
                "OperationType" => "Update",
                "SKU" => "56790",
                "StandarProductID_Type" => "ASIN",
                "StandarProductID_Value" => "B0EXAMPLEG",
                "DescriptionData_Title" => "Example Product Title",
                "DescriptionData_Brand" => "Example Product Brand",
                "DescriptionData_Description" => "This is an example product description",
                "DescriptionData_BulletPoint" => "Example Bullet Point 1",
                "DescriptionData_Currency" => "MXN",
                "DescriptionData_Msrp" => "200.00",
                "DescriptionData_Manufacturer" => "Example Product Manufacturer",
                "DescriptionData_ItemType" => "example-item-type",
                "ProductData_Size" => "34",
                "ProductData_Color" => "Negro",
                "ProductData_Gender" => "mujeres"
            ],
            [
                "OperationType" => "Update",
                "SKU" => "56791",
                "StandarProductID_Type" => "ASIN",
                "StandarProductID_Value" => "B0EXAMPLEG2",
                "DescriptionData_Title" => "Example Product Title",
                "DescriptionData_Brand" => "Example Product Brand",
                "DescriptionData_Description" => "This is an example product description",
                "DescriptionData_BulletPoint" => "Example Bullet Point 1",
                "DescriptionData_Currency" => "MXN",
                "DescriptionData_Msrp" => "200.00",
                "DescriptionData_Manufacturer" => "Example Product Manufacturer",
                "DescriptionData_ItemType" => "example-item-type",
                "ProductData_Size" => "34",
                "ProductData_Color" => "Negro",
                "ProductData_Gender" => "mujeres"
            ]
        ];
        (object)$data = json_decode(json_encode($data), FALSE);
        $request = $mapping->buildRequestFeed($data,'Product');
        $this->assertJson($request);
    }
}
