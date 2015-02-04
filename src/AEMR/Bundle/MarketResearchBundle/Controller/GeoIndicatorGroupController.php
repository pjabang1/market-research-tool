<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use AEMR\Bundle\MarketResearchBundle\Controller\AEMRRestController AS Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;

/**
 * GeoIndicatorGroup controller.
 * @Rest\View()
 */
class GeoIndicatorGroupController extends Controller {

    /**
     * Lists all GeoIndicatorGroup entities.
     *
     */
    public function indexAction() {
        $service = $this->get('geoindicatorgroup_service');
        $entities = $service->retrieve($this->getRequest());
        return array('groups' => $entities);
    }

    /**
     * Lists all GeoIndicatorGroup entities.
     *
     */
    public function indicatorsAction() {
        $service = $this->get('geoindicatorgroup_service');
        $return = array();
        $return['group'] = $service->get($this->getRequest()->query->get('id'));
        $return['indicators'] = $service->getIndicators($this->getRequest());
        return $return;
    }

    /**
     * Lists all GeoIndicatorGroup entities.
     *
     */
    public function indicatorsReplaceAction() {
        
        // return $this->getRequest()->request->all();
        
        $service = $this->get('geoindicatorgroup_service');

        try {
            $service->replace($this->getRequest());
            return array('success' => true);
        } catch (\Exception $e) {
            return $this->view(array('success' => false, 'message' => 'Could not save', 'exception' => $e->getMessage()), 500);
        }
    }

  
}
