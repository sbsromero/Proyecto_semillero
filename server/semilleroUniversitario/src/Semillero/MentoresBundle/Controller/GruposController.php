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
      $mentor = $grupo->getMentor();
      return $this->render('MentoresBundle:Grupo:view.html.twig',array(
        'grupo' => $grupo,
        'mentor' => $mentor));
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

  //Metodo que permite generar un pdf con las semillas de un grupo
  /**
  * @Route("/getPdfGrupoSemillas",name="getPdfGrupoSemillas")
  */
  public function getPdfGrupoSemillas(Request $request){
    $idGrupo = $request->query->get('id');
    $em = $this->getDoctrine()->getManager();
    $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);
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


}
