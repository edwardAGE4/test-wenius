<?php

namespace AppBundle\Entity\Work;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Groups;

/**
 * Pièce
 *
 * @ORM\Table(name="piece")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Work\PieceRepository")
 */
class Piece
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=40)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 3,
     *      max = 40
     * )
     * @Groups({"details_operation"})
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     * @Groups({"details_operation"})
     */
    private $description;

    /**
     * @var \AppBundle\Entity\Work\Operation
     *
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Work\Operation", inversedBy="pieces")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="operation_affectee", referencedColumnName="id", nullable=false)
     * })
     * @Assert\NotNull()
     */
    private $operation;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Piece
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
     * Set description
     *
     * @param string $description
     * @return Piece
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
     * Set operation
     *
     * @param \AppBundle\Entity\Work\Operation $operation
     * @return Piece
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
}
