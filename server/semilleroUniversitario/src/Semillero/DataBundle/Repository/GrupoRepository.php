<?php

namespace Semillero\DataBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * GrupoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GrupoRepository extends EntityRepository
{
  //Retorna todos los grupos
  public function findAll()
  {
    return $this->findBy(array(), array('nombre' => 'DESC'));
  }
}
