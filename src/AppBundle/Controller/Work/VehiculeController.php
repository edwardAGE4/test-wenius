<?php

namespace AppBundle\Controller\Work;

use AppBundle\Entity\Work\Operation;
use AppBundle\Entity\Work\Probleme;
use AppBundle\Entity\Work\Vehicule;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller pour les véhicules.
 *
 * @Route("cars")
 * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_TECHNICIAN')")
 */
class VehiculeController extends Controller
{
    /**
     * Liste tous les véhicules.
     *
     * @Route("/", name="cars_index")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehicules = $em->getRepository('AppBundle:Work\Vehicule')->findAll();

        return $this->render('AppBundle:Work/Vehicule:index.html.twig', array(
            'vehicules' => $vehicules,
        ));
    }

    /**
     * Creates a new vehicule entity.
     *
     * @Route("/new", name="cars_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function newAction(Request $request)
    {
        $vehicule = new Vehicule();
        // Enregistrement du créateur
        $vehicule->setCreateur($this->getUser());
        
        $form = $this->createForm('AppBundle\Form\Work\VehiculeType', $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicule);
            $em->flush();

            return $this->redirectToRoute('cars_show', array('idVehicule' => $vehicule->getIdVehicule()));
        }

        return $this->render('AppBundle:Work/Vehicule:new.html.twig', array(
            'vehicule' => $vehicule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'un véhicule.
     *
     * @Route("/{idVehicule}", name="cars_show")
     * @Method("GET")
     * @param Vehicule $vehicule
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Vehicule $vehicule)
    {
        $deleteForm = $this->createDeleteForm($vehicule);

        return $this->render('AppBundle:Work/Vehicule:show.html.twig', array(
            'vehicule' => $vehicule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Supprime un véhicule
     *
     * @Route("/{idVehicule}", name="cars_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_MANAGER')")
     * @param Request $request
     * @param Vehicule $vehicule
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Vehicule $vehicule)
    {
        $form = $this->createDeleteForm($vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $em = $this->getDoctrine()->getManager();
                $em->remove($vehicule);
                $em->flush();
            }
            catch (ForeignKeyConstraintViolationException $e) {
                $this->addFlash('error', 'Action impossible, objet lié à d\'autres objets.');
                $referer = $request->headers->get('referer');
                return $this->redirect($referer);
            }
        }

        return $this->redirectToRoute('cars_index');
    }

    /**
     * Crée un formulaire de suppression de véhicule
     *
     * @param Vehicule $vehicule
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(Vehicule $vehicule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cars_delete', array('idVehicule' => $vehicule->getIdVehicule())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Liste toutes les opérations du véhicule passé en paramètre.
     *
     * @Route("/{idVehicule}/operations", name="operations_index")
     * @Method("GET")
     * @param Vehicule $vehicule
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function operationsAction(Vehicule $vehicule)
    {
        $em = $this->getDoctrine()->getManager();

        $operations = $em->getRepository('AppBundle:Work\Operation')->findBy(array(
            'vehiculeConcerne' => $vehicule
        ));

        return $this->render('AppBundle:Work/Operation:index.html.twig', array(
            'operations' => $operations,
            'vehicule' => $vehicule,
        ));
    }

    /**
     * Crée une nouvelle opération pour le véhicule passé en paramètre.
     *
     * @Route("{idVehicule}/operations/new", name="operations_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_TECHNICIAN')")
     */
    public function operationsNewAction(Request $request, Vehicule $vehicule)
    {
        $operation = new Operation();
        // Enregistrement du créateur
        $operation->setCreateur($this->getUser());
        // Enregistrement du véhicule concerné
        $operation->setVehiculeConcerne($vehicule);

        $form = $this->createForm('AppBundle\Form\Work\OperationType', $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($operation);
            $em->flush();

            return $this->redirectToRoute('operations_show', array('idOperation' => $operation->getIdOperation()));
        }

        return $this->render('AppBundle:Work/Operation:new.html.twig', array(
            'operation' => $operation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Liste tous les problèmes indiqués du véhicule passé en paramètre.
     *
     * @Route("/{idVehicule}/problems", name="problems_index")
     * @Method("GET")
     * @param Vehicule $vehicule
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function problemesAction(Vehicule $vehicule)
    {
        $em = $this->getDoctrine()->getManager();

        $problemes = $em->getRepository('AppBundle:Work\Probleme')->findBy(array(
            'vehiculeConcerne' => $vehicule
        ));

        return $this->render('AppBundle:Work/Probleme:index.html.twig', array(
            'problemes' => $problemes,
            'vehicule' => $vehicule,
        ));
    }

    /**
     * Crée un nouveau problème pour le véhicule.
     *
     * @Route("/{idVehicule}/problems/new", name="problems_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_TECHNICIAN')")
     */
    public function problemesNewAction(Request $request, Vehicule $vehicule)
    {
        $probleme = new Probleme();
        // Enregistrement du créateur
        $probleme->setCreateur($this->getUser());

        // Enregistrement du véhicule concerné
        $probleme->setVehiculeConcerne($vehicule);

        $form = $this->createForm('AppBundle\Form\Work\ProblemeType', $probleme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($probleme);
            $em->flush();

            return $this->redirectToRoute('problems_show', array('idProbleme' => $probleme->getIdProbleme()));
        }

        return $this->render('AppBundle:Work/Probleme:new.html.twig', array(
            'probleme' => $probleme,
            'form' => $form->createView()
        ));
    }
}
