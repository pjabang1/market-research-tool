<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

use AEMR\Bundle\MarketResearchBundle\Service\AEMRService;

class GeoIndicatorService extends AEMRService {

    /**
     * 
     * @param type $request
     * @return type
     */
    public function retrieve($request) {

        $entities = $this->getEntityManager()->getRepository('AEMRMarketResearchBundle:GeoIndicator')->findAll();

        return $entities;
    }

}
