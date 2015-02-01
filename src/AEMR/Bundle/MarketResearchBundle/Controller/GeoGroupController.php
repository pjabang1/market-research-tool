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
		$return['group'] = $service->get($this->getRequest());
		$return['geographies'] = $service->getGeographies($this->getRequest());
        return $return;
    }

    /**
     * Creates a new GeoGroup entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new GeoGroup();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('geogroup_show', array('id' => $entity->getId())));
        }

        return $this->render('AEMRMarketResearchBundle:GeoGroup:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GeoGroup entity.
     *
     * @param GeoGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GeoGroup $entity) {
        $form = $this->createForm(new GeoGroupType(), $entity, array(
            'action' => $this->generateUrl('geogroup_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GeoGroup entity.
     *
     */
    public function newAction() {
        $entity = new GeoGroup();
        $form = $this->createCreateForm($entity);

        return $this->render('AEMRMarketResearchBundle:GeoGroup:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a GeoGroup entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoGroup:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GeoGroup entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoGroup entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoGroup:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a GeoGroup entity.
     *
     * @param GeoGroup $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(GeoGroup $entity) {
        $form = $this->createForm(new GeoGroupType(), $entity, array(
            'action' => $this->generateUrl('geogroup_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing GeoGroup entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoGroup')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoGroup entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('geogroup_edit', array('id' => $id)));
        }

        return $this->render('AEMRMarketResearchBundle:GeoGroup:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a GeoGroup entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AEMRMarketResearchBundle:GeoGroup')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GeoGroup entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('geogroup'));
    }

    /**
     * Creates a form to delete a GeoGroup entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('geogroup_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
