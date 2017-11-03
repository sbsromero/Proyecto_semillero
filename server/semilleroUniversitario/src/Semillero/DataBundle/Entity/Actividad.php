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
    * @ORM\ManyToOne(targetEntity="semilla_actividad", inversedBy="actividades")
    * @ORM\JoinColumn(name="semilla_actividad_id", referencedColumnName="id")
    */
    private $semilla_actividad;

    /**
    * @ORM\ManyToOne(targetEntity="TipoActividad", inversedBy="actividades")
    * @ORM\JoinColumn(name="id_tipo_actividad", referencedColumnName="id")
    * @Assert\NotBlank(message="Seleccione un tipo de actividad")
    */
    private $tipoActividad;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="string", length=255)
     */
    private $observacion;

    /**
     * @var int
     *
     * @ORM\Column(name="nota", type="integer")
     */
    private $nota;


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
     * Set nota
     *
     * @param integer $nota
     * @return Actividad
     */
    public function setNota($nota)
    {
        $this->nota = $nota;

        return $this;
    }

    /**
     * Get nota
     *
     * @return integer
     */
    public function getNota()
    {
        return $this->nota;
    }

    /**
     * Set semilla_actividad
     *
     * @param \Semillero\DataBundle\Entity\semilla_actividad $semillaActividad
     * @return Actividad
     */
    public function setSemillaActividad(\Semillero\DataBundle\Entity\semilla_actividad $semillaActividad = null)
    {
        $this->semilla_actividad = $semillaActividad;

        return $this;
    }

    /**
     * Get semilla_actividad
     *
     * @return \Semillero\DataBundle\Entity\semilla_actividad
     */
    public function getSemillaActividad()
    {
        return $this->semilla_actividad;
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
     * Set tipoActividad
     *
     * @param \Semillero\DataBundle\Entity\tipoActividad $tipoActividad
     * @return Actividad
     */
    public function setTipoActividad(\Semillero\DataBundle\Entity\tipoActividad $tipoActividad = null)
    {
        $this->tipoActividad = $tipoActividad;

        return $this;
    }

    /**
     * Get tipoActividad
     *
     * @return \Semillero\DataBundle\Entity\tipoActividad
     */
    public function getTipoActividad()
    {
        return $this->tipoActividad;
    }
}
