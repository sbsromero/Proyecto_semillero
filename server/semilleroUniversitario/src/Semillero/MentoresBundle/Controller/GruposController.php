<?php

namespace Semillero\MentoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

use Semillero\DataBundle\Entity\Grupo;
use Semillero\DataBundle\Entity\Segmento;
use Semillero\DataBundle\Entity\Mentor_Grupos;
use Semillero\DataBundle\Form\GrupoType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
* @Route("/admin/grupos")
*/
class GruposController extends Controller
{

  //------------------Metodo index, carga todos los grupos registrados en la base de datos --------------------
  /**
  * @Route("/index",name="indexGrupos")
  */

  public function indexAction(Request $request)
  {
    // if($this->isGranted('IS_AUTHENTICATED_FULLY')){
    //   $em = $this->getDoctrine()->getManager();
    //   //$grupos = $em->getRepository('DataBundle:Grupo')->findAll();
    //
    //   //------------------------------------------------------
    //   $dql = "SELECT g FROM DataBundle:Grupo g";
    //   $grupos = $em->createQuery($dql);
    //   //------------------------------------------------------
    //
    //   $paginator = $this->get('knp_paginator');
    //   $pagination = $paginator->paginate(
    //     $grupos, $request->query->getInt('page',1),
    //     5
    //   );
    //   return $this->render('MentoresBundle:Grupo:index.html.twig',array('pagination' => $pagination));
    // }
    // return $this->redirectToRoute('adminLogin');
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $valorBusqueda = $request->query->get('valorBusqueda');
      $btnMostrarGrupos = $request->query->get('btnMostrarGrupos');
      $valorBusqueda = empty($valorBusqueda) ? "" : $valorBusqueda;

      if(!empty($btnMostrarGrupos)){
        $valorBusqueda = "";
      }

      $grupos = $em->getRepository('DataBundle:Grupo')->getAllGrupos($valorBusqueda);

      $page= $request->query->get('pageActive');
      $page = empty($page) ? 1 : $page;

      $paginator = $this->get('knp_paginator');
      $pagination = $paginator->paginate($grupos,$page,5);
      $items = $pagination->getItems();
      $pageCount = $pagination->getPageCount();

      return $this->render('MentoresBundle:Grupo:index.html.twig',array(
        'pageCount' => $pageCount,
        'pagination' => $items));
    }
    return $this->redirectToRoute('adminLogin');
  }

  //------------------ Metodo add, agregar un GRUPO a la base de datos --------------------
  /**
  * @Route("/add",name="addGrupos")
  */
  public function addAction(Request $request)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $grupo = new Grupo();
        $form = $this->createCreateForm($grupo);
        return $this->render('MentoresBundle:Grupo:add.html.twig',array('form' =>$form->createView()));
      }
      return $this->redirectToRoute('indexGrupos');
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function createCreateForm(Grupo $entity)
  {
    $form = $this->createForm(new GrupoType(), $entity, array('method' => 'POST'));
    return $form;
  }

  /**
  * @Route("/create",name="createGrupos")
  * @Method({"POST"})
  */
  public function createAction(Request $request)
  {
    $grupo = new Grupo();
    $form = $this->createCreateForm($grupo);
    $form->handleRequest($request);

    #Validamos si el formulario se envio correctamente
    if($form->isValid())
    {
      $em = $this->getDoctrine()->getManager();
      $this->agregarSegmentos($grupo);
      $em -> persist($grupo);
      $em -> flush();

      return new Response(Response::HTTP_OK);
    }
    #Renderizamos al forumlario si existe algun problema
    return new Response($this->renderView('MentoresBundle:Grupo:add.html.twig',array(
      'form' =>$form->createView()
    )),400);
  }

  //------------------ Metodo edit, editar un GRUPO de la base de datos --------------------

  /**
  * @Route("/edit/{id}",name="editGrupos")
  */
  public function editAction($id, Request $request)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if($request->isXmlHttpRequest()){
        $em = $this->getDoctrine()->getManager();
        $grupo = $em->getRepository('DataBundle:Grupo')->find($id);

        if(!$grupo)
        {
          throw $this->createNotFoundException('El Grupo a Editar NO Existe');
        }
        $form = $this->createEditForm($grupo);
        return $this->render('MentoresBundle:Grupo:edit.html.twig', array(
          'idGrupo'=>$id,
          'form'=>$form->createView()));
      }
      return $this->redirectToRoute('indexDiplomados');
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function createEditForm(Grupo $entity)
  {
    $form = $this->createForm(new GrupoType(), $entity, array('method' => 'PUT'));
    // $form = $this->createForm(new GrupoType(), $entity, array('action' => $this->generateUrl('updateGrupos', array('id' => $entity->getId())), 'method' => 'PUT'));
    return $form;
  }

  /**
  * @Route("/update/{id}",name="updateGrupos")
  * @Method({"POST","PUT"})
  */
  public function updateAction($id, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $grupo = $em->getRepository('DataBundle:Grupo')->find($id);

    if(!$grupo)
    {
      throw $this->createNotFoundException('El Grupo a Editar NO Existe');
    }

    $form = $this->createEditForm($grupo);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
      $em -> flush();
      return new Response(Response::HTTP_OK);
    }

    return new Response($this->renderView('MentoresBundle:Grupo:edit.html.twig',array(
      'idGrupo' => $id,
      'form' =>$form->createView()
    )),400);
  }

  //------------------ Metodo view, carga un GRUPÓ seleccionado por parametro Id --------------------
  /**
  * @Route("/view/{id}",name="viewGrupos")
  */
  public function viewAction(Request $request,$id)
  {
    if ($request->isXmlHttpRequest()) {

      $em = $this->getDoctrine()->getManager();
      $Repository = $this->getDoctrine()->getRepository('DataBundle:Grupo');
      $grupo = $em->getRepository('DataBundle:Grupo')->find/*ById*/($id);

      if(!$grupo)
      {
        return $this->redirectToRoute('indexGrupos');
      }
      $m_g = $em->getRepository('DataBundle:Mentor_Grupos')->getMentorAsignadoPorGrupo($grupo->getId());
      if(!empty($m_g)){
        $mentor = $m_g->getMentor();
      }
      $idMentor = (!empty($m_g)) ? $m_g->getMentor()->getId() : null;

      $detalleMentor_Grupo = $em->getRepository('DataBundle:Mentor_Grupos')
      ->getDetalleMentorGrupo($idMentor,$grupo->getId());

      return $this->render('MentoresBundle:Grupo:view.html.twig',array(
        'grupo' => $grupo,
        'detalle'=> $detalleMentor_Grupo,
        'isAdmin' => true));
    }
    return $this->redirectToRoute('indexGrupos');
  }

  //------------------ Metodo delete, eliminar un GRUPÓ de la base de datos --------------------

  /**
  * @Route("/delete/{id}",name="deleteGrupos")
  * @Method({"POST","DELETE"})
  */
  public function deleteAction(Request $request, $id)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $grupo = $em->getRepository('DataBundle:Grupo')->find($id);

      if($this->existeRegistroSemillasPorGrupo($grupo)){
        return new Response('No se pudo eliminar el grupo',Response::HTTP_NOT_FOUND);
      }
      else{
        $em->remove($grupo);
        $em->flush();
        return new Response(Response::HTTP_OK);
      }
    }
    return new Response('user not loggin',Response::HTTP_NOT_FOUND);
  }

  Metodo que permite generar un pdf con las semillas de un grupo
  /**
  * @Route("/getPdfGrupoSemillas",name="getPdfGrupoSemillas")
  */
  public function getPdfGrupoSemillas(Request $request){
    $idGrupo = $request->query->get('id');
    $em = $this->getDoctrine()->getManager();
    $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);
    $m_g = $em->getRepository('DataBundle:Mentor_Grupos')->getMentorAsignadoPorGrupo($idGrupo);
    $mentor = (empty($m_g)) ? null : $m_g->getMentor();

    $grupo_semillas = $grupo->getSemillas();
    $semillas = array();
    foreach ($grupo_semillas as $grupo_semilla) {
      if($grupo_semilla->getActivo()){
        array_push($semillas, $grupo_semilla->getSemilla());
      }
    }
    return new PdfResponse(
         $this->get('knp_snappy.pdf')->getOutputFromHtml($this->renderView('MentoresBundle:Grupo:plantillaPdfGrupoSemillas.html.twig', array(
             'base_dir' => $this->get('kernel')->getRootDir().'/../web'. $request->getBasePath(),
             'grupo' => $grupo,
             'mentor' => $mentor,
             'semillas' => $semillas,
         ))),
         'semillas-'.trim($grupo->getNombre()).'.pdf'
     );
    // return $this->render('MentoresBundle:Grupo:plantillaPdfSemillas.html.twig',array(
    //   'grupo' => $grupo,
    //   'semillas' => $semillas,
    //   'base_dir' => $this->get('kernel')->getRootDir().'/../web'. $request->getBasePath()
    // ));
  }
  function quitar_tildes($cadena) {
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
  }

  //Metodo que permite generar un pdf con todos los grupos registrados
  /**
  * @Route("/getPdfGrupos",name="getPdfGrupos")
  */
  public function getPdfGrupos(Request $request){
    $em = $this->getDoctrine()->getManager();
    $grupos = $em->getRepository('DataBundle:Grupo')->findAll();

    return new PdfResponse(
      $this->get('knp_snappy.pdf')->getOutputFromHtml($this->renderView('MentoresBundle:Grupo:plantillaPdfGrupos.html.twig', array(
        'base_dir' => $this->get('kernel')->getRootDir().'/../web'. $request->getBasePath(),
        'grupos' => $grupos
      ))),
      'reporteGrupos'.'.pdf'
    );
  }

  /**
  * @Route("/getAsignarMentor/{id}", name="getAsignarMentor")
  */
  public function getAsignarMentor($id,Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $page= $request->query->get('pageActive');
        $page = empty($page) ? 1 : $page;

        $em = $this->getDoctrine()->getManager();
        $grupo = $em->getRepository('DataBundle:Grupo')->find($id);

        $mentores = $em->getRepository('DataBundle:Mentor')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($mentores, $page, 2);
        $items = $pagination->getItems();
        $pageCount = $pagination->getPageCount();

        return $this->render('MentoresBundle:Grupo:asignarMentor.html.twig',array(
          'grupo' => $grupo,
          'mentores'=> $items,
          'pageCount' => $pageCount
        ));
      }
      return $this->redirectToRoute('indexGrupos');
    }
    return $this->redirectToRoute('adminLogin');
  }

  /**
  * @Route("/setMentor", name="setMentor")
  * @Method({"POST"})
  */
  public function asignarMentor(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $idGrupo = $request->request->get('idGrupo');
        $idMentor = $request->request->get('idMentor');

        $em = $this->getDoctrine()->getManager();

        //Grupos asignados al mentor
        $gruposAsignados = $em->getRepository('DataBundle:Mentor_Grupos')->gruposAsignadosPorMentor($idMentor);

        //Mentor asignado al grupo
        $mentorAsignado = $em->getRepository('DataBundle:Mentor_Grupos')->getMentorAsignadoPorGrupo($idGrupo);

        if(count($gruposAsignados) < 2 ){
          $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);
          if(!$this->gruposMismaJornada($gruposAsignados, $grupo)){
            $mentor = $em->getRepository('DataBundle:Mentor')->find($idMentor);
            $mentor_grupos = new Mentor_Grupos();
            $mentor_grupos->setMentor($mentor);
            $mentor_grupos->setGrupo($grupo);
            if(!empty($mentorAsignado)){
              $mentorAsignado->setFechaDesasignacion(new \Datetime());
              $mentorAsignado->setActivo(false);
            }
            $em->persist($mentor_grupos);
            $em->flush();
            return new Response(Response::HTTP_OK);
          }
          return new Response("No se puede asignar un grupo en la misma jornada",400);
        }
        return new Response("No se pueden asignar mas grupos a este mentor",400);
      }
      return $this->redirectToRoute('indexGrupos');
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function existeRegistroSemillasPorGrupo($grupo){
    return (count($grupo->getSemillas())>0) ? true : false ;
  }

  private function agregarSegmentos($grupo){
    for ($i=0; $i <4 ; $i++) {
      $segmento = new Segmento();
      $segmento->setNumeroSegmento($i+1);
      $segmento->setActivo(true);
      $segmento->setGrupo($grupo);
      $grupo->addSegmento($segmento);
    }
  }

  //Metodo que verifica si el grupo que se va asignar a un Mentor
  //es de diferente joranda
  private function gruposMismaJornada($mentor_grupos, $grupo){
    foreach ($mentor_grupos as $grupos) {
      if($grupos->getActivo() == true && $grupos->getGrupo()->getJornada()->getId() == $grupo->getJornada()->getId()){
        return true;
      }
    }
    return false;
  }

  //Renderiza el mentor asociado a un grupo
  public function getMentorGrupoAction($id){
    $em = $this->getDoctrine()->getManager();
    $mentor = $em->getRepository('DataBundle:Mentor_Grupos')->getMentorAsignadoPorGrupo($id);

    if(empty($mentor)){
      return new Response("No asignado");
    }
    return new Response($mentor->getMentor()->getFullName());
  }


}
