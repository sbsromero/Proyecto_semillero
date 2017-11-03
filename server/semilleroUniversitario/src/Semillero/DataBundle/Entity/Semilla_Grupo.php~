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
    * @ORM\ManyToOne(targetEntity="Semilla", inversedBy="semilla_grupos")
    * @ORM\JoinColumn(name="semilla_id", referencedColumnName="id")
    */
    private $semilla;

    /**
    * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="semilla_grupos")
    * @ORM\JoinColumn(name="grupo_id", referencedColumnName="id")
    */
    private $grupo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaInicio", type="datetime")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="datetime")
     */
    private $fechaFin;

    /**
     * @var int
     *
     * @ORM\Column(name="totalUgenios", type="integer")
     */
    private $totalUgenios;


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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return Semilla_Grupo
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     * @return Semilla_Grupo
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set totalUgenios
     *
     * @param integer $totalUgenios
     * @return Semilla_Grupo
     */
    public function setTotalUgenios($totalUgenios)
    {
        $this->totalUgenios = $totalUgenios;

        return $this;
    }

    /**
     * Get totalUgenios
     *
     * @return integer
     */
    public function getTotalUgenios()
    {
        return $this->totalUgenios;
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
