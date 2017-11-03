<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* TipoActividad
*
* @ORM\Table(name="tipo_actividad")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\TipoActividadRepository")
*/
class TipoActividad
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
  * @ORM\OneToMany(targetEntity="actividad", mappedBy="tipoActividad")
  **/
  private $actividades;


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
  * @return TipoActividad
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
    $this->actividades = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
  * Add actividades
  *
  * @param \Semillero\DataBundle\Entity\actividad $actividades
  * @return TipoActividad
  */
  public function addActividade(\Semillero\DataBundle\Entity\actividad $actividades)
  {
    $this->actividades[] = $actividades;

    return $this;
  }

  /**
  * Remove actividades
  *
  * @param \Semillero\DataBundle\Entity\actividad $actividades
  */
  public function removeActividade(\Semillero\DataBundle\Entity\actividad $actividades)
  {
    $this->actividades->removeElement($actividades);
  }

  /**
  * Get actividades
  *
  * @return \Doctrine\Common\Collections\Collection
  */
  public function getActividades()
  {
    return $this->actividades;
  }
}
