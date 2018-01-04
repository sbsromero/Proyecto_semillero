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

  // /**
  //  * @ORM\ManyToMany(targetEntity="Grupo",mappedBy="segmentos")
  //  */
  /**
  * @ORM\ManyToOne(targetEntity="Grupo", inversedBy="segmentos")
  * @ORM\JoinColumn(name="id_grupo", referencedColumnName="id")
  */
  private $grupo;

  /**
  * @ORM\OneToMany(targetEntity="Encuentro", mappedBy="segmento")
  */
  private $encuentros;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->encuentros = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add encuentros
     *
     * @param \Semillero\DataBundle\Entity\Encuentro $encuentros
     * @return Segmento
     */
    public function addEncuentro(\Semillero\DataBundle\Entity\Encuentro $encuentros)
    {
        $this->encuentros[] = $encuentros;

        return $this;
    }

    /**
     * Remove encuentros
     *
     * @param \Semillero\DataBundle\Entity\Encuentro $encuentros
     */
    public function removeEncuentro(\Semillero\DataBundle\Entity\Encuentro $encuentros)
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
     * Set grupo
     *
     * @param \Semillero\DataBundle\Entity\Grupo $grupo
     * @return Segmento
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
