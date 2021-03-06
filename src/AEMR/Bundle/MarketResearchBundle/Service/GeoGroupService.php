<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

use AEMR\Bundle\MarketResearchBundle\Service\EntityGroupService;

class GeoGroupService extends EntityGroupService {


    public function __construct() {
        $this->setEntity('geography');
        $this->setEntityIdAlias('geography_id');
    }

    /**
     * 
     * @param type $request
     * @return type
     */
    public function getGeographies($request) {

        $params = array(
            'id' => $request->query->get('id')
        );
        
        return $this->_getEntities($params);
    }
    
    /**
     * 
     * @param type $request
     */
    public function replace($request) {
        $params = array();
        
        $params['entities'] = $request->request->get('geographies');
        $params['name'] = $request->request->get('name');
        $params['id'] = $request->request->get('id');
        $params['description'] = $request->request->get('description');
        
        return $this->_replace($params);
    }



  

}
