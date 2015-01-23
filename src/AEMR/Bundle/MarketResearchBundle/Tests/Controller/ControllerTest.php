<?php

namespace AEMR\Bundle\MarketResearchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase {

    /**
     *
     * @var type 
     */
    protected $client;

    /**
     *
     * @var type 
     */
    protected $router;

    public function setUp() {
        
    }

    /**
     * 
     * @return type
     */
    protected function getClient() {
        if (null === $this->client) {
            $auth = array(
                'PHP_AUTH_USER' => 'user',
                'PHP_AUTH_PW' => 'userpass',
            );
            $this->client = static::createClient(array(), $auth);
        }
        return $this->client;
    }

    protected function getRouter() {

        if (null === $this->router) {
            $this->router = $this->getClient()->getContainer()->get('router');
        }
        return $this->router;
    }

}
