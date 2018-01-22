<?php

namespace Semillero\ActividadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Semillero\DataBundle\Entity\Actividad;
use Semillero\DataBundle\Form\ActividadType;

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
  * @Route("/usuarios/agregarActividad", name="agregarActividadUsuarios")
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
    return $this->redirectToRoute('gestionActividadesUsuarios');
  }

  /**
  * @Route("/usuarios/modificarActividad/{idActividad}", name="modificarActividadUsuarios")
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
  */
  public function getDetalleActividad($idActividad, Request $request){
    if($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $actividad = $em->getRepository('DataBundle:Actividad')->find($idActividad);
      return $this->render('ActividadBundle:Actividad:detalleActividad.html.twig', array(
        'actividad' => $actividad
      ));
    }
    return $this->redirectToRoute('gestionActividadesUsuarios');
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
    return $this->redirectToRoute('gestionActividadesUsuarios');
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
