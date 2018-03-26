<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cuenta
 *
 * @ORM\Table(name="cuenta")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CuentaRepository")
 */
class Cuenta
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
     * @ORM\Column(name="Apellido", type="string", length=255)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="Nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=255)
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="mail", type="string", length=255)
     */
    private $mail;

    /**
     * @var string
     *
     * @ORM\Column(name="tieneMail", type="boolean", length=255)
     */
    private $tieneMail;

    /**
     * @var string
     *
     * @ORM\Column(name="tipoCorreo", type="string", length=255)
     */
    private $tipoCorreo;

    /**
     * Many Features have One Product.
     * @ORM\ManyToOne(targetEntity="Jurisdiccion", inversedBy="cuentas")
     * @ORM\JoinColumn(name="jurisdiccion_id", referencedColumnName="id")
     */
    private $jurisdiccion;

    /**
     * @var string
     *
     * @ORM\Column(name="ticket", type="string", length=255)
     */
    private $ticket;


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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Cuenta
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return Cuenta
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Cuenta
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Cuenta
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set tieneMail
     *
     * @param boolean $tieneMail
     *
     * @return Cuenta
     */
    public function setTieneMail($tieneMail)
    {
        $this->tieneMail = $tieneMail;

        return $this;
    }

    /**
     * Get tieneMail
     *
     * @return boolean
     */
    public function getTieneMail()
    {
        return $this->tieneMail;
    }

    /**
     * Set tipoCorreo
     *
     * @param string $tipoCorreo
     *
     * @return Cuenta
     */
    public function setTipoCorreo($tipoCorreo)
    {
        $this->tipoCorreo = $tipoCorreo;

        return $this;
    }

    /**
     * Get tipoCorreo
     *
     * @return string
     */
    public function getTipoCorreo()
    {
        return $this->tipoCorreo;
    }



    /**
     * Set jurisdiccion
     *
     * @param \AppBundle\Entity\Jurisdiccion $jurisdiccion
     *
     * @return Cuenta
     */
    public function setJurisdiccion(\AppBundle\Entity\Jurisdiccion $jurisdiccion = null)
    {
        $this->jurisdiccion = $jurisdiccion;

        return $this;
    }

    /**
     * Get jurisdiccion
     *
     * @return \AppBundle\Entity\Jurisdiccion
     */
    public function getJurisdiccion()
    {
        return $this->jurisdiccion;
    }

    /**
     * Set ticket
     *
     * @param string $ticket
     *
     * @return Cuenta
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return string
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
