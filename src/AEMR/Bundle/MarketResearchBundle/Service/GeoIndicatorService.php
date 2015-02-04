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

        // $entities = $this->getEntityManager()->getRepository('AEMRMarketResearchBundle:GeoIndicator')->findAll();

        $q = $this->getEntityManager()->createQuery("SELECT i.id, i.name, i.code FROM AEMRMarketResearchBundle:GeoIndicator i");
        // $q->setParameter(':entitygroup_id', $params['id']);
        // $q->setParameter(':entity', $this->getEntity());
        return $q->getArrayResult();

        /**
          $query_select = "SELECT i
          FROM AEMRMarketResearchBundle:GeoIndicator i
          "
          ;


          $query = $this->getEntityManager()
          ->createQuery($query_select)
          // ->setParameters($params)
          ->setMaxResults(50);
          ;

          $entities = $query->getResult();

          return $entities;* */
    }

}
