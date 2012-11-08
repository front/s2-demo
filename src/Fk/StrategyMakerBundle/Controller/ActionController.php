<?php

namespace Fk\StrategyMakerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fk\StrategyMakerBundle\Entity\Action;
use Fk\StrategyMakerBundle\Form\ActionType;

/**
 * Action controller.
 *
 * @Route("/action")
 */
class ActionController extends Controller
{
    /**
     * Lists all Action entities.
     *
     * @Route("/", name="action")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FkStrategyMakerBundle:Action')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Action entity.
     *
     * @Route("/{id}/show", name="action_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FkStrategyMakerBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Action entity.
     *
     * @Route("/new/{goal_id}", name="action_new")
     * @Template()
     */
    public function newAction($goal_id)
    {
        $goal = $this->getDoctrine()->getManager()
            ->getRepository('FkStrategyMakerBundle:Goal')->find($goal_id);

        $entity = new Action();
        $entity->setGoal($goal);
        $form   = $this->createForm(new ActionType(), $entity);

        return array(
            'entity' => $entity,
            'goal'   => $goal,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Action entity.
     *
     * @Route("/create", name="action_create")
     * @Method("POST")
     * @Template("FkStrategyMakerBundle:Action:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Action();
        $form = $this->createForm(new ActionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('strategy_show', array('id' => $entity->getGoal()->getStrategy()->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Action entity.
     *
     * @Route("/{id}/edit", name="action_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FkStrategyMakerBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $editForm = $this->createForm(new ActionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Action entity.
     *
     * @Route("/{id}/update", name="action_update")
     * @Method("POST")
     * @Template("FkStrategyMakerBundle:Action:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FkStrategyMakerBundle:Action')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Action entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ActionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('action_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Action entity.
     *
     * @Route("/{id}/delete", name="action_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        $strategy_id = 0;

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FkStrategyMakerBundle:Action')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Action entity.');
            }

            $strategy_id = $entity->getGoal()->getStrategy()->getId();

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('strategy_show', array('id' => $strategy_id)));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
