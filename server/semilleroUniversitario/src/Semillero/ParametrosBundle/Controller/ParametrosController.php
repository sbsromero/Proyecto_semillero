<?php

namespace Semillero\ParametrosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Semillero\DataBundle\Entity\Semestre;
use Semillero\DataBundle\Entity\Segmento;
use Semillero\DataBundle\Form\SemestreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
* @Route("/admin/parametros")
*/
class ParametrosController extends Controller
{
  /**
  * @Route("/index",name="indexParametros")
  */
  public function indexAction(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->render('ParametrosBundle:Parametros:index.html.twig');
    }
    return $this->redirectToRoute('adminLogin');
  }

  /**
  * @Route("/semestres/index", name="indexSemestres")
  */
  public function indexSemestresAction(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $semestres = $em->getRepository('DataBundle:Semestre')->findAll();

      $page= $request->query->get('pageActive');
      $page = empty($page) ? 1 : $page;

      $paginator = $this->get('knp_paginator');
      $pagination = $paginator->paginate($semestres,$page,5);
      $items = $pagination->getItems();
      $pageCount = $pagination->getPageCount();

      return $this->render('ParametrosBundle:Semestre:indexSemestres.html.twig', array(
        'pageCount' => $pageCount,
        'pagination' => $items
      ));
    }
    return $this->redirectToRoute('adminLogin');
  }

  /**
  * @Route("/semestres/add", name="addSemestre")
  */
  public function addSemestre(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $semestre = new Semestre();
      $form = $this->createAddSemestreForm($semestre);
      return $this->render('ParametrosBundle:Semestre:addSemestre.html.twig',array(
        'form' => $form->createView(),
        'error' => false
      ));
    }
    return $this->redirectToRoute('adminLogin');
  }

  /**
  * @Route("/semestres/create", name="createSemestre")
  * @Method({"POST"})
  */
  public function crearSemestre(Request $request){
    $em = $this->getDoctrine()->getManager();
    $semestre = new Semestre();

    $semestreRequest = $request->request->get('semestre');
    $semestreRequest['anoSemestre']['month'] = "1";
    $semestreRequest['anoSemestre']['day'] = "1";

    $request->request->set('semestre',$semestreRequest);

    $form = $this->createAddSemestreForm($semestre);
    $form->handleRequest($request);
    if($form->isValid()){
      $periodo = $semestre->getPeriodo();
      $año = $semestre->getAnoSemestre()->format('Y');

      $res = $em->getRepository('DataBundle:Semestre')->validarCreacionSemestre($periodo,$año);
      if(empty($res)){
        $em -> persist($semestre);
        $em -> flush();
        return new Response(Response::HTTP_OK);
      }
      return new Response($this->renderView('ParametrosBundle:Semestre:addSemestre.html.twig',array(
        'form' =>$form->createView(),
        'error' => true
      )),400);
    }

    return new Response($this->renderView('ParametrosBundle:Semestre:addSemestre.html.twig',array(
      'form' =>$form->createView(),
      'error' => false
    )),400);
  }

  /**
  * @Route("/semestre/activarSemestre/{id}", name="activarSemestre")
  * @Method({"POST"})
  */
  public function activarSemestre(Request $request,$id){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $semestre = $em->getRepository('DataBundle:Semestre')->find($id);
        $semestre->setActivo(true);
        $em->flush();
        return new Response(Response::HTTP_OK);
      }
      return $this->redirectToRoute('indexSemestres');
    }
    return $this->redirectToRoute('adminLogin');
  }

  /**
  * @Route("/semestre/inactivarSemestre/{id}", name="inactivarSemestre")
  * @Method({"POST"})
  */
  public function inactivarSemestre(Request $request,$id){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $semestre = $em->getRepository('DataBundle:Semestre')->find($id);
        $semestre->setActivo(false);
        $em->flush();
        return new Response(Response::HTTP_OK);
      }
      return $this->redirectToRoute('indexSemestres');
    }
    return $this->redirectToRoute('adminLogin');
  }

  //Crea el formulario para registrar un semestre partiendo de la entidad semestre
  private function createAddSemestreForm(Semestre $entity)
  {
    $form = $this-> createForm(new SemestreType(),$entity, array (
      'method' => 'POST'
    ));
    return $form;
  }

  /**
  * @Route("/segmentos/index",name="indexSegmentos")
  */
  public function indexSegmentos(Request $request)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $segmentos = $em->getRepository('DataBundle:Segmento')->findAll();

      $page= $request->query->get('pageActive');
      $page = empty($page) ? 1 : $page;

      $paginator = $this->get('knp_paginator');
      $pagination = $paginator->paginate($segmentos,$page,5);
      $items = $pagination->getItems();
      $pageCount = $pagination->getPageCount();

      return $this->render('ParametrosBundle:Segmentos:indexSegmentos.html.twig', array(
        'pageCount' => $pageCount,
        'pagination' => $items
      ));
    }
    return $this->redirectToRoute('adminLogin');
  }

  /**
  * @Route("/segmentos/add", name="addSegmento")
  */
  public function addSegmento(Request $request)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $segmento = new Segmento();
      $form = $this->createAddSegmentoForm($segmento);
      return $this->render('ParametrosBundle:Segmentos:addSegmento.html.twig',array(
        'form' =>$form->createView()));
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function createAddSegmentoForm(Segmento $entity)
  {
    $form = $this-> createForm(new SegmentoType(),$entity, array (
      'method' => 'POST'
    ));
    return $form;
  }


}
