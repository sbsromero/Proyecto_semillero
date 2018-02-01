<?php

namespace Semillero\ActividadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Semillero\DataBundle\Entity\Actividad;
use Semillero\DataBundle\Entity\semilla_actividad;
use Semillero\DataBundle\Form\ActividadType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

class ActividadController extends Controller
{

  /**
  * @Route("/usuarios/gestionActividades/{idGrupo}", name="gestionActividadesUsuarios")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
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
  * @Route("/usuarios/agregarActividad", name="agregarActividadUsuarios")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function agregarActividad(Request $request){
    if($request->isXmlHttpRequest()) {
      $actividad = new Actividad();
      $form = $this-> createCreateForm($actividad);
      return $this->render('ActividadBundle:Actividad:agregarActividad.html.twig',array(
        'form' =>$form->createView()));
    }
    return $this->redirectToRoute('gestionEncuentros');
  }

  //Metodo que hace el renderizado de una actividad que se va a editar
  /**
  * @Route("/usuarios/editarActividad/{idActividad}", name="editarActividadUsuarios")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function editarActividad($idActividad, Request $request){
    if($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $actividad = $em->getRepository('DataBundle:Actividad')->find($idActividad);
      $form = $this->createCreateForm($actividad);
      return $this->render('ActividadBundle:Actividad:editarActividad.html.twig',array(
        'form' => $form->createView()
      ));
    }
    return $this->redirectToRoute('indexGrupos_usuarios');
  }

  /**
  * @Route("/usuarios/modificarActividad/{idActividad}", name="modificarActividadUsuarios")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function modiciarActividadUsuarios($idActividad, Request $request){
    if($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $actividad = $em->getRepository('DataBundle:Actividad')->find($idActividad);
      $form = $this->createCreateForm($actividad);
      $form->handleRequest($request);
      if($form->isValid()){
        $em->flush();
        return new Response(Response::HTTP_OK);
      }
      return new Response($this->renderView('ActividadBundle:Actividad:editarActividad.html.twig',array(
        'form' =>$form->createView()
      )),400);
    }
    return $this->redirectToRoute('gestionActividadesUsuarios');
  }

  /**
  * @Route("/usuarios/registrarActividad", name="registrarActividadUsuarios")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  * @Method({"POST"})
  */
  public function registrarActividad(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $actividad = new Actividad();
      $form = $this->createCreateForm($actividad);
      $form->handleRequest($request);
      $idEncuentro = $request->request->get('idEncuentro');
      $em = $this->getDoctrine()->getManager();
      $encuentro = $em->getRepository('DataBundle:Encuentro')->find($idEncuentro);

      //Pentiente por asignar, fecha realizacion y guardar en la base de datos
      if($form->isValid()){
        //Verifica si el encuentro todavia esta disponible
        if($this->isEncuentroDisponible($encuentro)){
          $actividad->setFechaRealizacion($encuentro->getFechaRealizacion());
          $actividad->setEncuentro($encuentro);
          $em->persist($actividad);
          $em->flush();
          $numActividades = $em->getRepository('DataBundle:Actividad')->getActividadesEncuentor($idEncuentro);
          return new Response(json_encode(array(
            'msg' => "La actividad ha sido registrada",
            'numActividades' => count($numActividades)
          )));
        }
        return new Response("El tiempo para registrar actividades ha culminado", 404);
      }
      #Renderizamos al forumlario si existe algun problema
      return new Response($this->renderView('ActividadBundle:Actividad:agregarActividad.html.twig',array(
        'form' =>$form->createView()
      )),400);
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/usuarios/getDetalleActividad/{idActividad}", name="getDetalleActividadUsuarios")
  * @PreAuthorize("hasAnyRole('ROLE_MENTOR','ROLE_SEMILLA')")
  */
  public function getDetalleActividad($idActividad, Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $user = $this->container->get('security.context')->getToken()->getUser();
      $role = $user->getRoles()[0];

      if($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $actividad = $em->getRepository('DataBundle:Actividad')->find($idActividad);
        return $this->render('ActividadBundle:Actividad:detalleActividad.html.twig', array(
          'actividad' => $actividad
        ));
      }
      if($role == "ROLE_MENTOR"){
        return $this->redirectToRoute('indexGrupos_usuarios');
      }
      return $this->redirectToRoute('gestionAcademica');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/usuarios/getListActividades/{idSegmento}", name="getListActividadesUsuarios")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function getListActividades($idSegmento,Request $request){
    if($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $segmento = $em->getRepository('DataBundle:Segmento')->find($idSegmento);
      $encuentros = $segmento->getEncuentros();
      $actividades = $this->getActividades($encuentros);

      if(count($actividades) > 0){
        return $this->render('ActividadBundle:Usuarios:listaActividades.html.twig',array(
          'actividades' => $actividades
        ));
      }
      return new Response("Segmento sin actividades",400);
    }
    return $this->redirectToRoute('indexGrupos_usuarios');
  }

  /**
  * @Route("/usuarios/calificaciones/{segmento}/{idActividad}", name="calificacionesUsuarios")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function calificaciones($segmento,$idActividad, Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $segmento = $em->getRepository('DataBundle:Segmento')->find($segmento);
      $grupo = $segmento->getGrupo();
      $actividad = $em->getRepository('DataBundle:Actividad')->find($idActividad);
      $page = $request->query->get('pageActive');
      $pageActive = (empty($page)) ? 1 : $page ;

      $semillas = $em->getRepository('DataBundle:Semilla')->getSemillasPorGrupo($grupo->getId());

      //Metodo que recupera los registros de semilla actividad de una actividad
      $semillas_actividad = $em->getRepository('DataBundle:semilla_actividad')->getCalificacionesSemillas($idActividad);
      $calificaciones = array();
      if(!empty($semillas_actividad)){
        foreach ($semillas_actividad as $registro) {
          $calificaciones[$registro->getSemilla()->getId()] = array(
            'nota' => $registro->getNotaActividad(),
            'asistencia' => $registro->getNotaAsistencia()
          );
        }
      }

      $paginador = $this->get('knp_paginator');
      $pagination = $paginador->paginate($semillas, $pageActive, 10);
      $items = $pagination->getItems();
      $pageCount = $pagination->getPageCount();

      return $this->render('ActividadBundle:Actividad:calificaciones.html.twig', array(
        'actividad' => $actividad,
        'segmento' => $segmento,
        'grupo' => $grupo,
        'semillas' => $items,
        'calificaciones' => $calificaciones,
        'pageCount' => $pageCount
      ));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/usuarios/guardarCalificaciones/{idActividad}/{idGrupo}", name="guardarCalificaciones")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  * @Method({"POST"})
  */
  public function guardarCalificaciones($idActividad, $idGrupo,Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){

      $em = $this->getDoctrine()->getManager();
      $registros = $request->request->all();
      $actividad = $em->getRepository('DataBundle:Actividad')->find($idActividad);
      $semillas = array();

      foreach ($registros as $registro => $value) {
        $idSemilla = substr($registro,2,4);

        $ambosValores = $this->contarValores($registros,$idSemilla);
        $asistencia = ($ambosValores == true ) ? $ambosValores : false;

        if(substr($registro,0,1) == 'n'){
          $semillas[$idSemilla] = array(
            'nota' => $registros[$registro],
            'asistencia' => $asistencia
          );
        }
      }
      $this->registrarCalificaciones($semillas,$actividad);
      return $this->redirectToRoute('gestionActividadesUsuarios',array('idGrupo'=> $idGrupo));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  //Metodo que permite guardar en la base de datos los registros de
  //las calificaciones obtenidas por los estudiantes en una actividad
  private function registrarCalificaciones($semillas,$actividad){
    $em = $this->getDoctrine()->getManager();
    foreach ($semillas as $idSemilla => $value) {

      $semilla_actividad = $this->existeRegistroCalificaion($idSemilla,$actividad->getId());
      $flagAgregar = true;

      if(count($semilla_actividad) == 0){
        $semilla_actividad = new semilla_actividad();
      }else{
        $semilla_actividad = $semilla_actividad[0];
        $flagAgregar = false;
      }

      $asistencia = ($value['asistencia'] == true ) ? $value['asistencia']: false ;
      $notaActividad = ($value['nota']);
      $notaAsistencia = ($asistencia == true ) ? 3 : 0 ;
      $notaActividad = (empty($notaActividad)) ? 0 : $notaActividad;
      $semilla = $em->getRepository('DataBundle:Semilla')->find($idSemilla);
      $semilla_actividad->setAsistio($asistencia);
      $semilla_actividad->setNotaAsistencia($notaAsistencia);
      $semilla_actividad->setNotaActividad($notaActividad);
      if($flagAgregar){
        $semilla_actividad->setSemilla($semilla);
        $semilla_actividad->setActividad($actividad);
        $semilla_actividad->setFechaRealizacion($actividad->getEncuentro()->getFechaRealizacion());
        $em->persist($semilla_actividad);
      }
      $em->flush();
    }
    $sucessMessage ="Se han guardado las calificaciones";
    $this->addFlash('msjCalificaciones',$sucessMessage);
  }

  //Metodo que verifica si ya se ha guardado para una semilla
  //una calificacion en una actividad

  private function existeRegistroCalificaion($idSemilla,$idActividad){
    $em = $this->getDoctrine()->getManager();
    $semilla_actividad = $em->getRepository('DataBundle:semilla_actividad')->getRegistroDetalleActividad($idSemilla,$idActividad);
    return $semilla_actividad;
  }

  //Metodo que cuenta la cantidad de registros por el id en este caso
  //(n-id, a-id) para saber si tiene nota y asitencia
  private function contarValores($registros, $idSemilla){
    $nota = 'n-'.$idSemilla;
    $asistencia = 'a-'.$idSemilla;
    if(array_key_exists($nota,$registros) && array_key_exists($asistencia,$registros)){
      return true;
    }
    return false;
  }

  //Metodo que crea el formulario para agregar una actividad
  private function createCreateForm(Actividad $actividad)
  {
    $form = $this->createForm(new ActividadType,$actividad);
    return $form;
  }

  //Metodo que obtiene todas las actividades registradas en un grupo
  private function getActividades($encuentros){
    $listActividades = array();
    foreach ($encuentros as $encuentro) {
      $actividades = $encuentro->getActividades();
      foreach ($actividades as $actividad) {
        array_push($listActividades,$actividad);
      }
    }
    return $listActividades;
  }

  //Metodo que valida si un encuentro esta disponible, esto quiere decir que
  //si han pasado menos o 5 dias despues de que se realizo el encuentro
  private function isEncuentroDisponible($encuentro)
  {
    $fechaRealizacion = $encuentro->getFechaRealizacion();
    $currentDate = new \Datetime("now", new \DateTimeZone('America/Bogota'));
    $diasTranscurridos = date_diff($fechaRealizacion,$currentDate)->format('%d');
    if($diasTranscurridos <= 5){
      return true;
    }
    return false;
  }
}
