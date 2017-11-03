<?php

namespace AppBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;

/**
 * Administrateur
 *
 * @ORM\Table(name="administrateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Security\AdministrateurRepository")
 */
class Administrateur extends Utilisateur
{
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_ADMIN'];
    }
}
