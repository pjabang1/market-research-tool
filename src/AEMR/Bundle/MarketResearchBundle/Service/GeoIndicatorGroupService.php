<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

use AEMR\Bundle\MarketResearchBundle\Service\EntityGroupService;

class GeoIndicatorGroupService extends EntityGroupService {


    public function __construct() {
        $this->setEntity('geoindicator');
        $this->setEntityIdAlias('geoindicator_id');
    }

    /**
     *
     * @param type $request
     * @return type
     */
    public function getIndicators($request) {

        $params = array(
            'id' => $request->query->get('id')
        );

        return $this->_getEntities($params);
    }

    public function getSummary($request) {

        $params = array(
            'id' => $request->query->get('id')
        );

        return $this->_getEntities($params);
    }

    public function getGeographyIndicators($request) {

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
        $params['id'] = $request->request->get('id');
        $params['entities'] = $request->request->get('indicators');
        $params['name'] = $request->request->get('name');
        $params['description'] = $request->request->get('description');

        return $this->_replace($params);
    }





}
