<?php

namespace AppBundle\Entity\Work;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

/**
 * Intervention
 *
 * @ORM\Table(name="intervention")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Work\InterventionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Intervention
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"list_intervention", "details_intervention"})
     */
    private $idIntervention;

    /**
     * @var \AppBundle\Entity\Work\Operation
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Work\Operation", inversedBy="intervensions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operation", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotNull()
     * @Assert\Valid()
     * @Groups({"details_intervention"})
     */
    private $operation;

    /**
     * @var \AppBundle\Entity\Security\Technicien
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Security\Technicien", inversedBy="interventions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotNull()
     * @Groups({"details_intervention"})
     */
    private $createur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_intervention", type="date")
     * @Assert\NotBlank()
     * @Groups({"list_intervention", "details_intervention"})
     */
    private $dateIntervention;

    /**
     * @var string
     *
     * @ORM\Column(name="notes", type="text")
     * @Assert\NotBlank()
     * @Groups({"list_intervention", "details_intervention"})
     */
    private $notes;

    /**
     * @var \AppBundle\Entity\Media\Image[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Media\Image", mappedBy="intervention", cascade={"persist"})
     * @Assert\Valid()
     * @Groups({"details_intervention"})
     */
    private $images;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Groups({"list_intervention", "details_intervention"})
     */
    private $createdAt;


    /**
     * Get idIntervention
     *
     * @return integer 
     */
    public function getIdIntervention()
    {
        return $this->idIntervention;
    }

    /**
     * Set dateIntervention
     *
     * @param \DateTime $dateIntervention
     * @return Intervention
     */
    public function setDateIntervention($dateIntervention)
    {
        $this->dateIntervention = $dateIntervention;

        return $this;
    }

    /**
     * Get dateIntervention
     *
     * @return \DateTime 
     */
    public function getDateIntervention()
    {
        return $this->dateIntervention;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Intervention
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Intervention
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
     * Set operation
     *
     * @param \AppBundle\Entity\Work\Operation $operation
     * @return Intervention
     */
    public function setOperation(\AppBundle\Entity\Work\Operation $operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return \AppBundle\Entity\Work\Operation 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set createur
     *
     * @param \AppBundle\Entity\Security\Technicien $createur
     * @return Intervention
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
     * Add images
     *
     * @param \AppBundle\Entity\Media\Image $images
     * @return Intervention
     */
    public function addImage(\AppBundle\Entity\Media\Image $images)
    {
        $images->setIntervention($this);
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \AppBundle\Entity\Media\Image $images
     */
    public function removeImage(\AppBundle\Entity\Media\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Instructions exécutées juste avant enregistrement de la nouvelle intervention.
     *
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }
    /**
     * Constructeur initialisant la liste d'images
     */
    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Vérifie la validité de la date de l'intervention.
     *
     * @return bool
     * @Assert\IsTrue(message = "La date de l'intervention n'est pas valide. Une intervention ne peut être effectuée hors de la période de l'opération à laquelle elle est liée")
     */
    public function isDateInterventionValid()
    {
        if ($this->dateIntervention >= $this->getOperation()->getDateDebut()) {
            if ($this->getOperation()->getDateFinEffective() != null) {
                return $this->dateIntervention <= $this->getOperation()->getDateFinEffective();
            }
            else {
                return true;
            }
        }
        else {
            return false;
        }
    }
}
