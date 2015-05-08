<?php

namespace jarekkozak\kie\heartbeat;

use jarekkozak\kie\IKieFactSourceObject;
use yii\base\Object;

/**
 * Example of fact
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieHBResponse extends Object implements IKieFactSourceObject
{
    public $output;
    public $responseDate;

    public function getFactName()
    {
        return 'trimetis.heartbeat.Response';
    }

    public function getIdentifier()
    {
        return 'response-id';
    }

    public function getNodes()
    {
        return [
            'output',
            'responseDate',
        ];
    }
}