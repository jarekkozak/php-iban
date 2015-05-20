<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie;

/**
 * Description of XML
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class XML
{

    public function parse($file)
    {
        $body = simplexml_load_string(file_get_contents($file));
        $result = $this->xml2array($body->asXML());
    }

    function xml2array($fname)
    {
        $sxi = new \SimpleXmlIterator($fname, null, true);
        return sxiToArray($sxi);
    }

    function sxiToArray($sxi)
    {
        $a = array();
        for ($sxi->rewind(); $sxi->valid(); $sxi->next()) {
            if (!array_key_exists($sxi->key(), $a)) {
                $a[$sxi->key()] = array();
            }
            if ($sxi->hasChildren()) {
                $a[$sxi->key()][] = sxiToArray($sxi->current());
            } else {
                $a[$sxi->key()][] = strval($sxi->current());
            }
        }
        return $a;
    }
}