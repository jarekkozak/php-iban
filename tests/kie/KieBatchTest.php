<?php

namespace jarekkozak\kie;

use jarekkozak\kie\converters\KieMomentConverter;
use jarekkozak\kie\heartbeat\KieHBRequest;
use Moment\Moment;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-04-21 at 21:12:01.
 */
class KieBatchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KieServer
     */
    protected $object;
    protected $property;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->property = new \jarekkozak\sys\PropertiesFile([
            'filename' => '$HOME/.secret/kiesrv-secret'
        ]);
        if ($this->property->getProperty('kie-server') == NULL) {
            echo 'Property file does not exist:';
            echo 'With content:';
            echo 'kie-server=exchange_address_with_context';
            echo 'kie-user=username or email';
            echo 'kie-password=password';
        }
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }

    /**
     * @covers jarekkozak\helpers\KieServer::call
     * @todo   Implement testCall().
     */
    public function testCall()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers jarekkozak\helpers\KieServer::toXml
     */
    public function testToXml()
    {
        $batch = new KieBatch();
        self::assertEquals('<?xml version="1.0" encoding="UTF-8"?>'."\n"
        .'<batch-execution><fire-all-rules/></batch-execution>'."\n",$batch->toXml());
    }

    /**
     * @covers jarekkozak\helpers\KieServer::toXml
     */
    public function testToXml1()
    {
        $batch = new KieBatch(['lookup'=>'ksession']);
        self::assertEquals('<?xml version="1.0" encoding="UTF-8"?>'."\n"
        .'<batch-execution lookup="ksession"><fire-all-rules/></batch-execution>'."\n",$batch->toXml());
    }

    /**
     * @covers jarekkozak\helpers\KieServer::toXml
     */
    public function testToXml2()
    {
        $batch = new KieBatch(['lookup'=>'ksession']);


        $converter = new KieMomentConverter();
        $config = ['factName' => 'org.jarekkozak.Request','nodes' => [
                'message',
                'start' => [
                    'name' => 'start',
                    'converter' => $converter,
                ],
                'time' => [
                    'converter' => $converter,
                ]
            ],
        ];

        $request          = new KieHBRequest();
        $request->message = 'Test message';
        $request->start   = new Moment('2015-01-01T12:34:00');
        $request->time    = new Moment('2015-01-02T12:34:00');

        //$config['object']=$request;
        $config['identifier']='req1';

        $reqFact1 = new KieFact($request,$config);

        $request          = new KieHBRequest();
        $request->message = 'Test message2';
        $request->start   = new Moment('2015-02-01T12:34:00');
        $request->time    = new Moment('2015-02-02T12:34:00');

        //$config['object']=$request;
        $config['identifier']='req2';

        $reqFact2 = new KieFact($request,$config);

        $batch->addFact($reqFact1);
        $batch->addFact($reqFact2);

        $batch->addQuery(new KieQuery([
            'name'=>'response',
            'identifier'=>'identyfikator'
        ]));

        self::assertEquals('<?xml version="1.0" encoding="UTF-8"?>'."\n"
        .'<batch-execution lookup="ksession"><insert out-identifier="req1"><org.jarekkozak.Request><message>Test message</message><start>2015-01-01 12:34:00.000000 UTC</start><time>2015-01-02 12:34:00.000000 UTC</time></org.jarekkozak.Request></insert><insert out-identifier="req2"><org.jarekkozak.Request><message>Test message2</message><start>2015-02-01 12:34:00.000000 UTC</start><time>2015-02-02 12:34:00.000000 UTC</time></org.jarekkozak.Request></insert><fire-all-rules/><query out-identifier="identyfikator" name="response"/></batch-execution>'."\n",$batch->toXml());
    }
}