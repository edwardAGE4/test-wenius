<?php

namespace AppBundle\Entity\Work;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Véhicule
 *
 * @ORM\Table(name="vehicule")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Work\VehiculeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity("immatriculation")
 */
class Vehicule
{
    /**
     * Id auto incrément des véhicules
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idVehicule;
    
    /**
     * @var \AppBundle\Entity\Security\Gestionnaire
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Security\Gestionnaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotNull()
     */
    private $createur;

    /**
     * @var string
     *
     * @ORM\Column(name="immatriculation", type="string", length=10, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      max = 10
     * )
     */
    private $immatriculation;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=25)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 1,
     *      max = 25
     * )
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="modele", type="string", length=15)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 1,
     *      max = 10
     * )
     */
    private $modele;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=15)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 15
     * )
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_achat", type="date")
     * @Assert\NotBlank()
     */
    private $dateAchat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    private $deletedAt;


    /**
     * Get idVehicule
     *
     * @return integer
     */
    public function getIdVehicule()
    {
        return $this->idVehicule;
    }
    
    /**
     * Set immatriculation
     *
     * @param string $immatriculation
     * @return Vehicule
     */
    public function setImmatriculation($immatriculation)
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    /**
     * Get immatriculation
     *
     * @return string 
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
    }

    /**
     * Set marque
     *
     * @param string $marque
     * @return Vehicule
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return string 
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * Set modele
     *
     * @param string $modele
     * @return Vehicule
     */
    public function setModele($modele)
    {
        $this->modele = $modele;

        return $this;
    }

    /**
     * Get modele
     *
     * @return string 
     */
    public function getModele()
    {
        return $this->modele;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Vehicule
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
     * Set dateAchat
     *
     * @param \DateTime $dateAchat
     * @return Vehicule
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * Get dateAchat
     *
     * @return \DateTime 
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Vehicule
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
     * @return Vehicule
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
     * Set createur
     *
     * @param \AppBundle\Entity\Security\Gestionnaire $createur
     * @return Vehicule
     */
    public function setCreateur(\AppBundle\Entity\Security\Gestionnaire $createur)
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * Get createur
     *
     * @return \AppBundle\Entity\Security\Gestionnaire 
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * Instructions exécutées juste avant enregistrement du nouveau véhicule.
     *
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Vérifie la validité de l'utilisateur affecté.
     *
     * @return bool
     * @Assert\IsTrue(message = "Ce compte n'existe pas")
     */
    public function isCreateurValid()
    {
        return $this->createur ? ($this->createur->getDeletedAt() ? false : true) : false;
    }
}
