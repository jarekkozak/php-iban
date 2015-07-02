<?php

namespace jarekkozak\kie;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-05 at 11:28:15.
 */
class KieQueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KieQuery
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new KieQuery;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers jarekkozak\kie\KieQuery::getIdentifier
     * @todo   Implement testGetIdentifier().
     */
    public function testGetIdentifier()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jarekkozak\kie\KieQuery::getName
     * @todo   Implement testGetName().
     */
    public function testGetName()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jarekkozak\kie\KieQuery::setIdentifier
     * @todo   Implement testSetIdentifier().
     */
    public function testSetIdentifier()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jarekkozak\kie\KieQuery::setName
     * @todo   Implement testSetName().
     */
    public function testSetName()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jarekkozak\kie\KieQuery::createNode
     * @todo   Implement testCreateNode().
     */
    public function testCreateNode()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jarekkozak\kie\KieQuery::toXml
     * @todo   Implement testToXml().
     */
    public function testToXml()
    {
        $query = new KieQuery([
            'name'=>'response',
            'identifier'=>'identyfikator'
        ]);
        self::assertEquals('<query out-identifier="identyfikator" name="response"/>',$query->toXml());
    }
}