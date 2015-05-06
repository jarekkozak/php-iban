<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie;

use DOMDocument;

/**
 * Description of KieServer
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieBatch extends \yii\base\Object
{

    public $lookup;

    protected $_facts = [];
    protected $_queries = [];


    function getLookup()
    {
        return $this->lookup;
    }

    function setLookup($lookup)
    {
        $this->lookup = $lookup;
    }



    public function addFact(KieFact $fact){
        $this->_facts[] = $fact;
    }


    public function addQuery(KieQuery $query){
        $this->_queries[] = $query;
    }

    /**
     * Creates batch for rules call
     * @return DOMDocument
     */
    public function createBatch(){
        $xml = new DOMDocument("1.0", "UTF-8");
        $batch = $xml->createElement("batch-execution");
        $xml->appendChild($batch);
        //Add lookup session to batch
        if($this->lookup){
            $batch->setAttribute('lookup', $this->lookup);
        }
        //Add facts to batch
        if(!empty($this->_facts)){
            foreach ($this->_facts as $fact) {
                $insert = $xml->createElement("insert");
                $insert->setAttribute("out-identifier", $fact->getIdentifier());
                $insert->appendChild($fact->createNode($xml));
                $batch->appendChild($insert);
            }
        }
        $fire = $xml->createElement("fire-all-rules");
        $batch->appendChild($fire);
        //Add queries to batch
        if(!empty($this->_queries)){
            foreach ($this->_queries as $query) {
                $batch->appendChild($query->createNode($xml));
            }
        }
        return $xml;
    }

    /**
     * Prepares xml file
     * @return type
     */
    public function toXml()
    {
        return $this->createBatch()->saveXML();
    }
}