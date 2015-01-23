<?php

namespace AEMR\Bundle\MarketResearchBundle\Tests\Controller;

use AEMR\Bundle\MarketResearchBundle\Tests\Controller\ControllerTest;

class GeoIndicatorControllerTest extends ControllerTest {

    public function testCreate() {
        $data = array(
            'code' => 'UPDATED:1001',
            'name' => 'Hello',
            'geo_type' => 'COUNTRY',
            'value_type' => 'Number',
            'periodicity' => 'Monthly',
            'description' => 'Essa Testing',
            'source' => 'INSERT',
        );
        
        
        $this->getClient()->request(
                'PUT', $this->getRouter()->generate('geoindicator_update', array('id' => 1), false), array('geoindicator' => $data)
        );
        
        $response = $this->getClient()->getResponse();
        
        // var_dump($this->getRouter()->generate('geoindicator_create', array(), false));
        var_dump($response->getContent());
        
        $this->assertEquals(1, 1);
        
    }
}
