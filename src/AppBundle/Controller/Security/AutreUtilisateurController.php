<?php

namespace AppBundle\Controller\Security;

use AppBundle\Entity\Security\AutreUtilisateur;
use AppBundle\Entity\Security\Gestionnaire;
use AppBundle\Entity\Security\Technicien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:Security\AutreUtilisateur')->findBy(array(
            'deletedAt' => null
        ));

        return $this->render('AppBundle:Security/User:index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Crée un nouvel utilisateur.
     *
     * @Route("/new", name="users_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $user = new AutreUtilisateur();
        
        $form = $this->createForm('AppBundle\Form\Security\AutreUtilisateurType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Enregistrement du créateur
            $user->setCreateur($this->getUser());
            
            if ($form->isValid()) {

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
     * @param AutreUtilisateur $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(AutreUtilisateur $user)
    {
        $this->verifyUtilisateur($user);
        
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
     * @param Request $request
     * @param AutreUtilisateur $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, AutreUtilisateur $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setDeletedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();
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
        $this->verifyUtilisateur($user);
        
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('idUtilisateur' => $user->getIdUtilisateur())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Vérifie la validité de l'utilisateur sur lesquel on effectue les traitements
     *
     * @param AutreUtilisateur $utilisateur
     */
    private function verifyUtilisateur(AutreUtilisateur $utilisateur)
    {
        if ($utilisateur->getDeletedAt())
            throw new NotFoundHttpException();
    }
}
