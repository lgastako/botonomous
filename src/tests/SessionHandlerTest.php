<?php

namespace Slackbot\Tests;

use Slackbot\SessionHandler;

class SessionHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * SessionHandlerTest constructor.
     */
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Test set.
     */
    public function testSet()
    {
        $sessionHandler = new SessionHandler();
        $sessionHandler->set('testKey', 'testValue');

        $this->assertEquals('testValue', $sessionHandler->get('testKey'));

        $sessionHandler->set('testKey', 'testNewValue');

        $this->assertEquals('testNewValue', $sessionHandler->get('testKey'));
    }

    /**
     * Test get.
     */
    public function testGet()
    {
        $sessionHandler = new SessionHandler();

        $this->assertEquals(null, $sessionHandler->get('unknownKey'));
    }

    /**
     * Test getSession.
     */
    public function testGetSession()
    {
        $sessionHandler = new SessionHandler();
        $session = $sessionHandler->getSession();

        $session['myKey'] = 'meyValue';
        $sessionHandler->setSession($session);

        $this->assertEquals($session, $sessionHandler->getSession());
    }
}