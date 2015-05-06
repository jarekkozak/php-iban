<?php

namespace jarekkozak\kie;

/**
 * Generic class for parsing response from Kie execution server
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieResponse extends \yii\base\Object {

    /* @var $body SimpleXMLElement */

    public $type;
    public $msg;
    public $data;


    public function setBody(\SimpleXMLElement $body) {
        $this->data = null;
        $json = json_encode($body);
        $data = json_decode($json,TRUE);
        if(!isset($data['@attributes']['type']) || !isset($data['@attributes']['msg'])) {
            return;
        }
        $this->data = $data;
    }

    public function init()
    {
        parent::init();
        if($this->data == null){
            return;
        }
        $this->type = $this->data['@attributes']['type'];
        $this->msg = $this->data['@attributes']['msg'];
    }

    /**
     * If response is success
     * @return boolean
     */
    public function isSuccess(){
        return $this->type == 'SUCCESS';
    }

    /**
     * Get extended message
     * @return type
     */
    public function getMsg(){
        return $this->msg;
    }

    /**
     * Get response SUCCESS or FAILURE
     * @return string
     */
    public function getType(){
        return $this->type;
    }

    public function getData(){
        return $this->data;
    }
}