<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AEMR\Bundle\MarketResearchBundle\Entity\GeoIndicator;
use AEMR\Bundle\MarketResearchBundle\Form\GeoIndicatorType;

/**
 * GeoIndicator controller.
 *
 */
class GeoIndicatorController extends Controller
{

    /**
     * Lists all GeoIndicator entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AEMRMarketResearchBundle:GeoIndicator')->findAll();

        return $this->render('AEMRMarketResearchBundle:GeoIndicator:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new GeoIndicator entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new GeoIndicator();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('geoindicator_show', array('id' => $entity->getId())));
        }

        return $this->render('AEMRMarketResearchBundle:GeoIndicator:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GeoIndicator entity.
     *
     * @param GeoIndicator $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GeoIndicator $entity)
    {
        $form = $this->createForm(new GeoIndicatorType(), $entity, array(
            'action' => $this->generateUrl('geoindicator_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GeoIndicator entity.
     *
     */
    public function newAction()
    {
        $entity = new GeoIndicator();
        $form   = $this->createCreateForm($entity);

        return $this->render('AEMRMarketResearchBundle:GeoIndicator:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a GeoIndicator entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoIndicator entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoIndicator:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GeoIndicator entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoIndicator entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoIndicator:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a GeoIndicator entity.
    *
    * @param GeoIndicator $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GeoIndicator $entity)
    {
        $form = $this->createForm(new GeoIndicatorType(), $entity, array(
            'action' => $this->generateUrl('geoindicator_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing GeoIndicator entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoIndicator entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('geoindicator_edit', array('id' => $id)));
        }

        return $this->render('AEMRMarketResearchBundle:GeoIndicator:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a GeoIndicator entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
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
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('geoindicator_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
