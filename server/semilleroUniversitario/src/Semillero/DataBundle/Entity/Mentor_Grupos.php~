<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mentor_Grupos
 *
 * @ORM\Table(name="mentor_grupos")
 * @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\Mentor_GruposRepository")
 */
class Mentor_Grupos
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAsignacion", type="datetime")
     */
    private $fechaAsignacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaDesasignacion", type="datetime")
     */
    private $fechaDesasignacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;
    
    /**
    * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="grupos")
    * @ORM\JoinColumn(name="id_mentor", referencedColumnName="id")
    */
    private $mentor;

    /**
    * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="mentor")
    * @ORM\JoinColumn(name="id_grupo", referencedColumnName="id")
    */
    private $grupo;


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
     * @return Mentor_Grupos
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
     * Set fechaDesasignacion
     *
     * @param \DateTime $fechaDesasignacion
     * @return Mentor_Grupos
     */
    public function setFechaDesasignacion($fechaDesasignacion)
    {
        $this->fechaDesasignacion = $fechaDesasignacion;

        return $this;
    }

    /**
     * Get fechaDesasignacion
     *
     * @return \DateTime
     */
    public function getFechaDesasignacion()
    {
        return $this->fechaDesasignacion;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Mentor_Grupos
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
     * Set mentor
     *
     * @param \Semillero\DataBundle\Entity\Mentor $mentor
     * @return Mentor_Grupos
     */
    public function setMentor(\Semillero\DataBundle\Entity\Mentor $mentor = null)
    {
        $this->mentor = $mentor;

        return $this;
    }

    /**
     * Get mentor
     *
     * @return \Semillero\DataBundle\Entity\Mentor
     */
    public function getMentor()
    {
        return $this->mentor;
    }

    /**
     * Set grupo
     *
     * @param \Semillero\DataBundle\Entity\Grupo $grupo
     * @return Mentor_Grupos
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
