<?php

namespace AppBundle\Entity\Work;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\Groups;

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
     * @Groups({"list_car", "details_car"})
     */
    private $idVehicule;
    
    /**
     * @var \AppBundle\Entity\Security\Gestionnaire
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Security\Gestionnaire", inversedBy="vehicules")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotNull()
     * @Groups({"details_car"})
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
     * @Groups({"list_car", "details_car"})
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
     * @Groups({"list_car", "details_car"})
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
     * @Groups({"list_car", "details_car"})
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
     * @Groups({"list_car", "details_car"})
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_achat", type="date")
     * @Assert\NotBlank()
     * @Groups({"list_car", "details_car"})
     */
    private $dateAchat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \AppBundle\Entity\Work\Probleme[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Probleme", mappedBy="vehiculeConcerne")
     * @Groups({"details_car"})
     */
    private $problemes;

    /**
     * @var \AppBundle\Entity\Work\Operation[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Operation", mappedBy="vehiculeConcerne")
     * @Groups({"details_car"})
     */
    private $operations;


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
     * Constructor
     */
    public function __construct()
    {
        $this->problemes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->operations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add probleme
     *
     * @param \AppBundle\Entity\Work\Probleme $probleme
     *
     * @return Vehicule
     */
    public function addProbleme(\AppBundle\Entity\Work\Probleme $probleme)
    {
        $this->problemes[] = $probleme;

        return $this;
    }

    /**
     * Remove probleme
     *
     * @param \AppBundle\Entity\Work\Probleme $probleme
     */
    public function removeProbleme(\AppBundle\Entity\Work\Probleme $probleme)
    {
        $this->problemes->removeElement($probleme);
    }

    /**
     * Get problemes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProblemes()
    {
        return $this->problemes;
    }

    /**
     * Add operation
     *
     * @param \AppBundle\Entity\Work\Operation $operation
     *
     * @return Vehicule
     */
    public function addOperation(\AppBundle\Entity\Work\Operation $operation)
    {
        $this->operations[] = $operation;

        return $this;
    }

    /**
     * Remove operation
     *
     * @param \AppBundle\Entity\Work\Operation $operation
     */
    public function removeOperation(\AppBundle\Entity\Work\Operation $operation)
    {
        $this->operations->removeElement($operation);
    }

    /**
     * Get operations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOperations()
    {
        return $this->operations;
    }

    /**
     * Vérifie la validité de la date de'achat du véhicule.
     *
     * @return bool
     * @Assert\IsTrue(message = "Vous ne pouvez enregistrer de véhicule que vous n'avez pas encore acquis")
     */
    public function isDateDebutValid()
    {
        return $this->dateAchat <= new \DateTime();
    }
}
