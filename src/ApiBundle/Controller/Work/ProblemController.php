<?php

namespace ApiBundle\Controller\Work;

use AppBundle\Entity\Work\Probleme;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller de l'api pour les problèmes
 * 
 * @Route("problems")
 */
class ProblemController extends Controller
{
    /**
     * Renvoie un problème.
     *
     * @Route("/{idProbleme}")
     * @Method("GET")
     * @param Probleme $probleme
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Probleme $probleme)
    {
        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $probleme,
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'details_problem',
                        'list_user',
                        'list_car',
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8'
                )
            );
    }
}
