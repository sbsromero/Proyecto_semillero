<?php

namespace Semillero\DiplomadosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

use Semillero\DataBundle\Entity\Diplomado;
use Semillero\DataBundle\Form\DiplomadoType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
* @Route("/admin")
*/

class DiplomadoController extends Controller
{
    //------------------Metodo index, carga todos los diplomados registrados en la base de datos --------------------
    /**
    * @Route("/diplomados/index",name="indexDiplomados")
    */

    public function indexAction(Request $request)
    {
      if($this->isGranted('IS_AUTHENTICATED_FULLY')){
        $em = $this->getDoctrine()->getManager();
        $valorBusqueda = $request->query->get('valorBusqueda');
        $btnMostrarDiplomados = $request->query->get('btnMostrarDiplomados');
        $valorBusqueda = empty($valorBusqueda) ? "" : $valorBusqueda;

        if(!empty($btnMostrarDiplomados)){
          $valorBusqueda = "";
        }

        $diplomados = $em->getRepository('DataBundle:Diplomado')->getAllDiplomados($valorBusqueda);
        $page= $request->query->get('pageActive');
        $page = empty($page) ? 1 : $page;

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($diplomados,$page,10);
        $items = $pagination->getItems();
        $pageCount = $pagination->getPageCount();
        return $this->render('DiplomadosBundle:Diplomado:index.html.twig',array(
          'pageCount' => $pageCount,
          'pagination' => $items));
      }
      return $this->redirectToRoute('adminLogin');
    }

      //------------------ Metodo add, agregar un DIPLOMADO a la base de datos --------------------
    /**
    * @Route("/diplomados/add",name="addDiplomados")
    */
    public function addAction(Request $request)
    {
      if($this->isGranted('IS_AUTHENTICATED_FULLY')){
        if ($request->isXmlHttpRequest() ) {
          $diplomado = new Diplomado();
          $form = $this->createCreateForm($diplomado);
          return $this->render('DiplomadosBundle:Diplomado:add.html.twig',array('form' =>$form->createView()));
        }
        return $this->redirectToRoute('indexDiplomados');
      }
      return $this->redirectToRoute('adminLogin');
    }

    private function createCreateForm(Diplomado $entity)
    {
      $form = $this->createForm(new DiplomadoType(), $entity, array('method' => 'POST'));
      return $form;
    }

    /**
    * @Route("/diplomados/create",name="createDiplomados")
    * @Method({"POST"})
    */
    public function createAction(Request $request)
    {
      $diplomado = new Diplomado();
      $form = $this->createCreateForm($diplomado);
      $form->handleRequest($request);

      #Validamos si el formulario se envio correctamente
      if($form->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        $em -> persist($diplomado);
        $em -> flush();

        return new Response(Response::HTTP_OK);
      }
      #Renderizamos al forumlario si existe algun problema
      return new Response($this->renderView('DiplomadosBundle:Diplomado:add.html.twig',array(
        'form' =>$form->createView()
      )),400);
    }

    //------------------ Metodo edit, editar un DIPLOMADO de la base de datos --------------------

    /**
    * @Route("/diplomados/edit/{id}",name="editDiplomados")
    */
    public function editAction($id,Request $request)
    {
      if($this->isGranted('IS_AUTHENTICATED_FULLY')){
        if ($request->isXmlHttpRequest()) {
          $em = $this->getDoctrine()->getManager();
          $diplomado = $em->getRepository('DataBundle:Diplomado')->find($id);
          if(!$diplomado)
          {
            return $this->redirectToRoute('indexDiplomados');
          }
          $form = $this->createEditForm($diplomado);
          return $this->render('DiplomadosBundle:Diplomado:edit.html.twig', array(
            'idDiplomado'=>$id,
            'form'=>$form->createView()));
        }
        return $this->redirectToRoute('indexDiplomados');
      }
      return $this->redirectToRoute('adminLogin');
    }

    private function createEditForm(Diplomado $entity)
    {
      $form = $this->createForm(new DiplomadoType(), $entity, array('method' => 'PUT'));
      // $form = $this->createForm(new DiplomadoType(), $entity, array('action' => $this->generateUrl('updateDiplomados', array('id' => $entity->getId())), 'method' => 'PUT'));
      return $form;
    }

    /**
    * @Route("/diplomados/update/{id}",name="updateDiplomados")
    * @Method({"POST","PUT"})
    */
    public function updateAction($id, Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $diplomado = $em->getRepository('DataBundle:Diplomado')->find($id);

      if(!$diplomado)
      {
        throw $this->createNotFoundException('El Diplomado a Editar NO Existe');
      }

      $form = $this->createEditForm($diplomado);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid())
      {
        $em -> flush();
        return new Response(Response::HTTP_OK);
      }
      return new Response($this->renderView('DiplomadosBundle:Diplomado:edit.html.twig',array(
        'idDiplomado'=>$id,
        'form' =>$form->createView()
      )),400);
    }

    //------------------ Metodo view, carga un DIPLOMADO seleccionado por parametro Id --------------------

    /**
    * @Route("/diplomados/view/{id}",name="viewDiplomados")
    */
    public function viewAction(Request $request,$id)
    {
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $Repository = $this->getDoctrine()->getRepository('DataBundle:Diplomado');
        $diplomado = $em->getRepository('DataBundle:Diplomado')->findById($id)[0];

        if(!$diplomado)
        {
          return $this->redirectToRoute('indexDiplomados');
        }

        return $this->render('DiplomadosBundle:Diplomado:view.html.twig',array(
          'diplomado' => $diplomado
        ));
      }
      return $this->redirectToRoute('indexDiplomados');
    }


    //------------------ Metodo delete, eliminar un DIPLOMADO de la base de datos --------------------

    /**
    * @Route("/diplomados/delete/{id}",name="deleteDiplomados")
    * @Method({"POST","DELETE"})
    */

    public function deleteAction(Request $request, $id)
    {
      if($this->isGranted('IS_AUTHENTICATED_FULLY')){
        $em = $this->getDoctrine()->getManager();
        $diplomado = $em->getRepository('DataBundle:Diplomado')->find($id);
        if(count($diplomado->getGrupos()) == 0){
          $em->remove($diplomado);
          $em->flush();
          return new Response(Response::HTTP_OK);
        }
        return new Response('No se puede eliminar este diplomado, tiene grupos asignados',Response::HTTP_NOT_FOUND);
      }
      return $this->redirectToRoute('adminLogin');
      // return new Response('user not loggin',Response::HTTP_NOT_FOUND);
      }
}
