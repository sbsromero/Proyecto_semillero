<?php

namespace Semillero\DataBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Semilla_GrupoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class Semilla_GrupoRepository extends EntityRepository
{

  //Metodo que permite obtener un registro del Semilla_Grupo
  //donde hay un grupo activo de una semilla
  public function getGrupoAsignado($idSemilla){
    return $this->getEntityManager()
              ->createQuery('SELECT sg FROM DataBundle:Semilla_Grupo sg WHERE sg.activo = true
                and sg.semilla = :idSemilla')
              ->setParameter('idSemilla',$idSemilla)
              ->getOneOrNullResult();
  }

  //Metodo que retorna toda la cantidad de semillas que estan registradas en un grupo
  public function getCantidadSemillasPorGrupo($idGrupo){
    return $this->getEntityManager()
      ->createQuery('SELECT COUNT(sg.semilla) from DataBundle:Semilla_Grupo sg WHERE
        sg.activo = true and sg.grupo =:idGrupo')
      ->setParameter('idGrupo',$idGrupo)
      ->getOneOrNullResult();
  }
}
