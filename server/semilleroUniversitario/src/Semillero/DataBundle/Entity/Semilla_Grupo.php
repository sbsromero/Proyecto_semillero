<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Semilla_Grupo
 *
 * @ORM\Table(name="semilla_grupo")
 * @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\Semilla_GrupoRepository")
 */
class Semilla_Grupo
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
    * @ORM\ManyToOne(targetEntity="Semilla", inversedBy="grupos")
    * @ORM\JoinColumn(name="id_semilla", referencedColumnName="id")
    */
    private $semilla;

    /**
    * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="semillas")
    * @ORM\JoinColumn(name="id_grupo", referencedColumnName="id")
    */
    private $grupo;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="fecha_asignacion", type="datetime")
    */
    private $fechaAsignacion;

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
     * Set fechaAsignacion
     *
     * @param \DateTime $fechaAsignacion
     * @return Semilla_Grupo
     */
    public function setFechaAsignacion($fechaAsignacion)
    {
        $this->fechaAsignacion = $fechaAsignacion;

        return $this;
    }

    /**
     * Get fechaAsignacion
     *
     * @return \DateTime 
     */
    public function getFechaAsignacion()
    {
        return $this->fechaAsignacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Semilla_Grupo
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
     * Set semilla
     *
     * @param \Semillero\DataBundle\Entity\Semilla $semilla
     * @return Semilla_Grupo
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
     * Set grupo
     *
     * @param \Semillero\DataBundle\Entity\Grupo $grupo
     * @return Semilla_Grupo
     */
    public function setGrupo(\Semillero\DataBundle\Entity\Grupo $grupo = null)
    {
        $this->grupo = $grupo;

        return $this;
    }

    /**
     * Get grupo
     *
     * @return \Semillero\DataBundle\Entity\Grupo 
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
}
