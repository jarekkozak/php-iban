<?php

namespace jarekkozak\kie;

use jarekkozak\kie\converters\KieMomentConverter;
use jarekkozak\kie\heartbeat\KieHBRequest;
use jarekkozak\kie\KieRequest;
use Moment\Moment;
use PHPUnit_Framework_TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-05 at 07:30:51.
 */
class KieFactTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var KieFact
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
     * @covers KieFact::setObject
     */
    public function testSetObject()
    {

        $request          = new KieHBRequest();
        $request->message = 'Test message';
        $request->start   = new Moment('2015-01-01T12:34:00');
        $request->time    = new Moment('2015-01-02T12:34:00');

        $converter = new KieMomentConverter();

        $reqFact = new KieFact($request,
            ['factName' => 'org.jarekkozak.Request',
            'nodes' => [
                'message',
                'start' => [
                    'name' => 'startAA',
                    'converter' => $converter,
                    'in' => true,
                    'out' => true,
                ],
                'time' => [
                    'converter' => $converter,
                ]
            ],
            'identifier' => 'req1'
        ]);

        $xml = $reqFact->toXml();
        $this->assertEquals('<org.jarekkozak.Request><message>Test message</message><startAA>2015-01-01 12:34:00.000000 UTC</startAA><time>2015-01-02 12:34:00.000000 UTC</time></org.jarekkozak.Request>',
            $xml);
        $this->assertEquals('req1', $reqFact->getIdentifier());
    }

    /**
     * @covers KieFact::setObject
     */
    public function testSetObject3()
    {

        $request          = new KieHBRequest();
        $request->message = 'Test message';
        $request->start   = new Moment('2015-01-01T12:34:00');
        $request->time    = new Moment('2015-01-02T12:34:00');

        $converter = new KieMomentConverter();

        $reqFact = new KieFact($request,
            ['factName' => 'org.jarekkozak.Request',
            'nodes' => [
                'message',
                'start' => [
                    'name' => 'startAA',
                    'converter' => $converter,
                    'in' => true,
                    'out' => false,
                ],
                'time' => [
                    'converter' => $converter,
                ]
            ],
            'identifier' => 'req1'
        ]);

        $xml = $reqFact->toXml();
        $this->assertEquals('<org.jarekkozak.Request><message>Test message</message><time>2015-01-02 12:34:00.000000 UTC</time></org.jarekkozak.Request>',
            $xml);
        $this->assertEquals('req1', $reqFact->getIdentifier());
    }

    /**
     * @covers KieFact::setObject
     */
    public function testSetObject1()
    {

        $request          = new KieHBRequest();
        $request->message = 'Test message';
        $request->start   = new Moment('2015-01-01T12:34:00');
        $request->time    = new Moment('2015-01-02T12:34:00');

        $converter = new KieMomentConverter();

        $reqFact = new KieFact(null,
            ['factName' => 'org.jarekkozak.Request', 'object' => $request,
            'nodes' => [
                'message',
                'start',
                'time'
            ]
        ]);

        $xml = $reqFact->toXml();
        $this->assertEquals('<org.jarekkozak.Request><message>Test message</message><start>2015-01-01 12:34:00.000000 UTC</start><time>2015-01-02 12:34:00.000000 UTC</time></org.jarekkozak.Request>',
            $xml);

        $this->assertEquals(13, strlen($reqFact->getIdentifier()));
    }

    /**
     * @covers KieFact::updateFact
     */
    public function testUpdateFact()
    {
        //Poszukiwanie z query, podajemy fact pola do wypełnienia, jesli puste to próbujemy wypełnić wszystkie
        //Dla faktu już zdefiniowanego robimy update, poszukujemy w resultatach identyfikatora i robimy wsteczny update pól
        $request          = new KieHBRequest();
        $request->message = 'Old message';
        $request->start   = new Moment('1970-01-01T12:34:00');
        $request->time    = new Moment('1970-01-02T12:34:00');
        $converter        = new KieMomentConverter();
        $reqFact          = new KieFact(null,
            ['factName' => 'trimetis.perdiem.Request', 'object' => $request,
            'nodes' => [
                'message',
                'start' => [
                    'converter' => $converter,
                    'in' => true,
                    'out' => true,
                ],
                'time' => [
                    'converter' => $converter,
                ]
            ],
            'identifier' => 'hb_request'
        ]);

        $reqFact->updateFact($this->preparedata()['result']);

        /* @var KieHBRequest */
        $object = $reqFact->getObject();
        $this->assertEquals('HeartBeat', $object->message);
        $this->assertEquals('2015-05-06T09:56:37+0000', $object->start->format());
        $this->assertEquals('2015-05-06T09:56:37+0000', $object->time->format());
    }

    /**
     * @covers KieFact::updateFact
     */
    public function testUpdateFact1()
    {
        //Poszukiwanie z query, podajemy fact pola do wypełnienia, jesli puste to próbujemy wypełnić wszystkie
        //Dla faktu już zdefiniowanego robimy update, poszukujemy w resultatach identyfikatora i robimy wsteczny update pól
        $request          = new KieHBRequest();
        $request->message = 'Old message';
        $request->start   = new Moment('1970-01-01T12:34:00');
        $request->time    = new Moment('1970-01-02T12:34:00');
        $converter        = new KieMomentConverter();
        $reqFact          = new KieFact($request,
            ['factName' => 'trimetis.perdiem.Request',
            'nodes' => [
                'message',
                'start' => [
                    'converter' => $converter,
                    'in' => false,
                    'out' => true,
                ],
                'time' => [
                    'converter' => $converter,
                ]
            ],
            'identifier' => 'hb_request'
        ]);

        $reqFact->updateFact($this->preparedata()['result']);

        /* @var KieHBRequest */
        $object = $reqFact->getObject();
        $this->assertEquals('HeartBeat', $object->message);
        $this->assertEquals('1970-01-01T12:34:00+0000', $object->start->format());
        $this->assertEquals('2015-05-06T09:56:37+0000', $object->time->format());
    }

    /**
     * @covers KieFact::parseQuery
     */
    public function testParseQuery()
    {
        //Poszukiwanie z query, podajemy fact pola do wypełnienia, jesli puste to próbujemy wypełnić wszystkie
        //Dla faktu już zdefiniowanego robimy update, poszukujemy w resultatach identyfikatora i robimy wsteczny update pól
        $response  = new heartbeat\KieHBResponse();
        $converter = new KieMomentConverter();
        $reqFact   = new KieFact(null,
            ['factName' => 'trimetis.perdiem.Response', 'object' => $response,
            'nodes' => [
                'output',
                'responseDate' => [
                    'converter' => $converter,
                    'in' => true,
                    'out' => true,
                ],
            ],
            'identifier' => 'response'
        ]);

        $query = $reqFact->parseQuery($this->preparedata()['result']);
        $r1    = $query[0];
        $this->assertEquals('HeartBeat', $r1->output);
        $this->assertEquals('2015-05-06T09:56:37+0000',
            $r1->responseDate->format());
        $r1    = $query[1];
        $this->assertEquals('I\'m alive', $r1->output);
        $this->assertEquals('2015-05-06T09:56:37+0000',
            $r1->responseDate->format());
    }
    /**
     * @covers KieFact::parseQuery
     */
    public function testParseQueryOneResult()
    {
        //Poszukiwanie z query, podajemy fact pola do wypełnienia, jesli puste to próbujemy wypełnić wszystkie
        //Dla faktu już zdefiniowanego robimy update, poszukujemy w resultatach identyfikatora i robimy wsteczny update pól
        $response  = new heartbeat\KieHBResponse();
        $converter = new KieMomentConverter();
        $reqFact   = new KieFact(null,
            ['factName' => 'trimetis.perdiem.Response', 'object' => $response,
            'nodes' => [
                'output',
                'responseDate' => [
                    'converter' => $converter,
                    'in' => true,
                    'out' => true,
                ],
            ],
            'identifier' => 'response'
        ]);

        $query = $reqFact->parseQuery($this->preparedata1()['result']);
        $this->assertCount(1,$query);
        $r1    = $query[0];
        $this->assertEquals('HeartBeat', $r1->output);
        $this->assertEquals('2015-05-06T09:56:37+0000',
            $r1->responseDate->format());
    }

    /**
     * Prepares data for  two query results
     * @return type
     */
    public function preparedata()
    {
        return [
            'result' => [
                [
                    '@attributes' => [
                        'identifier' => 'response'
                    ],
                    'query-results' => [
                        'identifiers' => [
                            'identifier' => 'r'
                        ],
                        'row' => [
                            [
                                'trimetis.perdiem.Response' => [
                                    'output' => 'HeartBeat',
                                    'responseDate' => '2015-05-06 09:56:37.0 UTC'
                                ],
                                'fact-handle' => [
                                    '@attributes' => [
                                        'external-form' => '0:2:1717024092:1717024092:2:DEFAULT:NON_TRAIT'
                                    ]
                                ]
                            ],
                            [
                                'trimetis.perdiem.Response' => [
                                    'output' => 'I\'m alive',
                                    'responseDate' => '2015-05-06 09:56:37.475 UTC'
                                ],
                                'fact-handle' => [
                                    '@attributes' => [
                                        'external-form' => '0:3:138665858:138665858:3:DEFAULT:NON_TRAIT'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    '@attributes' => [
                        'identifier' => 'hb_request'
                    ],
                    'trimetis.perdiem.Request' => [
                        'message' => 'HeartBeat',
                        'time' => '2015-05-06 09:56:37.0 UTC',
                        'start' => '2015-05-06 09:56:37.0 UTC'
                    ]
                ]
            ],
            'fact-handle' => [
                '@attributes' => [
                    'identifier' => 'hb_request',
                    'external-form' => '0:1:344450851:344450851:1:DEFAULT:NON_TRAIT'
                ]
            ]
        ];
    }

    /**
     * Prepares data for query result - one result
     * @return type
     */
    public function preparedata1()
    {
        return [
            'result' => [
                [
                    '@attributes' => [
                        'identifier' => 'response'
                    ],
                    'query-results' => [
                        'identifiers' => [
                            'identifier' => 'r'
                        ],
                        'row' => [
                            'trimetis.perdiem.Response' => [
                                'output' => 'HeartBeat',
                                'responseDate' => '2015-05-06 09:56:37.0 UTC'
                            ],
                            'fact-handle' => [
                                '@attributes' => [
                                    'external-form' => '0:2:1717024092:1717024092:2:DEFAULT:NON_TRAIT'
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    '@attributes' => [
                        'identifier' => 'hb_request'
                    ],
                    'trimetis.perdiem.Request' => [
                        'message' => 'HeartBeat',
                        'time' => '2015-05-06 09:56:37.0 UTC',
                        'start' => '2015-05-06 09:56:37.0 UTC'
                    ]
                ]
            ],
            'fact-handle' => [
                '@attributes' => [
                    'identifier' => 'hb_request',
                    'external-form' => '0:1:344450851:344450851:1:DEFAULT:NON_TRAIT'
                ]
            ]
        ];
    }
}