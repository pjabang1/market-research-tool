<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;

/**
 * AEMRRestController controller.
 *
 */
abstract class AEMRRestController extends FOSRestController {

    protected function getFormErrors($entity, \Symfony\Component\Form\Form $form) {
        return array(
            'message' => 'Save failed.',
            'errors' => $form->getErrorsAsString()
                // 'request' => $request->request->all(),
                // 'entity' => $entity,
                // 'form' => $form->createView(),
        );
    }

}
