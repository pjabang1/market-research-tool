<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

use AEMR\Bundle\MarketResearchBundle\Service\AEMRService;

class GeoGroupService extends AEMRService {

    /**
     * 
     * @param type $request
     * @return type
     */
    public function retrieve($request) {
        $em = $this->getEntityManager();

        $entities = $em->getRepository('AEMRMarketResearchBundle:GeoGroup')->findAll();

        return $entities;
    }

}
