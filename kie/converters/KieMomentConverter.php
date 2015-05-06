<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie\converters;

use DateTime;
use Moment\Moment;
use yii\base\Object;

/**
 * Description of KieMomentConverter
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieMomentConverter extends Object implements IKieConverter
{
    public $format = 'Y-m-d H:i:s.u T';
    public function toObject($value)
    {

        $dt =     DateTime::createFromFormat($this->format, $value);
        if($dt == false){
            throw new \InvalidArgumentException();
        }
        return new Moment(DateTime::createFromFormat($this->format, $value)->format(DateTime::ISO8601));
    }

    public function toString($object)
    {
        if($object instanceof Moment) {
            return $object->toUTC()->format($this->format);
        }
        return '';
    }
}