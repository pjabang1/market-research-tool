<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use AEMR\Bundle\MarketResearchBundle\Controller\AEMRRestController AS Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use AEMR\Bundle\MarketResearchBundle\Entity\GeoModel;
use AEMR\Bundle\MarketResearchBundle\Form\GeoModelType;

/**
 * GeoModel controller.
 * @Rest\View()
 */
class GeoModelController extends Controller {

    /**
     * Lists all GeoModel entities.
     *
     * 
     */
    public function indexAction() {
        $service = $this->get('geomodel_service');
        $entities = $service->retrieve($this->getRequest());
        return array('geomodels' => $entities);
    }

    /**
     * 
     * @return array
     */
    public function valuesAction() {
        $service = $this->get('geomodel_service');
        $entities = $service->getValues($this->getRequest());
        $hydrator = new \AEMR\Bundle\MarketResearchBundle\Hydrator\GeoModelMatrixHydrator();

        // $indicators = $hydrator->hydrateIndicators($service->getIndicators($this->getRequest()));
        $values = $hydrator->hydrateValues($entities);
        $geographies = $hydrator->hydrateGeographies($service->getGeographies($this->getRequest()), $values);




        return array(
            // 'values' => $values,
            'geographies' => $geographies,
            'settings' => array('max_weight' => 100)
        );
    }

    public function geographiesAction() {
        $service = $this->get('geomodel_service');
        $entities = $service->getGeographies($this->getRequest());
        return array('geographies' => $entities);
    }

    public function indicatorsAction() {
        $service = $this->get('geomodel_service');
        $hydrator = new \AEMR\Bundle\MarketResearchBundle\Hydrator\GeoModelMatrixHydrator();

        $parameters = $service->getParameters($this->getRequest());
        $indicators = $hydrator->hydrateIndicators($service->getIndicators($this->getRequest()));

        return array(
            'model' => $service->getModel($this->getRequest()->query->get('id')),
            'indicators' => $indicators,
            'parameters' => $parameters
        );
    }

    public function parametersAction() {
        $service = $this->get('geomodel_service');

        $parameters = $service->getParameters($this->getRequest());

        return array('parameters' => $parameters);
    }

    /**
     * Creates a new GeoModel entity.
     *
     */
    public function newAction() {
        $service = $this->get('geomodel_service');
        return $service->newModel($this->getRequest()->query->get('id'));
    }

    /**
     * Replace a GeoModel
     *
     */
    public function replaceAction() {
        $hydrator = new \AEMR\Bundle\MarketResearchBundle\Hydrator\GeoModelReplaceHydrator();
        $data = $hydrator->hydrate($this->getRequest());
        $service = $this->get('geomodel_service');
        return $service->replace($data);
    }

    /**
     * Creates a form to create a GeoModel entity.
     *
     * @param GeoModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GeoModel $entity) {
        $form = $this->createForm(new GeoModelType(), $entity, array(
            'action' => $this->generateUrl('geomodel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Finds and displays a GeoModel entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoModel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoModel:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GeoModel entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoModel entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoModel:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a GeoModel entity.
     *
     * @param GeoModel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(GeoModel $entity) {
        $form = $this->createForm(new GeoModelType(), $entity, array(
            'action' => $this->generateUrl('geomodel_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing GeoModel entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModel')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoModel entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('geomodel_edit', array('id' => $id)));
        }

        return $this->render('AEMRMarketResearchBundle:GeoModel:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a GeoModel entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModel')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GeoModel entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('geomodel'));
    }

    /**
     * Creates a form to delete a GeoModel entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('geomodel_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
