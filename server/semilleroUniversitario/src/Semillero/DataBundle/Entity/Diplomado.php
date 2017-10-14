<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Diplomado
 *
 * @ORM\Table(name="diplomado")
 * @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\DiplomadoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Diplomado
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     * @Assert\NotBlank()
     *
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="Grupo", mappedBy="id")
     **/
    private $grupos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime")
     */
    private $fechaCreacion;

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
     * Set nombre
     *
     * @param string $nombre
     * @return Diplomado
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
     * Set fechaCreacion
     *
     * @param string $fechaCreacion
     * @return Diplomado
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return string
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
    * @ORM\PrePersist
    */
     public function setCreatedAtValue()
     {
         $this->fechaCreacion = new \DateTime();
     }


    /**
     * Set activo
     *
     * @param boolean $activo
     * @return Diplomado
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
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add grupos
     *
     * @param \Semillero\DataBundle\Entity\Grupo $grupos
     * @return Diplomado
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
