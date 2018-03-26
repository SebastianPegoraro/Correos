<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Jurisdiccion
 *
 * @ORM\Table(name="jurisdiccion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JurisdiccionRepository")
 */
class Jurisdiccion
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    // ...
    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="Cuenta", mappedBy="jurisdiccion")
     */
    private $cuentas;
    // ...

    public function __construct() {
        $this->cuentas = new ArrayCollection();
    }


    public function __toString(){
      return $this->name;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Jurisdiccion
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     *
     * @return Jurisdiccion
     */
    public function addCuenta(\AppBundle\Entity\Cuenta $cuenta)
    {
        $this->cuentas[] = $cuenta;

        return $this;
    }

    /**
     * Remove cuenta
     *
     * @param \AppBundle\Entity\Cuenta $cuenta
     */
    public function removeCuenta(\AppBundle\Entity\Cuenta $cuenta)
    {
        $this->cuentas->removeElement($cuenta);
    }

    /**
     * Get cuentas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCuentas()
    {
        return $this->cuentas;
    }
}
