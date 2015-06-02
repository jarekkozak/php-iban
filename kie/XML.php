<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie;

/**
 * XML parsing class with xstream object reference support.
 *
 * XML is converted inti table, node attributes are stored in "@attributes" key
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class XML
{

    /**
     * Parse xml file
     * @param string $file filename
     * @return array
     */
    public function parseFile($file){
        return $this->parse(file_get_contents($file));
    }

    /**
     * Parse xml string
     * @param string $xml
     * @return array
     */
    public function parse($xml)
    {
        $source = simplexml_load_string($xml);
        return $this->SimpleXML2ArrayWithCDATASupport($source);
    }

    /**
     * Converts to array xml object
     * @param \SimpleXMLElement $xml
     * @return array
     */
    public function toArray(\SimpleXMLElement $xml){
        return $this->SimpleXML2ArrayWithCDATASupport($xml);
    }

    /**
     * Walk through xml object, resolves references and convert it inti tables.
     * @param mixed $xml
     * @return array|string
     */
    protected function SimpleXML2ArrayWithCDATASupport($xml)
    {
        if(is_string($xml)){
            return $xml;
        }
        
        $array = (array) $xml;
        if (count($array) == 0) {
            $array = (string) $xml;
        }
        if (is_array($array)) {
            //recursive Parser
            foreach ($array as $key => $value) {
                if (is_object($value)) {
                    if (strpos(get_class($value), "SimpleXML") !== false) {
                        $object = $value;
                        if(isset($value->attributes()['reference'])){
                            $path   = (string) $value->attributes()['reference'];
                            $result = $value->xpath($path);
                            if(count($result)>0){
                                $object = $result[0];
                            }
                        }
                        $array[$key] = $this->SimpleXML2ArrayWithCDATASupport($object);
                    }
                } else {
                    $array[$key] = $this->SimpleXML2ArrayWithCDATASupport($value);
                }
            }
        }
        return $array;
    }

}