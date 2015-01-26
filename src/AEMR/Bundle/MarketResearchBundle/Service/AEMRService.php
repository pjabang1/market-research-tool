<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

class AEMRService {

    /**
     *
     * @var \Doctrine\ORM\EntityManager 
     */
    protected $entityManager;
    
    /**
     * 
     * @return \Doctrine\ORM\EntityManager 
     */
    public function getEntityManager() {
        return $this->entityManager;
    }

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }
    
    public function getConnection() {
        return $this->getEntityManager()->getConnection();
    }


    

}
