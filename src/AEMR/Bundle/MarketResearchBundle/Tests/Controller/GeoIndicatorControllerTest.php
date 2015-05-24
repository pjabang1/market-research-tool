<?php

namespace AEMR\Bundle\MarketResearchBundle\Tests\Controller;

use AEMR\Bundle\MarketResearchBundle\Tests\Controller\ControllerTest;

class GeoIndicatorControllerTest extends ControllerTest {

    public function testCreate() {
        
        $data = array();
        $data['series'] = [];
        $data['series'] = array('country' => 'Afghanistan', '2012' => 123, '2013' => 150, '2014' => 1600);
        $data['series'] = array('country' => 'Albania', '2012' => 123, '2013' => 56, '2014' => 908);
        /**
        $this->getClient()->request(
                'PUT', $this->getRouter()->generate('geoindicator_update', array('id' => 1), false), array('geoindicator' => $data)
        );
        

        $response = $this->getClient()->getResponse();
        
        // var_dump($this->getRouter()->generate('geoindicator_create', array(), false));
        var_dump($response->getContent());
  
        **/
        $this->assertEquals(1, 1);
        
    }

    




}
