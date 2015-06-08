<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie;

use Exception;
use Httpful\Request;
use Httpful\Response;
use yii\base\Object;

/**
 * Description of KieClient
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieClient extends Object
{
    public $serverContext;
    public $username;
    public $password;

    /* @var $response Response */
    protected $response;

    const SERVER_PATH = '/services/rest/server';

    /**
     * GET command
     * @return bool true if ok 
     */
    public function GET($url)
    {
        try {
            $this->response = Request::get($url)
                ->authenticateWith($this->username, $this->password)
                ->expectsType('xml')
                ->send();
        } catch (Exception $exc) {
            \Yii::error($exc->getMessage()."\n".$exc->getTraceAsString());
            return false;
        }

        if ($this->isOk()) {
            return true;
        }
        return false;
    }

    /**
     * PUT command
     * @return bool true if ok
     */
    public function PUT($url, $data)
    {
        try {
            $this->response = Request::put($url, $data, 'xml')
                ->authenticateWith($this->username, $this->password)
                ->expectsType('xml')
                ->send();
        } catch (Exception $ex) {
            \Yii::error($exc->getMessage()."\n".$exc->getTraceAsString());
            return false;
        }
        if ($this->isOk()) {
            return true;
        }
        return false;
    }

    /**
     * PUT command
     * @return bool true if ok
     */
    public function DELETE($url)
    {
        try {
            $this->response = Request::delete($url)
                ->authenticateWith($this->username, $this->password)
                ->expectsType('xml')
                ->send();
        } catch (Exception $ex) {
            \Yii::error($exc->getMessage()."\n".$exc->getTraceAsString());
            return false;
        }
        if ($this->isOk()) {
            return true;
        }
        return false;
    }

    /**
     * POST command
     * @return bool true if ok
     */
    public function POST($url, $data)
    {
        try{
        $this->response = Request::post($url, $data, 'xml')
            ->authenticateWith($this->username, $this->password)
            ->expectsType('xml')
            ->send();
        } catch (Exception $ex) {
            \Yii::error($exc->getMessage()."\n".$exc->getTraceAsString());
            return false;
        }
        if ($this->isOk()) {
            return true;
        }
        return false;
    }

    /**
     * Gets server url + add server path if necessary
     * @param string $path
     * @return string
     */
    public function getServerUrl($path = null)
    {
        $url = $this->serverContext.self::SERVER_PATH;
        if ($path !== null) {
            $url .= '/'.$path;
        }
        return $url;
    }

    /**
     * Checks if call was succesful
     * @return type
     */
    public function isOk()
    {
        return $this->response != null && !$this->response->hasErrors();
    }

    /**
     * Gets server info
     * @return boolean|array FALSE in case of error array with data
     */
    public function getServerInfo()
    {
        $this->GET($this->getServerUrl());
        if (!$this->isOk()) {
            return FALSE;
        }
        $result = $this->getKieResponse();
        if (!$result->isSuccess()) {
            return FALSE;
        }
        return $result->getData()['kie-server-info'];
    }

    public function getKieResponse()
    {
        \Yii::trace("REST Response:".$this->response);
        if ($this->response!=null && $this->response->body!=null) {
            \Yii::trace("REST Response body:".$this->response->body);
            return new KieResponse(['body' => $this->response->body]);
        }
        return FALSE;
    }
}