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
        'form' => $form->createView()
      ));
    }
    return $this->redirectToRoute('adminLogin');
  }

  /**
  * @Route("/semestres/create", name="createSemestre")
  * @Method({"POST"})
  */
  public function crearSemestre(Request $request){
    $semestre = new Semestre();
    $form = $this->createAddSemestreForm($semestre);


    // $anoSemestre = $request->request->get('semestre')['anoSemestre'];
    // $semestreModificado = $request->request->get('semestre');
    // $semestreModificado['anoSemestre'] = (new \DateTime("01-01-".$anoSemestre))->format('yyyy');
    // $request->request->set('semestre',$semestreModificado);

    $form->handleRequest($request);
    // dump($request->request->all(),$form->isValid());exit();
    $em = $this->getDoctrine()->getManager();
    $segmentos = $em->getRepository('DataBundle:Segmento')->findAll();
    
    dump($form->get('periodo')->isValid(),
    $form->get('activo')->isValid(),
    $form->get('anoSemestre')->isValid(),
    $form->isValid());exit();

    if($form->isValid()){
      for ($i=0; $i < 4 ; $i++) {
        $Semestre->addSegmento($segmentos[$i]);
      }
      $em = $this->getDoctrine()->getManager();
      $em -> persist($semestre);
      $em -> flush();

      return new Response(Response::HTTP_OK);
    }
    return new Response($this->renderView('ParametrosBundle:Semestre:addSemestre.html.twig',array(
      'form' =>$form->createView()
    )),400);
  }

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
