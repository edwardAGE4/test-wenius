<?php

namespace AppBundle\Entity\Security;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\Groups;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Security\UtilisateurRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @UniqueEntity("identifiant")
 * @UniqueEntity(fields={"nom", "prenom"})
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Utilisateur implements UserInterface
{
    /**
     * Id auto incrément des utilisateurs
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"list_user", "details_user"})
     */
    protected $idUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="identifiant", type="string", length=25, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 4,
     *      max = 25
     * )
     * @Groups({"list_user", "details_user"})
     */
    protected $identifiant;

    /**
     * Mot de passe crypté
     *
     * @var string
     *
     * @ORM\Column(name="mot_de_passe", type="string", length=60)
     */
    protected $motDePasse;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=25)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 25
     * )
     * @Groups({"list_user", "details_user"})
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=25)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 25
     * )
     * @Groups({"list_user", "details_user"})
     */
    protected $prenom;

    /**
     * Mot de passe avant cryptage
     *
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 15,
     *      minMessage = "Le mot de passe doit avoir au moins 5 caractères",
     *      maxMessage = "Le mot de passe doit avoir au plus 15 caractères"
     * )
     */
    protected $motDePasseClair;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Groups({"list_user", "details_user"})
     */
    protected $createdAt;

    
    /**
     * Get idUtilisateur
     *
     * @return integer
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * Set identifiant
     *
     * @param string $identifiant
     * @return Utilisateur
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    /**
     * Get identifiant
     *
     * @return string 
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * Set motDePasse
     *
     * @param string $motDePasse
     * @return Utilisateur
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    /**
     * Get motDePasse
     *
     * @return string 
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set motDePasseClair
     *
     * @param string $motDePasseClair
     * @return Utilisateur
     */
    public function setMotDePasseClair($motDePasseClair)
    {
        $this->motDePasseClair = $motDePasseClair;

        return $this;
    }

    /**
     * Get motDePasseClair
     *
     * @return string
     */
    public function getMotDePasseClair()
    {
        return $this->motDePasseClair;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Utilisateur
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
     * @inheritDoc
     */
    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->motDePasse;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->identifiant;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Instructions exécutées juste avant enregistrement du nouvel utilisateur
     *
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new \DateTime();
    }
}
