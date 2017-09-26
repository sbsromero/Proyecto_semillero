<?php

namespace Semillero\MentoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Semillero\DataBundle\Entity\Grupo;
use Semillero\DataBundle\Form\GrupoType;

class GruposController extends Controller
{

  //------------------Metodo index, carga todos los grupos registrados en la base de datos --------------------
  /**
  * @Route("/grupos/index",name="semillero_grupos_index")
  */

  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $grupos = $em->getRepository('DataBundle:Grupo')->findAll();

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $grupos, $request->query->getInt('page',1),
      5
    );

    return $this->render('MentoresBundle:Grupo:index.html.twig',array('pagination' => $pagination));
  }

  //------------------ Metodo add, agregar un GRUPO a la base de datos --------------------
  /**
  * @Route("/grupos/add",name="semillero_grupos_add")
  */
  public function addAction()
  {
    $grupo = new Grupo();
    $form = $this->createCreateForm($grupo);
    return $this->render('MentoresBundle:Grupo:add.html.twig',array('form' =>$form->createView()));
  }

  private function createCreateForm(Grupo $entity)
  {
    $form = $this->createForm(new GrupoType(), $entity, array(
      'action' => $this->generateUrl('semillero_grupos_create'),
      'method' => 'POST'
    ));

    return $form;
  }

  /**
  * @Route("/grupos/create",name="semillero_grupos_create")
  *
  */
  public function createAction(Request $request)
  {
    $grupo = new Grupo();
    $form = $this->createCreateForm($grupo);
    $form->handleRequest($request);

    #Validamos si el formulario se envio correctamente
    if($form->isValid())
    {

      $grupo->setActivo(0);
      $em = $this->getDoctrine()->getManager();
      $em -> persist($grupo);
      $em -> flush();

      $this->addFlash('mensaje','¡El grupo ha sido creado satisfactoriamente!');

      return $this->redirectToRoute('semillero_grupos_index');
    }
    #Renderizamos al forumlario si existe algun problema
    return $this->render('MentoresBundle:Grupo:add.html.twig',array('form' =>$form->createView()));
  }
}
