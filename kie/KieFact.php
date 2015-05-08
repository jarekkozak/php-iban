<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie;

use DOMDocument;
use DOMElement;
use jarekkozak\kie\converters\IKieConverter;
use jarekkozak\kie\converters\KieMomentConverter;
use Moment\Moment;
use yii\base\Object;

/**
 * Description of Fact
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieFact extends Object
{
    protected $identifier;
    protected $factName = null;   // Fact name e.g. org.demo.Message
    protected $nodes = null;      // List of nodes to be sent
    protected $object = null;


    public function __construct($object, $config = array())
    {
        $this->object = $object;
        if($object instanceof IKieFactSourceObject){
            $this->factName = $object->getFactName();
            $this->identifier = $object->getIdentifier();
            $this->nodes = $object->getNodes();
        }
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
        if ($this->identifier == null) {
            $this->identifier = uniqid();
        }
    }

    function getIdentifier()
    {
        return $this->identifier;
    }

    function setIdentifier($handle)
    {
        $this->identifier = $handle;
    }

    function getFactName()
    {
        return $this->factName;
    }

    function getNodes()
    {
        return $this->nodes;
    }

    function setFactName($factName)
    {
        $this->factName = $factName;
    }

    function setNodes($nodes)
    {
        $this->nodes = $nodes;
    }

    public function setObject(Object $objec)
    {
        $this->object = $objec;
    }

    public function getObject()
    {
        return $this->object;
    }

    /**
     * Returns default converters if type of object is recognized
     * @return IKieConverter
     */
    public function getDefaultConverter($object)
    {
        if ($object instanceof Moment) {
            return new KieMomentConverter();
        }
        return null;
    }

    /**
     *
     * @param DOMDocument $document
     * @param string|array $nodeName
     * @return DOMElement boolean
     */
    protected function createElement(DOMDocument $document, $attrName, $config)
    {

        if (is_string($config)) {
            $attrName = $config;
        }

        $cv = null;
        $nm = $attrName;

        if (is_array($config)) {
            if (isset($config['out']) && $config['out'] == false) {
                return false;
            }
            if (isset($config['name'])) {
                $nm = $config['name'];
            }
            if (isset($config['converter']) && $config['converter'] instanceof IKieConverter) {
                $cv = $config['converter'];
            }
        }

        if (!$this->object->canGetProperty($attrName)) {
            return false;
        }
        $value = $this->object->{$attrName};
        if ($cv == null) {
            $cv = $this->getDefaultConverter($value);
        }
        return $document->createElement($nm,
                $cv == null ? ''.$value : $cv->toString($value));
    }

    /**
     *
     * @param DOMDocument $document
     * @return type
     */
    public function createNode(DOMDocument $document)
    {
        if ($this->object == null) {
            return null;
        }
        $fact = $document->createElement($this->factName);
        foreach ($this->nodes as $key => $value) {
            if (($element = $this->createElement($document, $key, $value)) !== false) {
                $fact->appendChild($element);
            }
        }
        return $fact;
    }

    /**
     * Dumps to XML only specific
     * @return type
     */
    public function toXml()
    {
        $document = new DOMDocument("1.0", "UTF-8");
        $fact     = $this->createNode($document);
        $document->appendChild($fact);
        return $document->saveXML($fact);
    }

    /**
     * Parse result into currenct object 
     * @param array $result
     */
    public function parseResult($result)
    {
        $properties = json_decode(json_encode($this->object), true);
        foreach ($properties as $property => $value) {
            // if key is in array
            if(in_array($property, $this->nodes) && isset($result[$property])){
                $converter = $this->getDefaultConverter($this->object->{$property});
                $this->object->{$property} = $converter==null?$result[$property]:$converter->toObject($result[$property]);
            }
            // field is defined in array
            if(array_key_exists($property,$this->nodes)){
                $config = $this->nodes[$property];
                if(isset($config['in']) && $config['in']==false) {
                    continue; // In not allowed
                }
                $name = $property;
                if(isset($config['name'])){
                    $name = $config['name'];
                }
                if(!isset($result[$name])){
                    continue; // Not exist in result
                }
                $converter = $this->getDefaultConverter($this->object->{$property});
                if(isset($config['converter'])){
                    $converter = $config['converter'];
                }
                $this->object->{$property} = $converter==null?$result[$name]:$converter->toObject($result[$name]);
            }

        }
        return true;
    }

    /**
     * 
     * @param array $results
     */
    public function updateFact(array $results)
    {
        foreach ($results as $key => $value) {
            if (isset($value['@attributes']['identifier']) && $value['@attributes']['identifier']
                == $this->identifier && isset($value[$this->factName])) {
                if($this->parseResult($value[$this->factName])){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Parse query 
     * @param array $result
     * @return array
     */
    public function parseQuery(array $results)
    {
        $query = [];
        foreach ($results as $key => $value) {
            if (isset($value['@attributes']['identifier']) && $value['@attributes']['identifier']
                == $this->identifier && isset($value['query-results']['row'])) {
                foreach ($value['query-results']['row'] as $fact) {
                    if(!isset($fact[$this->factName])){
                        continue;
                    }
                    $copy = clone $this->object; // save template
                    if($this->parseResult($fact[$this->factName])){
                        $query[] = $this->object;
                    }
                    $this->object = $copy; //restore empty object
                }


            }
        }
        return $query;
    }
}