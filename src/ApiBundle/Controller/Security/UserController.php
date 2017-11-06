<?php

namespace ApiBundle\Controller\Security;

use AppBundle\Entity\Security\AutreUtilisateur;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller de l'api pour les utilisateurs
 * 
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * Renvoie la liste des utilisateurs.
     *
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:Security\AutreUtilisateur')->findAll();

        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $users,
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'list_user'
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8'
                )
            );
    }

    /**
     * Renvoie un utilisateur.
     *
     * @Route("/{idUtilisateur}")
     * @Method("GET")
     * @param AutreUtilisateur $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(AutreUtilisateur $user)
    {
        $serializer = $this->get('jms_serializer');

        return
            new Response(
                $serializer->serialize(
                    $user,
                    'json',
                    SerializationContext::create()->setGroups(array(
                        'details_user',
                        'list_car',
                        'list_problem',
                        'list_operation',
                        'list_intervention'
                    ))
                ),
                200,
                array(
                    'Content-Type' => 'application/json; charset=UTF-8'
                )
            );
    }
}
