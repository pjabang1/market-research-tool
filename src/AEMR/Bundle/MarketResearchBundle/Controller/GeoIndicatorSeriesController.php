<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AEMR\Bundle\MarketResearchBundle\Entity\GeoIndicatorSeries;
use AEMR\Bundle\MarketResearchBundle\Form\GeoIndicatorSeriesType;

/**
 * GeoIndicatorSeries controller.
 *
 */
class GeoIndicatorSeriesController extends Controller
{

    /**
     * Lists all GeoIndicatorSeries entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AEMRMarketResearchBundle:GeoIndicatorSeries')->findAll();

        return $this->render('AEMRMarketResearchBundle:GeoIndicatorSeries:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new GeoIndicatorSeries entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new GeoIndicatorSeries();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('geoindicatorseries_show', array('id' => $entity->getId())));
        }

        return $this->render('AEMRMarketResearchBundle:GeoIndicatorSeries:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GeoIndicatorSeries entity.
     *
     * @param GeoIndicatorSeries $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GeoIndicatorSeries $entity)
    {
        $form = $this->createForm(new GeoIndicatorSeriesType(), $entity, array(
            'action' => $this->generateUrl('geoindicatorseries_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GeoIndicatorSeries entity.
     *
     */
    public function newAction()
    {
        $entity = new GeoIndicatorSeries();
        $form   = $this->createCreateForm($entity);

        return $this->render('AEMRMarketResearchBundle:GeoIndicatorSeries:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a GeoIndicatorSeries entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicatorSeries')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoIndicatorSeries entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoIndicatorSeries:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GeoIndicatorSeries entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicatorSeries')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoIndicatorSeries entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoIndicatorSeries:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a GeoIndicatorSeries entity.
    *
    * @param GeoIndicatorSeries $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GeoIndicatorSeries $entity)
    {
        $form = $this->createForm(new GeoIndicatorSeriesType(), $entity, array(
            'action' => $this->generateUrl('geoindicatorseries_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing GeoIndicatorSeries entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicatorSeries')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoIndicatorSeries entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('geoindicatorseries_edit', array('id' => $id)));
        }

        return $this->render('AEMRMarketResearchBundle:GeoIndicatorSeries:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a GeoIndicatorSeries entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AEMRMarketResearchBundle:GeoIndicatorSeries')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GeoIndicatorSeries entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('geoindicatorseries'));
    }

    /**
     * Creates a form to delete a GeoIndicatorSeries entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('geoindicatorseries_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
