<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\dict;

/**
 * Description of EnumMap
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class DictionaryJsonDecorator implements IDictionaryDecorator
{

    protected $translator;

    public function __construct(IDictionaryTranslation $translator=null)
    {
        $this->translator = $translator;
    }

    protected function translate(IDictionary $obj){
        return $this->translator==null?$obj->key():$this->translator->translate($obj);
    }
    /**
     * Prepare json encoded array of values where key is dictionary value
     * @param array $values - array of IDictionary entities
     * @return array
     */
    public function values(array $values)
    {
        $ret = [];
        foreach ($values as $key => $obj) {
            if ($obj instanceof IDictionary) {
                $ret[]= [
                    'id'=> $obj->value(),
                    'text'=>$this->translate($obj)
                ];
            }
        }
        return \yii\helpers\Json::encode($ret);
    }
}