<?php

namespace jarekkozak\outlook;

/**
 * Test class for outlook connection. In order to run test you have to define
 * property file in $HOME/.secret/skills-secret with attributes
 * server=xxxxxx
 * username=XXXXXXX
 * password=XXXXXX
 */
// \PHPUnit_Framework_TestCase
class OutlookTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Outlook
     */
    protected $property;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->property = new \jarekkozak\sys\PropertiesFile([
            'filename' => '$HOME/.secret/skills-secret'
        ]);

        if ($this->property->getProperty('exchangeServer') == NULL) {
            echo 'Property file does not exist:';
            echo 'With content:';
            echo 'exchangeServer=exchange_address';
            echo 'exchangeUsername=username or email';
            echo 'exchangePassword=password';
        }
        //$this->mockApplication();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        //$this->destroyApplication();
    }

    /**
     * @covers common\lib\outlook\Outlook::authenticate
     */
    public function testAuthenticateSuccess()
    {
        $auth = new Outlook([
            'properties' => $this->property
            ]
        );
        $this->assertTrue($auth->authenticate());
    }

    /**
     * @covers common\lib\outlook\Outlook::authenticate
     */
    public function testAuthenticateContainerInjection()
    {
        \jarekkozak\sys\DependencyManager::register([
            'jarekkozak\sys\IProperties' => [
                'class' => 'jarekkozak\sys\PropertiesFile',
                'filename' => '$HOME/.secret/skills-secret'
            ],
            'jarekkozak\outlook\Outlook' => [
                'class' => 'jarekkozak\outlook\Outlook',
                'log' => 'jarekkozak\sys\LogConsole'
            ]
        ]);

        /* @var $auth Outlook */
        $auth = \Yii::$container->get('jarekkozak\outlook\Outlook');
        $this->assertTrue($auth->authenticate());
    }

    /**
     * @covers common\lib\outlook\Outlook::authenticate
     */
    public function testAuthenticateServiceLocator()
    {
        \Yii::$container->clear('jarekkozak\sys\IProperties');
        \Yii::$container->set('jarekkozak\sys\IProperties',
            [
            'class' => 'jarekkozak\sys\PropertiesFile',
            'filename' => '$HOME/.secret/skills-secret'
        ]);
        $app  = \Yii::$app;
        \Yii::$app->set('outlookAuth',
            [
            'class' => 'jarekkozak\outlook\Outlook'
        ]);
        /* @var $auth Outlook */
        $auth = \Yii::$app->outlookAuth;
        $this->assertTrue($auth->authenticate());
    }

    /**
     * @covers common\lib\outlook\Outlook::authenticate
     */
    public function testAuthenticateFailrue()
    {
        $this->property = new \jarekkozak\sys\PropertiesFile([
            'filename' => 'a.txt'
        ]);

        $auth = new Outlook([
                'properties' => $this->property
            ]
        );
        $this->assertFalse($auth->authenticate());
    }
}