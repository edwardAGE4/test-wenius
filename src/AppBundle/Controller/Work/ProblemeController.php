<?php

namespace AppBundle\Controller\Work;

use AppBundle\Entity\Work\Probleme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller pour les problèmes.
 *
 * @Route("problems")
 * @Security("has_role('ROLE_MANAGER') or has_role('ROLE_TECHNICIAN')")
 */
class ProblemeController extends Controller
{
    /**
     * Affiche un problème.
     *
     * @Route("/{idProbleme}", name="problems_show")
     * @Method("GET")
     * @param Probleme $probleme
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Probleme $probleme)
    {
        return $this->render('AppBundle:Work/Probleme:show.html.twig', array(
            'probleme' => $probleme,
        ));
    }
}
