<?php

namespace Semillero\SemillasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

use Semillero\DataBundle\Entity\Semilla;
use Semillero\DataBundle\Form\SemillaType;
use Semillero\DataBundle\Entity\Grupo;
use Semillero\DataBundle\Entity\Semilla_Grupo;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class SemillaController extends Controller
{
  //------------------Metodo index, carga todos las semillas registrados en la base de datos --------------------
  /**
  * @Route("/admin/semillas/index",name="indexSemillas")
  */

  public function indexAction(Request $request)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $valorBusqueda = $request->query->get('valorBusqueda');
      $btnMostrarSemillas = $request->query->get('btnMostrarSemillas');
      $valorBusqueda = empty($valorBusqueda) ? "" : $valorBusqueda;

      if(!empty($btnMostrarSemillas)){
        $valorBusqueda = "";
      }

      $semillas = $em->getRepository('DataBundle:Semilla')->getAllSemillas($valorBusqueda);

      $page= $request->query->get('pageActive');
      $page = empty($page) ? 1 : $page;

      $paginator = $this->get('knp_paginator');
      $pagination = $paginator->paginate($semillas,$page,10);
      $items = $pagination->getItems();
      $pageCount = $pagination->getPageCount();

      return $this->render('SemillasBundle:Semilla:index.html.twig',array(
        'pageCount' => $pageCount,
        'pagination' => $items));
    }
    return $this->redirectToRoute('adminLogin');
  }

  //------------------ Metodo add, agregar una SEMILLA a la base de datos --------------------
  /**
  * @Route("/admin/semillas/add",name="addSemillas")
  */

  public function addAction()
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      #Creamos nuestro objeto semilla para poder acceder a cada una de las propiedades y metodos de nuestra entidad (semilla)
      $semilla = new Semilla();
      #Variable que llama al metodo creaCreateForm, creado luego
      $form = $this-> createCreateForm($semilla,'createSemillas');
      $grupos = $this->getDoctrine()->getManager()->getRepository('DataBundle:Grupo')->findAll();
      return $this->render('SemillasBundle:Semilla:add.html.twig',array(
        'form' =>$form->createView()));
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function createCreateForm(Semilla $entity, $url)
  {
    $form = $this-> createForm(new SemillaType(),$entity, array (
      'action' => $this->generateUrl($url),
      'method' => 'POST'
    ));

    return $form;
  }

  /**
  * @Route("/admin/semillas/create",name="createSemillas")
  * @Method({"POST"})
  */

  public function createAction(Request $request)
  {
    $semilla = new Semilla();
    $form = $this->createCreateForm($semilla,'createSemillas');
    $em = $this->getDoctrine()->getManager();

    $emailExistente = $em->getRepository('DataBundle:Usuarios')->findByEmail($request->request->get('semilla')['email']);
    $documentoExistente = $em->getRepository('DataBundle:Usuarios')->findByNumeroDocumento($request->request->get('semilla')['numeroDocumento']);;

    $form->handleRequest($request);

    if(!empty($emailExistente)){
      $form->get('email')->addError(new FormError('El email ya se encuentra registrado'));
    }
    if(!empty($documentoExistente)){
      $form->get('numeroDocumento')->addError(new FormError('Documento ya registrado'));
    }
    $idGrupo = $request->request->get('semilla_grupo');

    #Validamos si el formulario se envio correctamente
    if($form->isValid())
    {
      $password = $form->get('password')->getData();
      $encoder = $this->container->get('security.password_encoder');
      $encoded = $encoder->encodePassword($semilla, $password);

      $semilla->setPassword($encoded);
      $semilla->setActivo(true);

      $em -> persist($semilla);
      $em -> flush();

      $this->addFlash('mensajeSemilla','La semilla ha sido creado satisfactoriamente');
      return $this->redirectToRoute('indexSemillas');
    }
    #Renderizamos al formulario si existe algun problema
    return $this->render('SemillasBundle:Semilla:add.html.twig',array(
      'form' =>$form->createView(),
    ));
  }

  //------------------ Metodo edit, editar una SEMILLA de la base de datos --------------------

  /**
  * @Route("/admin/semillas/edit/{numeroDocumento}",name="editSemillas")
  */
  public function editAction($numeroDocumento)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $semilla = $em->getRepository('DataBundle:Semilla')->findOneByNumeroDocumento($numeroDocumento);

      if(!$semilla)
      {
        return $this->redirectToRoute('indexSemillas');
      }

      $form = $this->createEditForm($semilla);
      // $idGrupoAsignado = $this->getGrupoAsignado($semilla)->getId();

      $grupos = $this->getDoctrine()->getManager()->getRepository('DataBundle:Grupo')->findAll();
      return $this->render('SemillasBundle:Semilla:edit.html.twig', array(
        'semilla'=>$semilla,
        'grupos'=>$grupos,
        // 'errorSelected' => false,
        // 'idGrupoAsignado' => $idGrupoAsignado,
        'form'=>$form->createView()));
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function createEditForm(Semilla $entity)
  {
    $form = $this->createForm(new SemillaType(), $entity, array('action' => $this->generateUrl('updateSemillas', array('numeroDocumento' => $entity->getNumeroDocumento())), 'method' => 'PUT'));
    return $form;
  }

  /**
  * @Route("/admin/semillas/update/{numeroDocumento}",name="updateSemillas")
  * @Method({"POST","PUT"})
  */
  public function updateAction($numeroDocumento, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $semilla = $em->getRepository('DataBundle:Semilla')->findOneByNumeroDocumento($numeroDocumento);
    if(!$semilla)
    {
      throw $this->createNotFoundException('La SEMILLA a Editar NO Existe');
    }

    $form = $this->createEditForm($semilla);
    $form->handleRequest($request);

    if($form->isValid())
    {

      $password = $form->get('password')->getData();

      //Verificamos si se puso una nueva contraseña
      if(!empty($password))
      {
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($semilla, $password);
        $semilla->setPassword($encoded);
      }
      else
      {
        $pass = $em->getRepository('DataBundle:Semilla')->recoverPass($numeroDocumento);
        $semilla->setPassword($pass[0]['password']);
      }

      $em -> flush();
      $this->addFlash('mensajeSemilla','La semilla ha sido modificado satisfactoriamente');
      return $this->redirectToRoute('indexSemillas');
    }
    $grupos = $this->getDoctrine()->getManager()->getRepository('DataBundle:Grupo')->findAll();

    return $this->render('SemillasBundle:Semilla:edit.html.twig',array(
      'semilla' => $semilla,
      'grupos' => $grupos,
      'form' =>$form->createView()));
  }

  //------------------ Metodo view, carga una SEMILLA seleccionado por parametro NumeroDocumento --------------------

  /**
  * @Route("/admin/semillas/view/{id}",name="viewSemillas")
  */
  public function viewAction(Request $request,$id)
  {
    if ($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $Repository = $this->getDoctrine()->getRepository('DataBundle:Semilla');
      $semilla = $em->getRepository('DataBundle:Semilla')->findById($id);
      $grupo = $this->getGrupoAsignado($semilla[0]);

      if(!$semilla)
      {
        return $this->redirectToRoute('indexSemillas');
      }

      return $this->render('SemillasBundle:Semilla:view.html.twig',array(
        'semilla' => $semilla[0],
        'grupo' => $grupo
      ));
    }
    return $this->redirectToRoute('indexSemillas');
  }

  //------------------ Metodo delete, eliminar una SEMILLA de la base de datos --------------------

  /**
  * @Route("/admin/semillas/delete/{id}",name="deleteSemillas")
  * @Method({"POST","DELETE"})
  */
  public function deleteAction(Request $request, $id)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $semilla = $em->getRepository('DataBundle:Semilla')->find($id);
      if(count($semilla->getGrupos())>0){
        return new Response('No es posible eliminar la semilla, tiene un grupo asignado',Response::HTTP_NOT_FOUND);
      }
      else{
        $em->remove($semilla);
        $em->flush();
        return new Response(Response::HTTP_OK);
      }
    }
    return new Response('user not loggin',Response::HTTP_NOT_FOUND);
  }

  //Metodo que permite realizar el pdf de todas las semillas registradas
  /**
  * @Route("/admin/getPdfSemillas", name="getPdfSemillas")
  */
  public function getPdfSemillas(Request $request){
    $em = $this->getDoctrine()->getManager();
    $semillas = $em->getRepository('DataBundle:Semilla')->findAll();

    return new PdfResponse(
      $this->get('knp_snappy.pdf')->getOutputFromHtml($this->renderView('SemillasBundle:Semilla:plantillaPdfSemillas.html.twig', array(
        'base_dir' => $this->get('kernel')->getRootDir().'/../web'. $request->getBasePath(),
        'semillas' => $semillas
      ))),
      'reporteSemillas'.'.pdf'
    );
  }

  /**
  * @Route("/admin/mentores/getAsignarGrupo/{idSemilla}",name="getAsignarGrupo")
  */
  public function getAsignarGrupo($idSemilla, Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $grupos = $em->getRepository('DataBundle:Grupo')->getGruposActivos();

        $idGrupoAsignado = $em->getRepository('DataBundle:Semilla_Grupo')->getGrupoAsignado($idSemilla);
        if(!empty($idGrupoAsignado)){
          $idGrupoAsignado = $idGrupoAsignado->getGrupo()->getId();
        }

        $page= $request->query->get('pageActive');
        $page = empty($page) ? 1 : $page;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($grupos,$page,10);
        $items = $pagination->getItems();
        $pageCount = $pagination->getPageCount();

        return $this->render('SemillasBundle:Semilla:asignarGrupo.html.twig',array(
          'pageCount' => $pageCount,
          'grupos' => $items,
          'idGrupoAsignado' => $idGrupoAsignado
        ));
      }
      return $this->redirectToRoute('indexSemillas');
    }
    return $this->redirectToRoute('adminLogin');
  }

  /**
  * @Route("/admin/mentores/asignarGrupo", name="asignarGrupo")
  * @Method({"POST"})
  */
  public function asignarGrupo(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $idGrupo = $request->request->get('idGrupo');
      $idSemilla = $request->request->get('idSemilla');
      $em = $this->getDoctrine()->getManager();

      $semilla = $em->getRepository('DataBundle:Semilla')->find($idSemilla);
      $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);

      $grupoAsignado = $em->getRepository('DataBundle:Semilla_Grupo')->getGrupoAsignado($idSemilla);

      //Si tiene cupo disponible agrega la semilla al grupo
      if($this->cupoDisponible($em, $idSemilla, $idGrupo)){
        if(!empty($grupoAsignado)){
          $grupoAsignado->setActivo(false);
          $grupoAsignado->setFechaDesasignacion(new \Datetime("now", new \DateTimeZone('America/Bogota')));
          $em->flush();
        }
        $semilla_grupo = new Semilla_Grupo();
        $semilla_grupo->setSemilla($semilla);
        $semilla_grupo->setGrupo($grupo);
        $semilla_grupo->setFechaAsignacion(new \Datetime("now", new \DateTimeZone('America/Bogota')));
        $em->persist($semilla_grupo);
        $em->flush();
        return new Response(Response::HTTP_OK);
      }
      return new Response("No hay cupos diponibles para este grupo",400);
    }
    return $this->redirectToRoute('adminLogin');
  }

  /**
  * @Route("/admin/semillas/historicoGruposSemillas/{id}", name="historicoGruposSemillas")
  */
  public function historicoGruposSemillas($id, Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $historicoGrupos = $em->getRepository('DataBundle:Semilla_Grupo')->getHistoricoGrupos($id);

        return $this->render('SemillasBundle:Semilla:historicoGrupos.html.twig', array(
          'historicoGrupos' => $historicoGrupos
        ));
      }
      return $this->redirectToRoute('indexMentores');
    }
    return $this->redirectToRoute('adminLogin');
  }

  /** Registro de semillas para cualquier usuario, diferente a administrador y mentor*/
  /**
  * @Route("/semilleroUniversitario/registrarse", name="registrarSemilla")
  */
  public function registroSemillas(){
    $semilla = new Semilla();
    $form = $this-> createCreateForm($semilla,'guardarSemilla');
    $grupos = $this->getDoctrine()->getManager()->getRepository('DataBundle:Grupo')->findAll();
    return $this->render('SemillasBundle:Semilla:add.html.twig',array(
      'form' =>$form->createView(),
      'grupos'=>$grupos,
      'errorSelected' =>false));
  }

  /**
  * @Route("/semilleroUniversitario/registrarSemilla", name="guardarSemilla")
  * @Method({"POST"})
  */
  public function registrarSemilla(Request $request){

    $semilla = new Semilla();
    $form = $this->createCreateForm($semilla,'guardarSemilla');
    $em = $this->getDoctrine()->getManager();

    $emailExistente = $em->getRepository('DataBundle:Usuarios')->findByEmail($request->request->get('semilla')['email']);
    $documentoExistente = $em->getRepository('DataBundle:Usuarios')->findByNumeroDocumento($request->request->get('semilla')['numeroDocumento']);;
    $grupoId = $request->request->get('grupo_id');
    $grupos = $this->getDoctrine()->getManager()->getRepository('DataBundle:Grupo')->findAll();

    $form->handleRequest($request);

    if(!empty($emailExistente)){
      $form->get('email')->addError(new FormError('El email ya se encuentra registrado'));
    }
    if(!empty($documentoExistente)){
      $form->get('numeroDocumento')->addError(new FormError('Documento ya registrado'));
    }

    #Validamos si el formulario se envio correctamente
    if($form->isValid() && !empty($grupoId))
    {
      if($grupoId != "0"){
        $password = $form->get('password')->getData();
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($semilla, $password);

        $grupoAspirante = $em->getRepository('DataBundle:Grupo')->find($grupoId);

        $semilla->setPassword($encoded);
        $semilla->setActivo(true);
        $semilla->setGrupoAspirante($grupoAspirante);

        $em -> persist($semilla);
        $em -> flush();
        // $this->addFlash('mensajeSemilla','La semilla ha sido creado satisfactoriamente');
        return $this->redirectToRoute('usuariosLogin');
      }
    }
    $errorSelected = empty($grupoId) ? true : false;
    #Renderizamos al formulario si existe algun problema
    return $this->render('SemillasBundle:Semilla:add.html.twig',array(
      'form' =>$form->createView(),
      'grupos'=>$grupos,
      'errorSelected'=>$errorSelected
    ));
  }

  private function cupoDisponible($em,$idSemilla,$idGrupo){
    $cantidadSemillas = $em->getRepository('DataBundle:Semilla_Grupo')->getCantidadSemillasPorGrupo($idGrupo);
    $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);
    return ($cantidadSemillas[1] < $grupo->getCupo()) ? true : false;
  }

//Metodo que permite saber que grupo tiene asignado una semilla
  private function getGrupoAsignado($semilla){
    foreach ($semilla->getGrupos() as $grupo) {
      if($grupo->getActivo()){
        return $grupo->getGrupo();
      }
    }
  }

  //Metodo que permite realizar la reasignacion de un grupo a una semilla
  private function reasignarGrupo($semilla, $grupo){
    $em = $this->getDoctrine()->getManager();
    $registroSG = $em->getRepository('DataBundle:Semilla_Grupo')->getGrupoAsignado($semilla->getId());
    $registroSG->setActivo(false);
    $registroSG->setFechaDesasignacion(new \DateTime());

    $semillaGrupo = new Semilla_Grupo();
    $semillaGrupo->setSemilla($semilla);
    $semillaGrupo->setGrupo($grupo);
    $em->persist($semillaGrupo);
    $em->flush();
  }

}
