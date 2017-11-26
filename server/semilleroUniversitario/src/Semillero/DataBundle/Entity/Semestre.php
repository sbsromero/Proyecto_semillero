<?php

namespace Semillero\DataBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Semestre
 *
 * @ORM\Table(name="semestre")
 * @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\SemestreRepository")
 */
class Semestre
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
     * @var int
     *
     * @ORM\Column(name="periodo", type="integer")
     */
    private $periodo;

    /**
     * @var bool
     *
     * @ORM\Column(name="activo", type="boolean")
     */
    private $activo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="anoSemestre", type="date")
     */
    private $anoSemestre;

    /**
    * @ORM\OneToMany(targetEntity="Grupo", mappedBy="semestre")
    */
    private $grupos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set periodo
     *
     * @param integer $periodo
     * @return Semestre
     */
    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;

        return $this;
    }

    /**
     * Get periodo
     *
     * @return integer
     */
    public function getPeriodo()
    {
        return $this->periodo;
    }

    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Semestre
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
     * Set anoSemestre
     *
     * @param \DateTime $anoSemestre
     * @return Semestre
     */
    public function setAnoSemestre($anoSemestre)
    {
        $this->anoSemestre = $anoSemestre;

        return $this;
    }

    /**
     * Get anoSemestre
     *
     * @return \DateTime
     */
    public function getAnoSemestre()
    {
        return $this->anoSemestre;
    }

    /**
     * Add grupos
     *
     * @param \Semillero\DataBundle\Entity\Grupo $grupos
     * @return Semestre
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
