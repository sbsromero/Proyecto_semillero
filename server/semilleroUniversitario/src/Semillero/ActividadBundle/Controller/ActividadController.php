<?php

namespace Semillero\ActividadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ActividadController extends Controller
{

  /**
  * @Route("/usuarios/gestionActividades/{idGrupo}", name="gestionActividadesUsuarios")
  */
  public function gestionActividades ($idGrupo, Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);
      $segmentos = $grupo->getSegmentos();

      return $this->render('ActividadBundle:Usuarios:administracionActividades.html.twig', array(
        'grupo' => $grupo,
        'segmentos' => $segmentos
      ));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/usuarios/getListActividades{idSegmento}", name="getListActividadesUsuarios")
  */
  public function getListActividades($idSegmento,Request $request){
    if($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $segmento = $em->getRepository('DataBundle:Segmento')->find($idSegmento);
      $encuentros = $segmento->getEncuentros();
      $actividades = $this->getActividades($encuentros);

      return $this->render('ActividadBundle:Usuarios:listaActividades.html.twig',array(
        'actividades' => $actividades
      ));
    }
    return $this->redirectToRoute('gestionActividades');
  }

  //Metodo que obtiene todas las actividades registradas en un grupo
  private function getActividades($encuentros){
    $actividades = array();
    foreach ($encuentros as $encuentro) {
      array_push($actividades,$encuentro->getActividades());
    }
    return $actividades;
  }
}
