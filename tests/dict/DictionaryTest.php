<?php

namespace jarekkozak\dict;

use jarekkozak\tests\dict\Dict1;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-03-25 at 22:23:54.
 */
class DictionaryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Dictionary
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
     * @covers jarekkozak\dict\Dictionary::value
     * @todo   Implement testValue().
     */
    public function testValue()
    {
        $a = new Dict1(Dict1::VALUE1);
        $this->assertTrue(1 === $a->value());
        $this->assertTrue('1' == $a->value());
    }

    /**
     * @covers jarekkozak\dict\Dictionary::equals
     */
    public function testEquals()
    {
        $a = new Dict1(Dict1::VALUE1);
        $b = new Dict1(Dict1::VALUE2);
        $this->assertTrue($a != $b);


        $a = new Dict1(Dict1::VALUE1);
        $b = new Dict1(Dict1::VALUE1);
        $this->assertTrue($a->equals($b));

        $this->assertTrue($a == $b);
        $this->assertTrue(1 == $b->value());

        $a = new Dict1(Dict1::VALUE1);
        $b = new Dict1(Dict1::VALUE1);
        $this->assertTrue($a->value() == $b->value());
    }

    /**
     * @covers jarekkozak\dict\Dictionary::isValid
     */
    public function testIsValid()
    {
        $dict = new Dict1();
        $this->assertTrue($dict->isValid(1));
        $this->assertTrue($dict->isValid(2));
        $this->assertFalse($dict->isValid(3));
        $this->assertFalse($dict->isValid('1'));
        $this->assertFalse($dict->isValid('2'));
    }

    /**
     * @covers jarekkozak\dict\Dictionary::getInstanceFromValue
     */
    public function testGetInstanceFromValue()
    {
        $this->assertInstanceOf('jarekkozak\tests\dict\Dict1',
            $ret = Dict1::getInstanceFromValue(1));
        $this->assertTrue($ret->equals(new Dict1(Dict1::VALUE1)));
        $this->assertTrue(1 === $ret->value());
    }

    /**
     * @covers jarekkozak\dict\Dictionary::values()
     */
    public function testValues()
    {
        $arr = [
            new Dict1(Dict1::VALUE1),
            new Dict1(Dict1::VALUE2),
        ];
        $this->assertEquals($arr, Dict1::getInstance()->values());
    }

    /**
     * @covers jarekkozak\dict\Dictionary::getInstance($key)
     */
    public function testGetInstance()
    {
        $this->assertEquals(new Dict1(Dict1::VALUE1), Dict1::getInstance(Dict1::VALUE1));
    }

    /**
     * @covers jarekkozak\dict\Dictionary::dictionary()
     */
    public function testDictionary()
    {
        $this->assertEquals('jarekkozak\tests\dict\Dict1', Dict1::getInstance()->dictionary());
    }

    /**
     * @covers jarekkozak\dict\Dictionary::toString
     */
    public function testToString()
    {
        $a = new Dict1(Dict1::VALUE1);
        $this->assertEquals('key:com.common.value1  value:1  type:integer', ''.$a);
    }

}