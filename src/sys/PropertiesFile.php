<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jk\sys;

/**
 * Properties class read properties defined in plain text file *.properties.
 * Properties shoulb in pair
 * key=value
 *
 * usage:
 *  $prop = new PropertiesFile([
 *          "envars" => ['HOME', 'PWD'],  //env vars to be used for filename
 *          "filename" => "myfile.properties",
 *  ]);
 * "filename" can be defined as $HOME/file_name where $HOME will be replaces with
 * your actual home directory.
 *
 * @property array $envars array of enviromet variables to be used
 * @property array $filename - property file
 * 
 * @author jarek
 */
class PropertiesFile extends \yii\base\Object implements \jk\sys\IProperties
{
    protected $envars = ['HOME', 'PWD'];
    protected $filename = '';

    protected $values = [];
    protected $enviroment = [];

    public function init()
    {
        parent::init();
        foreach ($this->envars as $key => $value) {
            $this->enviroment['$'.$value] = getenv($value);
        }
        $this->filename = strtr($this->filename, $this->enviroment);
        $this->readFromFile();
    }

    /**
     * Read properties from file
     */
    protected function readFromFile()
    {
        if (@file_exists($this->filename)) {
            $this->values = \yii\helpers\ArrayHelper::merge($this->values,parse_ini_file($this->filename));
        }
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

    function getEnvars()
    {
        return $this->envars;
    }

    function getFilename()
    {
        return $this->filename;
    }

    function setEnvars($envars)
    {
        $this->envars = $envars;
    }

    function setFilename($filename)
    {
        $this->filename = $filename;
    }


}