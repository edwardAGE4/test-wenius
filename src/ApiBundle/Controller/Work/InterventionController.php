<?php

namespace ApiBundle\Controller\Work;

use AppBundle\Entity\Work\Intervention;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller de l'api pour les interventions
 * 
 * @Route("interventions")
 */
class InterventionController extends Controller
{
    /**
     * Renvoie une intervention.
     *
     * @Route("/{idIntervention}")
     * @Method("GET")
     * @param Intervention $intervention
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Intervention $intervention)
    {
        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $intervention,
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'details_intervention',
                        'list_user',
                        'list_car',
                        'list_image',
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8'
                )
            );
    }
}
