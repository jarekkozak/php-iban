<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace jarekkozak\kie;

use DOMDocument;
use yii\base\Object;

/**
 * Description of KieProject
 *
 * @author Jarosław Kozak <jaroslaw.kozak68@gmail.com>
 */
class KieProject extends Object
{
    public $container_id;
    public $group_id;
    public $artifact_id;
    public $version = 'LATEST';



    /* @var jarekkozak\kie\KieClient */
    public $client;
    public $response;
//Getters

    function getContainer_id()
    {
        return $this->container_id;
    }

    function getGroup_id()
    {
        return $this->group_id;
    }

    function getArtifact_id()
    {
        return $this->artifact_id;
    }

    function getVersion()
    {
        return $this->version;
    }

    function setContainer_id($container_id)
    {
        $this->container_id = $container_id;
    }

    function setGroup_id($group_id)
    {
        $this->group_id = $group_id;
    }

    function setArtifact_id($artifact_id)
    {
        $this->artifact_id = $artifact_id;
    }

    function setVersion($version)
    {
        $this->version = $version;
    }
    
    function getClient()
    {
        return $this->client;
    }

    function setClient($client)
    {
        $this->client = $client;
    }

//End getters

    public function toXml()
    {
        $document  = new DOMDocument("1.0", "UTF-8");
        $container = $document->createElement('kie-container');
        $document->appendChild($container);

        $container_id = $document->createElement('container-id',
            $this->container_id);
        $container->appendChild($container_id);

        $status = $document->createElement('status');
        $container->appendChild($status);

        $release_id = $document->createElement('release-id');

        $group_id = $document->createElement('group-id', $this->group_id);
        $release_id->appendChild($group_id);

        $artifact_id = $document->createElement('artifact-id',
            $this->artifact_id);
        $release_id->appendChild($artifact_id);

        $version = $document->createElement('version', $this->version);
        $release_id->appendChild($version);

        $container->appendChild($release_id);

        $resolved = $document->createElement('resolved-release-id');
        $container->appendChild($resolved);


        return $document->saveXML();
    }

    public function _url()
    {
        return $this->client->getServerUrl('containers/'.$this->container_id);
        //$this->client->getServerUrl('containers/');
    }

    public function scanProject()
    {
        if ($this->client == null) {
            return FALSE;
        }
        if ($this->client->PUT($this->_url(), $this->toXml()) == false) {
            return false;
        }
        $this->response = $this->client->getKieResponse();
        /* @var $this->response jarekkozak\kie\KieResponse */
        if (!$this->response->isSuccess()) {
            return FALSE;
        }
        $this->info = $this->response->getData();
        return $this->info;
    }

    
}