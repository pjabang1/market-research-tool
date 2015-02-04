<?php

namespace AEMR\Bundle\MarketResearchBundle\Service;

use AEMR\Bundle\MarketResearchBundle\Service\AEMRService;
use AEMR\Bundle\MarketResearchBundle\Entity\EntityGroup AS EGroup;
use AEMR\Bundle\MarketResearchBundle\Entity\EntityGroupEntity AS EEntity;

class EntityGroupService extends AEMRService {

    protected $entity = 'geography';
    protected $entity_id_alias = 'geography_id';

    public function getEntity() {
        return $this->entity;
    }

    public function setEntity($entity) {
        $this->entity = $entity;
    }

    public function getEntityIdAlias() {
        return $this->entity_id_alias;
    }

    public function setEntityIdAlias($entity_id_alias) {
        $this->entity_id_alias = $entity_id_alias;
    }

    /**
     * 
     * @param type $request
     * @return type
     */
    public function retrieve($request) {
        $em = $this->getEntityManager();

        $entities = $em->getRepository('AEMRMarketResearchBundle:EntityGroup')->findBy(
                array('entity' => $this->getEntity()
                )
        );

        return $entities;
    }

    protected function _getEntities($params) {

        $eGroup = $this->get($params['id']);
        if (!$eGroup) {
            return array();
        }

        $q = $this->getEntityManager()->createQuery("SELECT ggg.entity_id FROM AEMRMarketResearchBundle:EntityGroupEntity ggg WHERE ggg.entitygroup_id = :entitygroup_id");
        $q->setParameter(':entitygroup_id', $params['id']);
        // $q->setParameter(':entity', $this->getEntity());
        $result = $q->getArrayResult();
        return $this->hydrateResult($result);
    }

    protected function hydrateResult($array) {
        if ($array && is_array($array)) {
            foreach ($array AS $key => $value) {
                if (isset($value['entity_id'])) {
                    $value[$this->getEntityIdAlias()] = $value['entity_id'];
                    unset($value['entity_id']);
                    $array[$key] = $value;
                }
            }
        }
        return $array;
    }

    protected function _replace($params) {

        $em = $this->getEntityManager();

        $eGroup = null;
        if (null !== $params['id']) {
            $eGroup = $this->get($params['id']);
        }

        if (!$eGroup) {
            $eGroup = new EGroup();
        }

        $eGroup->setName($params['name']);
        $eGroup->setEntity($this->getEntity());
        $eGroup->setDescription($params['description']);
        $eGroup->setModified(new \DateTime());

        try {
            $em->persist($eGroup);
            $em->flush();
            $this->replaceEntities($eGroup, $params['entities']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 
     * @param type $request
     * @return type
     * 
     */
    public function replaceEntities(EGroup $eGroup, $entities) {
        $em = $this->getEntityManager();

        if (null !== $eGroup->getId()) {
            $q = $em->createQuery('DELETE from AEMRMarketResearchBundle:EntityGroupEntity ege  WHERE ege.entitygroup_id = :entitygroup_id');
            $q->setParameter(':entitygroup_id', $eGroup->getId());
            $q->execute();
        }

        if ($entities && is_array($entities)) {

            foreach ($entities AS $entity) {
                $eEntity = new EEntity();
                $eEntity->setEntitygroupId($eGroup->getId());
                $eEntity->setEntityId($entity['id']);
                $em->persist($eEntity);
            }

            $em->flush();
        }
    }

    /**
     * 
     * @param type $request
     * @return type
     */
    public function get($id) {
        $em = $this->getEntityManager();
        return $em->getRepository('AEMRMarketResearchBundle:EntityGroup')->findOneBy(
                        array(
                            'id' => $id,
                            'entity' => $this->getEntity()
        ));
    }

}
