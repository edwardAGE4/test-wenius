<?php

namespace AppBundle\Entity\Work;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

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
     * @Groups({"list_operation", "details_operation"})
     */
    private $idOperation;

    /**
     * @var \AppBundle\Entity\Security\Technicien
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Security\Technicien", inversedBy="operations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotNull()
     * @Groups({"details_operation"})
     */
    private $createur;

    /**
     * @var \AppBundle\Entity\Work\Vehicule
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Work\Vehicule", inversedBy="operations")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vehicule_concerne", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotNull()
     * @Groups({"details_operation"})
     */
    private $vehiculeConcerne;

    /**
     * @var string
     *
     * @ORM\Column(name="sujet", type="string", length=50)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      max = 50
     * )
     * @Groups({"list_operation", "details_operation"})
     */
    private $sujet;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     * @Groups({"list_operation", "details_operation"})
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date")
     * @Assert\NotBlank()
     * @Groups({"list_operation", "details_operation"})
     * )
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_prevue", type="date")
     * @Assert\NotBlank()
     * @Groups({"list_operation", "details_operation"})
     */
    private $dateFinPrevue;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_effective", type="date", nullable=true)
     * @Groups({"list_operation", "details_operation"})
     */
    private $dateFinEffective;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Groups({"list_operation", "details_operation"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     * @Groups({"list_operation", "details_operation"})
     */
    private $updatedAt;

    /**
     * @var \AppBundle\Entity\Work\Piece[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Piece", mappedBy="operation", cascade={"persist"})
     * @Assert\Valid()
     * @Groups({"details_operation"})
     */
    private $pieces;

    /**
     * @var \AppBundle\Entity\Work\Intervention[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Intervention", mappedBy="operation")
     * @Assert\Valid()
     * @Groups({"details_operation"})
     */
    private $interventions;


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
        $this->interventions = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Vérifie la validité de la date de début de l'opération.
     *
     * @return bool
     * @Assert\IsTrue(message = "La date de début ne peut être avant la date de d'achat du véhicule")
     */
    public function isDateDebutValid()
    {
        return $this->dateDebut >= $this->vehiculeConcerne->getDateAchat();
    }
    
    /**
     * Vérifie la validité des dates.
     *
     * @return bool
     * @Assert\IsTrue(message = "La date de fin prévue ne peut être avant la date de début")
     */
    public function isDatesValid()
    {
        return $this->dateFinPrevue >= $this->dateDebut;
    }

    /**
     * Vérifie la validité de la date de fin effective.
     *
     * @return bool
     * @Assert\IsTrue(message = "La date de fin effective ne peut être avant la date de début")
     */
    public function isDateFinEffectiveValid()
    {
        return $this->dateFinEffective ? $this->dateFinEffective >= $this->dateDebut : true;
    }

    /**
     * Add intervention
     *
     * @param \AppBundle\Entity\Work\Intervention $intervention
     *
     * @return Operation
     */
    public function addIntervention(\AppBundle\Entity\Work\Intervention $intervention)
    {
        $this->interventions[] = $intervention;

        return $this;
    }

    /**
     * Remove intervention
     *
     * @param \AppBundle\Entity\Work\Intervention $intervention
     */
    public function removeIntervention(\AppBundle\Entity\Work\Intervention $intervention)
    {
        $this->interventions->removeElement($intervention);
    }

    /**
     * Get interventions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterventions()
    {
        return $this->interventions;
    }

    /**
     * Vérifie la validité de la date de début de l'opération.
     *
     * @return bool
     * @Assert\IsTrue(message = "La date de début n'est pas valide. Une opération ne peut être démarrée avant l'acquisition du véhicule")
     */
    public function isDateDetectionValid()
    {
        return $this->dateDebut >= $this->vehiculeConcerne->getDateAchat();
    }

    /**
     * Vérifie la validité de la date de fin effective de l'opération lors de l'édition.
     *
     * @return bool
     * @Assert\IsTrue(message = "La date de fin n'est pas valide. Une opération ne peut prendre fin avant une intervention la concernant")
     */
    public function isFinEffectiveValid()
    {
        foreach ($this->interventions as $intervention) {
            if ($intervention->getDateIntervention() > $this->dateFinEffective)
                return false;
        }
        return true;
    }

    /**
     * Vérifie la validité de la date de fin effective de l'opération par rapport à la date du jour.
     *
     * @return bool
     * @Assert\IsTrue(message = "La date de fin n'est pas valide. Vous ne pouvez définir une date de fin effective ultérieure à la date du jour.")
     */
    public function isFinEffectiveValidWithToday()
    {
        return $this->dateFinEffective <= new \DateTime();
    }
}
