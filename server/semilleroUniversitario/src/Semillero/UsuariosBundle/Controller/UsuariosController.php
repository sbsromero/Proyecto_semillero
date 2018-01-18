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
      return $this->render('UsuariosBundle:Dashboard:dashboardUsuarios.html.twig');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  //Metodo que se encarga de administrar los grupos asignados a un mentor
  /**
  * @Route("/index", name="indexGrupos_usuarios")
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
      return $this->redirectToRoute('administracionUsuarios');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/gestionGruposAsignados", name="gestionGruposAsignados")
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
      return $this->redirectToRoute('administracionUsuarios');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  //Metodo que se encarga de responder con la vista donde se listaran
  //los encuentros relacionados a cada segmento
  /**
  * @Route("/gestionEncuentros/{idGrupo}", name="gestionEncuentros")
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
    return $this->redirectToRoute('gestionEncuentros');
  }

  //Metodo que agregar un encuentro a un segmento, puede agregar maximo
  //4 encuentros por segmento
  /**
  * @Route("/agregarEncuentro", name="agregarEncuentro")
  * @Method({"POST"})
  */
  public function agregarEncuentro(Request $request){
    if($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $idSegmento = $request->request->get('idSegmento');
      $contadorEncuentro = $request->request->get('contador');
      $segmento = $em->getRepository('DataBundle:Segmento')->find($idSegmento);
      $encuentros = $segmento->getEncuentros();
      $fechaActual = new \Datetime();
      $fechaActual->setTimeZone(new \DateTimeZone('America/Bogota'));

      //Si la fecha es un sabado, puede agregar un encuentro
      if($fechaActual->format('N') == 6){
        //Si hay menos de 4 encuentros por segmento y si ya se agrego uno cuadno se realizo el
        //encuentro
        if(count($encuentros) < 4 && $contadorEncuentro==1){
          $encuentro = new Encuentro();
          $encuentro->setSegmento($segmento);
          $encuentro->setNumeroEncuentro(count($encuentros)+1);
          $encuentro->setFechaRealizacion(new \DateTime('now', new \DateTimeZone('America/Bogota')));
          $em->persist($encuentro);
          $em->flush();
          return new Response(Response::HTTP_OK);
        }
        return new Response("No se pudo registrar el encuentro",400);
      }
      return new Response("No es un dia vigente para agregar un encuentro", 400);
    }
    return $this->redirectToRoute('gestionEncuentros');
  }

  /**
  * @Route("/agregarActividad", name="agregarActividad")
  */
  public function agregarActividad(Request $request){
    if($request->isXmlHttpRequest()) {
      $actividad = new Actividad();
      $form = $this-> createCreateForm($actividad);
      return $this->render('UsuariosBundle:Encuentros:agregarActividad.html.twig',array(
        'form' =>$form->createView()));
    }
    return $this->redirectToRoute('gestionEncuentros');
  }

  /**
  * @Route("/registrarActividad", name="registrarActividad")
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

      }
        #Renderizamos al forumlario si existe algun problema
      return new Response($this->renderView('UsuariosBundle:Encuentros:agregarActividad.html.twig',array(
        'form' =>$form->createView()
      )),400);

    }
    return $this->redirectToRoute('usuariosLogin');
  }

  public function createCreateForm(Actividad $actividad)
  {
    $form = $this->createForm(new ActividadType,$actividad);
    return $form;
  }
}
