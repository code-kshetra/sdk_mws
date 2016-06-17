<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 17/06/16
 * Time: 11:00 AM
 */

namespace Osom\Sdk_Mws\ProductManagement;

include_once ('src/.config.php');
include_once ('src/MarketplaceWebService/Client.php');

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
    
    public function createRequestFeed(){
        $feed = <<<EOD
        <?xml version="1.0" ?>
        <AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="amznenvelope.xsd">
            <Header>
                <DocumentVersion>1.01</DocumentVersion>
                <MerchantIdentifier>M_SELLER_354577</MerchantIdentifier>
        </Header>
        <MessageType>Product</MessageType>
        <PurgeAndReplace>true</PurgeAndReplace>
        <Message>
        <MessageID>1</MessageID>
        <OperationType>Update</OperationType>
        <Product>
        <SKU>1Z-500ABR-FLAT</SKU>
        <ProductTaxCode>A_GEN_TAX</ProductTaxCode>
        <LaunchDate>2005-07-26T00:00:01</LaunchDate>
        <DescriptionData>
        <Title>Lyric 500 tc Queen Flat Sheet, Ivory</Title>
        <Brand>Peacock Alley</Brand> 
        <Description>Lyric sheeting by Peacock Alley is the epitome of simple and classic elegance. The flat sheets and pillowcases feature a double row of hemstitching. The fitted sheets fit mattresses up to 21 inches deep. The sheets are shown at left with tone on tone monogramming, please call for monogramming details and prices. Please note, gift wrapping and overnight shipping are not available for this style.</Description>
        <BulletPoint>made in Italy</BulletPoint>
        <BulletPoint>500 thread count</BulletPoint>
        <BulletPoint>plain weave (percale)</BulletPoint>
        <BulletPoint>100% Egyptian cotton</BulletPoint>
        <Manufacturer>Peacock Alley</Manufacturer>
        <SearchTerms>bedding</SearchTerms>
        <SearchTerms>Sheets</SearchTerms>
        <ItemType>flat-sheets</ItemType>
        <IsGiftWrapAvailable>false</IsGiftWrapAvailable>
        <IsGiftMessageAvailable>false</IsGiftMessageAvailable>
         <RecommendedBrowseNode>60583031</RecommendedBrowseNode>
         <RecommendedBrowseNode>60576021</RecommendedBrowseNode>
        </DescriptionData>
        <ProductData>
        <Home>
        <Parentage>variation-parent</Parentage>
        <VariationData>
        <VariationTheme>Size-Color</VariationTheme>
        </VariationData>
        <Material>cotton</Material>
        <ThreadCount>500</ThreadCount>
        </Home>
        </ProductData>
        </Product>
        </Message>
        <Message>
        </AmazonEnvelope>
EOD;
        $feedHandle = @fopen('php://memory', 'rw+');
        fwrite($feedHandle, $feed);
        rewind($feedHandle);

        $request = new MarketplaceWebService_Model_SubmitFeedRequest();
        $request->setMerchant(MERCHANT_ID);
        $request->setMarketplaceIdList($this->marketplaceIdArray);
        $request->setFeedType('_POST_PRODUCT_DATA_');
        $request->setContentMd5(base64_encode(md5(stream_get_contents($feedHandle), true)));
        rewind($feedHandle);
        $request->setPurgeAndReplace(false);
        $request->setFeedContent($feedHandle);
        //$request->setMWSAuthToken('<MWS Auth Token>'); // Optional

        rewind($feedHandle);
        $this->invokeSubmitFeed($this->service, $request);

        @fclose($feedHandle);
        return true;
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
        try {
            $response = $service->submitFeed($request);

            echo ("Service Response\n");
            echo ("=============================================================================\n");

            echo("        SubmitFeedResponse\n");
            if ($response->isSetSubmitFeedResult()) {
                echo("            SubmitFeedResult\n");
                $submitFeedResult = $response->getSubmitFeedResult();
                if ($submitFeedResult->isSetFeedSubmissionInfo()) {
                    echo("                FeedSubmissionInfo\n");
                    $feedSubmissionInfo = $submitFeedResult->getFeedSubmissionInfo();
                    if ($feedSubmissionInfo->isSetFeedSubmissionId())
                    {
                        echo("                    FeedSubmissionId\n");
                        echo("                        " . $feedSubmissionInfo->getFeedSubmissionId() . "\n");
                    }
                    if ($feedSubmissionInfo->isSetFeedType())
                    {
                        echo("                    FeedType\n");
                        echo("                        " . $feedSubmissionInfo->getFeedType() . "\n");
                    }
                    if ($feedSubmissionInfo->isSetSubmittedDate())
                    {
                        echo("                    SubmittedDate\n");
                        echo("                        " . $feedSubmissionInfo->getSubmittedDate()->format(DATE_FORMAT) . "\n");
                    }
                    if ($feedSubmissionInfo->isSetFeedProcessingStatus())
                    {
                        echo("                    FeedProcessingStatus\n");
                        echo("                        " . $feedSubmissionInfo->getFeedProcessingStatus() . "\n");
                    }
                    if ($feedSubmissionInfo->isSetStartedProcessingDate())
                    {
                        echo("                    StartedProcessingDate\n");
                        echo("                        " . $feedSubmissionInfo->getStartedProcessingDate()->format(DATE_FORMAT) . "\n");
                    }
                    if ($feedSubmissionInfo->isSetCompletedProcessingDate())
                    {
                        echo("                    CompletedProcessingDate\n");
                        echo("                        " . $feedSubmissionInfo->getCompletedProcessingDate()->format(DATE_FORMAT) . "\n");
                    }
                }
            }
            if ($response->isSetResponseMetadata()) {
                echo("            ResponseMetadata\n");
                $responseMetadata = $response->getResponseMetadata();
                if ($responseMetadata->isSetRequestId())
                {
                    echo("                RequestId\n");
                    echo("                    " . $responseMetadata->getRequestId() . "\n");
                }
            }

            echo("            ResponseHeaderMetadata: " . $response->getResponseHeaderMetadata() . "\n");
        } catch (MarketplaceWebService_Exception $ex) {
            echo("Caught Exception: " . $ex->getMessage() . "\n");
            echo("Response Status Code: " . $ex->getStatusCode() . "\n");
            echo("Error Code: " . $ex->getErrorCode() . "\n");
            echo("Error Type: " . $ex->getErrorType() . "\n");
            echo("Request ID: " . $ex->getRequestId() . "\n");
            echo("XML: " . $ex->getXML() . "\n");
            echo("ResponseHeaderMetadata: " . $ex->getResponseHeaderMetadata() . "\n");
        }
    }
}