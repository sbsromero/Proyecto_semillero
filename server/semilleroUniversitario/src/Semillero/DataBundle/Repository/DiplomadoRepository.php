<?php

namespace Semillero\DataBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * DiplomadoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DiplomadoRepository extends EntityRepository
{
  //Retorna todos los diplomados
  public function findAll()
  {
    return $this->findBy(array(), array('nombre' => 'DESC'));
  }

  //Metodo que lista todos los diplomados, tambien es utilizado para cuando
  //Se realizan busquedas
  //@param $querySearch : busqueda a realizar
  public function getAllDiplomados($querySearch)
  {
    return $this->getEntityManager()
    ->createQuery("SELECT d FROM DataBundle:Diplomado d LEFT JOIN d.grupos dg WHERE upper(d.nombre)
    like upper(:querySearch)
    OR
    ( CAST(YEAR(d.fechaCreacion) as string) like :querySearch OR
      CAST(MONTH(d.fechaCreacion) as string) like :querySearch OR
      CAST(DAY(d.fechaCreacion) as string) like :querySearch OR
      CONCAT(CONCAT('0',CAST(DAY(d.fechaCreacion) as string)),'-',
      CAST(MONTH(d.fechaCreacion) as string),'-',
      CAST(YEAR(d.fechaCreacion) as string)) like :querySearch)")
    ->setParameter('querySearch','%'.$querySearch.'%');
  }
}
