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
class DictionarySelectDecorator implements IDictionaryDecorator
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
     * Prepare array of values where key is dictionary value
     * @param IEnum $enum
     * @return array
     */
    public function values(array $values)
    {
        $ret = [];
        foreach ($values as $key => $obj) {
            if ($obj instanceof IDictionary) {
                $ret[$obj->value()]= $this->translate($obj);
            }
        }
        return $ret;
    }
}