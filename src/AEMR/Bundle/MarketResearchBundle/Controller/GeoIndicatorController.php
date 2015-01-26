<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use AEMR\Bundle\MarketResearchBundle\Controller\AEMRRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Util\Codes;
use AEMR\Bundle\MarketResearchBundle\Entity\GeoIndicator;
use AEMR\Bundle\MarketResearchBundle\Form\GeoIndicatorType;

/**
 * GeoIndicator controller.
 * @Rest\View()
 */
class GeoIndicatorController extends AEMRRestController {

    /**
     * Lists all GeoIndicator entities.
     *
     */
    public function indexAction() {
        $service = $this->get('geoindicator_service');
        $entities = $service->retrieve($this->getRequest());
        return array('geoindicators' => $entities);
    }

    /**
     * Creates a new GeoIndicator entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new GeoIndicator();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->view($entity, Codes::HTTP_CREATED);
        } else {
            return $this->getFormErrors($entity, $form);
        }
    }

    /**
     * Finds and displays a GeoIndicator entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoIndicator entity.');
        }


        return array(
            'entity' => $entity
        );
    }

    /**
     * Edits an existing GeoIndicator entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoIndicator entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->view($entity);
        }

        return $this->getFormErrors($entity, $editForm);

    }

    /**
     * Displays a form to edit an existing GeoIndicator entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoIndicator entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoIndicator:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to create a new GeoIndicator entity.
     *
     */
    public function newAction() {
        $entity = new GeoIndicator();
        $form = $this->createCreateForm($entity);

        return $this->render('AEMRMarketResearchBundle:GeoIndicator:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GeoIndicator entity.
     *
     * @param GeoIndicator $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GeoIndicator $entity) {
        $form = $this->createForm(new GeoIndicatorType(), $entity, array(
            'action' => $this->generateUrl('geoindicator_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Creates a form to edit a GeoIndicator entity.
     *
     * @param GeoIndicator $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(GeoIndicator $entity) {
        $form = $this->createForm(new GeoIndicatorType(), $entity, array(
            'action' => $this->generateUrl('geoindicator_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Deletes a GeoIndicator entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicator')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GeoIndicator entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('geoindicator'));
    }

    /**
     * Creates a form to delete a GeoIndicator entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('geoindicator_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
