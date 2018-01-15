<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
* Administrador
*
* @ORM\Table(name="administrador")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\AdministradorRepository")
*/
class Administrador implements AdvancedUserInterface, \Serializable
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
  */
  private $nombres;

  /**
  * @var string
  *
  * @ORM\Column(name="apellidos", type="string", length=255)
  */
  private $apellidos;

  /**
  * @var string
  *
  * @ORM\Column(name="username", type="string", length=255, unique=true)
  */
  private $username;

  /**
  * @var \DateTime
  *
  * @ORM\Column(name="fechaRegistro", type="datetime")
  */
  private $fechaRegistro;

  /**
  * @var string
  *
  * @ORM\Column(name="password", type="string", length=255)
  */
  private $password;

  /**
  * @var string
  *
  * @ORM\Column(name="email", type="string", length=255, unique=true)
  */
  private $email;

  /**
  * @var bool
  *
  * @ORM\Column(name="activo", type="boolean")
  */
  private $activo;

  /**
  *
  *
  */
  private $perfil;


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
  * @return Administrador
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
  * @return Administrador
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
  * Set username
  *
  * @param string $username
  * @return Administrador
  */
  public function setUsername($username)
  {
    $this->username = $username;

    return $this;
  }

  /**
  * Get username
  *
  * @return string
  */
  public function getUsername()
  {
    return $this->username;
  }

  /**
  * Set fechaRegistro
  *
  * @param \DateTime $fechaRegistro
  * @return Administrador
  */
  public function setFechaRegistro($fechaRegistro)
  {
    $this->fechaRegistro = $fechaRegistro;

    return $this;
  }

  /**
  * Get fechaRegistro
  *
  * @return \DateTime
  */
  public function getFechaRegistro()
  {
    return $this->fechaRegistro;
  }

  /**
  * Set password
  *
  * @param string $password
  * @return Administrador
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
  * Set email
  *
  * @param string $email
  * @return Administrador
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
  * Set activo
  *
  * @param boolean $activo
  * @return Administrador
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
      $this->username,
      $this->password,
      $this->activo
    ));
  }
  public function unserialize($serialized)
  {
    list (
      // ...
      $this->id,
      $this->username,
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
      return array('ROLE_ADMIN');
    }
  }
