<?php

namespace AppBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;

/**
 * Technicien
 *
 * @ORM\Table(name="technicien")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Security\TechnicienRepository")
 */
class Technicien  extends AutreUtilisateur
{
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_TECHNICIAN'];
    }
}
