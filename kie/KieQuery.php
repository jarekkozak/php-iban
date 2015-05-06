<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie;

use DOMDocument;
use yii\base\Object;

/**
 * Description of KieQuery
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieQuery extends \yii\base\Object
{
    protected $identifier;
    protected $name;
    
    function getIdentifier()
    {
        return $this->identifier;
    }

    function getName()
    {
        return $this->name;
    }

    function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    public function createNode(DOMDocument$document){
        $query =  $document->createElement('query');
        $query->setAttribute('out-identifier', $this->identifier);
        $query->setAttribute('name', $this->name);
        return $query;
    }

    public function toXml()
    {
        $document = new DOMDocument("1.0", "UTF-8");
        $fact     = $this->createNode($document);
        $document->appendChild($fact);
        return $document->saveXML($fact);
    }

}