<?php

namespace AppBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

/**
 * AutreUtilisateur
 *
 * @ORM\Table(name="autre_utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Security\AutreUtilisateurRepository")
 */
class AutreUtilisateur extends Utilisateur
{
    /**
     * @var \AppBundle\Entity\Security\Administrateur 
     *
     * @ORM\ManyToOne(targetEntity="Administrateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotNull()
     * @Groups({"details_user"})
     */
    protected $createur;

    /**
     * Type de l'utilisateur à enregistrer
     *
     * @var string
     * @Assert\Choice({"gestionnaire", "technicien"})
     * @Groups({"list_user", "details_user"})
     */
    protected $typeUtilisateur;

    /**
     * Set createur
     *
     * @param \AppBundle\Entity\Security\Administrateur $createur
     * @return AutreUtilisateur
     */
    public function setCreateur(\AppBundle\Entity\Security\Administrateur $createur)
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * Get createur
     *
     * @return \AppBundle\Entity\Security\Administrateur 
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return AutreUtilisateur
     */
    public function setType($type)
    {
        $this->typeUtilisateur = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->typeUtilisateur;
    }

    /**
     * Recopie d'un utilisateur.
     * 
     * @param AutreUtilisateur $utilisateur
     */
    public function copy(AutreUtilisateur $utilisateur)
    {
        $this->nom = $utilisateur->nom;
        $this->prenom = $utilisateur->prenom;
        $this->identifiant = $utilisateur->identifiant;
        $this->motDePasse = $utilisateur->motDePasse;
        $this->createur = $utilisateur->createur;
    }
}
