<?php

namespace jarekkozak\util;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-03-22 at 08:35:08.
 */
class CurrencyExchangeNBPTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CurrencyExchangeNBP
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new CurrencyExchangeNBP;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::findTableName
     */
    public function testFindTableName()
    {
        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-20')
        ]);

        $this->assertEquals('a055z150320', $this->object->findTableName('a'));

        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-21')
        ]);
        $this->assertEquals(FALSE, $this->object->findTableName('a'));
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getExRatioTableList
     */
    public function testGetExRatioTableList()
    {
        $alist = $this->object->getExRatioTableList('a');
        $list  = $this->object->getExRatioTableList();
        $this->assertTrue(count($alist) > 100);
        $this->assertTrue(count($list) > count($alist));
        $this->assertEquals('a001z020102', $alist[0]);
        $this->assertEquals('c001z020102', $list[0]);
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::convert
     * @todo   Implement testConvert().
     */
    public function testConvert()
    {
        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-20')
        ]);

        $this->assertEquals(412.55, $this->object->convert(100, 'EUR'));
        $this->assertEquals(222.55, $this->object->convert(500, 'SEK'));
        $this->assertEquals(1932.25, $this->object->convert(500, 'USD'));
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::setExchangeRateDate
     */
    public function testSetExchangeRateDate()
    {

        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-20')
        ]);
        $this->assertEquals('2015-03-20T00:00:00+0000',
            $this->object->getExchangeRateDate()->format());
        $this->assertEquals('2015-03-20T00:00:00+0000',
            $this->object->getTableDate()->format());

        $this->object->setExchangeRateDate(new \Moment\Moment('2015-03-21'));
        $this->assertEquals('2015-03-21T00:00:00+0000',
            $this->object->getExchangeRateDate()->format());

        $this->assertEquals('2015-03-20T00:00:00+0000',
            $this->object->getTableDate()->format());

        $this->object->setExchangeRateDate(new \Moment\Moment('2015-03-19'));
        $this->assertEquals('2015-03-19T00:00:00+0000',
            $this->object->getExchangeRateDate()->format());
        $this->assertEquals('2015-03-19T00:00:00+0000',
            $this->object->getTableDate()->format());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::setSourceCurrency
     */
    public function testSetSourceCurrency()
    {
        $this->assertEquals('PLN', $this->object->getSourceCurrency());
        $this->object->setSourceCurrency('EUR');
        $this->assertEquals('EUR', $this->object->getSourceCurrency());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getLinkList
     */
    public function testGetLinkList()
    {
        $this->assertEquals('http://www.nbp.pl/kursy/xml/dir.txt',
            $this->object->getLinkList());

        $this->object = new CurrencyExchangeNBP([
            'linkList' => 'test_a'
        ]);
        
        $this->assertEquals('test_a',
            $this->object->getLinkList());

    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getLinkDir
     */
    public function testGetLinkDir()
    {
        $this->assertEquals('http://www.nbp.pl/kursy/xml',
            $this->object->getLinkDir());

        $this->object = new CurrencyExchangeNBP([
            'linkDir' => 'test_b'
        ]);

        $this->assertEquals('test_b',
            $this->object->getLinkDir());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getTableType
     */
    public function testGetTableType()
    {
        $this->assertEquals('a',$this->object->getTableType());
        $this->object->setTableType('b');
        $this->assertEquals('b',$this->object->getTableType());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getTableDate
     */
    public function testGetTableDate()
    {
        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-20')
        ]);
        $this->assertEquals('2015-03-20T00:00:00+0000',
            $this->object->getTableDate()->format());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getTableNumber
     */
    public function testGetTableNumber()
    {
        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-20')
        ]);
        $this->assertEquals('055/A/NBP/2015',
            $this->object->getTableNumber());
        $this->assertEquals('a055z150320',$this->object->getTableName());
    }

}