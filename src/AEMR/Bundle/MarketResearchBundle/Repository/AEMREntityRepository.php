<?php

namespace AEMR\Bundle\MarketResearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AEMREntityRepository
 */
class AEMREntityRepository extends EntityRepository
{
    
    protected function getConnection() {
        return $stmt = $this->getEntityManager()
        ->getConnection();
    }
    

}
