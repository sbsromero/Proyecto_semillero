<?php

namespace Semillero\SemillasBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

use Semillero\DataBundle\Entity\Semilla;
use Semillero\DataBundle\Form\SemillaType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
* @Route("/admin")
*/
class SemillaController extends Controller
{
  //------------------Metodo index, carga todos las semillas registrados en la base de datos --------------------
  /**
  * @Route("/semillas/index",name="indexSemillas")
  */

  public function indexAction(Request $request)
  {
    // if($this->isGranted('IS_AUTHENTICATED_FULLY')){
    //   $em = $this->getDoctrine()->getManager();
    //
    //   $dql = "SELECT s FROM DataBundle:Semilla s";
    //   $semillas = $em->createQuery($dql);
    //
    //   $paginator = $this->get('knp_paginator');
    //   $pagination = $paginator->paginate(
    //     $semillas, $request->query->getInt('page',1),
    //     5
    //   );
    //   //
    //   return $this->render('SemillasBundle:Semilla:index.html.twig',array('pagination' => $pagination));
    // }
    // return $this->redirectToRoute('adminLogin');
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
      $pagination = $paginator->paginate($semillas,$page,5);
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
  * @Route("/semillas/add",name="addSemillas")
  */

  public function addAction()
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      #Creamos nuestro objeto semilla para poder acceder a cada una de las propiedades y metodos de nuestra entidad (semilla)
      $semilla = new Semilla();
      #Variable que llama al metodo creaCreateForm, creado luego
      $form = $this-> createCreateForm($semilla);
      return $this->render('SemillasBundle:Semilla:add.html.twig',array(
        'form' =>$form->createView()));
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function createCreateForm(Semilla $entity)
  {
    $form = $this-> createForm(new SemillaType(),$entity, array (
      'action' => $this->generateUrl('createSemillas'),
      'method' => 'POST'
    ));

    return $form;
  }

  /**
  * @Route("/semillas/create",name="createSemillas")
  * @Method({"POST"})
  */

  public function createAction(Request $request)
  {
    $semilla = new Semilla();
    $form = $this->createCreateForm($semilla);
    $form->handleRequest($request);

    #Validamos si el formulario se envio correctamente
    if($form->isValid())
    {
      $password = $form->get('password')->getData();
      $encoder = $this->container->get('security.password_encoder');
      $encoded = $encoder->encodePassword($semilla, $password);

      $semilla->setPassword($encoded);
      $semilla->setActivo(true);

      $em = $this->getDoctrine()->getManager();
      $em -> persist($semilla);
      $em -> flush();

      $this->addFlash('mensaje','¡La semilla ha sido creado satisfactoriamente!');

      return $this->redirectToRoute('indexSemillas');
    }
    #Renderizamos al formulario si existe algun problema
    return $this->render('SemillasBundle:Semilla:add.html.twig',array('form' =>$form->createView()));
  }

  //------------------ Metodo edit, editar una SEMILLA de la base de datos --------------------

  /**
  * @Route("/semillas/edit/{numeroDocumento}",name="editSemillas")
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
      return $this->render('SemillasBundle:Semilla:edit.html.twig', array('semilla'=>$semilla, 'form'=>$form->createView()));
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function createEditForm(Semilla $entity)
  {
    $form = $this->createForm(new SemillaType(), $entity, array('action' => $this->generateUrl('updateSemillas', array('numeroDocumento' => $entity->getNumeroDocumento())), 'method' => 'PUT'));
    return $form;
  }

  /**
  * @Route("/semillas/update/{numeroDocumento}",name="updateSemillas")
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

    if($form->isSubmitted() && $form->isValid())
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
      $this->addFlash('mensaje','¡La semilla ha sido modificado satisfactoriamente!');
      return $this->redirectToRoute('indexSemillas', array('numeroDocumento' => $semilla->getNumeroDocumento()));
    }
    return $this->render('SemillasBundle:Semilla:edit.html.twig',array('semilla' => $semilla, 'form' =>$form->createView()));
  }

  //------------------ Metodo view, carga una SEMILLA seleccionado por parametro NumeroDocumento --------------------

  /**
  * @Route("/semillas/view/{id}",name="viewSemillas")
  */
  public function viewAction(Request $request,$id)
  {
    if ($request->isXmlHttpRequest()) {
      $em = $this->getDoctrine()->getManager();
      $Repository = $this->getDoctrine()->getRepository('DataBundle:Semilla');
      $semilla = $em->getRepository('DataBundle:Semilla')->findById($id);

      if(!$semilla)
      {
        return $this->redirectToRoute('indexSemillas');
      }

      return $this->render('SemillasBundle:Semilla:view.html.twig',array(
        'semilla' => $semilla[0]
      ));
    }
    return $this->redirectToRoute('indexSemillas');
  }

  //------------------ Metodo delete, eliminar una SEMILLA de la base de datos --------------------

  /**
  * @Route("/semillas/delete/{id}",name="deleteSemillas")
  * @Method({"POST","DELETE"})
  */
  public function deleteAction(Request $request, $id)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $semilla = $em->getRepository('DataBundle:Semilla')->find($id);
      $em->remove($semilla);
      $em->flush();
      return new Response(Response::HTTP_OK);
      return $this->redirectToRoute('indexSemillas');

    }
    return new Response('user not loggin',Response::HTTP_NOT_FOUND);
  }

}
