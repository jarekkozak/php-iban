<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie;

/**
 * Description of KieContainer
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieContainer extends \yii\base\Object
{

    /* @var $client jarekkozak\kie\KieClient */
    protected $client;

    protected $container;

    protected $containers_context = 'containers';

    /* @var jarekkozak\kie\KieResponse */
    protected $response;
    protected $type;
    protected $msg;
    protected $info;

    /* @var $kieProject KieProject */
    protected $kieProject;

    function getContainers_context()
    {
        return $this->containers_context;
    }

    function getKieProject()
    {
        return $this->kieProject;
    }

    function setContainers_context($containers_context)
    {
        $this->containers_context = $containers_context;
    }

    function setKieProject($kieProject)
    {
        $this->kieProject = $kieProject;
    }

    function getClient()
    {
        return $this->client;
    }

    function getContainer()
    {
        return $this->container;
    }

    function setClient($client)
    {
        $this->client = $client;
    }

    function setContainer($container)
    {
        $this->container = $container;
    }

    function getResponse()
    {
        return $this->response;
    }

    function getType()
    {
        return $this->type;
    }

    function getMsg()
    {
        return $this->msg;
    }

    function getInfo()
    {
        return $this->info;
    }

    protected function _url(){
        return $this->client->getServerUrl($this->containers_context.'/'.$this->container);
    }

    /**
     * Stops and dispose container
     */
    public function stopContainer(){
        if($this->kieProject){
            $this->kieProject->setClient($this->client);
            return $this->kieProject->disposeProject();
        }
        return false;
    }

    /**
     * Start container  with supplied project
     */
    public function startContainer(){
        if($this->getContainerInfo()){
            return true;
        }
        if($this->kieProject!=null){
            $this->kieProject->setClient($this->client);
            return $this->kieProject->scanProject();
        }
        return false;
    }

    /**
     * Gets container info 
     * @return boolean
     */
    public function getContainerInfo(){
        if($this->client->GET($this->_url())==false){
            return false;
        }
        $this->response = $this->client->getKieResponse();
        /* @var $this->response jarekkozak\kie\KieResponse */
        if(!$this->response->isSuccess()){
            return FALSE;
        }
        $this->info = $this->response->getData()['kie-container'];
        return $this->info;
    }

    /**
     * Sends facts to rule service for execution
     * @param \jarekkozak\kie\KieBatch $batch
     * @return boolean
     */
    public function execute(KieBatch $batch){
        if($this->client->POST($this->_url(),$batch->toXml())==false){
            return FALSE;
        };
        $this->response = $this->client->getKieResponse();
        return $this->response->isSuccess();
    }

    /**
     * Gets rule execution results
     * @return boolean
     */
    public function getResults(){
        if(!$this->response->isSuccess()){
            return FALSE;
        }
        $results = simplexml_load_string($this->response->getData()['results']);
        return json_decode(json_encode($results),TRUE);
    }

}