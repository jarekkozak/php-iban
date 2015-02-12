<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jk\util;

use common\models\SkillLevelSearch;
use DateTime;
use yii\base\Object;
use yii\helpers\ArrayHelper;

/**
 * SkillsHelper provides methods for values list generation
 *
 * @author Jaroslaw Kozak <jaroslaw.kozak68@gmail.com>
 */
class SkillsHelper extends Object
{

    public static function getYearsList($countdown = 20)
    {
        $date  = new DateTime();
        $i     = (integer) $date->format('Y');
        $stop  = $i - $countdown;
        $years = [];
        do {
            $years["$i"] = $i;
            $i--;
        } while ($i > $stop);
        return $years;
    }

    public static function getDurationList($stop = 21)
    {
        $i        = 0.00;
        $duration = [];
        do {
            $duration["$i"] = $i;
            $i += 0.50;
        } while ($i < $stop);
        return $duration;
    }

    public static function getLevels()
    {
        $searchLevelsModel = new SkillLevelSearch();
        return ArrayHelper::map($searchLevelsModel->getLevelList()->all(), 'id',
                'name');
    }
}