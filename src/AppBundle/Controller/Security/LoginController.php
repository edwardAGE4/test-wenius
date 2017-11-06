<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\Security\Administrateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoginController
 * @package AppBundle\Controller\Security
 */
class LoginController extends Controller
{
    /**
     * @Route("/login", name="app_login")
     * @Method({"GET", "POST"})
     */
    public function loginAction()
    {
        // Une personne authentifiée ne peut s'authentifier de nouveau tant qu'elle ne s'est pas déconnectée
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('app_index');
        }

        // Si il n'existe pas d'administrateur dans la base de données alors on demande de le créer
        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository('AppBundle:Security\Administrateur')->findAll();
        if (!$admin) {
            return $this->redirectToRoute('app_first_login');
        }

        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('AppBundle:Security/Login:login.html.twig', array(
            'last_username'=>$lastUsername,
            'error'=>$error
        ));
    }

    /**
     * @Route("/loginCheck", name="app_login_check")
     */
    public function loginCheckAction()
    {
        
    }
    
    /**
     * Crée l'administrateur si il n'en existe pas
     *
     * @Route("/firstLogin", name="app_first_login")
     * @Method({"GET", "POST"})
     */
    public function firstLogin(Request $request)
    {
        // Si il existe un administrateur dans la base de données alors on ne peut plus en créer
        $em = $this->getDoctrine()->getManager();
        $admin = $em->getRepository('AppBundle:Security\Administrateur')->findAll();
        if ($admin) {
            return $this->redirectToRoute('app_login');
        }

        $user = new Administrateur();

        $form = $this->createForm('AppBundle\Form\Security\AdministrateurType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Cryptage du mot de passe clair dans mot de passe
            $encoder = $this->get('security.password_encoder');
            $user->setMotDePasse($encoder->encodePassword($user, $user->getMotDePasseClair()));

            // Enregistrement de l'objet utilisateur
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('AppBundle:Security/Login:first_login.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
}
