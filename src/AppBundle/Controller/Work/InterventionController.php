<?php

namespace AppBundle\Controller\Work;

use AppBundle\Entity\Work\Intervention;
use AppBundle\Entity\Work\Operation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller pour les interventions.
 * Prend en paramètre l'opération concernée.
 *
 * @Route("operations/{idOperation}/interventions")
 * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_TECHNICIAN')")
 */
class InterventionController extends Controller
{
    /**
     * Liste toutes les interventions d'une opération.
     *
     * @Route("/", name="interventions_index")
     * @Method("GET")
     * @param Operation $operation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Operation $operation)
    {
        $this->verifyOperation($operation);

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
     * @Route("/new", name="interventions_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_TECHNICIAN')")
     * @param Request $request
     * @param Operation $operation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Operation $operation)
    {
        $this->verifyOperation($operation);

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

            return $this->redirectToRoute('interventions_show', array(
                'idIntervention' => $intervention->getIdIntervention(),
                'idOperation' => $operation->getIdOperation(),
            ));
        }

        return $this->render('@App/Work/Intervention/new.html.twig', array(
            'intervention' => $intervention,
            'form' => $form->createView(),
            'operation' => $operation,
        ));
    }

    /**
     * Affiche une intervention d'une opération.
     *
     * @Route("/{idIntervention}", name="interventions_show")
     * @Method("GET")
     * @param Operation $operation
     * @param Intervention $intervention
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Operation $operation, Intervention $intervention)
    {
        $this->verifyOperation($operation);

        return $this->render('AppBundle:Work/Intervention:show.html.twig', array(
            'intervention' => $intervention,
            'operation' => $operation,
        ));
    }

    /**
     * Vérifie la validité de l'opération sur laquelle on effectue les traitements
     *
     * @param Operation $operation
     */
    private function verifyOperation(Operation $operation)
    {
        if ($operation->getVehiculeConcerne()->getDeletedAt())
            throw new NotFoundHttpException();
    }
}
