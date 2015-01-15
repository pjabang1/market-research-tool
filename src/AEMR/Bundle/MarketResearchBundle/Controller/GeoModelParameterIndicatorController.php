<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AEMR\Bundle\MarketResearchBundle\Entity\GeoModelParameterIndicator;
use AEMR\Bundle\MarketResearchBundle\Form\GeoModelParameterIndicatorType;

/**
 * GeoModelParameterIndicator controller.
 *
 */
class GeoModelParameterIndicatorController extends Controller
{

    /**
     * Lists all GeoModelParameterIndicator entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameterIndicator')->findAll();

        return $this->render('AEMRMarketResearchBundle:GeoModelParameterIndicator:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new GeoModelParameterIndicator entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new GeoModelParameterIndicator();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('geomodelparameterindicator_show', array('id' => $entity->getId())));
        }

        return $this->render('AEMRMarketResearchBundle:GeoModelParameterIndicator:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GeoModelParameterIndicator entity.
     *
     * @param GeoModelParameterIndicator $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GeoModelParameterIndicator $entity)
    {
        $form = $this->createForm(new GeoModelParameterIndicatorType(), $entity, array(
            'action' => $this->generateUrl('geomodelparameterindicator_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GeoModelParameterIndicator entity.
     *
     */
    public function newAction()
    {
        $entity = new GeoModelParameterIndicator();
        $form   = $this->createCreateForm($entity);

        return $this->render('AEMRMarketResearchBundle:GeoModelParameterIndicator:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a GeoModelParameterIndicator entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameterIndicator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoModelParameterIndicator entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoModelParameterIndicator:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GeoModelParameterIndicator entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameterIndicator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoModelParameterIndicator entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoModelParameterIndicator:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a GeoModelParameterIndicator entity.
    *
    * @param GeoModelParameterIndicator $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GeoModelParameterIndicator $entity)
    {
        $form = $this->createForm(new GeoModelParameterIndicatorType(), $entity, array(
            'action' => $this->generateUrl('geomodelparameterindicator_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing GeoModelParameterIndicator entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameterIndicator')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoModelParameterIndicator entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('geomodelparameterindicator_edit', array('id' => $id)));
        }

        return $this->render('AEMRMarketResearchBundle:GeoModelParameterIndicator:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a GeoModelParameterIndicator entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameterIndicator')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GeoModelParameterIndicator entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('geomodelparameterindicator'));
    }

    /**
     * Creates a form to delete a GeoModelParameterIndicator entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('geomodelparameterindicator_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
