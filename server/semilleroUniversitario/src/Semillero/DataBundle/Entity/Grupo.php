<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Grupo
 *
 * @ORM\Table(name="grupo")
 * @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\GrupoRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Grupo
{
  /**
  * @ORM\ManyToOne(targetEntity="Mentor", inversedBy="grupos")
  * @ORM\JoinColumn(name="mentor_id", referencedColumnName="id")
  */
    protected $mentor;

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
     * @Assert\NotBlank(message="Por favor ingrese el nombre del grupo")
     */
    private $nombre;

    /**
    * @ORM\ManyToOne(targetEntity="Jornada", inversedBy="grupos")
    * @ORM\JoinColumn(name="id_jornada", referencedColumnName="id")
    * @Assert\NotBlank(message="Seleccione jornada del grupo")
    */
    private $jornada;

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
     * @return Grupo
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
     * Set jornada
     *
     * @param string $jornada
     * @return Grupo
     */
    public function setJornada($jornada)
    {
        $this->jornada = $jornada;

        return $this;
    }

    /**
     * Get jornada
     *
     * @return string
     */
    public function getJornada()
    {
        return $this->jornada;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     * @return Grupo
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
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
     * @return Grupo
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
     * @return Grupo
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
}
