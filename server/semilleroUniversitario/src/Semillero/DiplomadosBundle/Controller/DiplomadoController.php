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
        //------------------------------------------------------
        $dql = "SELECT d FROM DataBundle:Diplomado d";
        $diplomados = $em->createQuery($dql);
        //------------------------------------------------------
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
          $diplomados, $request->query->getInt('page',1),
          5
        );
        return $this->render('DiplomadosBundle:Diplomado:index.html.twig',array('pagination' => $pagination));
      }
      return $this->redirectToRoute('adminLogin');
    }

      //------------------ Metodo add, agregar un DIPLOMADO a la base de datos --------------------
    /**
    * @Route("/diplomados/add",name="addDiplomados")
    */
    public function addAction(Request $request)
    {
      if ($request->isXmlHttpRequest()) {
        $diplomado = new Diplomado();
        $form = $this->createCreateForm($diplomado);
        return $this->render('DiplomadosBundle:Diplomado:add.html.twig',array('form' =>$form->createView()));
      }
      return $this->redirectToRoute('indexDiplomados');
    }

    private function createCreateForm(Diplomado $entity)
    {
      $form = $this->createForm(new DiplomadoType(), $entity, array('method' => 'POST'));
      return $form;
    }

    /**
    * @Route("/diplomados/create",name="createDiplomados")
    *
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

        $this->addFlash('mensaje','¡El diplomado ha sido creado satisfactoriamente!');

        return $this->redirectToRoute('indexDiplomados');
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
    public function editAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $diplomado = $em->getRepository('DataBundle:Diplomado')->find($id);

      if(!$diplomado)
      {
        throw $this->createNotFoundException('El Diplomado a Editar NO Existe');
      }

      $form = $this->createEditForm($diplomado);
      return $this->render('DiplomadosBundle:Diplomado:edit.html.twig', array('diplomado'=>$diplomado, 'form'=>$form->createView()));
    }

    private function createEditForm(Diplomado $entity)
    {
      $form = $this->createForm(new DiplomadoType(), $entity, array('action' => $this->generateUrl('updateDiplomados', array('id' => $entity->getId())), 'method' => 'PUT'));
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
        $this->addFlash('mensaje','¡El Diplomado ha sido modificado satisfactoriamente!');
        return $this->redirectToRoute('indexDiplomados', array('id' => $diplomado->getId()));
      }
      return $this->render('DiplomadosBundle:Diplomado:edit.html.twig',array('grupo' => $diplomado, 'form' =>$form->createView()));
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
        $diplomado = $em->getRepository('DataBundle:Diplomado')->findById($id);

        if(!$diplomado)
        {
          return $this->redirectToRoute('indexDiplomados');
        }

        return $this->render('DiplomadosBundle:Diplomado:view.html.twig',array(
          'diplomado' => $diplomado[0]
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
        $em->remove($diplomado);
        $em->flush();
        return new Response(Response::HTTP_OK);
        return $this->redirectToRoute('indexDiplomados');
      }
      return new Response('user not loggin',Response::HTTP_NOT_FOUND);
      }
}
