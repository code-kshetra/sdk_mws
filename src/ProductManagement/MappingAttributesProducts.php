<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 29/06/16
 * Time: 04:48 PM
 */

namespace Osom\Sdk_Mws\ProductManagement;

include_once (substr(__DIR__,0,strpos(__DIR__, 'src')).'src/.config.php');
use Osom\Sdk_Mws\OrdersManagement\Dummies\DummieOrderAcknowledgement;
use Osom\Sdk_Mws\OrdersManagement\Dummies\DummieOrderAdjustment;
use Osom\Sdk_Mws\OrdersManagement\Dummies\DummieOrderFulfillment;
use Osom\Sdk_Mws\ProductManagement\Dummies\DummieImagesRequest;
use Osom\Sdk_Mws\ProductManagement\Dummies\DummiePriceRequest;
use Osom\Sdk_Mws\ProductManagement\Dummies\DummieProductRequest;
use Osom\Sdk_Mws\ProductManagement\Dummies\DummieStockRequest;
use SimpleXMLElement;

class MappingAttributesProducts{
    
    public function __construct(){
        return $this;
    }
    
    public function createXmlfromJson($json){
        $jsonDataArray = json_decode($json, TRUE);
        $xml_body_string = "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
        $xml_body_string .= "<AmazonEnvelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"amzn-envelope.xsd\">";
        $xml_body_string .= "</AmazonEnvelope>";
        $xml_body_info = new SimpleXMLElement($xml_body_string);
        //head info
        $xml_head_info = $xml_body_info->addChild("Header");
        $xml_head_info->addChild("DocumentVersion","1.01");
        $xml_head_info->addChild("MerchantIdentifier",MERCHANT_ID);

        //data convert JSON to XML
        $this->array_to_xml($jsonDataArray,$xml_body_info);
        
        //return $xml_body_info->asXML(dirname(__FILE__)."/tmp.xml");
        return $xml_body_info->asXML();
    }
    
    private function array_to_xml($jsonDataArray, &$xml_body_info, $parent = ''){
        foreach ($jsonDataArray as $key => $value){
            if (is_array($value)) {
                if (array_key_exists('attribute', $value)) {
                    $node = $xml_body_info->addChild($key, $value['value']);
                    foreach ($value['attribute'] as $k => $v) {
                        $node->addAttribute($k, $v);
                    }
                } else {
                    if (!is_numeric($key)) {
                        if(is_array($value)){
                            $cont = 0;
                            foreach(array_keys($value) as $k){
                                if(is_numeric($k)) $cont++;
                            }
                        }
                        if($cont>0){
                            for($i=0; $i < $cont; $i++){
                                $subnode = $xml_body_info->addChild($key);
                                $this->array_to_xml($value[$i], $subnode);
                            }
                        }else{
                            $subnode = $xml_body_info->addChild($key);
                            $this->array_to_xml($value, $subnode);
                        }
                    } else {
                        $this->array_to_xml($value, $xml_body_info);
                    }
                }
            } else {
                $xml_body_info->addChild($key, $value);
            }
        }
    }

    public function buildRequestFeed($dataItems,$type, $purgeAndReplace = "false"){
        $request = [];
        
        if(count($dataItems)>0) {
            $request["MessageType"] = $type;
            $request["PurgeAndReplace"] = $purgeAndReplace;
            $request["Message"] = [];   
            $countMessage = 1;
            foreach ($dataItems as $data) {
                switch ($type) {
                    case 'Product':
                        $dummieProduct = new DummieProductRequest();
                        $dataDummie = $dummieProduct->getStructure();
                        $dataDummie["MessageID"] = (string)$countMessage;
                        $dataDummie["OperationType"] = $data->OperationType;
                        $dataDummie["Product"]["SKU"] = $data->SKU;
                        $dataDummie["Product"]["StandardProductID"]["Type"] = $data->StandarProductID_Type;
                        $dataDummie["Product"]["StandardProductID"]["Value"] = $data->StandarProductID_Value;
                        $dataDummie["Product"]["DescriptionData"]["Title"] = $data->DescriptionData_Title;
                        $dataDummie["Product"]["DescriptionData"]["Brand"] = $data->DescriptionData_Brand;
                        $dataDummie["Product"]["DescriptionData"]["Description"] = $data->DescriptionData_Description;
                        $dataDummie["Product"]["DescriptionData"]["BulletPoint"] = $data->DescriptionData_BulletPoint;
                        $dataDummie["Product"]["DescriptionData"]["MSRP"]["attribute"]["currency"] = $data->DescriptionData_Currency;
                        $dataDummie["Product"]["DescriptionData"]["MSRP"]["value"] = $data->DescriptionData_Msrp;
                        $dataDummie["Product"]["DescriptionData"]["Manufacturer"] = $data->DescriptionData_Manufacturer;
                        $dataDummie["Product"]["DescriptionData"]["ItemType"] = $data->DescriptionData_ItemType;
                        $dataDummie["Product"]["ProductData"]["ClothingAccessories"]["VariationData"]["Size"] = $data->ProductData_Size;
                        $dataDummie["Product"]["ProductData"]["ClothingAccessories"]["VariationData"]["Color"] = $data->ProductData_Color;
                        $dataDummie["Product"]["ProductData"]["ClothingAccessories"]["ClassificationData"]["Department"] = $data->ProductData_Gender;
                        break;
                    case 'Price':
                        $dummiePrice = new DummiePriceRequest();
                        $dataDummie = $dummiePrice->getStructure();
                        $dataDummie["MessageID"] = (string)$countMessage;
                        $dataDummie["OperationType"] = $data->OperationType;
                        $dataDummie["Price"]["SKU"] = $data->SKU;
                        $dataDummie["Price"]["StandardPrice"]["attribute"]["currency"] = $data->StandardPrice_Currency;
                        $dataDummie["Price"]["StandardPrice"]["value"] = $data->StandardPrice;
                        $dataDummie["Price"]["Sale"]["StartDate"] = $data->Sale_StartDate;
                        $dataDummie["Price"]["Sale"]["EndDate"] = $data->Sale_EndDate;
                        $dataDummie["Price"]["Sale"]["SalePrice"]["attribute"]["currency"] = $data->Sale_SalePrice_Currency;
                        $dataDummie["Price"]["Sale"]["SalePrice"]["value"] = $data->Sale_SalePrice;
                        break;
                    case 'Inventory':
                        $dummieStock = new DummieStockRequest();
                        $dataDummie = $dummieStock->getStructure();
                        $dataDummie["MessageID"] = (string)$countMessage;
                        $dataDummie["OperationType"] = $data->OperationType;
                        $dataDummie["Inventory"]["SKU"] = $data->SKU;
                        $dataDummie["Inventory"]["Quantity"] = $data->Quantity;
                        $dataDummie["Inventory"]["FulfillmentLatency"] = $data->FulfillmentLatency;
                        break;
                    case 'ProductImage':
                        $dummieImages = new DummieImagesRequest();
                        $dataDummie = $dummieImages->getStructure();
                        $dataDummie["MessageID"] = (string)$countMessage;
                        $dataDummie["OperationType"] = $data->OperationType;
                        $dataDummie["ProductImage"]["SKU"] = $data->SKU;
                        $dataDummie["ProductImage"]["ImageType"] = $data->ImageType;
                        $dataDummie["ProductImage"]["ImageLocation"] = $data->ImageLocation;
                        break;
                    case 'OrderAcknowledgement':
                        $dummieOrderAcknowledgement = new DummieOrderAcknowledgement();
                        $dataDummie = $dummieOrderAcknowledgement->getStructure();
                        $dataDummie["MessageID"] = (string)$countMessage;
                        $dataDummie["OrderAcknowledgement"]["AmazonOrderID"] = $data->AmazonOrderID;
                        $dataDummie["OrderAcknowledgement"]["MerchantOrderID"] = $data->MerchantOrderID;
                        $dataDummie["OrderAcknowledgement"]["StatusCode"] = $data->StatusCode;
                        $dataDummie["OrderAcknowledgement"]["Item"]["AmazonOrderItemCode"] = $data->AmazonOrderItemCode;
                        $dataDummie["OrderAcknowledgement"]["Item"]["MerchantOrderItemID"] = $data->MerchantOrderItemID;
                        break;
                    case 'OrderFulfillment':
                        $dummieOrderFulfillment = new DummieOrderFulfillment();
                        $dataDummie = $dummieOrderFulfillment->getStructure();
                        $dataDummie["MessageID"] = (string)$countMessage;
                        $dataDummie["OrderFulfillment"]["MerchantOrderID"]= $data->MerchantOrderID;
                        $dataDummie["OrderFulfillment"]["MerchantFulfillmentID"] = $data->MerchantFulfillmentID;
                        $dataDummie["OrderFulfillment"]["FulfillmentDate"] = $data->FulfillmentDate;
                        $dataDummie["OrderFulfillment"]["FulfillmentData"]["CarrierCode"] = $data->FulfillmentData_CarrierCode;
                        $dataDummie["OrderFulfillment"]["FulfillmentData"]["ShippingMethod"] = $data->FulfillmentData_ShippingMethod;
                        $dataDummie["OrderFulfillment"]["FulfillmentData"]["ShipperTrackingNumber"] = $data->FulfillmentData_ShipperTrackingNumber;
                        $dataDummie["OrderFulfillment"]["Item"]["MerchantOrderItemID"] = $data->Item_MerchantOrderItemID;
                        $dataDummie["OrderFulfillment"]["Item"]["MerchantFulfillmentItemID"] = $data->MerchantFulfillmentItemID;
                        $dataDummie["OrderFulfillment"]["Item"]["Quantity"] = $data->Item_Quantity;
                        break;
                    case 'OrderAdjustment':
                        $dummieOrderAdjustment = new DummieOrderAdjustment();
                        $dataDummie = $dummieOrderAdjustment->getStructure();
                        $dataDummie["MessageID"] = (string)$countMessage;
                        $dataDummie["OrderAdjustment"]["MerchantOrderID"] = $data->MerchantOrderID;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["MerchantOrderItemID"] = $data->AdjustedItem_MerchantOrderItemID;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["MerchantAdjustmentItemID"] = $data->AdjustedItem_MerchantAdjustmentItemID;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["AdjustmentReason"] = $data->AdjustedItem_AdjustmentReason;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["ItemPriceAdjustments"]["Component"][0]["Amount"]["value"] = $data->ItemPriceAdjustments_Principal;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["ItemPriceAdjustments"]["Component"][1]["Amount"]["value"] = $data->ItemPriceAdjustments_Shipping;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["ItemPriceAdjustments"]["Component"][2]["Amount"]["value"] = $data->ItemPriceAdjustments_Tax;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["ItemPriceAdjustments"]["Component"][3]["Amount"]["value"] = $data->ItemPriceAdjustments_Shipping_Tax;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["PromotionAdjustments"]["PromotionClaimCode"] = $data->PromotionAdjustments_PromotionClaimCode;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["PromotionAdjustments"]["MerchantPromotionID"] = $data->PromotionAdjustments_MerchantPromotionID;
                        $dataDummie["OrderAdjustment"]["AdjustedItem"]["PromotionAdjustments"]["Component"][0]["Amount"]["value"] = $data->PromotionAdjustments_Principal;
                        break;
                }
                $countMessage++;
                array_push($request["Message"],$dataDummie);
            }
        }

        $request = json_encode($request);
        return $request;
    }

}