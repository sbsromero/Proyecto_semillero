<?php

namespace Semillero\ServicesBundle\Services;

class PaginationService {

  //Metodo que permite paginar las vistas
  //@param $elements => elementos a ser paginados
  //@param $page => la pagina que sera paginada
  //@param $itemsForPage => items que se quieren tener por pagina
  public function paginate($paginator,$elements,$page,$itemsForPage){
    $pagination = $paginator->paginate(
      $elements, $page,$itemsForPage
    );
  }

}

?>
