<?php

namespace AEMR\Bundle\MarketResearchBundle\Hydrator;

use AEMR\Bundle\MarketResearchBundle\Entity\GeoModel;
use AEMR\Bundle\MarketResearchBundle\Entity\GeoModelParameter;
use AEMR\Bundle\MarketResearchBundle\Entity\GeoModelParameterIndicator;

class GeoModelReplaceHydrator {
    
    protected $service;

    protected $data;

    // $conn->lastInsertId();
    
    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }
    
    public function getService() {
        return $this->service;
    }

    public function setService($service) {
        $this->service = $service;
    }

    
    /**
     * 
     * @param array $request
     */
    public function hydrate($request) {
        
        return $this->hydrateModel($request->request->all());
    }
    
    /**
     * 
     * @param \AEMR\Bundle\MarketResearchBundle\Entity\GeoModel $model
     */
    public function hydrateModel($model) {
        $entity = array();
        // $this->getService()->newModel($this->getRequest()->query->get('id'));
        if(isset($model['id']) && $model) {
            $entity['id'] = $model['id'];
        }
        $entity['algorithm_code'] = $model['algorithm_code'];
        $entity['name'] = $model['name'];
        $entity['description'] = $model['description'];
        
        $return['model'] = $entity;
        $return['parameters'] = $this->hydrateParameters($model['parameters']);
        
        return $return;
    }
 
    /**
     * 
     * @param arrat $indicators
     */
    public function hydrateIndicators($indicators) {
        $return = array();
        if($indicators && is_array($indicators)) {
            foreach($indicators AS $indicator) {
                $return[] = $this->hydrateIndicator($indicator);
            }
        }
        return $return;
    }
    
    /**
     * 
     * @param type $indicators
     */
    public function hydrateIndicator($indicator) {
        $entity = array();
        $entity['geoindicator_id'] = $indicator['id'];
        return $entity;
    }

    /**
     * 
     * @param \AEMR\Bundle\MarketResearchBundle\Entity\GeoModelParameter $parameter
     * @return \AEMR\Bundle\MarketResearchBundle\Entity\GeoModelParameter
     */
    public function hydrateParameter($parameter) {
        $entity = array();
        $entity['code'] = $parameter['code'];
        $entity['axis'] = $parameter['axis'];
        $entity['name'] = $parameter['name'];
        $entity['id'] = $parameter['id'];
        return $entity;
    }

    protected function hydrateParameters($parameters) {
        $return = array();
        foreach ($parameters AS $key => $parameter) {
            $return[$key]['parameter'] = $this->hydrateParameter($parameter);
            $return[$key]['indicators'] = $this->hydrateIndicators($parameter['indicators']);
        }
        return $return;
    }

}
