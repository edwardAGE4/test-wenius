<?php

namespace AppBundle\Controller\Work;

use AppBundle\Entity\Work\Operation;
use AppBundle\Entity\Work\Vehicule;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller pour les opérations.
 * Prend en paramètre le véhicule concerné.
 *
 * @Route("cars/{idVehicule}/operations")
 * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_TECHNICIAN')")
 */
class OperationController extends Controller
{
    /**
     * Liste toutes les opérations du véhicule.
     *
     * @Route("/", name="operations_index")
     * @Method("GET")
     * @param Vehicule $vehicule
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Vehicule $vehicule)
    {
        $this->verifyVehicule($vehicule);

        $em = $this->getDoctrine()->getManager();

        $operations = $em->getRepository('AppBundle:Work\Operation')->findAll();

        return $this->render('AppBundle:Work/Operation:index.html.twig', array(
            'operations' => $operations,
            'vehicule' => $vehicule,
        ));
    }

    /**
     * Crée une nouvelle opération pour le véhicule.
     *
     * @Route("/new", name="operations_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_TECHNICIAN')")
     * @param Request $request
     * @param Vehicule $vehicule
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Vehicule $vehicule)
    {
        $this->verifyVehicule($vehicule);

        $operation = new Operation();
        $form = $this->createForm('AppBundle\Form\Work\OperationType', $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Enregistrement du créateur
            $operation->setCreateur($this->getUser());

            // Enregistrement du véhicule concerné
            $operation->setVehiculeConcerne($vehicule);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($operation);
                $em->flush();

                return $this->redirectToRoute('operations_show', array(
                    'idVehicule' => $vehicule->getIdVehicule(),
                    'idOperation' => $operation->getIdOperation()
                ));
            }
        }

        return $this->render('AppBundle:Work/Operation:new.html.twig', array(
            'operation' => $operation,
            'form' => $form->createView(),
            'vehicule' => $vehicule,
        ));
    }

    /**
     * Affiche une opération d'un véhicule.
     *
     * @Route("/{idOperation}", name="operations_show")
     * @Method("GET")
     * @param Vehicule $vehicule
     * @param Operation $operation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Vehicule $vehicule, Operation $operation)
    {
        $this->verifyVehicule($vehicule);

        return $this->render('AppBundle:Work/Operation:show.html.twig', array(
            'operation' => $operation,
            'vehicule' => $vehicule,
        ));
    }

    /**
     * Displays a form to edit an existing operation entity.
     *
     * @Route("/{idOperation}/edit", name="operations_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_TECHNICIAN')")
     * @param Request $request
     * @param Vehicule $vehicule
     * @param Operation $operation
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Vehicule $vehicule, Operation $operation)
    {
        $this->verifyVehicule($vehicule);

        $editForm = $this->createForm('AppBundle\Form\Work\OperationEditType', $operation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('operations_show', array(
                'idVehicule' => $vehicule->getIdVehicule(),
                'idOperation' => $operation->getIdOperation()
            ));
        }

        return $this->render('AppBundle:Work/Operation:edit.html.twig', array(
            'operation' => $operation,
            'edit_form' => $editForm->createView(),
            'vehicule' => $vehicule,
        ));
    }

    /**
     * Vérifie la validité du véhicule sur lesquel on effectue les traitements
     *
     * @param Vehicule $vehicule
     */
    private function verifyVehicule(Vehicule $vehicule)
    {
        if ($vehicule->getDeletedAt())
            throw new NotFoundHttpException();
    }
}
