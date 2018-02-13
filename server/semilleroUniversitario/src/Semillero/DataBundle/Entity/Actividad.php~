<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
* Actividad
*
* @ORM\Table(name="actividad")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\ActividadRepository")
*/
class Actividad
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
  * @ORM\ManyToOne(targetEntity="Encuentro", inversedBy="actividades")
  * @ORM\JoinColumn(name="encuentro_id", referencedColumnName="id")
  */
  protected $encuentro;

  /**
  * @ORM\OneToMany(targetEntity="semilla_actividad", mappedBy="actividad")
  * @ORM\JoinColumn(name="semilla_id", referencedColumnName="id")
  */
  private $semillas;

  /**
  * @ORM\ManyToOne(targetEntity="TipoActividad", inversedBy="actividades")
  * @ORM\JoinColumn(name="tipo_actividad_id", referencedColumnName="id")
  * @Assert\NotBlank(message="Seleccione un tipo de actividad")
  */
  private $tipoActividad;

  /**
  * @var string
  *
  * @ORM\Column(name="nombre", type="string", length=255)
  * @Assert\NotBlank(message="Ingrese un nombre para la actividad")
  */
  private $nombre;

  /**
  * @var string
  *
  * @ORM\Column(name="descripcion", type="string", length=255)
  * @Assert\NotBlank(message="Ingrese una descripción para la actividad")
  */
  private $descripcion;

  /**
  * @var \DateTime
  *
  * @ORM\Column(name="fechaRealizacion", type="datetime")
  */
  private $fechaRealizacion;

  /**
  * @var \DateTime
  *
  * @ORM\Column(name="fechaRegistro", type="datetime")
  */
  private $fechaRegistro;

  /**
  * @var string
  *
  * @ORM\Column(name="observacion", type="string", length=255, nullable=true)
  */
  private $observacion;

  // /**
  // * @var int
  // *
  // * @ORM\Column(name="nota", type="integer")
  // */
  // private $nota;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fechaRegistro = new \DateTime('now', new \DateTimeZone('America/Bogota'));
        $this->semillas = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Actividad
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Actividad
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaRealizacion
     *
     * @param \DateTime $fechaRealizacion
     * @return Actividad
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
     * @return Actividad
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
     * Set encuentro
     *
     * @param \Semillero\DataBundle\Entity\Encuentro $encuentro
     * @return Actividad
     */
    public function setEncuentro(\Semillero\DataBundle\Entity\Encuentro $encuentro = null)
    {
        $this->encuentro = $encuentro;

        return $this;
    }

    /**
     * Get encuentro
     *
     * @return \Semillero\DataBundle\Entity\Encuentro
     */
    public function getEncuentro()
    {
        return $this->encuentro;
    }

    /**
     * Add semillas
     *
     * @param \Semillero\DataBundle\Entity\semilla_actividad $semillas
     * @return Actividad
     */
    public function addSemilla(\Semillero\DataBundle\Entity\semilla_actividad $semillas)
    {
        $this->semillas[] = $semillas;

        return $this;
    }

    /**
     * Remove semillas
     *
     * @param \Semillero\DataBundle\Entity\semilla_actividad $semillas
     */
    public function removeSemilla(\Semillero\DataBundle\Entity\semilla_actividad $semillas)
    {
        $this->semillas->removeElement($semillas);
    }

    /**
     * Get semillas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSemillas()
    {
        return $this->semillas;
    }

    /**
     * Set tipoActividad
     *
     * @param \Semillero\DataBundle\Entity\TipoActividad $tipoActividad
     * @return Actividad
     */
    public function setTipoActividad(\Semillero\DataBundle\Entity\TipoActividad $tipoActividad = null)
    {
        $this->tipoActividad = $tipoActividad;

        return $this;
    }

    /**
     * Get tipoActividad
     *
     * @return \Semillero\DataBundle\Entity\TipoActividad
     */
    public function getTipoActividad()
    {
        return $this->tipoActividad;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return Actividad
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
}
