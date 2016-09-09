<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 9/09/16
 * Time: 04:06 PM
 */

namespace Osom\Sdk_Mws\ProductManagement;

include_once (substr(__DIR__,0,strpos(__DIR__, 'src')).'src/.config.php');
use Osom\Sdk_Mws\MarketplaceWebServiceProducts\MarketplaceWebServiceProducts_Exception;
use Osom\Sdk_Mws\MarketplaceWebServiceProducts\MarketplaceWebServiceProducts_Interface;
use Osom\Sdk_Mws\MarketplaceWebServiceProducts\MarketplaceWebServiceProducts_Client;
use Osom\Sdk_Mws\MarketplaceWebServiceProducts\Model\MarketplaceWebServiceProducts_Model_GetMatchingProductForIdRequest;
use DOMDocument;
use Osom\Sdk_Mws\MarketplaceWebServiceProducts\Model\MarketplaceWebServiceProducts_Model_IdListType;


class Products
{
    private $serviceUrl;

    private $config = [];

    private $service;

    private $marketplaceIdArray = [];

    public function __construct(){
        $this->serviceUrl = "https://mws.amazonservices.com/Products/2011-10-01";
        $this->config = [
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3
        ];


        $this->service = new MarketplaceWebServiceProducts_Client(
            AWS_ACCESS_KEY_ID,
            AWS_SECRET_ACCESS_KEY,
            APPLICATION_NAME,
            APPLICATION_VERSION,
            $this->config);


        $this->marketplaceIdArray = 'A1AM78C64UM0Y8';
    }

    public function createRequestProduct($operation, $parameters = array()){
        $response = false;

        switch($operation){
            case 'GetMatchingProductForId':
                $request = new MarketplaceWebServiceProducts_Model_GetMatchingProductForIdRequest();
                $request->setSellerId(MERCHANT_ID);
                $request->setMarketplaceId($this->marketplaceIdArray);
                $request->setIdType('SellerSKU');
                $idList = new MarketplaceWebServiceProducts_Model_IdListType();
                $idList->setId($parameters["SKU"]);
                $request->setIdList($idList);
                // object or array of parameters
                $response = $this->invokeGetMatchingProductForId($this->service, $request);
                break;
        }

        return $response;
    }

    public function invokeGetMatchingProductForId(MarketplaceWebServiceProducts_Interface $service, $request)
    {
        $responseVar = null;
        $responseJson = array();
        try {
            $response = $service->GetMatchingProductForId($request);

            $dom = new DOMDocument();
            $dom->loadXML($response->toXML());
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $xml = simplexml_load_string($dom->saveXML());
            $json = json_encode($xml);
            $responseJson = json_decode($json,TRUE);
            $responseJson["success"] = true;
            $responseJson["ResponseHeaderMetadata"] = $response->getResponseHeaderMetadata();
            $responseVar = json_encode($responseJson);

        } catch (MarketplaceWebServiceProducts_Exception $ex) {
            $responseJson['success'] = false;
            $responseJson["caughtException"] = $ex->getMessage();
            $responseJson["responseStatusCode"] = $ex->getStatusCode();
            $responseJson["errorCode"] = $ex->getErrorCode();
            $responseJson["errorType"] = $ex->getErrorType();
            $responseJson["requestID"] = $ex->getRequestId();
            $responseJson["xml"] = $ex->getXML();
            $responseJson["responseHeaderMetadata"] = $ex->getResponseHeaderMetadata();
            $responseVar = json_encode($responseJson);
        }

        return$responseVar;
    }
}