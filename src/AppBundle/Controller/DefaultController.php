<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * Accueil et tableau de bord de l'application
     * 
     * @Route("/", name="app_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * Retourne une brique du tableau de bord : Opérations
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function operationsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $operationsEnCours = $em->getRepository('AppBundle:Work\Operation')->getEnCours();
        $operationsFutures = $em->getRepository('AppBundle:Work\Operation')->getFutures();

        return $this->render('AppBundle:Default:operations.html.twig', array(
            'en_cours' => $operationsEnCours,
            'futures' => $operationsFutures
        ));
    }

    /**
     * Retourne une brique du tableau de bord : Véhicules
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function vehiculesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $vehiculesEnCours = $em->getRepository('AppBundle:Work\Vehicule')->getEnCours();
        $vehiculesFutures = $em->getRepository('AppBundle:Work\Vehicule')->getFutures();

        dump($vehiculesEnCours);

        return $this->render('AppBundle:Default:vehicules.html.twig', array(
            'en_cours' => $vehiculesEnCours,
            'futures' => $vehiculesFutures
        ));
    }
}
