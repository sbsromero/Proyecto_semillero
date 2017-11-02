<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Semillero\DataBundle\Entity\Usuarios;

/**
* Semilla
*
* @ORM\Table(name="semilla")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\SemillaRepository")
* @UniqueEntity("numeroDocumento",message="Documento ya registrado")
*/
class Semilla extends Usuarios
{

  protected $discr = 'semilla';
  /**
  * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="semillas")
  * @ORM\JoinColumn(name="grupo_id", referencedColumnName="id")
  */
    protected $grupo;

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

    /**
     * Set grupo
     *
     * @param \Semillero\DataBundle\Entity\Grupo $grupo
     * @return Semilla
     */
    public function setGrupo(\Semillero\DataBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \Semillero\DataBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }

    /**
    * Get discriminator
    */
    public function getDiscr()
    {
      return $this->discr;
    }
}
