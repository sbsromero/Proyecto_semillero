<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
* semilla_actividad
*
* @ORM\Table(name="semilla_actividad")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\semilla_actividadRepository")
*/
class semilla_actividad
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
  * @ORM\ManyToOne(targetEntity="Semilla", inversedBy="semilla_actividades")
  * @ORM\JoinColumn(name="semilla_id", referencedColumnName="id")
  */
  private $semilla;


  /**
  * @ORM\OneToMany(targetEntity="Actividad", mappedBy="semilla_actividad")
  */
  private $actividades;


  /**
  * @var bool
  *
  * @ORM\Column(name="asistio", type="boolean")
  */
  private $asistio;

  /**
  * @var \DateTime
  *
  * @ORM\Column(name="fechaRealizacion", type="datetime")
  */
  private $fechaRealizacion;

  /**
  * @var string
  *
  * @ORM\Column(name="observacion", type="string", length=255)
  */
  private $observacion;

  /**
  * @var int
  *
  * @ORM\Column(name="notaAsistencia", type="integer")
  */
  private $notaAsistencia;


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
  * Set asistio
  *
  * @param boolean $asistio
  * @return semilla_actividad
  */
  public function setAsistio($asistio)
  {
    $this->asistio = $asistio;

    return $this;
  }

  /**
  * Get asistio
  *
  * @return boolean
  */
  public function getAsistio()
  {
    return $this->asistio;
  }

  /**
  * Set fechaRealizacion
  *
  * @param \DateTime $fechaRealizacion
  * @return semilla_actividad
  */
  public function setFechaRealizacion($fechaRealizacion)
  {
    $this->fechaRealizacion = $fechaRealizacion;

    return $this;
  }

  /**
  * Get fechaRealizacion
  *
  * @return \DateTime
  */
  public function getFechaRealizacion()
  {
    return $this->fechaRealizacion;
  }

  /**
  * Set observacion
  *
  * @param string $observacion
  * @return semilla_actividad
  */
  public function setObservacion($observacion)
  {
    $this->observacion = $observacion;

    return $this;
  }

  /**
  * Get observacion
  *
  * @return string
  */
  public function getObservacion()
  {
    return $this->observacion;
  }

  /**
  * Set notaAsistencia
  *
  * @param integer $notaAsistencia
  * @return semilla_actividad
  */
  public function setNotaAsistencia($notaAsistencia)
  {
    $this->notaAsistencia = $notaAsistencia;

    return $this;
  }

  /**
  * Get notaAsistencia
  *
  * @return integer
  */
  public function getNotaAsistencia()
  {
    return $this->notaAsistencia;
  }

  /**
  * Set semilla
  *
  * @param \Semillero\DataBundle\Entity\Semilla $semilla
  * @return semilla_actividad
  */
  public function setSemilla(\Semillero\DataBundle\Entity\Semilla $semilla = null)
  {
    $this->semilla = $semilla;

    return $this;
  }

  /**
  * Get semilla
  *
  * @return \Semillero\DataBundle\Entity\Semilla
  */
  public function getSemilla()
  {
    return $this->semilla;
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
  * @param \Semillero\DataBundle\Entity\Actividad $actividades
  * @return semilla_actividad
  */
  public function addActividade(\Semillero\DataBundle\Entity\Actividad $actividades)
  {
    $this->actividades[] = $actividades;

    return $this;
  }

  /**
  * Remove actividades
  *
  * @param \Semillero\DataBundle\Entity\Actividad $actividades
  */
  public function removeActividade(\Semillero\DataBundle\Entity\Actividad $actividades)
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
