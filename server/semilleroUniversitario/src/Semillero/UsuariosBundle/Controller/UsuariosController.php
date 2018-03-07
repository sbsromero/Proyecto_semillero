<?php

namespace Semillero\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Semillero\DataBundle\Entity\Encuentro;
use Semillero\DataBundle\Entity\Actividad;
use Semillero\DataBundle\Form\ActividadType;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

/**
* @Route("/usuarios")
*/
class UsuariosController extends Controller
{
  /**
  * @Route("/dashboard", name="dashboardUsuarios")
  */
  public function dashboardUsuariosAction()
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $user = $this->container
       ->get('security.context')
       ->getToken()
       ->getUser();

      $role = $user->getRoles()[0];
      if($role == "ROLE_SEMILLA"){
        return $this->redirectToRoute('indexSemillasUsuarios');
      }
      return $this->redirectToRoute("indexGrupos_usuarios");
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  //Metodo que se encarga de administrar los grupos asignados a un mentor
  /**
  * @Route("/index", name="indexGrupos_usuarios")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function indexGrupos (Request $request)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $user = $this->container->get('security.context')->getToken()->getUser();
      $gruposPorMentor = $em->getRepository('DataBundle:Mentor_Grupos')->gruposAsignadosPorMentor($user->getId());
      return $this->render('UsuariosBundle:Grupos:indexGrupos.html.twig',array(
        'user' => $user,
        'gruposPorMentor' => $gruposPorMentor
      ));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/administracionUsuarios", name="administracionUsuarios")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function administracionUsuarios (Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $idGrupo = $request->query->get('idGrupo');
      $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);

      return $this->render('UsuariosBundle:Grupos:administracionUsuarios.html.twig',array(
        'grupo' => $grupo
      ));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/datosPersonales",name="verDatosPersonales")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function verDatosPersonales(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $mentor = $this->container->get('security.context')->getToken()->getUser();

        return $this->render('MentoresBundle:Mentor:view.html.twig',array(
          'mentor' => $mentor
        ));
      }
      // return $this->redirectToRoute('administracionUsuarios');
      return $this->redirectToRoute('indexGrupos_usuarios');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/gestionGruposAsignados", name="gestionGruposAsignados")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function gestionGruposAsignados(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $mentor = $this->container->get('security.context')->getToken()->getUser();
      $grupos_mentor = $em->getRepository('DataBundle:Mentor_Grupos')->gruposAsignadosPorMentor($mentor->getId());
      $gruposActivos = array();

      foreach ($grupos_mentor as $grupo_mentor) {
        array_push($gruposActivos, $grupo_mentor->getGrupo());
      }

      return $this->render('UsuariosBundle:Grupos:gestionGrupos.html.twig',array(
      'gruposActivos' => $gruposActivos));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/getDetalleGrupo/{idGrupo}", name="getDetalleGrupo")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function getDetalleGrupo($idGrupo, Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $mentor = $this->container->get('security.context')->getToken()->getUser();
        $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);

        $detalleMentor_Grupo = $em->getRepository('DataBundle:Mentor_Grupos')
        ->getDetalleMentorGrupo($mentor->getId(),$idGrupo);

        return $this->render('MentoresBundle:Grupo:view.html.twig',array(
          'grupo' => $grupo,
          'detalle'=> $detalleMentor_Grupo,
          'isAdmin' => false
        ));
      }
      return $this->redirectToRoute('indexGrupos_usuarios');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  //Metodo que se encarga de responder con la vista donde se listaran
  //los encuentros relacionados a cada segmento
  /**
  * @Route("/gestionEncuentros/{idGrupo}", name="gestionEncuentros")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function gestionEncuentros($idGrupo, Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);
      $segmentos = $grupo->getSegmentos();

      return $this->render('UsuariosBundle:Encuentros:administracionEncuentros.html.twig',array(
        'grupo' => $grupo,
        'segmentos' => $segmentos
      ));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  //Metodo que retorna todos los encuentros pertenecientes a un
  //segmento asociado a un grupo
  /**
  * @Route("/getEncuentros/{idSegmento}", name="getEncuentros")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  */
  public function getEncuentros($idSegmento, Request $request){
    if($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $segmento = $em->getRepository('DataBundle:Segmento')->find($idSegmento);
      $encuentros = $segmento->getEncuentros();

      return $this->render('UsuariosBundle:Encuentros:listaEncuentros.html.twig',array(
        'encuentros' => $encuentros
      ));
    }
    // return $this->redirectToRoute('gestionEncuentros');
    return $this->redirectToRoute('indexGrupos_usuarios');
  }

  //Metodo que agregar un encuentro a un segmento, puede agregar maximo
  //4 encuentros por segmento
  /**
  * @Route("/agregarEncuentro", name="agregarEncuentro")
  * @PreAuthorize("hasRole('ROLE_MENTOR')")
  * @Method({"POST"})
  */
  public function agregarEncuentro(Request $request){
    if($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $idSegmento = $request->request->get('idSegmento');
      $contadorEncuentro = false;
      $segmento = $em->getRepository('DataBundle:Segmento')->find($idSegmento);
      $encuentros = $segmento->getEncuentros();
      $fechaActual = new \Datetime();
      $fechaActual->setTimeZone(new \DateTimeZone('America/Bogota'));
      $contadorEncuentro = $this->encuentroRegistroHoy($encuentros,$fechaActual);

      //Si la fecha es un sabado, puede agregar un encuentro
      // if($fechaActual->format('N') == 6){
        //Si hay menos de 4 encuentros por segmento y si ya se agrego uno cuadno se realizo el
        //encuentro
        if(count($encuentros) < 4 && !$contadorEncuentro){
          $encuentro = new Encuentro();
          $encuentro->setSegmento($segmento);
          $encuentro->setNumeroEncuentro(count($encuentros)+1);
          $encuentro->setFechaRealizacion(new \DateTime('now', new \DateTimeZone('America/Bogota')));
          $em->persist($encuentro);
          $em->flush();
          return new Response(Response::HTTP_OK);
        }
        return new Response("No se pudo registrar el encuentro",400);
      // }
      return new Response("No es un dia vigente para agregar un encuentro", 400);
    }
    return $this->redirectToRoute('gestionEncuentros');
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

  //Metodo que valida si ya se registro un encuentro el dia sabado
  private function encuentroRegistroHoy($encuentros,$fecha){
    foreach ($encuentros as $encuentro) {
      if($encuentro->getFechaRealizacion()->format('d-m-y') == $fecha->format('d-m-y')){
        return true;
      }
    }
    return false;
  }

  //DESDE AQUI SE HACE TODA LA GESTION DE LA SEMILLA CUANDO INGRESA AL SISTEMA PARA REVISAR
  //SUS DATOS PERSONALES INFORMACION ACADEMICA
  /**
  * @Route("/indexSemillas", name="indexSemillasUsuarios")
  * @PreAuthorize("hasRole('ROLE_SEMILLA')")
  */
  public function indexSemillasUsuarios(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->render('UsuariosBundle:Semillas:indexSemillas.html.twig');
    }
    return $this->redirectToRoute('usuariosLogin');
  }
  /**
  * @Route("/informacionPersonal", name="informacionPersonal")
  * @PreAuthorize("hasRole('ROLE_SEMILLA')")
  */
  public function informacionPersonal (Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->render('UsuariosBundle:Semillas:informacionPersonal.html.twig');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/verDatosPersonalesSemilla",name="verDatosPersonalesSemilla")
  * @PreAuthorize("hasRole('ROLE_SEMILLA')")
  */
  public function verDatosPersonalesSemilla(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $semilla = $this->container->get('security.context')->getToken()->getUser();
        $grupo = $this->getGrupoAsignado($semilla);

        return $this->render('SemillasBundle:Semilla:view.html.twig',array(
          'semilla' => $semilla,
          'grupo' => $grupo
        ));
      }
      return $this->redirectToRoute('informacionPersonal');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/getCambiarClave", name="getCambiarClave")
  * @PreAuthorize("hasRole('ROLE_SEMILLA')")
  */
  public function vistaCambiarClave(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->render('UsuariosBundle:Semillas:cambiarClave.html.twig');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/cambiarClave", name="cambiarClave")
  * @PreAuthorize("hasRole('ROLE_SEMILLA')")
  * @Method({"POST"})
  */
  public function cambiarClave(Request $request){
    $em = $this->getDoctrine()->getManager();
    $semilla = $this->container->get('security.context')->getToken()->getUser();
    $claveActual = $request->request->get('claveActual');
    $nuevaClave = $request->request->get('nuevaClave');
    $confirmacion = $request->request->get('confirmacion');

    $encoder = $this->container->get('security.password_encoder');
    $valid = $encoder->isPasswordValid($semilla, $nuevaClave);
    if($valid){
      return new Response("La contraseña debe ser diferente a la actual", 400);
    }
    if(strlen($nuevaClave) < 6){
      return new Response("La contraseña debe tener de 6 a 12 caracteres", 400);
    }
    if($nuevaClave != $confirmacion){
      return new Response("Las contraseñas no coinciden", 400);
    }

    $encriptarNuevaClave = $this->container->get('security.password_encoder');
    $NuevaClave = $encriptarNuevaClave->encodePassword($semilla, $nuevaClave);
    $semilla->setPassword($NuevaClave);
    $em->flush();
    return new Response(Response::HTTP_OK);
  }

  /**
  * @Route("/gestionAcademica", name="gestionAcademica")
  * @PreAuthorize("hasRole('ROLE_SEMILLA')")
  */
  public function gestionAcademica(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $semilla = $this->container->get('security.context')->getToken()->getUser();
      $grupo = $this->getGrupoAsignado($semilla);
      $items = null; $pageCount=0;

      if(!empty($grupo)){
        $actividades = $this->get('service_actividades')->getlistaActividades($em,$grupo);
        $page= $request->query->get('pageActive');
        $page = empty($page) ? 1 : $page;
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($actividades,$page,10);
        $items = $pagination->getItems();
        $pageCount = $pagination->getPageCount();
      }

      return $this->render('UsuariosBundle:Semillas:gestionAcademica.html.twig',array(
        'grupo' => $grupo,
        'actividades' => $items,
        'pageCount' => $pageCount
      ));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  //Metodo que permite saber que grupo tiene asignado una semilla
  private function getGrupoAsignado($semilla){
    foreach ($semilla->getGrupos() as $grupo) {
      if($grupo->getActivo()){
        return $grupo->getGrupo();
      }
    }
  }
}
