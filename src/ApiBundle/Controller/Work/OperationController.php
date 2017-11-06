<?php

namespace ApiBundle\Controller\Work;

use AppBundle\Entity\Work\Operation;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller de l'api pour les opérations
 *
 * @Route("operations")
 */
class OperationController extends Controller
{
    /**
     * Renvoie une opération.
     *
     * @Route("/{idOperation}")
     * @Method("GET")
     * @param Operation $operation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Operation $operation)
    {
        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $operation,
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'details_operation',
                        'list_user',
                        'list_car',
                        'list_intervention',
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8'
                )
            );
    }

    /**
     * Renvoie la liste des interventions d'une opération.
     *
     * @Route("/{idVehicule}/operations")
     * @Method("GET")
     * @param Operation $operation
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function operationsAction(Operation $operation)
    {
        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $operation->getInterventions(),
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'list_intervention',
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8'
                )
            );
    }
}
