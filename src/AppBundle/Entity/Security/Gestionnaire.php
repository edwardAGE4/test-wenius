<?php

namespace AppBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gestionnaire
 *
 * @ORM\Table(name="gestionnaire")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Security\GestionnaireRepository")
 */
class Gestionnaire extends AutreUtilisateur
{
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_MANAGER'];
    }
}
