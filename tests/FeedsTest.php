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
    public function testSetFeeds(){
        $feeds = new Feeds();
        $this->assertTrue($feeds->createRequestFeed());
    }
}
