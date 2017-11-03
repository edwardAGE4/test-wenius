<?php

namespace AppBundle\Controller\Work;

use AppBundle\Entity\Work\Vehicule;
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
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $vehicules = $em->getRepository('AppBundle:Work\Vehicule')->findBy(array(
            'deletedAt' => null
        ));

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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $vehicule = new Vehicule();
        $form = $this->createForm('AppBundle\Form\Work\VehiculeType', $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrement du créateur
            $vehicule->setCreateur($this->getUser());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicule);
            $em->flush();

            return $this->redirectToRoute('cars_show', array('id' => $vehicule->getId()));
        }

        return $this->render('AppBundle:Work/Vehicule:new.html.twig', array(
            'vehicule' => $vehicule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'un véhicule.
     *
     * @Route("/{id}", name="cars_show")
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
     * @Route("/{id}", name="cars_delete")
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
            $vehicule->setDeletedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();
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
            ->setAction($this->generateUrl('cars_delete', array('id' => $vehicule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
