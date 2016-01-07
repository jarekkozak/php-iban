<?php namespace jarekkozak\util;

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
        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-20')
        ]);
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
        // 20.03.2015 is Friday 
        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-20')
        ]);
        self::assertEquals('a055z150320', $this->object->findTableName('a'));

        // 21.03.2015 is Saturday
        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-21')
        ]);
        self::assertEquals(FALSE, $this->object->findTableName('a'));
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getExRatioTableList
     */
    public function testGetExRatioTableList()
    {

        $moment = new \Moment\Moment();
        $year = '15';$moment->format('y');

        $alist = $this->object->getExRatioTableList('a');
        $list = $this->object->getExRatioTableList();
        self::assertTrue(count($alist) > 100);
        self::assertTrue(count($list) > count($alist));
        self::assertContains('a001z' . $year . '01', $alist[0]);
        self::assertContains('c001z' . $year . '01', $list[0]);
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

        self::assertEquals(412.55, $this->object->convert(100, 'EUR'));
        self::assertEquals(222.55, $this->object->convert(500, 'SEK'));
        self::assertEquals(1932.25, $this->object->convert(500, 'USD'));
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
        self::assertEquals('2015-03-20T00:00:00+0000', $this->object->getExchangeRateDate()->format());
        self::assertEquals('2015-03-20T00:00:00+0000', $this->object->getTableDate()->format());

        $this->object->setExchangeRateDate(new \Moment\Moment('2015-03-21'));
        self::assertEquals('2015-03-21T00:00:00+0000', $this->object->getExchangeRateDate()->format());

        self::assertEquals('2015-03-20T00:00:00+0000', $this->object->getTableDate()->format());

        $this->object->setExchangeRateDate(new \Moment\Moment('2015-03-19'));
        self::assertEquals('2015-03-19T00:00:00+0000', $this->object->getExchangeRateDate()->format());
        self::assertEquals('2015-03-19T00:00:00+0000', $this->object->getTableDate()->format());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::setSourceCurrency
     */
    public function testSetSourceCurrency()
    {
        self::assertEquals('PLN', $this->object->getSourceCurrency());
        $this->object->setSourceCurrency('EUR');
        self::assertEquals('PLN', $this->object->getSourceCurrency());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getLinkList
     */
    public function testGetLinkList()
    {
        self::assertEquals('http://www.nbp.pl/kursy/xml/dir2015.txt', $this->object->getLinkList());

        $this->object = new CurrencyExchangeNBP([
            'linkList' => 'test_a'
        ]);

        self::assertEquals('test_a', $this->object->getLinkList());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getLinkDir
     */
    public function testGetLinkDir()
    {
        self::assertEquals('http://www.nbp.pl/kursy/xml', $this->object->getLinkDir());

        $this->object = new CurrencyExchangeNBP([
            'linkDir' => 'test_b'
        ]);

        self::assertEquals('test_b', $this->object->getLinkDir());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getTableType
     */
    public function testGetTableType()
    {
        self::assertEquals('a', $this->object->getTableType());
        $this->object->setTableType('b');
        self::assertEquals('b', $this->object->getTableType());
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
        self::assertEquals('2015-03-20T00:00:00+0000', $this->object->getTableDate()->format());
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
        self::assertEquals('055/A/NBP/2015', $this->object->getTableNumber());
        self::assertEquals('a055z150320', $this->object->getTableName());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::getTableOrderNumber()
     */
    public function testGetTableOrderNumber()
    {
        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => new \Moment\Moment('2015-03-20')
        ]);
        self::assertEquals(2015055, $this->object->getTableOrderNumber());
    }

    /**
     * @covers jarekkozak\util\CurrencyExchangeNBP::init
     *
     *
     * @expectedException jarekkozak\util\CurrencyExchangeRateException
     */
    public function testFutureDate()
    {
        $today = new \Moment\Moment();
        $tommorow = $today->addDays(1);

        $this->object = new CurrencyExchangeNBP([
            'tableType' => 'a',
            'exchangeRateDate' => $tommorow
        ]);
    }
}
