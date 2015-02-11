<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jk\sys;

/**
 *
 * Reads properties key->valuefrom database
 * usage:
 *  $prop = new PropertiesFile($connection, [
 *          "sql" => "any sql to read pair values"
 *  ]);
 *
 * or
 *  $prop = \Yii::$container->get("jk\sys\PropertiesDb",[
 *              "sql" => "any sql to read pair values"
 * ]);
 *
 * sql is not mandatory, default query will be used
 *  public $sql = 'select name, property from {{%Properties}}';
 * 
 * @property string $sql Description
 * @property array $values array of properties key=>value
 *
 * @author jaroslaw.kozak68@gmail.com
 */
class PropertiesDb extends \yii\base\Object implements \jk\sys\IProperties
{
    protected $sql = 'select name, property from {{%Properties}}';
    protected $values = [];

    public function __construct(\yii\db\Connection $db, $config = array())
    {
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    /**
     * Returns value of the property
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

    function getSql()
    {
        return $this->sql;
    }

    function getValues()
    {
        return $this->values;
    }

    function setSql($sql)
    {
        $this->sql = $sql;
    }

    function setValues($values)
    {
        $this->values = $values;
    }


}