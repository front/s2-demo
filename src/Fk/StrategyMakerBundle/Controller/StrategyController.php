<?php

namespace Fk\StrategyMakerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fk\StrategyMakerBundle\Entity\Strategy;
use Fk\StrategyMakerBundle\Form\StrategyType;

/**
 * Strategy controller.
 *
 * @Route("/")
 */
class StrategyController extends Controller
{
    /**
     * Lists all Strategy entities.
     *
     * @Route("/", name="strategy")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FkStrategyMakerBundle:Strategy')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Strategy entity.
     *
     * @Route("/{id}/show", name="strategy_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FkStrategyMakerBundle:Strategy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Strategy entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Strategy entity.
     *
     * @Route("/new", name="strategy_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Strategy();
        $form   = $this->createForm(new StrategyType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Strategy entity.
     *
     * @Route("/create", name="strategy_create")
     * @Method("POST")
     * @Template("FkStrategyMakerBundle:Strategy:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Strategy();
        $form = $this->createForm(new StrategyType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('strategy_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Strategy entity.
     *
     * @Route("/{id}/edit", name="strategy_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FkStrategyMakerBundle:Strategy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Strategy entity.');
        }

        $editForm = $this->createForm(new StrategyType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Strategy entity.
     *
     * @Route("/{id}/update", name="strategy_update")
     * @Method("POST")
     * @Template("FkStrategyMakerBundle:Strategy:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FkStrategyMakerBundle:Strategy')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Strategy entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new StrategyType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('strategy_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Strategy entity.
     *
     * @Route("/{id}/delete", name="strategy_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FkStrategyMakerBundle:Strategy')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Strategy entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('strategy'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
