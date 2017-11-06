<?php

namespace AppBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Gestionnaire
 *
 * @ORM\Table(name="gestionnaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Security\GestionnaireRepository")
 */
class Gestionnaire extends AutreUtilisateur
{
    /**
     * @var \AppBundle\Entity\Work\Vehicule[]|\Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\AppBundle\Entity\Work\Vehicule", mappedBy="createur")
     * @Groups({"details_user"})
     */
    private $vehicules;
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_MANAGER'];
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->vehicules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add vehicule
     *
     * @param \AppBundle\Entity\Work\Vehicule $vehicule
     *
     * @return Gestionnaire
     */
    public function addVehicule(\AppBundle\Entity\Work\Vehicule $vehicule)
    {
        $this->vehicules[] = $vehicule;

        return $this;
    }

    /**
     * Remove vehicule
     *
     * @param \AppBundle\Entity\Work\Vehicule $vehicule
     */
    public function removeVehicule(\AppBundle\Entity\Work\Vehicule $vehicule)
    {
        $this->vehicules->removeElement($vehicule);
    }

    /**
     * Get vehicules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVehicules()
    {
        return $this->vehicules;
    }
}
