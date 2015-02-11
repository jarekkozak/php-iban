<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jk\sys;

/**
 *
 * @property array $values - pair of values 
 *
 * @author jaroslaw.kozak68@gmail.com
 */
class Properties extends \yii\base\Object implements \jk\sys\IProperties
{
    protected $values;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function setValues($_values)
    {
        $this->values = $_values;
    }

    /**
     * Returns property value
     * @param type $name
     * @param type $default
     * @return type
     */
    public function getProperty($name, $default = NULL)
    {
        if (isset($this->values[$name])) {
            return $this->values[$name];
        }
        return $default;
    }

}