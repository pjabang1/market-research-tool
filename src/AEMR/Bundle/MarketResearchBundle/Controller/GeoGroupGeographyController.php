<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AEMR\Bundle\MarketResearchBundle\Entity\GeoGroupGeography;
use AEMR\Bundle\MarketResearchBundle\Form\GeoGroupGeographyType;

/**
 * GeoGroupGeography controller.
 *
 */
class GeoGroupGeographyController extends Controller
{

    /**
     * Lists all GeoGroupGeography entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AEMRMarketResearchBundle:GeoGroupGeography')->findAll();

        return $this->render('AEMRMarketResearchBundle:GeoGroupGeography:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new GeoGroupGeography entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new GeoGroupGeography();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('geogroupgeography_show', array('id' => $entity->getId())));
        }

        return $this->render('AEMRMarketResearchBundle:GeoGroupGeography:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GeoGroupGeography entity.
     *
     * @param GeoGroupGeography $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GeoGroupGeography $entity)
    {
        $form = $this->createForm(new GeoGroupGeographyType(), $entity, array(
            'action' => $this->generateUrl('geogroupgeography_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GeoGroupGeography entity.
     *
     */
    public function newAction()
    {
        $entity = new GeoGroupGeography();
        $form   = $this->createCreateForm($entity);

        return $this->render('AEMRMarketResearchBundle:GeoGroupGeography:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a GeoGroupGeography entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoGroupGeography')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoGroupGeography entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoGroupGeography:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GeoGroupGeography entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoGroupGeography')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoGroupGeography entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoGroupGeography:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a GeoGroupGeography entity.
    *
    * @param GeoGroupGeography $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GeoGroupGeography $entity)
    {
        $form = $this->createForm(new GeoGroupGeographyType(), $entity, array(
            'action' => $this->generateUrl('geogroupgeography_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing GeoGroupGeography entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoGroupGeography')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoGroupGeography entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('geogroupgeography_edit', array('id' => $id)));
        }

        return $this->render('AEMRMarketResearchBundle:GeoGroupGeography:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a GeoGroupGeography entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AEMRMarketResearchBundle:GeoGroupGeography')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GeoGroupGeography entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('geogroupgeography'));
    }

    /**
     * Creates a form to delete a GeoGroupGeography entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('geogroupgeography_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
