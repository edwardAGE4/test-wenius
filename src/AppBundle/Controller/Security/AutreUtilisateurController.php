<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\Security\AutreUtilisateur;
use AppBundle\Entity\Security\Gestionnaire;
use AppBundle\Entity\Security\Technicien;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller pour les autres utilisateurs.
 *
 * @Route("users")
 * @Security("has_role('ROLE_ADMIN')")
 */
class AutreUtilisateurController extends Controller
{
    /**
     * Liste les autres utilisateurs.
     *
     * @Route("/", name="users_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:Security\AutreUtilisateur')->findAll();

        return $this->render('AppBundle:Security/User:index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Crée un nouvel utilisateur.
     *
     * @Route("/new", name="users_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new AutreUtilisateur();
        // Enregistrement du créateur
        $user->setCreateur($this->getUser());
        
        $form = $this->createForm('AppBundle\Form\Security\AutreUtilisateurType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Cryptage du mot de passe clair dans mot de passe
            $encoder = $this->get('security.password_encoder');
            $user->setMotDePasse($encoder->encodePassword($user, $user->getMotDePasseClair()));

            // Création de l'objet utilisateur à persister en base en fonction du type
            $object = null;
            if ($user->getType() == 'gestionnaire') {
                $object = new Gestionnaire();
            }
            elseif ($user->getType() == 'technicien') {
                $object = new Technicien();
            }
            // Recopie des informations entrées
            $object->copy($user);

            // Enregistrement de l'objet utilisateur
            $em = $this->getDoctrine()->getManager();
            $em->persist($object);
            $em->flush();

            return $this->redirectToRoute('users_show', array('idUtilisateur' => $object->getIdUtilisateur()));
        }

        return $this->render('AppBundle:Security/User:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Affiche les détails d'un utilisateur.
     *
     * @Route("/{idUtilisateur}", name="users_show")
     * @Method("GET")
     */
    public function showAction(AutreUtilisateur $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('AppBundle:Security/User:show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Supprime un utilisateur.
     *
     * @Route("/{idUtilisateur}", name="users_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AutreUtilisateur $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        try {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }
        catch (ForeignKeyConstraintViolationException $e) {
            $this->addFlash('error', 'Action impossible, objet lié à d\'autres objets.');
            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
        }

        return $this->redirectToRoute('users_index');
    }

    /**
     * Crée un formulaire de suppression d'utilisateur
     *
     * @param AutreUtilisateur $user
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(AutreUtilisateur $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('idUtilisateur' => $user->getIdUtilisateur())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
