<?php

namespace ApiBundle\Controller\Work;

use AppBundle\Entity\Work\Vehicule;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller de l'api pour les véhicules
 * 
 * @Route("/cars")
 */
class CarsController extends Controller
{
    /**
     * Renvoie la liste des véhicules.
     *
     * @Route("/")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cars = $em->getRepository('AppBundle:Work\Vehicule')->findAll();

        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $cars,
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'list_car',
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8')
            );
    }

    /**
     * Renvoie un véhicule.
     *
     * @Route("/{idVehicule}")
     * @Method("GET")
     * @param Vehicule $car
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Vehicule $car)
    {
        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $car,
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'details_car',
                        'list_user',
                        'list_operation',
                        'list_problem'
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8'
                )
            );
    }

    /**
     * Renvoie la liste des opérations d'un véhicule.
     *
     * @Route("/{idVehicule}/operations")
     * @Method("GET")
     * @param Vehicule $car
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function operationsAction(Vehicule $car)
    {
        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $car->getOperations(),
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'list_operation',
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8'
                )
            );
    }

    /**
     * Renvoie la liste des problèmes d'un véhicule.
     *
     * @Route("/{idVehicule}/problems")
     * @Method("GET")
     * @param Vehicule $car
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function problemsAction(Vehicule $car)
    {
        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $car->getProblemes(),
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'list_problem',
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8'
                )
            );
    }
}
