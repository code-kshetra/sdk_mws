<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 22/07/16
 * Time: 09:55 AM
 */

namespace Osom\Sdk_Mws\OrdersManagement;

include_once (substr(__DIR__,0,strpos(__DIR__, 'src')).'src/.config.php');

use Osom\Sdk_Mws\MarketplaceWebServiceOrders\MarketplaceWebServiceOrders_Client;
use Osom\Sdk_Mws\MarketplaceWebServiceOrders\Model\MarketplaceWebServiceOrders_Model_ListOrdersRequest;
use Osom\Sdk_Mws\MarketplaceWebServiceOrders\Model\MarketplaceWebServiceOrders_Model_ListOrderItemsRequest;
use Osom\Sdk_Mws\MarketplaceWebServiceOrders\MarketplaceWebServiceOrders_Interface;
use Osom\Sdk_Mws\MarketplaceWebServiceOrders\MarketplaceWebServiceOrders_Mock;
use DOMDocument;
use SebastianBergmann\Exporter\Exception;


class Orders
{
    private $serviceUrl;

    private $config = [];

    private $service;

    private $marketplaceIdArray = [];
    
    public function __construct(){
        $this->serviceUrl = "https://mws.amazonservices.com/Orders/2013-09-01";
        $this->config = array (
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'ProxyUsername' => null,
            'ProxyPassword' => null,
            'MaxErrorRetry' => 3,
        );

        $this->service = new MarketplaceWebServiceOrders_Client(
            AWS_ACCESS_KEY_ID,
            AWS_SECRET_ACCESS_KEY,
            APPLICATION_NAME,
            APPLICATION_VERSION,
            $this->config);

        /************************************************************************
         * Uncomment to try out Mock Service that simulates MarketplaceWebServiceOrders
         * responses without calling MarketplaceWebServiceOrders service.
         *
         * Responses are loaded from local XML files. You can tweak XML files to
         * experiment with various outputs during development
         *
         * XML files available under MarketplaceWebServiceOrders/Mock tree
         *
         ***********************************************************************/
        //$this->service = new MarketplaceWebServiceOrders_Mock();

        $this->marketplaceIdArray = array('A1AM78C64UM0Y8');
    }

    public function createRequestOrders($operation, $parameters = array()){
        $response = false;

        switch($operation){
            case 'ListOrders':
                $request = new MarketplaceWebServiceOrders_Model_ListOrdersRequest();
                $request->setSellerId(MERCHANT_ID);
                $request->setMarketplaceId($this->marketplaceIdArray);
                if(isset($parameters['CreatedAfter']) && !empty($parameters['CreatedAfter']) && !isset($parameters['CreatedBefore'])) {
                    $request->withCreatedAfter($parameters['CreatedAfter']);
                    if(isset($parameters['OrderStatus']) && !empty($parameters['OrderStatus'])){
                        $request->setOrderStatus($parameters['OrderStatus']);
                    }
                }elseif (isset($parameters['CreatedAfter']) && !empty($parameters['CreatedAfter']) && isset($parameters['CreatedBefore']) && !empty($parameters['CreatedBefore'])){
                    $request->withCreatedAfter($parameters['CreatedAfter']);
                    $request->withCreatedBefore($parameters['CreatedBefore']);
                    if(isset($parameters['OrderStatus']) && !empty($parameters['OrderStatus'])){
                        $request->setOrderStatus($parameters['OrderStatus']);
                    }
                }elseif (isset($parameters['LastUpdatedAfter']) && !empty($parameters['LastUpdatedAfter'])) {
                    $request->withLastUpdatedAfter($parameters['LastUpdatedAfter']);
                }

                // object or array of parameters
                $response = $this->invokeListOrders($this->service, $request);
                break;
            case 'ListOrderItems':
                $request = new MarketplaceWebServiceOrders_Model_ListOrderItemsRequest();
                $request->setSellerId(MERCHANT_ID);
                if(isset($parameters['AmazonOrderId']) && !empty($parameters['AmazonOrderId'])) {
                    $request->withAmazonOrderId($parameters['AmazonOrderId']);
                }
                $response = $this->invokeListOrderItems($this->service, $request);
                break;
            default:
                $response = false;
                break;
        }

        return $response;
    }

    public function invokeListOrders(MarketplaceWebServiceOrders_Interface $service, $request)
    {
        $responseVar = null;
        $responseJson = array();
        try {
            $response = $service->ListOrders($request);
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

        } catch (MarketplaceWebServiceOrders_Exception $ex) {
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

    function invokeListOrderItems(MarketplaceWebServiceOrders_Interface $service, $request)
    {
        $responseVar = null;
        $responseJson = array();
        try {
            $response = $service->ListOrderItems($request);

            //echo ("Service Response\n");
            //echo ("=============================================================================\n");

            $dom = new DOMDocument();
            $dom->loadXML($response->toXML());
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            //echo $dom->saveXML();
            //echo("ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");

            $xml = simplexml_load_string($dom->saveXML());
            $json = json_encode($xml);
            $responseJson = json_decode($json,TRUE);
            $responseJson["success"] = true;
            $responseJson["ResponseHeaderMetadata"] = $response->getResponseHeaderMetadata();
            $responseVar = json_encode($responseJson);


        } catch (MarketplaceWebServiceOrders_Exception $ex) {
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