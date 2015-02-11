<?php

namespace jarekkozak\helpers;

use kartik\widgets\Alert;

/**
 * helper class for alerts
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class FlashHelper
{

    const MAIN_ALERT_ID = 'main-flash-id';

    const SUCCESS = 'success';
    const ERROR = 'error';
    const WARNING = 'warning';
    const DANGER = 'error';
    const INFO = 'info';
    const PRIMARY = 'primary';
    const DEFAULTA = 'default';
    
    /**
     * @param string $message
     */
    public static function setFlashSuccess($message)
    {
        \Yii::$app->getSession()->setFlash(FlashHelper::SUCCESS, $message);
    }

    public static function hasFlashSuccess()
    {
        return \Yii::$app->getSession()->hasFlash(FlashHelper::SUCCESS);
    }

    /**
     * @param string $message
     */
    public static function setFlashInfo($message)
    {
        \Yii::$app->getSession()->setFlash(FlashHelper::INFO, $message);
    }

    public static function hasFlashInfo()
    {
        return \Yii::$app->getSession()->hasFlash(FlashHelper::INFO);
    }

    /**
     * @param string $message
     */
    public static function setFlashError($message)
    {
        \Yii::$app->getSession()->setFlash(FlashHelper::ERROR, $message);
    }

    public static function hasFlashError()
    {
        return \Yii::$app->getSession()->hasFlash(FlashHelper::ERROR);
    }

    /**
     * @param string $message
     */
    public static function setFlashWarning($message)
    {
        \Yii::$app->getSession()->setFlash(FlashHelper::WARNING, $message);
    }

    public static function hasFlashWarning()
    {
        return \Yii::$app->getSession()->hasFlash(FlashHelper::WARNING);
    }

    /**
     * @param string $message
     */
    public static function setFlashDanger($message)
    {
        \Yii::$app->getSession()->setFlash(FlashHelper::DANGER, $message);
    }

    /**
     * Sprawdzenie występowania komunikatu
     */
    public static function hasFlashDanger()
    {
        return \Yii::$app->getSession()->hasFlash(FlashHelper::DANGER);
    }

    public static function setFlashPrimary($message)
    {
        \Yii::$app->getSession()->setFlash(FlashHelper::PRIMARY, $message);
    }

    /**
     * Sprawdzenie występowania komunikatu
     */
    public static function hasFlashPrimary()
    {
        return \Yii::$app->getSession()->hasFlash(FlashHelper::PRIMARY);
    }
    
    public static function setFlash($message)
    {
        \Yii::$app->getSession()->setFlash(FlashHelper::DEFAULTA, $message);
    }

    /**
     * Sprawdzenie występowania komunikatu
     */
    public static function hasFlashDefault()
    {
        return \Yii::$app->getSession()->hasFlash(FlashHelper::DEFAULTA);
    }

}
