<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 17/06/16
 * Time: 11:00 AM
 */

namespace Osom\Sdk_Mws\ProductManagement;


include_once (substr(__DIR__,0,strpos(__DIR__, 'src')).'src/.config.php');
use Osom\Sdk_Mws\MarketplaceWebService\MarketplaceWebService_Client;
use Osom\Sdk_Mws\MarketplaceWebService\MarketplaceWebService_Interface;
use Osom\Sdk_Mws\MarketplaceWebService\Model\MarketplaceWebService_Model_SubmitFeedRequest;
use Osom\Sdk_Mws\MarketplaceWebService\Model\MarketplaceWebService_Model_GetFeedSubmissionListRequest;
use Osom\Sdk_Mws\MarketplaceWebService\Model\MarketplaceWebService_Model_StatusList;
use Osom\Sdk_Mws\MarketplaceWebService\Model\MarketplaceWebService_Model_IdList;
use Osom\Sdk_Mws\MarketplaceWebService\Model\MarketplaceWebService_Model_SubmitFeedResponse;
use Osom\Sdk_Mws\MarketplaceWebService\Model\MarketplaceWebService_Model_SubmitFeedResult;
use Osom\Sdk_Mws\MarketplaceWebService\Model\MarketplaceWebService_Model_GetFeedSubmissionResultRequest;
use Osom\Sdk_Mws\MarketplaceWebService\MarketplaceWebService_Exception;
use SimpleXMLElement;
use stdClass;



class Feeds
{

    private $serviceUrl;
    
    private $config = [];
    
    private $service;

    private $marketplaceIdArray = [];
    
    public function __construct(){
        $this->serviceUrl = "https://mws.amazonservices.com";
        $this->config = [
            'ServiceURL' => $this->serviceUrl,
            'ProxyHost' => null,
            'ProxyPort' => -1,
            'MaxErrorRetry' => 3
        ];


        $this->service = new MarketplaceWebService_Client(
            AWS_ACCESS_KEY_ID,
            AWS_SECRET_ACCESS_KEY,
            $this->config,
            APPLICATION_NAME,
            APPLICATION_VERSION);


        $this->marketplaceIdArray = array("Id" => array('A1AM78C64UM0Y8'));
    }
    
    public function createRequestFeed($feed = '', $feedType = '', $operation, $parameters = array()){
        $response = false;
        switch($operation) {
            case 'SubmitFeed':
                $feedHandle = @fopen('php://memory', 'rw+');
                fwrite($feedHandle, $feed);
                rewind($feedHandle);

                $request = new MarketplaceWebService_Model_SubmitFeedRequest();
                $request->setMerchant(MERCHANT_ID);
                $request->setMarketplaceIdList($this->marketplaceIdArray);
                $request->setFeedType($feedType);
                $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
                rewind($feedHandle);
                $request->setPurgeAndReplace(false);
                $request->setFeedContent($feedHandle);

                rewind($feedHandle);

                $response = $this->invokeSubmitFeed($this->service, $request);

                @fclose($feedHandle);
                break;
            case 'GetFeedSubmissionList':
                $request = new MarketplaceWebService_Model_GetFeedSubmissionListRequest();
                $request->setMerchant(MERCHANT_ID);
                //$request->setMWSAuthToken('<MWS Auth Token>'); // Optional
                $statusList = new MarketplaceWebService_Model_StatusList();
                $idList = new MarketplaceWebService_Model_IdList();
                if(isset($parameters['Status']) && !empty($parameters['Status'])) {
                    $request->setFeedProcessingStatusList($statusList->withStatus($parameters['Status']));
                    $response = $this->invokeGetFeedSubmissionList($this->service, $request);
                }
                if(isset($parameters['SubmissionId']) && !empty($parameters['SubmissionId'])){
                    //$request->setFeedSubmissionId($parameters['SubmissionId']);
                    $request->setFeedSubmissionIdList($idList->withId($parameters['SubmissionId']));
                    $response = $this->invokeGetFeedSubmissionList($this->service, $request);
                }
                else 
                    $response = false;
                break;
            case 'GetFeedSubmissionResult':
                $request = new MarketplaceWebService_Model_GetFeedSubmissionResultRequest();
                $request->setMerchant(MERCHANT_ID);
                if(isset($parameters['SubmissionId']) && !empty($parameters['SubmissionId'])) {
                    $request->setFeedSubmissionId($parameters['SubmissionId']);
                    $request->setFeedSubmissionResult(@fopen('php://memory', 'rw+'));
                    //$request->setMWSAuthToken('<MWS Auth Token>'); // Optional
                    $response = $this->invokeGetFeedSubmissionResult($this->service, $request);
                }
                else
                    $response = false;
                break;
            default:
                $response = false;
                break;
        }
        return $response;
    }
    
    /**
     * Submit Feed Action Sample
     * Uploads a file for processing together with the necessary
     * metadata to process the file, such as which type of feed it is.
     * PurgeAndReplace if true means that your existing e.g. inventory is
     * wiped out and replace with the contents of this feed - use with
     * caution (the default is false).
     *
     * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
     * @param mixed $request MarketplaceWebService_Model_SubmitFeed or array of parameters
     */
    public function invokeSubmitFeed(MarketplaceWebService_Interface $service, $request)
    {
        $responseVar = null;
        $responseJson = array();
        try {
            $response = $service->submitFeed($request);

            $SubmitFeedResponse = array();
            if ($response->isSetSubmitFeedResult()) {
                $SubmitFeedResult = array();
                $submitFeedResult = $response->getSubmitFeedResult();
                if ($submitFeedResult->isSetFeedSubmissionInfo()) {
                    $FeedSubmissionInfo = array();
                    $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
                    if ($feedSubmissionInfo->isSetFeedSubmissionId())
                    {
                        $FeedSubmissionInfo["FeedSubmissionId"] = $feedSubmissionInfo->getFeedSubmissionId();
                    }
                    if ($feedSubmissionInfo->isSetFeedType())
                    {
                        $FeedSubmissionInfo["FeedType"] = $feedSubmissionInfo->getFeedType();
                    }
                    if ($feedSubmissionInfo->isSetSubmittedDate())
                    {
                        $FeedSubmissionInfo["SubmittedDate"] = $feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT);
                    }
                    if ($feedSubmissionInfo->isSetFeedProcessingStatus())
                    {
                        $FeedSubmissionInfo["FeedProcessingStatus"] = $feedSubmissionInfo->getFeedProcessingStatus();
                    }
                    if ($feedSubmissionInfo->isSetStartedProcessingDate())
                    {
                        $FeedSubmissionInfo["StartedProcessingDate"] = $feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT);
                    }
                    if ($feedSubmissionInfo->isSetCompletedProcessingDate())
                    {
                        $FeedSubmissionInfo["CompletedProcessingDate"] = $feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT);
                    }
                }
                $SubmitFeedResult["FeedSubmissionInfo"] = $FeedSubmissionInfo;
            }
            $SubmitFeedResponse["SubmitFeedResult"] = $SubmitFeedResult;

            if ($response->isSetResponseMetadata()) {
                $ResponseMetadata = array();
                $responseMetadata = $response->getResponseMetadata();
                if ($responseMetadata->isSetRequestId())
                {
                    $ResponseMetadata["RequestId"] = $responseMetadata->getRequestId();
                }
            }

            $SubmitFeedResponse["ResponseMetadata"] = $ResponseMetadata;

            $SubmitFeedResponse["ResponseHeaderMetadata"] = $response->getResponseHeaderMetadata();
            $responseJson["success"] = true;
            $responseJson["SubmitFeedResponse"] = $SubmitFeedResponse;
            $responseVar = json_encode($responseJson);
        } catch (MarketplaceWebService_Exception $ex) {
            $responseJson["success"] = false;
            $responseJson["caughtException"] = $ex->getMessage();
            $responseJson["responseStatusCode"] = $ex->getStatusCode();
            $responseJson["errorCode"] = $ex->getErrorCode();
            $responseJson["errorType"] = $ex->getErrorType();
            $responseJson["requestID"] = $ex->getRequestId();
            $responseJson["xml"] = $ex->getXML();
            $responseJson["responseHeaderMetadata"] = $ex->getResponseHeaderMetadata();
            $responseVar = json_decode($responseJson);
        }
        return$responseVar;
    }

    /**
     * Get Feed Submission List Action Sample
     * returns a list of feed submission identifiers and their associated metadata
     *
     * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
     * @param mixed $request MarketplaceWebService_Model_GetFeedSubmissionList or array of parameters
     */
    public function invokeGetFeedSubmissionList(MarketplaceWebService_Interface $service, $request)
    {
        $responseVar = null;
        $responseJson = array();
        try {
            $response = $service->getFeedSubmissionList($request);

            $GetFeedSubmissionListResponse = array();
            if ($response->isSetGetFeedSubmissionListResult()) {
                $GetFeedSubmissionListResult = array();
                $getFeedSubmissionListResult = $response->getGetFeedSubmissionListResult();
                if ($getFeedSubmissionListResult->isSetNextToken())
                {
                    $GetFeedSubmissionListResult["NextToken"] = $getFeedSubmissionListResult->getNextToken();
                }
                if ($getFeedSubmissionListResult->isSetHasNext())
                {
                    $GetFeedSubmissionListResult["HasNext"] = $getFeedSubmissionListResult->getHasNext();
                }
                $feedSubmissionInfoList = $getFeedSubmissionListResult->getFeedSubmissionInfoList();
                $FeedSubmissionInfoList = array();
                foreach ($feedSubmissionInfoList as $feedSubmissionInfo) {
                    $FeedSubmissionInfo = array();
                    if ($feedSubmissionInfo->isSetFeedSubmissionId())
                    {
                        $FeedSubmissionInfo["FeedSubmissionId"] = $feedSubmissionInfo->getFeedSubmissionId();
                    }
                    if ($feedSubmissionInfo->isSetFeedType())
                    {
                        $FeedSubmissionInfo["FeedType"] = $feedSubmissionInfo->getFeedType();
                    }
                    if ($feedSubmissionInfo->isSetSubmittedDate())
                    {
                        $FeedSubmissionInfo["SubmittedDate"] = $feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT);

                    }
                    if ($feedSubmissionInfo->isSetFeedProcessingStatus())
                    {
                        $FeedSubmissionInfo["FeedProcessingStatus"] = $feedSubmissionInfo->getFeedProcessingStatus();
                    }
                    if ($feedSubmissionInfo->isSetStartedProcessingDate())
                    {
                        $FeedSubmissionInfo["StartedProcessingDate"] = $feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT);
                    }
                    if ($feedSubmissionInfo->isSetCompletedProcessingDate())
                    {
                        $FeedSubmissionInfo["CompletedProcessingDate"] = $feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT);
                    }
                    array_push($FeedSubmissionInfoList,$FeedSubmissionInfo);
                }
                $GetFeedSubmissionListResult["FeedSubmissionInfo"] = $FeedSubmissionInfoList;
            }

            $GetFeedSubmissionListResponse["GetFeedSubmissionListResult"] = $GetFeedSubmissionListResult;
            $ResponseMetadata = array();
            if ($response->isSetResponseMetadata()) {
                $responseMetadata = $response->getResponseMetadata();
                if ($responseMetadata->isSetRequestId())
                {
                    $ResponseMetadata["RequestId"] = $responseMetadata->getRequestId();
                }

                $GetFeedSubmissionListResponse["ResponseMetadata"] = $ResponseMetadata;
            }

            $GetFeedSubmissionListResponse["ResponseHeaderMetadata"] = $response->getResponseHeaderMetadata();
            $responseJson["success"] = true;
            $responseJson["GetFeedSubmissionListResponse"] = $GetFeedSubmissionListResponse;
            $responseVar = json_encode($responseJson);
        } catch (MarketplaceWebService_Exception $ex) {

            $responseJson["success"] = false;
            $responseJson["caughtException"] = $ex->getMessage();
            $responseJson["responseStatusCode"] = $ex->getStatusCode();
            $responseJson["errorCode"] = $ex->getErrorCode();
            $responseJson["errorType"] = $ex->getErrorType();
            $responseJson["requestID"] = $ex->getRequestId();
            $responseJson["xml"] = $ex->getXML();
            $responseJson["responseHeaderMetadata"] = $ex->getResponseHeaderMetadata();
            $responseVar = json_encode($responseJson);
        }
        return $responseVar;
    }

    /**
     * Get Feed Submission Result Action Sample
     * retrieves the feed processing report
     *
     * @param MarketplaceWebService_Interface $service instance of MarketplaceWebService_Interface
     * @param mixed $request MarketplaceWebService_Model_GetFeedSubmissionResult or array of parameters
     */
    public function invokeGetFeedSubmissionResult(MarketplaceWebService_Interface $service, $request)
    {
        $responseVar = null;
        $responseJson = array();
        try {
            $response = $service->getFeedSubmissionResult($request);

            $GetFeedSubmissionResultResponse = array();
            if ($response->isSetGetFeedSubmissionResultResult()) {
                $getFeedSubmissionResultResult = $response->getGetFeedSubmissionResultResult();
                $GetFeedSubmissionResult = array();
                if ($getFeedSubmissionResultResult->isSetContentMd5()) {
                    $GetFeedSubmissionResult["ContentMd5"] = $getFeedSubmissionResultResult->getContentMd5();
                }
            }
            if ($response->isSetResponseMetadata()) {
                $ResponseMetadata = array();
                $responseMetadata = $response->getResponseMetadata();
                if ($responseMetadata->isSetRequestId())
                {
                    $ResponseMetadata["RequestId"] = $responseMetadata->getRequestId();
                }
            }

            //using this XML to catch response for amazon
            $xml = stream_get_contents($request->getFeedSubmissionResult());
            $xml = new SimpleXMLElement($xml);
            $result = new stdClass();

            $GetFeedSubmissionResult["Header"] = $xml->Header;

            $MessageType = (array) $xml->MessageType[0][0];

            $GetFeedSubmissionResult["MessageType"] = $MessageType[0];

            $GetFeedSubmissionResult["Message"] = $xml->Message;

            $GetFeedSubmissionResultResponse["GetFeedSubmissionResult"] = $GetFeedSubmissionResult;
            $GetFeedSubmissionResultResponse["ResponseMetadata"] = $ResponseMetadata;
            $GetFeedSubmissionResultResponse["ResponseHeaderMetadata"] = $response->getResponseHeaderMetadata();
            $responseJson["success"] = true;
            $responseJson["GetFeedSubmissionResultResponse"] = $GetFeedSubmissionResultResponse;
            $responseVar = json_encode($responseJson);

        } catch (MarketplaceWebService_Exception $ex) {
            $responseJson["success"] = false;
            $responseJson["caughtException"] = $ex->getMessage();
            $responseJson["responseStatusCode"] = $ex->getStatusCode();
            $responseJson["errorCode"] = $ex->getErrorCode();
            $responseJson["errorType"] = $ex->getErrorType();
            $responseJson["requestID"] = $ex->getRequestId();
            $responseJson["xml"] = $ex->getXML();
            $responseJson["responseHeaderMetadata"] = $ex->getResponseHeaderMetadata();
            $responseVar = json_encode($responseJson);
        }
        return $responseVar;
    }
}