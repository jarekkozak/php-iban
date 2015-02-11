<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jk\outlook;

/**
 * Class for connecting to the exchange server
 *
 * @property string $server - exchange server name only
 * @property string $username - user email adress
 * @property string $password - user password
 * @property string|bool $properties - class implementing IProprties or TRUE
 * to get from global container
 *
 * @author jaroslaw.kozak68@gmail.com
 *
 */
class Outlook extends \yii\base\Object
{
    const SERVER_PROPERTY   = 'exchangeServer';
    const USERNAME_PROPERTY = 'exchangeUsername';
    const PASSWORD_PROPERTY = 'exchangePassword';

    protected $server   = null;
    protected $username = null;
    protected $password = null;
    protected $properties = TRUE;


    /* @var $log \jk\sys\ILog */
    protected $log;
    protected $response;
    protected $info;
    protected $error;


    /**
     * Default constructor to provide connection details
     * @param \jk\sys\IProperties $property
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function init()
    {
        if ($this->properties === TRUE && \Yii::$container->has('jk\sys\IProperties')) {
            $this->setProperties(\Yii::$container->get('jk\sys\IProperties'));
        }
    }

    function setProperties(\jk\sys\IProperties $property)
    {
        if (!$this->username) {
            $this->setUsername($property->getProperty(self::USERNAME_PROPERTY));
        }
        if (!$this->password) {
            $this->setPassword($property->getProperty(self::PASSWORD_PROPERTY));
        }
        if (!$this->server) {
            $this->setServer($property->getProperty(self::SERVER_PROPERTY));
        }
    }

    function getLog()
    {
        return $this->log;
    }

    function setLog($log)
    {
        $this->log = $log;
    }

    function getServer()
    {
        return $this->server;
    }

    function getUsername()
    {
        return $this->username;
    }

    function getPassword()
    {
        return $this->password;
    }

    function setServer($server)
    {
        $this->server = $server;
    }

    function setUsername($username)
    {
        $this->username = $username;
    }

    function setPassword($password)
    {
        $this->password = $password;
    }

    protected function execute()
    {
        $ch             = curl_init('https://'.$this->server.'/ews/services.wsdl');
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username.':'.$this->password);
        $this->response = curl_exec($ch);
        $this->info     = curl_getinfo($ch);
        $this->error    = curl_error($ch);
    }

    /**
     * Authenticate user , returns TRUE if login OK otherwise FALSE
     */
    public function authenticate()
    {
        $this->execute();
        if (is_array($this->info) && isset($this->info['http_code']) && $this->info['http_code']
            == 200) {
            return TRUE;
        }
        return FALSE;
    }
}