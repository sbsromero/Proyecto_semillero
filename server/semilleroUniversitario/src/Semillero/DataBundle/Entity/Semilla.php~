<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Semilla
 *
 * @ORM\Table(name="semilla")
 * @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\SemillaRepository")
 */
class Semilla
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=255)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=255, unique=true)
     */
    private $dni;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaNacimiento", type="datetime")
     */
    private $fechaNacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="isFacebook", type="boolean")
     */
    private $isFacebook;

    /**
     * @var string
     *
     * @ORM\Column(name="emailFacebook", type="string", length=255)
     */
    private $emailFacebook;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=255)
     */
    private $celular;

    /**
     * @var bool
     *
     * @ORM\Column(name="isWhatsapp", type="boolean")
     */
    private $isWhatsapp;

    /**
     * @var string
     *
     * @ORM\Column(name="gradoEscolarActual", type="string", length=255)
     */
    private $gradoEscolarActual;

    /**
     * @var string
     *
     * @ORM\Column(name="colegio", type="string", length=255)
     */
    private $colegio;

    /**
     * @var string
     *
     * @ORM\Column(name="enfermedades", type="string", length=255)
     */
    private $enfermedades;

    /**
     * @var string
     *
     * @ORM\Column(name="eps", type="string", length=255)
     */
    private $eps;

    /**
     * @var string
     *
     * @ORM\Column(name="acudienteUno", type="string", length=255)
     */
    private $acudienteUno;

    /**
    * @var string
    *
    * @ORM\Column(name="direccionAcudienteUno", type="string", length=255)
    */
    private $direccionAcudienteUno;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonoAcudiente", type="string", length=255)
     */
    private $telefonoAcudienteUno;

    /**
     * @var string
     *
     * @ORM\Column(name="acudienteDos", type="string", length=255)
     */
    private $acudienteDos;

    /**
     * @var string
     *
     * @ORM\Column(name="direccionAcudienteDos", type="string", length=255)
     */
    private $direccionAcudienteDos;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonoAcudienteDos", type="string", length=255)
     */
    private $telefonoAcudienteDos;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="string", length=255)
     */
    private $observaciones;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Semilla
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
     * Set apellido
     *
     * @param string $apellido
     * @return Semilla
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
     * Set dni
     *
     * @param string $dni
     * @return Semilla
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
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Semilla
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Semilla
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Semilla
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isFacebook
     *
     * @param boolean $isFacebook
     * @return Semilla
     */
    public function setIsFacebook($isFacebook)
    {
        $this->isFacebook = $isFacebook;

        return $this;
    }

    /**
     * Get isFacebook
     *
     * @return boolean
     */
    public function getIsFacebook()
    {
        return $this->isFacebook;
    }

    /**
     * Set emailFacebook
     *
     * @param string $emailFacebook
     * @return Semilla
     */
    public function setEmailFacebook($emailFacebook)
    {
        $this->emailFacebook = $emailFacebook;

        return $this;
    }

    /**
     * Get emailFacebook
     *
     * @return string
     */
    public function getEmailFacebook()
    {
        return $this->emailFacebook;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Semilla
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Semilla
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set isWhatsapp
     *
     * @param boolean $isWhatsapp
     * @return Semilla
     */
    public function setIsWhatsapp($isWhatsapp)
    {
        $this->isWhatsapp = $isWhatsapp;

        return $this;
    }

    /**
     * Get isWhatsapp
     *
     * @return boolean
     */
    public function getIsWhatsapp()
    {
        return $this->isWhatsapp;
    }

    /**
     * Set gradoEscolarActual
     *
     * @param string $gradoEscolarActual
     * @return Semilla
     */
    public function setGradoEscolarActual($gradoEscolarActual)
    {
        $this->gradoEscolarActual = $gradoEscolarActual;

        return $this;
    }

    /**
     * Get gradoEscolarActual
     *
     * @return string
     */
    public function getGradoEscolarActual()
    {
        return $this->gradoEscolarActual;
    }

    /**
     * Set colegio
     *
     * @param string $colegio
     * @return Semilla
     */
    public function setColegio($colegio)
    {
        $this->colegio = $colegio;

        return $this;
    }

    /**
     * Get colegio
     *
     * @return string
     */
    public function getColegio()
    {
        return $this->colegio;
    }

    /**
     * Set enfermedades
     *
     * @param string $enfermedades
     * @return Semilla
     */
    public function setEnfermedades($enfermedades)
    {
        $this->enfermedades = $enfermedades;

        return $this;
    }

    /**
     * Get enfermedades
     *
     * @return string
     */
    public function getEnfermedades()
    {
        return $this->enfermedades;
    }

    /**
     * Set eps
     *
     * @param string $eps
     * @return Semilla
     */
    public function setEps($eps)
    {
        $this->eps = $eps;

        return $this;
    }

    /**
     * Get eps
     *
     * @return string
     */
    public function getEps()
    {
        return $this->eps;
    }

    /**
     * Set acudienteUno
     *
     * @param string $acudienteUno
     * @return Semilla
     */
    public function setAcudienteUno($acudienteUno)
    {
        $this->acudienteUno = $acudienteUno;

        return $this;
    }

    /**
     * Get acudienteUno
     *
     * @return string
     */
    public function getAcudienteUno()
    {
        return $this->acudienteUno;
    }

    /**
     * Set direccionAcudienteUno
     *
     * @param string $direccionAcudienteUno
     * @return Semilla
     */
    public function setDireccionAcudienteUno($direccionAcudienteUno)
    {
        $this->direccionAcudienteUno = $direccionAcudienteUno;

        return $this;
    }

    /**
     * Get direccionAcudienteUno
     *
     * @return string
     */
    public function getDireccionAcudienteUno()
    {
        return $this->direccionAcudienteUno;
    }

    /**
     * Set telefonoAcudienteUno
     *
     * @param string $telefonoAcudienteUno
     * @return Semilla
     */
    public function setTelefonoAcudienteUno($telefonoAcudienteUno)
    {
        $this->telefonoAcudienteUno = $telefonoAcudienteUno;

        return $this;
    }

    /**
     * Get telefonoAcudienteUno
     *
     * @return string
     */
    public function getTelefonoAcudienteUno()
    {
        return $this->telefonoAcudienteUno;
    }

    /**
     * Set acudienteDos
     *
     * @param string $acudienteDos
     * @return Semilla
     */
    public function setAcudienteDos($acudienteDos)
    {
        $this->acudienteDos = $acudienteDos;

        return $this;
    }

    /**
     * Get acudienteDos
     *
     * @return string
     */
    public function getAcudienteDos()
    {
        return $this->acudienteDos;
    }

    /**
     * Set direccionAcudienteDos
     *
     * @param string $direccionAcudienteDos
     * @return Semilla
     */
    public function setDireccionAcudienteDos($direccionAcudienteDos)
    {
        $this->direccionAcudienteDos = $direccionAcudienteDos;

        return $this;
    }

    /**
     * Get direccionAcudienteDos
     *
     * @return string
     */
    public function getDireccionAcudienteDos()
    {
        return $this->direccionAcudienteDos;
    }

    /**
     * Set telefonoAcudienteDos
     *
     * @param string $telefonoAcudienteDos
     * @return Semilla
     */
    public function setTelefonoAcudienteDos($telefonoAcudienteDos)
    {
        $this->telefonoAcudienteDos = $telefonoAcudienteDos;

        return $this;
    }

    /**
     * Get telefonoAcudienteDos
     *
     * @return string
     */
    public function getTelefonoAcudienteDos()
    {
        return $this->telefonoAcudienteDos;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Semilla
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }
}
