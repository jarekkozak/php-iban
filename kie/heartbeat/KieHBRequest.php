<?php

namespace jarekkozak\kie\heartbeat;

use jarekkozak\kie\converters\KieMomentConverter;
use jarekkozak\kie\IKieFactSourceObject;
use yii\base\Object;

/**
 * Example of fact
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieHBRequest extends Object implements IKieFactSourceObject
{
    public $message;
    public $start;
    public $time;

    public function getFactName()
    {
        return 'trimetis.heartbeat.Request';
    }

    public function getIdentifier()
    {
        return '####99999';
    }

    public function getNodes()
    {
        $converter = new KieMomentConverter();
        return ['message',
            'start' => [
                'converter' => $converter,
            ],
            'time' => [
                'converter' => $converter,
            ]
        ];
    }
}