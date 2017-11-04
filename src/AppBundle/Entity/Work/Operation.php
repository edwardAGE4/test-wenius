<?php

namespace AppBundle\Entity\Work;

use Doctrine\ORM\Mapping as ORM;

/**
 * Opération
 *
 * @ORM\Table(name="operation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Work\OperationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Operation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $idOperation;

    /**
     * @var \AppBundle\Entity\Security\Technicien
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Security\Technicien")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * })
     */
    private $createur;

    /**
     * @var \AppBundle\Entity\Work\Vehicule
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Work\Vehicule")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vehicule_concerne", referencedColumnName="id", nullable=false)
     * })
     */
    private $vehiculeConcerne;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=50)
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_prevue", type="date")
     */
    private $dateFinPrevue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_effective", type="date", nullable=true)
     */
    private $dateFinEffective;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \AppBundle\Entity\Work\Piece[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Piece", mappedBy="operation", cascade={"persist"})
     */
    private $pieces;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getIdOperation()
    {
        return $this->idOperation;
    }

    /**
     * Set sujet
     *
     * @param string $sujet
     * @return Operation
     */
    public function setSujet($sujet)
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Get sujet
     *
     * @return string 
     */
    public function getSujet()
    {
        return $this->sujet;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Operation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     * @return Operation
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime 
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFinPrevue
     *
     * @param \DateTime $dateFinPrevue
     * @return Operation
     */
    public function setDateFinPrevue($dateFinPrevue)
    {
        $this->dateFinPrevue = $dateFinPrevue;

        return $this;
    }

    /**
     * Get dateFinPrevue
     *
     * @return \DateTime 
     */
    public function getDateFinPrevue()
    {
        return $this->dateFinPrevue;
    }

    /**
     * Set dateFinEffective
     *
     * @param \DateTime $dateFinEffective
     * @return Operation
     */
    public function setDateFinEffective($dateFinEffective)
    {
        $this->dateFinEffective = $dateFinEffective;

        return $this;
    }

    /**
     * Get dateFinEffective
     *
     * @return \DateTime 
     */
    public function getDateFinEffective()
    {
        return $this->dateFinEffective;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Operation
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Operation
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createur
     *
     * @param \AppBundle\Entity\Security\Technicien $createur
     * @return Operation
     */
    public function setCreateur(\AppBundle\Entity\Security\Technicien $createur)
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * Get createur
     *
     * @return \AppBundle\Entity\Security\Technicien 
     */
    public function getCreateur()
    {
        return $this->createur;
    }

    /**
     * Set vehiculeConcerne
     *
     * @param \AppBundle\Entity\Work\Vehicule $vehiculeConcerne
     * @return Operation
     */
    public function setVehiculeConcerne(\AppBundle\Entity\Work\Vehicule $vehiculeConcerne)
    {
        $this->vehiculeConcerne = $vehiculeConcerne;

        return $this;
    }

    /**
     * Get vehiculeConcerne
     *
     * @return \AppBundle\Entity\Work\Vehicule 
     */
    public function getVehiculeConcerne()
    {
        return $this->vehiculeConcerne;
    }

    /**
     * Add pieces
     *
     * @param \AppBundle\Entity\Work\Piece $pieces
     * @return Operation
     */
    public function addPiece(\AppBundle\Entity\Work\Piece $pieces)
    {
        $pieces->setOperation($this);
        $this->pieces[] = $pieces;

        return $this;
    }

    /**
     * Remove pieces
     *
     * @param \AppBundle\Entity\Work\Piece $pieces
     */
    public function removePiece(\AppBundle\Entity\Work\Piece $pieces)
    {
        $this->pieces->removeElement($pieces);
    }

    /**
     * Get pieces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPieces()
    {
        return $this->pieces;
    }

    /**
     * Constructeur initialisant la liste des pièces d'une opération
     */
    public function __construct()
    {
        $this->pieces = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Instructions exécutées juste avant enregistrement de la nouvelle opération.
     *
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Instructions exécutées juste avant toute mise à jour.
     *
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
