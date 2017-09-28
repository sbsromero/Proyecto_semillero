<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
* Mentor
*
* @ORM\Table(name="mentor")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\MentorRepository")
* @UniqueEntity("email")
* @UniqueEntity("numeroDocumento")
*/
class Mentor implements AdvancedUserInterface, \Serializable
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
  * @ORM\Column(name="nombres", type="string", length=255)
  * @Assert\NotBlank(message="Por favor ingrese el nombre del mentor")
  */
  private $nombres;

  /**
  * @var string
  *
  * @ORM\Column(name="apellidos", type="string", length=255)
  * @Assert\NotBlank()
  */
  private $apellidos;

  /**
  * @ORM\ManyToOne(targetEntity="TipoDocumento", inversedBy="mentores")
  * @ORM\JoinColumn(name="id_tipo_documento", referencedColumnName="id")
  * @Assert\NotBlank(message="Seleccione un tipo de documento")
  */
  private $tipoDocumentoIdentidad;

  /**
  * @var string
  *
  * @ORM\Column(name="numeroDocumento", type="string", length=255, unique=true)
  * @Assert\NotBlank()
  */
  private $numeroDocumento;

  /**
  * @var \DateTime
  *
  * @ORM\Column(name="fechaNacimiento", type="datetime")
  * @Assert\NotBlank()
  */
  private $fechaNacimiento;

  /**
  * @var string
  *
  * @ORM\Column(name="direccion", type="string", length=255)
  * @Assert\NotBlank()
  */
  private $direccion;

  /**
  * @var string
  *
  * @ORM\Column(name="municipio", type="string", length=255)
  * @Assert\NotBlank()
  */
  private $municipio;

  /**
  * @var string
  *
  * @ORM\Column(name="departamento", type="string", length=255)
  * @Assert\NotBlank()
  */
  private $departamento;

  /**
  * @var string
  *
  * @ORM\Column(name="email", type="string", length=255)
  * @Assert\NotBlank()
  * @Assert\Email()
  */
  private $email;

  /**
  * @var string
  *
  * @ORM\Column(name="numeroMovil", type="string", length=255)
  * @Assert\NotBlank()
  */
  private $numeroMovil;

  /**
  * @var string
  *
  * @ORM\Column(name="numeroTelefono", type="string", length=255)
  */
  private $numeroTelefono;

  /**
  * @var string
  *
  * @ORM\Column(name="password", type="string", length=255)
  */
  private $password;

  /**
  * @var string
  *
  * @ORM\Column(name="eps", type="string", length=255)
  * @Assert\NotBlank()
  */
  private $eps;

  /**
  * @var string
  *
  * @ORM\Column(name="tipoSangre", type="string", length=255)
  * @Assert\NotBlank()
  */
  private $tipoSangre;

  /**
  * @var bool
  *
  * @ORM\Column(name="activo", type="boolean")
  */
  private $activo;

  /**
  * @var string
  *
  * @ORM\Column(name="tipoMentor", type="string", length=255)
  * @Assert\NotBlank()
  */
  private $tipoMentor;


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
  * Set nombres
  *
  * @param string $nombres
  * @return Mentor
  */
  public function setNombres($nombres)
  {
    $this->nombres = $nombres;

    return $this;
  }

  /**
  * Get nombres
  *
  * @return string
  */
  public function getNombres()
  {
    return $this->nombres;
  }

  /**
  * Set apellidos
  *
  * @param string $apellidos
  * @return Mentor
  */
  public function setApellidos($apellidos)
  {
    $this->apellidos = $apellidos;

    return $this;
  }

  /**
  * Get apellidos
  *
  * @return string
  */
  public function getApellidos()
  {
    return $this->apellidos;
  }


  /**
  * Set numeroDocumento
  *
  * @param string $numeroDocumento
  * @return Mentor
  */
  public function setNumeroDocumento($numeroDocumento)
  {
    $this->numeroDocumento = $numeroDocumento;

    return $this;
  }

  /**
  * Get numeroDocumento
  *
  * @return string
  */
  public function getNumeroDocumento()
  {
    return $this->numeroDocumento;
  }

  /**
  * Set fechaNacimiento
  *
  * @param \DateTime $fechaNacimiento
  * @return Mentor
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
  * @return Mentor
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
  * Set municipio
  *
  * @param string $municipio
  * @return Mentor
  */
  public function setMunicipio($municipio)
  {
    $this->municipio = $municipio;

    return $this;
  }

  /**
  * Get municipio
  *
  * @return string
  */
  public function getMunicipio()
  {
    return $this->municipio;
  }

  /**
  * Set departamento
  *
  * @param string $departamento
  * @return Mentor
  */
  public function setDepartamento($departamento)
  {
    $this->departamento = $departamento;

    return $this;
  }

  /**
  * Get departamento
  *
  * @return string
  */
  public function getDepartamento()
  {
    return $this->departamento;
  }

  /**
  * Set email
  *
  * @param string $email
  * @return Mentor
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
  * Set numeroMovil
  *
  * @param string $numeroMovil
  * @return Mentor
  */
  public function setNumeroMovil($numeroMovil)
  {
    $this->numeroMovil = $numeroMovil;

    return $this;
  }

  /**
  * Get numeroMovil
  *
  * @return string
  */
  public function getNumeroMovil()
  {
    return $this->numeroMovil;
  }

  /**
  * Set numeroTelefono
  *
  * @param string $numeroTelefono
  * @return Mentor
  */
  public function setNumeroTelefono($numeroTelefono)
  {
    $this->numeroTelefono = $numeroTelefono;

    return $this;
  }

  /**
  * Get numeroTelefono
  *
  * @return string
  */
  public function getNumeroTelefono()
  {
    return $this->numeroTelefono;
  }

  /**
  * Set password
  *
  * @param string $password
  * @return Mentor
  */
  public function setPassword($password)
  {
    $this->password = $password;

    return $this;
  }

  /**
  * Get password
  *
  * @return string
  */
  public function getPassword()
  {
    return $this->password;
  }

  /**
  * Set eps
  *
  * @param string $eps
  * @return Mentor
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
  * Set tipoSangre
  *
  * @param string $tipoSangre
  * @return Mentor
  */
  public function setTipoSangre($tipoSangre)
  {
    $this->tipoSangre = $tipoSangre;

    return $this;
  }

  /**
  * Get tipoSangre
  *
  * @return string
  */
  public function getTipoSangre()
  {
    return $this->tipoSangre;
  }

  /**
  * Set activo
  *
  * @param boolean $activo
  * @return Mentor
  */
  public function setActivo($activo)
  {
    $this->activo = $activo;

    return $this;
  }

  /**
  * Get activo
  *
  * @return boolean
  */
  public function getActivo()
  {
    return $this->activo;
  }

  /**
  * Set tipoMentor
  *
  * @param string $tipoMentor
  * @return Mentor
  */
  public function setTipoMentor($tipoMentor)
  {
    $this->tipoMentor = $tipoMentor;

    return $this;
  }

  /**
  * Get tipoMentor
  *
  * @return string
  */
  public function getTipoMentor()
  {
    return $this->tipoMentor;
  }

  /**
  * Set tipoDocumentoIdentidad
  *
  * @param \Semillero\DataBundle\Entity\TipoDocumento $tipoDocumentoIdentidad
  * @return Mentor
  */
  public function setTipoDocumentoIdentidad(\Semillero\DataBundle\Entity\TipoDocumento $tipoDocumentoIdentidad = null)
  {
    $this->tipoDocumentoIdentidad = $tipoDocumentoIdentidad;

    return $this;
  }

  /**
  * Get tipoDocumentoIdentidad
  *
  * @return \Semillero\DataBundle\Entity\TipoDocumento
  */
  public function getTipoDocumentoIdentidad()
  {
    return $this->tipoDocumentoIdentidad;
  }

  //---------------Metodos AdvancedUserInterface---------------
  public function isAccountNonExpired()
  {
    return true;
  }

  public function isAccountNonLocked()
  {
    return true;
  }

  public function isCredentialsNonExpired()
  {
    return true;
  }

  public function getUsername()
  {
    return $this->numeroDocumento;
  }

  public function isEnabled()
  {
    return $this->activo;
  }

  // serialize and unserialize must be updated - see below
  public function serialize()
  {
    return serialize(array(
      // ...
      $this->id,
      $this->numeroDocumento,
      $this->password,
      $this->activo
    ));
  }

  public function unserialize($serialized)
  {
    list (
      // ...
      $this->id,
      $this->numeroDocumento,
      $this->password,
      $this->activo
      ) = unserialize($serialized);
  }

  public function eraseCredentials()
  {
  }

  public function getSalt()
  {
    return null;
  }

  public function getRoles()
  {
    return array('ROLE_ADMINISTRATIVO');
  }
}
