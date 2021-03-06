<?php

namespace jarekkozak\sys;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-01-25 at 08:01:27.
 */
class PropertiesFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Properties
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers \jarekkozak\sys\Properties::init
     */
    public function testPrpertiesFromFile()
    {
        $filename = dirname(__FILE__) . '/PropertiesFileTest.properties';
        $prop = new PropertiesFile([
            'filename' => $filename
        ]);

        self::assertEquals('testProperty', $prop->getProperty('property1'));
        self::assertEquals('testProperty2', $prop->getProperty('property2'));
        self::assertNull($prop->getProperty('property3'));
        self::assertEquals('testProperty3', $prop->getProperty('property3','testProperty3'));

    }

    /**
     * @covers jk\sys\Properties::init
     */
    public function testPrpertiesExpandFIlename()
    {
        $prop = new PropertiesFile([
            'filename' => '$HOME/test.txt'
        ]);
        self::assertEquals(getenv('HOME').'/test.txt', $prop->filename);

        $prop = new PropertiesFile([
            'envars'=>[],
            'filename' => '$HOME/test.txt'
        ]);
        self::assertEquals('$HOME/test.txt', $prop->filename);

        $prop = new PropertiesFile([
            'envars'=>['NON_EXIST_VARIABLE_YI#(^$)(@&)$'],
            'filename' => '$HOME/test.txt'
        ]);
        self::assertEquals('$HOME/test.txt', $prop->filename);

        $prop = new PropertiesFile([
            'envars'=>['NON_EXIST_VARIABLE_YI#(^$)(@&)$'],
            'filename' => '$NON_EXIST_VARIABLE_YI#(^$)(@&)$/test.txt'
        ]);
        self::assertEquals('/test.txt', $prop->filename);

    }
}