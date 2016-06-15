<?php
/**
 * Created by PhpStorm.
 * User: octavio
 * Date: 15/06/16
 * Time: 06:06 PM
 */
use Osom\Sdk_Mws\Facades;

class FacadesTest extends PHPUnit_Framework_TestCase {
    public function testSetFeeds(){
        $facades = new Facades();
        $this->assertTrue($facades->setFeeds());
    }
}