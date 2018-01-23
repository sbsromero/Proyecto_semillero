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
  * @ORM\ManyToOne(targetEntity="Semilla", inversedBy="actividades")
  * @ORM\JoinColumn(name="semilla_id", referencedColumnName="id")
  */
  private $semilla;

  /**
  * @ORM\ManyToOne(targetEntity="Actividad", inversedBy="semillas")
  * @ORM\JoinColumn(name="actividad_id", referencedColumnName="id")
  */
  private $actividad;

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
  * @ORM\Column(name="nota_asistencia", type="integer")
  */
  private $notaAsistencia;

  /**
  * @var int
  *
  * @ORM\Column(name="nota_actividad", type="integer")
  */
  private $notaActividad;


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
     * Set actividad
     *
     * @param \Semillero\DataBundle\Entity\Actividad $actividad
     * @return semilla_actividad
     */
    public function setActividad(\Semillero\DataBundle\Entity\Actividad $actividad = null)
    {
        $this->actividad = $actividad;

        return $this;
    }

    /**
     * Get actividad
     *
     * @return \Semillero\DataBundle\Entity\Actividad
     */
    public function getActividad()
    {
        return $this->actividad;
    }

    /**
     * Set notaActividad
     *
     * @param integer $notaActividad
     * @return semilla_actividad
     */
    public function setNotaActividad($notaActividad)
    {
        $this->notaActividad = $notaActividad;

        return $this;
    }

    /**
     * Get notaActividad
     *
     * @return integer 
     */
    public function getNotaActividad()
    {
        return $this->notaActividad;
    }
}
