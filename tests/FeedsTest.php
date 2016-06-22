<?php

/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 17/06/16
 * Time: 05:08 PM
 */

use Osom\Sdk_Mws\ProductManagement\Feeds;
class FeedsTest extends PHPUnit_Framework_TestCase
{

    /*public function testSubmitProductFeeds(){
        $feeds = new Feeds();*/
        /*$feed = <<<EOD
<?xml version="1.0" encoding="iso-8859-1"?>
<AmazonEnvelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:noNamespaceSchemaLocation="amzn-envelope.xsd">
<Header>
<DocumentVersion>1.01</DocumentVersion>
<MerchantIdentifier>A140MHXDLIVF48</MerchantIdentifier>
</Header>
<MessageType>Product</MessageType>
<PurgeAndReplace>false</PurgeAndReplace>
<Message>
<MessageID>1</MessageID>
<OperationType>Update</OperationType>
<Product>
<SKU>56789</SKU>
<StandardProductID>
<Type>ASIN</Type>
<Value>B0EXAMPLEG</Value>
</StandardProductID>
<ProductTaxCode>A_GEN_NOTAX</ProductTaxCode>
<DescriptionData>
<Title>Example Product Title</Title>
<Brand>Example Product Brand</Brand>
<Description>This is an example product description.</Description>
<BulletPoint>Example Bullet Point 1</BulletPoint>
<BulletPoint>Example Bullet Point 2</BulletPoint>
<MSRP currency="USD">25.19</MSRP>
<Manufacturer>Example Product Manufacturer</Manufacturer>
<ItemType>example-item-type</ItemType>
</DescriptionData>
<ProductData>
<Health>
  <ProductType>
    <HealthMisc>
      <Ingredients>Example Ingredients</Ingredients>
      <Directions>Example Directions</Directions>
    </HealthMisc>
  </ProductType>
</Health>
</ProductData>
</Product>
</Message>
</AmazonEnvelope>
EOD;*/
        /*$feed = <<<EOD
<?xml version="1.0" encoding="iso-8859-1"?>
EOD;
        $feedType = '_POST_PRODUCT_DATA_';
        $operation = 'SubmitFeed';
        $this->assertTrue($feeds->createRequestFeed($feed,$feedType,$operation));
    }*/

    public function testGetFeedSubmissionList(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionList';
        $status = array('_SUBMITTED_', '_CANCELLED_', '_IN_SAFETY_NET_', '_IN_PROGRESS_', '_UNCONFIRMED_', '_AWAITING_ASYNCHRONOUS_REPLY_', '_DONE_');
        $parameters = array('Status' => $status[6]);
        $response = json_decode($feeds->createRequestFeed('','',$operation, $parameters));
        $this->assertTrue($response->success);
    }

    public function testGetFeedSubmissionResult(){
        $feeds = new Feeds();
        $operation = 'GetFeedSubmissionResult';
        $parameters = array('SubmissionId' => '50049016973');
        $this->assertTrue($feeds->createRequestFeed('','',$operation,$parameters));
    }
}
