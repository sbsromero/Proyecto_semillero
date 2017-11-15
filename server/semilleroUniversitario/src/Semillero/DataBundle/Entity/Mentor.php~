<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Semillero\DataBundle\Entity\Usuarios;

/**
* Mentor
*
* @ORM\Table(name="mentor")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\MentorRepository")
* @UniqueEntity("numeroDocumento",message="Documento ya registrado")
*/
class Mentor extends Usuarios
{
  protected $discr = 'semilla';
  /**
  * @ORM\ManyToOne(targetEntity="TipoMentor", inversedBy="mentores")
  * @ORM\JoinColumn(name="id_tipo_mentor", referencedColumnName="id")
  * @Assert\NotBlank(message="Seleccione el tipo de mentor")
  */
  private $tipoMentor;

  /**
  * @ORM\OneToMany(targetEntity="Grupo", mappedBy="mentor")
  */
  private $grupos;

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
  * Constructor
  */
  public function __construct()
  {
    $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
  * Add grupos
  *
  * @param \Semillero\DataBundle\Entity\Grupo $grupos
  * @return Mentor
  */
  public function addGrupo(\Semillero\DataBundle\Entity\Grupo $grupos)
  {
    $this->grupos[] = $grupos;

    return $this;
  }

  /**
  * Remove grupos
  *
  * @param \Semillero\DataBundle\Entity\Grupo $grupos
  */
  public function removeGrupo(\Semillero\DataBundle\Entity\Grupo $grupos)
  {
    $this->grupos->removeElement($grupos);
  }

  /**
  * Get grupos
  *
  * @return \Doctrine\Common\Collections\Collection
  */
  public function getGrupos()
  {
    return $this->grupos;
  }

  /**
  * Get discriminator
  */
  public function getDiscr()
  {
    return $this->discr;
  }
}
