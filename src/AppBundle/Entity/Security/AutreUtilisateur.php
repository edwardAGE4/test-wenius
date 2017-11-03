<?php

namespace AppBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;

/**
 * AutreUtilisateur
 *
 * @ORM\Table(name="autre_utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Security\AutreUtilisateurRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="autre_type", type="string")
 */
class AutreUtilisateur extends Utilisateur
{

    /**
     * @var \AppBundle\Entity\Security\Administrateur 
     *
     * @ORM\ManyToOne(targetEntity="Administrateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="identifiant", nullable=false)
     * })
     */
    protected $createur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime")
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
}
