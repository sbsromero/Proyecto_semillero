<?php

namespace Semillero\DataBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
* MentorRepository
*
* This class was generated by the Doctrine ORM. Add your own custom
* repository methods below.
*/
class MentorRepository extends EntityRepository
{
  public function recoverPass($numeroDocumento)
  {
    return $this->getEntityManager()->createQuery("SELECT m.password FROM DataBundle:Mentor m
      WHERE m.numeroDocumento = :query")->setParameter("query",$numeroDocumento)->getResult();
    }

    //Retorna todos los mentores
    public function findAll()
    {
      return $this->findBy(array(), array('nombres' => 'DESC'));
    }
  }
