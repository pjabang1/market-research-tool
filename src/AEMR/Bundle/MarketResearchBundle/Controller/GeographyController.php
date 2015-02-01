<?php

namespace AEMR\Bundle\MarketResearchBundle\Controller;

use AEMR\Bundle\MarketResearchBundle\Controller\AEMRRestController AS Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use AEMR\Bundle\MarketResearchBundle\Entity\Geography;
use AEMR\Bundle\MarketResearchBundle\Form\GeographyType;

/**
 * Geography controller.
 *
 * @Rest\View()
 */
class GeographyController extends Controller 
{

    /**
     * Lists all Geography entities.
     *
     * 
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AEMRMarketResearchBundle:Geography')->findAll();

        return array(
            'geographies' => $entities
        );

    }
    /**
     * Creates a new Geography entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Geography();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('geography_show', array('id' => $entity->getId())));
        }

        return $this->render('AEMRMarketResearchBundle:Geography:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Geography entity.
     *
     * @param Geography $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Geography $entity)
    {
        $form = $this->createForm(new GeographyType(), $entity, array(
            'action' => $this->generateUrl('geography_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Geography entity.
     *
     */
    public function newAction()
    {
        $entity = new Geography();
        $form   = $this->createCreateForm($entity);

        return $this->render('AEMRMarketResearchBundle:Geography:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Geography entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:Geography')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Geography entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Geography entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:Geography')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Geography entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AEMRMarketResearchBundle:Geography:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Geography entity.
    *
    * @param Geography $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Geography $entity)
    {
        $form = $this->createForm(new GeographyType(), $entity, array(
            'action' => $this->generateUrl('geography_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Geography entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AEMRMarketResearchBundle:Geography')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Geography entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('geography_edit', array('id' => $id)));
        }

        return $this->render('AEMRMarketResearchBundle:Geography:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Geography entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AEMRMarketResearchBundle:Geography')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Geography entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('geography'));
    }

    /**
     * Creates a form to delete a Geography entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('geography_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
