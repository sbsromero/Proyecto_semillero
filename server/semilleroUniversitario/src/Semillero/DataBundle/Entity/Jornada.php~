<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
* Jornada
*
* @ORM\Table(name="jornada")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\JornadaRepository")
*/
class Jornada
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
  * @ORM\Column(name="nombre", type="string", length=6, nullable=true, unique=true)
  */
  private $nombre;

  /**
  * @ORM\OneToMany(targetEntity="Grupo", mappedBy="id")
  **/
  private $grupos;


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
  * @return Jornada
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
  * @return Jornada
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
}
