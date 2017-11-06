<?php

namespace AppBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Technicien
 *
 * @ORM\Table(name="technicien")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Security\TechnicienRepository")
 */
class Technicien  extends AutreUtilisateur
{
    /**
     * @var \AppBundle\Entity\Work\Probleme[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Probleme", mappedBy="createur")
     * @Groups({"details_user"})
     */
    private $problemes;

    /**
     * @var \AppBundle\Entity\Work\Operation[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Operation", mappedBy="createur")
     * @Groups({"details_user"})
     */
    private $operations;

    /**
     * @var \AppBundle\Entity\Work\Intervention[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Intervention", mappedBy="createur")
     * @Groups({"details_user"})
     */
    private $interventions;
    
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_TECHNICIAN'];
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->problemes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add probleme
     *
     * @param \AppBundle\Entity\Work\Probleme $probleme
     *
     * @return Technicien
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
     * @return Technicien
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
     * Add intervention
     *
     * @param \AppBundle\Entity\Work\Intervention $intervention
     *
     * @return Technicien
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
}
