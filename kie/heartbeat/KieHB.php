<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie\heartbeat;

use jarekkozak\kie\converters\KieMomentConverter;
use jarekkozak\kie\KieBatch;
use jarekkozak\kie\KieContainer;
use jarekkozak\kie\KieFact;
use jarekkozak\kie\KieQuery;
use Moment\Moment;

/**
 * Description of KieHB
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieHB extends KieContainer
{
    public $req;

    public function init()
    {
        parent::init();
        $this->container = 'containers/perdiem';
    }

    /**
     * Calls heartbeat
     * @return boolean
     */
    public function listenHeart()
    {
        $batch     = new KieBatch(['lookup' => 'ksession']);
        $converter = new KieMomentConverter();

        $request          = new KieHBRequest();
        $request->message = 'HeartBeat';
        $request->start   = new Moment();
        $request->time    = new Moment();


        $config    = ['factName' => 'trimetis.perdiem.Request',
            'object' => $request,
            'identifier' => 'hb_request',
            'nodes' => [
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
        $this->req = new KieFact($config);
        $batch->addFact($this->req);
        $batch->addQuery(new KieQuery([
            'name' => 'getResponse',
            'identifier' => 'response'
        ]));
        return $this->execute($batch);
    }

    public function getHeartBeat()
    {
        if (!$this->listenHeart()) {
            return false;
        }

        $response  = new KieHBResponse();
        $reqFact   = new KieFact(['factName' => 'trimetis.perdiem.Response', 'object' => $response,
            'nodes' => [
                'output',
                'responseDate',
            ],
            'identifier' => 'response'
        ]);

        $results = $this->getResults();
        $query = $reqFact->parseQuery($results['result']);
        return $query;
    }
}