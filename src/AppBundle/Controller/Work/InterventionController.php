<?php

namespace AppBundle\Controller\Work;

use AppBundle\Entity\Work\Intervention;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Controller pour les interventions.
 *
 * @Route("interventions")
 * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_TECHNICIAN')")
 */
class InterventionController extends Controller
{
    /**
     * Affiche une intervention d'une opération.
     *
     * @Route("/{idIntervention}", name="interventions_show")
     * @Method("GET")
     * @param Intervention $intervention
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Intervention $intervention)
    {
        return $this->render('AppBundle:Work/Intervention:show.html.twig', array(
            'intervention' => $intervention,
        ));
    }
}
