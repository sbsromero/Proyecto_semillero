<?php

namespace Semillero\MentoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

use Semillero\DataBundle\Entity\Grupo;
use Semillero\DataBundle\Form\GrupoType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
* @Route("/admin")
*/
class GruposController extends Controller
{

  //------------------Metodo index, carga todos los grupos registrados en la base de datos --------------------
  /**
  * @Route("/grupos/index",name="indexGrupos")
  */

  public function indexAction(Request $request)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
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
    return $this->redirectToRoute('adminLogin');
  }

  //------------------ Metodo add, agregar un GRUPO a la base de datos --------------------
  /**
  * @Route("/grupos/add",name="addGrupos")
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
  * @Route("/grupos/create",name="createGrupos")
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
      //$grupo->setActivo(0);
      $em = $this->getDoctrine()->getManager();
      $em -> persist($grupo);
      $em -> flush();

      return $this->redirectToRoute('indexGrupos');
    }
    #Renderizamos al forumlario si existe algun problema
    return new Response($this->renderView('MentoresBundle:Grupo:add.html.twig',array(
      'form' =>$form->createView()
    )),400);
  }

  //------------------ Metodo edit, editar un GRUPO de la base de datos --------------------

  /**
  * @Route("/grupos/edit/{id}",name="editGrupos")
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
    $form = $this->createForm(new GrupoType(), $entity, array('action' => $this->generateUrl('updateGrupos', array('id' => $entity->getId())), 'method' => 'PUT'));
    return $form;
  }

  /**
  * @Route("/grupos/update/{id}",name="updateGrupos")
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
      return $this->redirectToRoute('indexGrupos', array('id' => $grupo->getId()));
    }
    return $this->render('MentoresBundle:Grupo:edit.html.twig',array('grupo' => $grupo, 'form' =>$form->createView()));
  }

  //------------------ Metodo view, carga un GRUPÓ seleccionado por parametro Id --------------------
  /**
  * @Route("/grupos/view/{id}",name="viewGrupos")
  */
  public function viewAction(Request $request,$id)
  {
    if ($request->isXmlHttpRequest()) {
      // $Repository = $this->getDoctrine()->getRepository('DataBundle:Grupo');
      // $grupo = $Repository->find($id);

      $em = $this->getDoctrine()->getManager();
      $Repository = $this->getDoctrine()->getRepository('DataBundle:Grupo');
      $grupo = $em->getRepository('DataBundle:Grupo')->find/*ById*/($id);
      if(!$grupo)
      {
        //throw $this->createNotFoundException('El Grupo a Editar NO Existe');
        return $this->redirectToRoute('indexGrupos');
      }
      $mentor = $grupo->getMentor();
      //$deleteForm = $this->createDeleteForm($grupo);
      //return $this->render('MentoresBundle:Grupo:view.html.twig',array('grupo' => $grupo,'mentor' => $mentor, 'delete_form' => $deleteForm->createView()));
      return $this->render('MentoresBundle:Grupo:view.html.twig',array(
        'grupo' => $grupo,'mentor' => $mentor));
    }
        return $this->redirectToRoute('indexGrupos');
  }


  // private function createDeleteForm($grupo)
  // {
  //   return $this->createFormBuilder()
  //   ->setAction($this->generateUrl('deleteGrupos',array('id' => $grupo->getId())))
  //   ->setMethod('DELETE')
  //   ->getForm();
  // }

  //------------------ Metodo delete, eliminar un GRUPÓ de la base de datos --------------------

  /**
  * @Route("/grupos/delete/{id}",name="deleteGrupos")
  * @Method({"POST","DELETE"})
  */

  public function deleteAction(Request $request, $id)
  {
    // $em = $this->getDoctrine()->getManager();
    // $grupo = $em->getRepository('DataBundle:Grupo')->find($id);
    // if(!$grupo)
    // {
    //   throw $this->createNotFoundException('El Grupo a eliminar NO Existe');
    // }
    //
    // $form = $this->createDeleteForm($grupo);
    // $form->handleRequest($request);
    //
    // if($form->isSubmitted() && $form->isValid())
    // {
    //
    //   $em->remove($grupo);
    //   $em -> flush();
    //
    //   $this->addFlash('mensaje','¡El grupo ha sido eliminado satisfactoriamente!');
    //   return $this->redirectToRoute('indexGrupos', array('id' => $grupo->getId()));
    //
    // }
  if($this->isGranted('IS_AUTHENTICATED_FULLY')){
  $em = $this->getDoctrine()->getManager();
  $grupo = $em->getRepository('DataBundle:Grupo')->find($id);
  $em->remove($grupo);
  $em->flush();
  return new Response(Response::HTTP_OK);
  return $this->redirectToRoute('indexGrupos');

  }
  return new Response('user not loggin',Response::HTTP_NOT_FOUND);
  }
}
