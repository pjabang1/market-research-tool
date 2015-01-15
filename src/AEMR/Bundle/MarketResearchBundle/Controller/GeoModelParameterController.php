<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AEMR\Bundle\MarketResearchBundle\Entity\GeoModelParameter;
use AEMR\Bundle\MarketResearchBundle\Form\GeoModelParameterType;

/**
 * GeoModelParameter controller.
 *
 */
class GeoModelParameterController extends Controller
{

    /**
     * Lists all GeoModelParameter entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameter')->findAll();

        return $this->render('AEMRMarketResearchBundle:GeoModelParameter:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new GeoModelParameter entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new GeoModelParameter();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('geomodelparameter_show', array('id' => $entity->getId())));
        }

        return $this->render('AEMRMarketResearchBundle:GeoModelParameter:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a GeoModelParameter entity.
     *
     * @param GeoModelParameter $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(GeoModelParameter $entity)
    {
        $form = $this->createForm(new GeoModelParameterType(), $entity, array(
            'action' => $this->generateUrl('geomodelparameter_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new GeoModelParameter entity.
     *
     */
    public function newAction()
    {
        $entity = new GeoModelParameter();
        $form   = $this->createCreateForm($entity);

        return $this->render('AEMRMarketResearchBundle:GeoModelParameter:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a GeoModelParameter entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoModelParameter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoModelParameter:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing GeoModelParameter entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoModelParameter entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:GeoModelParameter:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a GeoModelParameter entity.
    *
    * @param GeoModelParameter $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(GeoModelParameter $entity)
    {
        $form = $this->createForm(new GeoModelParameterType(), $entity, array(
            'action' => $this->generateUrl('geomodelparameter_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing GeoModelParameter entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameter')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find GeoModelParameter entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('geomodelparameter_edit', array('id' => $id)));
        }

        return $this->render('AEMRMarketResearchBundle:GeoModelParameter:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a GeoModelParameter entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AEMRMarketResearchBundle:GeoModelParameter')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find GeoModelParameter entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('geomodelparameter'));
    }

    /**
     * Creates a form to delete a GeoModelParameter entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('geomodelparameter_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
