<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* Segmento
*
* @ORM\Table(name="segmento")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\SegmentoRepository")
*/
class Segmento
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
  * @ORM\Column(name="numeroSegmento", type="integer")
  */
  private $numeroSegmento;

  /**
  * @var bool
  *
  * @ORM\Column(name="activo", type="boolean")
  */
  private $activo;

  /**
  * @ORM\OneToMany(targetEntity="Grupo",mappedBy="segmento")
  */
  private $grupos;

  /**
  * @ORM\OneToMany(targetEntity="Encuentro", mappedBy="segmento")
  */
  private $encuentros;

  /**
  * @ORM\ManyToOne(targetEntity="Semestre", inversedBy="segmentos")
  * @ORM\JoinColumn(name="semestre_id",referencedColumnName="id")
  */
  private $semestre;


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
  * Set numeroSegmento
  *
  * @param integer $numeroSegmento
  * @return Segmento
  */
  public function setNumeroSegmento($numeroSegmento)
  {
    $this->numeroSegmento = $numeroSegmento;

    return $this;
  }

  /**
  * Get numeroSegmento
  *
  * @return integer
  */
  public function getNumeroSegmento()
  {
    return $this->numeroSegmento;
  }

  /**
  * Set activo
  *
  * @param boolean $activo
  * @return Segmento
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
  * Constructor
  */
  public function __construct()
  {
    $this->encuentros = new \Doctrine\Common\Collections\ArrayCollection();
  }

  /**
  * Add encuentros
  *
  * @param \Semillero\DataBundle\Entity\Actividad $encuentros
  * @return Segmento
  */
  public function addEncuentro(\Semillero\DataBundle\Entity\Actividad $encuentros)
  {
    $this->encuentros[] = $encuentros;

    return $this;
  }

  /**
  * Remove encuentros
  *
  * @param \Semillero\DataBundle\Entity\Actividad $encuentros
  */
  public function removeEncuentro(\Semillero\DataBundle\Entity\Actividad $encuentros)
  {
    $this->encuentros->removeElement($encuentros);
  }

  /**
  * Get encuentros
  *
  * @return \Doctrine\Common\Collections\Collection
  */
  public function getEncuentros()
  {
    return $this->encuentros;
  }

    /**
     * Add grupos
     *
     * @param \Semillero\DataBundle\Entity\Grupo $grupos
     * @return Segmento
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

    /**
     * Set semestre
     *
     * @param \Semillero\DataBundle\Entity\Semestre $semestre
     * @return Segmento
     */
    public function setSemestre(\Semillero\DataBundle\Entity\Semestre $semestre = null)
    {
        $this->semestre = $semestre;

        return $this;
    }

    /**
     * Get semestre
     *
     * @return \Semillero\DataBundle\Entity\Semestre 
     */
    public function getSemestre()
    {
        return $this->semestre;
    }
}