<?php

namespace jarekkozak\util;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-03-20 at 11:09:33.
 */
class CurrencyCodeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurrencyCode
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CurrencyCode;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers jarekkozak\util\CurrencyCode::downloadISOCodes
     */
    public function testDownloadISOCodes()
    {
        $a = $this->object->downloadISOCodes();
        $this->assertCount(4, $a);
        $this->assertTrue(isset($a["country"]["POLAND"]));
        $poland = $a["country"]["POLAND"];
        $this->assertEquals('PLN',$poland['currency']);
        $this->assertEquals(985,$poland['code']);
        $this->assertEquals('Zloty',$poland['name']);
        $this->assertEquals(2,$poland['minor_unit']);



    }

    /**
     * @covers jarekkozak\util\CurrencyCode::getIsoCode
     */
    public function testGetIsoCode()
    {
        $this->assertEquals(985, $this->object->getIsoCode('PLN'));
        $this->assertEquals(840, $this->object->getIsoCode('USD'));
        $this->assertEquals(978, $this->object->getIsoCode('EUR'));
        $this->assertEquals(FALSE, $this->object->getIsoCode('@@@'));
    }

    /**
     * @covers jarekkozak\util\CurrencyCode::getIsoCurrency
     */
    public function testGetIsoCurrency()
    {
        $this->assertEquals('PLN', $this->object->getIsoCurrency(985));
        $this->assertEquals('USD', $this->object->getIsoCurrency(840));
        $this->assertEquals('EUR', $this->object->getIsoCurrency(978));
        $this->assertEquals(FALSE, $this->object->getIsoCurrency(8978));
    }
    
}