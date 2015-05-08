<?php

namespace jarekkozak\kie;

use Httpful\Mime;
use Httpful\Request;
use Httpful\Response;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-05-05 at 12:29:44.
 */
class KieClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KieClient
     */
    protected $object;
    protected $property;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new KieClient;

        $this->property = new \jarekkozak\sys\PropertiesFile([
            'filename' => '$HOME/.secret/kiesrv-secret'
        ]);
        if ($this->property->getProperty('kie-server') == NULL) {
            echo 'Property file does not exist:';
            echo 'With content:';
            echo 'kie-server=exchange_address_with_context';
            echo 'kie-user=username or email';
            echo 'kie-password=password';
        }


    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {

    }


    /**
     * Test Client
     */
    public function testContainerInfo()
    {
        $client = new KieClient([
            'serverContext'=>$this->property->getProperty('kie-server'),
            'username'=>$this->property->getProperty('kie-user'),
            'password'=>$this->property->getProperty('kie-password'),
        ]);

        $version = $this->property->getProperty('kie-version');

        $exp = [
          'version' => $version!=null?$version:'6.2.0.Final'
        ];
        $result = $client->getServerInfo();
        $this->assertEquals($exp, $result);
        $this->assertTrue($client->isOk());

    }
}