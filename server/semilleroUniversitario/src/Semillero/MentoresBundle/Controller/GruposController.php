<?php

namespace Semillero\MentoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Semillero\DataBundle\Entity\Grupo;
use Semillero\DataBundle\Form\GrupoType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class GruposController extends Controller
{

  //------------------Metodo index, carga todos los grupos registrados en la base de datos --------------------
  /**
  * @Route("/grupos/index",name="semillero_grupos_index")
  */

  public function indexAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    //$grupos = $em->getRepository('DataBundle:Grupo')->findAll();

    //------------------------------------------------------
    $dql = "SELECT g FROM DataBundle:Grupo g";
    $grupos = $em->createQuery($dql);
    //------------------------------------------------------

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

      //$grupo->setActivo(0);
      $em = $this->getDoctrine()->getManager();
      $em -> persist($grupo);
      $em -> flush();

      $this->addFlash('mensaje','¡El grupo ha sido creado satisfactoriamente!');

      return $this->redirectToRoute('semillero_grupos_index');
    }
    #Renderizamos al forumlario si existe algun problema
    return $this->render('MentoresBundle:Grupo:add.html.twig',array('form' =>$form->createView()));
  }

  //------------------ Metodo edit, editar un MENTOR de la base de datos --------------------

  /**
  * @Route("/grupos/edit/{id}",name="semillero_grupos_edit")
  */
  public function editAction($id)
  {
    $em = $this->getDoctrine()->getManager();
    $grupo = $em->getRepository('DataBundle:Grupo')->find($id);

    if(!$grupo)
    {
      throw $this->createNotFoundException('El Grupo a Editar NO Existe');
    }
    $form = $this->createEditForm($grupo);

    return $this->render('MentoresBundle:Grupo:edit.html.twig', array('grupo'=>$grupo, 'form'=>$form->createView()));
  }

  private function createEditForm(Grupo $entity)
  {
    $form = $this->createForm(new GrupoType(), $entity, array('action' => $this->generateUrl('semillero_grupos_update', array('id' => $entity->getId())), 'method' => 'PUT'));
    return $form;
  }

  /**
  * @Route("/grupos/update/{id}",name="semillero_grupos_update")
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
      $this->addFlash('mensaje','¡El Grupo ha sido modificado satisfactoriamente!');
      return $this->redirectToRoute('semillero_grupos_index', array('id' => $grupo->getId()));
    }
    return $this->render('MentoresBundle:Grupo:edit.html.twig',array('grupo' => $grupo, 'form' =>$form->createView()));
  }

  //------------------ Metodo view, carga un GRUPÓ seleccionado por parametro Id --------------------
  /**
  * @Route("/grupos/view/{id}",name="semillero_grupos_view")
  */
  public function viewAction($id)
  {
    $Repository = $this->getDoctrine()->getRepository('DataBundle:Grupo');
    $grupo = $Repository->find($id);
    if(!$grupo)
    {
      throw $this->createNotFoundException('El Grupo a Editar NO Existe');
    }
    $mentor = $grupo->getMentor();
    $deleteForm = $this->createDeleteForm($grupo);
    return $this->render('MentoresBundle:Grupo:view.html.twig',array('grupo' => $grupo,'mentor' => $mentor, 'delete_form' => $deleteForm->createView()));
  }

  private function createDeleteForm($grupo)
  {
    return $this->createFormBuilder()
    ->setAction($this->generateUrl('semillero_grupos_delete',array('id' => $grupo->getId())))
    ->setMethod('DELETE')
    ->getForm();
  }

  //------------------ Metodo delete, eliminar un GRUPÓ de la base de datos --------------------

  /**
  * @Route("/grupos/delete/{id}",name="semillero_grupos_delete")
  * @Method({"POST","DELETE"})
  */

  public function deleteAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $grupo = $em->getRepository('DataBundle:Grupo')->find($id);

    if(!$grupo)
    {
      throw $this->createNotFoundException('El Grupo a eliminar NO Existe');
    }

    $form = $this->createDeleteForm($grupo);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {

      $em->remove($grupo);
      $em -> flush();

      $this->addFlash('mensaje','¡El grupo ha sido eliminado satisfactoriamente!');
      return $this->redirectToRoute('semillero_grupos_index', array('id' => $grupo->getId()));

    }
  }
}
