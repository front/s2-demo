<?php

namespace Fk\StrategyMakerBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Fk\StrategyMakerBundle\Entity\Goal;
use Fk\StrategyMakerBundle\Form\GoalType;

/**
 * Goal controller.
 *
 * @Route("/goal")
 */
class GoalController extends Controller
{
    /**
     * Lists all Goal entities.
     *
     * @Route("/", name="goal")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FkStrategyMakerBundle:Goal')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Goal entity.
     *
     * @Route("/{id}/show", name="goal_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FkStrategyMakerBundle:Goal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Goal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Goal entity.
     *
     * @Route("/new/{strategy_id}", name="goal_new")
     * @Template()
     */
    public function newAction($strategy_id)
    {
        $entity = new Goal();
        $strategy = new \Fk\StrategyMakerBundle\Entity\Strategy;
        
        if ($strategy_id > 0) {
          $strategy = $this->getDoctrine()->getManager()
              ->getRepository('FkStrategyMakerBundle:Strategy')->find($strategy_id);

          $entity->setStrategy($strategy);          
        }
        
        $form   = $this->createForm(new GoalType(), $entity);

        return array(
            'entity' => $entity,
            'strategy' => $strategy,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Goal entity.
     *
     * @Route("/create", name="goal_create")
     * @Method("POST")
     * @Template("FkStrategyMakerBundle:Goal:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Goal();
        $form = $this->createForm(new GoalType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('strategy_show', array('id' => $entity->getStrategy()->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Goal entity.
     *
     * @Route("/{id}/edit", name="goal_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FkStrategyMakerBundle:Goal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Goal entity.');
        }

        $editForm = $this->createForm(new GoalType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Goal entity.
     *
     * @Route("/{id}/update", name="goal_update")
     * @Method("POST")
     * @Template("FkStrategyMakerBundle:Goal:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FkStrategyMakerBundle:Goal')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Goal entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new GoalType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('goal_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Goal entity.
     *
     * @Route("/{id}/delete", name="goal_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);
        
        $strategy_id = 0;

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FkStrategyMakerBundle:Goal')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Goal entity.');
            }

            $strategy_id = $entity->getStrategy()->getId();
            
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
