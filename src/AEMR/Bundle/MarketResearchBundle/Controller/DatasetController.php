<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use AEMR\Bundle\MarketResearchBundle\Controller\AEMRRestController AS Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use AEMR\Bundle\MarketResearchBundle\Entity\GeoModel;
use AEMR\Bundle\MarketResearchBundle\Form\GeoModelType;

/**
 * Dataset controller.
 * @Rest\View()
 */
class DatasetController extends Controller {

    /**
     * Lists all Datasets entities.
     *
     */
    public function indexAction() {
        $service = $this->get('dataset_service');
        $entities = $service->retrieve($this->getRequest());
        return array('geomodels' => $entities);
    }

    public function saveAction() {
        $service = $this->get('dataset_service');
        $entities = $service->save($this->getRequest());
        return array('geomodels' => $entities);
    }



}
