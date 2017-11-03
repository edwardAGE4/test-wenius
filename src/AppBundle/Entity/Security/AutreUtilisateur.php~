<?php

namespace AppBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;

/**
 * AutreUtilisateur
 *
 * @ORM\Table(name="autre_utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Security\AutreUtilisateurRepository")
 * @ORM\HasLifecycleCallbacks()
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
     */
    protected $createur;

    /**
     * Type de l'utilisateur à enregistrer
     *
     * @var string
     */
    protected $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

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
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return AutreUtilisateur
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return AutreUtilisateur
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Instructions exécutées juste avant enregistrement du nouvel utilisateur 
     * 
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
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

    /**
     * Renvoie faux si l'utilisateur a été supprimé, ainsi il ne peut se connecter
     *
     * @inheritDoc
     */
    public function isEnabled()
    {
        return $this->deletedAt?false:true;
    }
}
