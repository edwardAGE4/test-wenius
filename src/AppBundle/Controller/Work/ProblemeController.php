<?php

namespace AppBundle\Controller\Work;

use AppBundle\Entity\Work\Probleme;
use AppBundle\Entity\Work\Vehicule;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller pour les problèmes.
 * Prend en paramètre le véhicule concerné.
 *
 * @Route("cars/{idVehicule}/problems")
 * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_TECHNICIAN')")
 */
class ProblemeController extends Controller
{
    /**
     * Liste tous les problèmes indiqués du véhicule.
     *
     * @Route("/", name="problems_index")
     * @Method("GET")
     * @param Vehicule $vehicule
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Vehicule $vehicule)
    {
        $this->verifyVehicule($vehicule);
        
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
     * @Route("/new", name="problems_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_TECHNICIAN')")
     * @param Request $request
     * @param Vehicule $vehicule
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Vehicule $vehicule)
    {
        $this->verifyVehicule($vehicule);
        
        $probleme = new Probleme();
        $form = $this->createForm('AppBundle\Form\Work\ProblemeType', $probleme);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Enregistrement du créateur
            $probleme->setCreateur($this->getUser());
            
            // Enregistrement du véhicule concerné
            $probleme->setVehiculeConcerne($vehicule);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($probleme);
                $em->flush();

                return $this->redirectToRoute('problems_show', array(
                        'idVehicule' => $vehicule->getIdVehicule(),
                        'idProbleme' => $probleme->getIdProbleme()
                ));
            }
        }

        return $this->render('AppBundle:Work/Probleme:new.html.twig', array(
            'probleme' => $probleme,
            'form' => $form->createView(),
            'vehicule' => $vehicule,
        ));
    }

    /**
     * Affiche un problème d'un véhicule.
     *
     * @Route("/{idProbleme}", name="problems_show")
     * @Method("GET")
     * @param Vehicule $vehicule
     * @param Probleme $probleme
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Vehicule $vehicule, Probleme $probleme)
    {
        $this->verifyVehicule($vehicule);
        
        return $this->render('AppBundle:Work/Probleme:show.html.twig', array(
            'probleme' => $probleme,
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
