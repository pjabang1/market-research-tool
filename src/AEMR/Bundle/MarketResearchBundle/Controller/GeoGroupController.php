<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use AEMR\Bundle\MarketResearchBundle\Controller\AEMRRestController AS Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use AEMR\Bundle\MarketResearchBundle\Entity\GeoGroup;
use AEMR\Bundle\MarketResearchBundle\Form\GeoGroupType;

/**
 * GeoGroup controller.
 * @Rest\View()
 */
class GeoGroupController extends Controller {

    /**
     * Lists all GeoGroup entities.
     *
     */
    public function indexAction() {
        $service = $this->get('geogroup_service');
        $entities = $service->retrieve($this->getRequest());
        return array('geogroups' => $entities);
    }

    /**
     * Lists all GeoGroup entities.
     *
     */
    public function geographiesAction() {
        $service = $this->get('geogroup_service');
        $return = array();
        $return['group'] = $service->get($this->getRequest()->query->get('id'));
        $return['geographies'] = $service->getGeographies($this->getRequest());
        return $return;
    }

    /**
     * Lists all GeoGroup entities.
     *
     */
    public function geographiesReplaceAction() {
        $service = $this->get('geogroup_service');

        try {
            $service->replace($this->getRequest());
            return array('success' => true);
        } catch (\Exception $e) {
            return array('success' => false, 'message' => 'Could not save', 'exception' => $e->getMessage());
        }
    }

}
