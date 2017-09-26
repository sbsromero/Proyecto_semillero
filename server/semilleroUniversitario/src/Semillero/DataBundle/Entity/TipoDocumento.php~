<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TipoDocumento
 *
 * @ORM\Table(name="tipo_documento")
 * @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\TipoDocumentoRepository")
 */
class TipoDocumento
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
     * @ORM\Column(name="nombre", type="string", length=255, unique=true)
     */
    private $nombre;

    /**
   * @ORM\OneToMany(targetEntity="Mentor", mappedBy="tipoDocumentoIdentidad")
   **/
    private $mentores;

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
     * @return TipoDocumento
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
     * Constructor
     */
    public function __construct()
    {
        $this->mentores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mentores
     *
     * @param \Semillero\DataBundle\Entity\Mentor $mentores
     * @return TipoDocumento
     */
    public function addMentore(\Semillero\DataBundle\Entity\Mentor $mentores)
    {
        $this->mentores[] = $mentores;

        return $this;
    }

    /**
     * Remove mentores
     *
     * @param \Semillero\DataBundle\Entity\Mentor $mentores
     */
    public function removeMentore(\Semillero\DataBundle\Entity\Mentor $mentores)
    {
        $this->mentores->removeElement($mentores);
    }

    /**
     * Get mentores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMentores()
    {
        return $this->mentores;
    }
}
