<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Encuentro
 *
 * @ORM\Table(name="encuentro")
 * @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\EncuentroRepository")
 */
class Encuentro
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
    * @ORM\OneToMany(targetEntity="Actividad", mappedBy="Encuentro")
    */
    private $actividades;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroEncuentro", type="integer", nullable=true)
     */
    private $numeroEncuentro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRealizacion", type="datetime", nullable=true)
     */
    private $fechaRealizacion;


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
     * Set numeroEncuentro
     *
     * @param integer $numeroEncuentro
     * @return Encuentro
     */
    public function setNumeroEncuentro($numeroEncuentro)
    {
        $this->numeroEncuentro = $numeroEncuentro;

        return $this;
    }

    /**
     * Get numeroEncuentro
     *
     * @return integer
     */
    public function getNumeroEncuentro()
    {
        return $this->numeroEncuentro;
    }

    /**
     * Set fechaRealizacion
     *
     * @param \DateTime $fechaRealizacion
     * @return Encuentro
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
     * @return Encuentro
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
