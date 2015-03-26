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
class EnumSelectDecorator
{
    /**
     * Prepare array of values where key is dictionary value
     * @param IEnum $enum
     * @return array
     */
    public static function values(IEnum $enum, IEnumTranslation $trans=null){
        $out = [];
        foreach ($enum->values() as $key => $value) {
            $out[$value] = $trans==NULL?$key:$trans->translate($name,$enum->enumName());
        }
        return $out;
    }

    /**
     * Prepare JSO
     * @param \jarekkozak\dict\IEnum $enum
     * @param \jarekkozak\dict\IEnumTranslation $trans
     * @return type
     */
    public static function jsonValues(IEnum $enum,IEnumTranslation $trans=null){
        $out = [];
        foreach ($enum->values() as $key => $value) {
            $out[] = [
                'id'=> $key,
                'text'=> $trans==NULL?$key:$trans->translate($name,$enum->enumName())
            ];
        }
        return $out;
    }

}