<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;


/**
* @ORM\Entity
* @ORM\Table(name="usuarios")
* @ORM\InheritanceType("SINGLE_TABLE")
* @ORM\DiscriminatorColumn(name="discr", type="string")
* @ORM\DiscriminatorMap({"mentor" = "Mentor", "semilla" = "Semilla"})
* @UniqueEntity("email")
*/
abstract class Usuarios implements AdvancedUserInterface, \Serializable
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
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $nombre;

  /**
  * @var string
  *
  * @ORM\Column(name="apellidos", type="string", length=255)
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $apellidos;

  /**
  * @ORM\ManyToOne(targetEntity="TipoDocumento", inversedBy="usuarios")
  * @ORM\JoinColumn(name="id_tipo_documento", referencedColumnName="id")
  * @Assert\NotBlank(message="Seleccione un tipo de documento")
  */
  private $tipoDocumento;

  /**
  * @var string
  *
  * @ORM\Column(name="numeroDocumento", type="string", length=255)
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $numeroDocumento;

  /**
  * @var \DateTime
  *
  * @ORM\Column(name="fechaNacimiento", type="datetime")
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $fechaNacimiento;

  /**
  * @var string
  *
  * @ORM\Column(name="direccion", type="string", length=255)
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $direccion;

  /**
  * @var string
  *
  * @ORM\Column(name="municipio", type="string", length=255)
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $municipio;

  /**
  * @var string
  *
  * @ORM\Column(name="departamento", type="string", length=255)
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $departamento;

  /**
  * @var string
  *
  * @ORM\Column(name="email", type="string", length=255, unique=true)
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  * @Assert\Email()
  */
  private $email;

  /**
  * @var string
  *
  * @ORM\Column(name="numeroCelular", type="string", length=255)
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $numeroCelular;

  /**
  * @var string
  *
  * @ORM\Column(name="numeroTelefono", type="string", length=255)
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
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
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $eps;

  /**
  * @var string
  *
  * @ORM\Column(name="tipoSangre", type="string", length=255)
  * @Assert\NotBlank(message="Este campo no puede ser vacio")
  */
  private $tipoSangre;

  /**
  * @var bool
  *
  * @ORM\Column(name="activo", type="boolean")
  */
  private $activo;

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
  * @return Usuarios
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
  * Set apellidos
  *
  * @param string $apellidos
  * @return Usuarios
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
  * @return Usuarios
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
  * @return Usuarios
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
  * @return Usuarios
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
  * @return Usuarios
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
  * @return Usuarios
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
  * @return Usuarios
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
  * Set numeroCelular
  *
  * @param string $numeroCelular
  * @return Usuarios
  */
  public function setNumeroCelular($numeroCelular)
  {
    $this->numeroCelular = $numeroCelular;

    return $this;
  }

  /**
  * Get numeroCelular
  *
  * @return string
  */
  public function getNumeroCelular()
  {
    return $this->numeroCelular;
  }

  /**
  * Set numeroTelefono
  *
  * @param string $numeroTelefono
  * @return Usuarios
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
  * @return Usuarios
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
  * @return Usuarios
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
  * @return Usuarios
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
  * @return Usuarios
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
  * Set tipoDocumento
  *
  * @param \Semillero\DataBundle\Entity\TipoDocumento $tipoDocumento
  * @return Usuarios
  */
  public function setTipoDocumento(\Semillero\DataBundle\Entity\TipoDocumento $tipoDocumento = null)
  {
    $this->tipoDocumento = $tipoDocumento;

    return $this;
  }

  /**
  * Get tipoDocumento
  *
  * @return \Semillero\DataBundle\Entity\TipoDocumento
  */
  public function getTipoDocumento()
  {
    return $this->tipoDocumento;
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
    return $this->email;
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
      $this->email,
      $this->password,
      $this->activo
    ));
  }

  public function unserialize($serialized)
  {
    list (
      // ...
      $this->id,
      $this->email,
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
      return array('ROLE_'.strtoupper($this->getDiscr()));
    }

    public function getFullName()
    {
      return $this->nombre . " " . $this->apellidos;

    }

    public function getDiscr()
    {
      return $this->discr;
    }

  }
