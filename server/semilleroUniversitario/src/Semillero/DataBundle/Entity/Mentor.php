<?php

namespace Semillero\DataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Semillero\DataBundle\Entity\Usuarios;

/**
* Mentor
*
* @ORM\Table(name="mentor")
* @ORM\Entity(repositoryClass="Semillero\DataBundle\Repository\MentorRepository")
* @UniqueEntity("email")
* @UniqueEntity("numeroDocumento")
*/
class Mentor extends Usuarios
{

  /**
  * @var string
  *
  * @ORM\Column(name="tipoMentor", type="string", length=255)
  * @Assert\NotBlank()
  */
  private $tipoMentor;

  /**
  * Set tipoMentor
  *
  * @param string $tipoMentor
  * @return Mentor
  */
  public function setTipoMentor($tipoMentor)
  {
    $this->tipoMentor = $tipoMentor;

    return $this;
  }

  /**
  * Get tipoMentor
  *
  * @return string
  */
  public function getTipoMentor()
  {
    return $this->tipoMentor;
  }
}
