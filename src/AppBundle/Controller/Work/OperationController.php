<?php

namespace AppBundle\Controller\Work;

use AppBundle\Entity\Work\Intervention;
use AppBundle\Entity\Work\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller pour les opérations.
 * 
 * @Route("/operations")
 * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_TECHNICIAN')")
 */
class OperationController extends Controller
{
    /**
     * Affiche une opération d'un véhicule.
     *
     * @Route("/{idOperation}", name="operations_show")
     * @Method("GET")
     * @param Operation $operation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Operation $operation)
    {
        return $this->render('AppBundle:Work/Operation:show.html.twig', array(
            'operation' => $operation,
        ));
    }

    /**
     * Displays a form to edit an existing operation entity.
     *
     * @Route("/{idOperation}/edit", name="operations_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_TECHNICIAN')")
     */
    public function editAction(Request $request, Operation $operation)
    {
        $editForm = $this->createForm('AppBundle\Form\Work\OperationEditType', $operation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operations_show', array('idOperation' => $operation->getIdOperation()));
        }

        return $this->render('AppBundle:Work/Operation:edit.html.twig', array(
            'operation' => $operation,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Liste toutes les interventions de l'opération passée en paramètre.
     *
     * @Route("/{idOperation}/interventions", name="interventions_index")
     * @Method("GET")
     * @param Operation $operation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Operation $operation)
    {
        $em = $this->getDoctrine()->getManager();

        $interventions = $em->getRepository('AppBundle:Work\Intervention')->findBy(array(
            'operation' => $operation,
        ));

        return $this->render('AppBundle:Work/Intervention:index.html.twig', array(
            'interventions' => $interventions,
            'operation' => $operation,
        ));
    }

    /**
     * Crée une intervention d'une opération.
     *
     * @Route("{idOperation}/interventions/new", name="interventions_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_TECHNICIAN')")
     */
    public function newAction(Request $request, Operation $operation)
    {
        $intervention = new Intervention();
        // Enregistrement du créateur
        $intervention->setCreateur($this->getUser());

        // Enregistrement de l'opération concernée
        $intervention->setOperation($operation);

        $form = $this->createForm('AppBundle\Form\Work\InterventionType', $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($intervention);
            $em->flush();

            return $this->redirectToRoute('interventions_show', array('idIntervention' => $intervention->getIdIntervention()));
        }

        return $this->render('@App/Work/Intervention/new.html.twig', array(
            'intervention' => $intervention,
            'form' => $form->createView(),
        ));
    }
}
