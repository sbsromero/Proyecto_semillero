<?php

namespace Semillero\DataBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * semilla_actividadRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class semilla_actividadRepository extends EntityRepository
{
  //Metodo que retorna los registros de semillas_actividad cuando se busca
  //por el id de una actividad especifica
  public function getCalificacionesSemillas($idActividad){
    return $this->getEntityManager()
    ->createQuery("SELECT s_a FROM DataBundle:semilla_actividad s_a WHERE s_a.actividad =:idActividad")
    ->setParameter('idActividad',$idActividad)
    ->getResult();
  }

  //Metodo que retorna un registro para saber la nota de una semilla
  //en una activida que tenga el idsemilla e idactividad
  public function getRegistroDetalleActividad($idSemilla,$idActividad){
    return $this->getEntityManager()
    ->createQuery("SELECT s_a FROM DataBundle:semilla_actividad s_a where s_a.semilla =:idSemilla
    and s_a.actividad =:idActividad")
    ->setParameter('idSemilla',$idSemilla)
    ->setParameter('idActividad',$idActividad)
    ->getResult();
  }
}
