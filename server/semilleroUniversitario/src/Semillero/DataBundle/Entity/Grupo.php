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
  * @ORM\ManyToOne(targetEntity="Diplomado", inversedBy="grupos")
  * @ORM\JoinColumn(name="id_diplomado", referencedColumnName="id")
  * @Assert\NotBlank(message="Seleccione diplomado al que pertenece el grupo")
  */
  private $diplomado;

  /**
  * @ORM\OneToMany(targetEntity="Semilla_Grupo", mappedBy="grupo")
  */
  private $semillas;

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
  * @ORM\ManyToOne(targetEntity="Semestre", inversedBy="grupos")
  * @ORM\JoinColumn(name="semestre_id", referencedColumnName="id")
  */
  private $semestre;

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
     * Constructor
     */
    public function __construct()
    {
        $this->fechaCreacion = new \DateTime();
        $this->semillas = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set diplomado
     *
     * @param \Semillero\DataBundle\Entity\Diplomado $diplomado
     * @return Grupo
     */
    public function setDiplomado(\Semillero\DataBundle\Entity\Diplomado $diplomado = null)
    {
        $this->diplomado = $diplomado;

        return $this;
    }

    /**
     * Get diplomado
     *
     * @return \Semillero\DataBundle\Entity\Diplomado
     */
    public function getDiplomado()
    {
        return $this->diplomado;
    }

    /**
     * Add semillas
     *
     * @param \Semillero\DataBundle\Entity\Semilla_Grupo $semillas
     * @return Grupo
     */
    public function addSemilla(\Semillero\DataBundle\Entity\Semilla_Grupo $semillas)
    {
        $this->semillas[] = $semillas;

        return $this;
    }

    /**
     * Remove semillas
     *
     * @param \Semillero\DataBundle\Entity\Semilla_Grupo $semillas
     */
    public function removeSemilla(\Semillero\DataBundle\Entity\Semilla_Grupo $semillas)
    {
        $this->semillas->removeElement($semillas);
    }

    /**
     * Get semillas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSemillas()
    {
        return $this->semillas;
    }

    /**
     * Set jornada
     *
     * @param \Semillero\DataBundle\Entity\Jornada $jornada
     * @return Grupo
     */
    public function setJornada(\Semillero\DataBundle\Entity\Jornada $jornada = null)
    {
        $this->jornada = $jornada;

        return $this;
    }

    /**
     * Get jornada
     *
     * @return \Semillero\DataBundle\Entity\Jornada
     */
    public function getJornada()
    {
        return $this->jornada;
    }

    /**
     * Set semestre
     *
     * @param \Semillero\DataBundle\Entity\Semestre $semestre
     * @return Grupo
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
