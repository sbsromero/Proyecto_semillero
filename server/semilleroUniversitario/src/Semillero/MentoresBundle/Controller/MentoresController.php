<?php

namespace Semillero\MentoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

use Semillero\DataBundle\Entity\Mentor;
use Semillero\DataBundle\Form\MentorType;
use Symfony\Component\HttpFoundation\File\File;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\PropertyAccess\PropertyAccess;


/**
* @Route("/admin")
*/
class MentoresController extends Controller
{

  #Definición de rutas las rutas para el sistema CRUD MENTORES


  //------------------Metodo index, carga todos los mentores registrados en la base de datos --------------------
  /**
  * @Route("/mentores/index",name="indexMentores")
  */

  public function indexAction(Request $request)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $valorBusqueda = $request->query->get('valorBusqueda');
      $btnMostrarMentores = $request->query->get('btnMostrarMentores');
      $valorBusqueda = empty($valorBusqueda) ? "" : $valorBusqueda;

      if(!empty($btnMostrarMentores)){
        $valorBusqueda = "";
      }

      $mentores = $em->getRepository('DataBundle:Mentor')->getAllMentores($valorBusqueda);

      $page= $request->query->get('pageActive');
      $page = empty($page) ? 1 : $page;

      $paginator = $this->get('knp_paginator');
      $pagination = $paginator->paginate($mentores,$page,10);
      $items = $pagination->getItems();
      $pageCount = $pagination->getPageCount();

      return $this->render('MentoresBundle:Mentor:index.html.twig',array(
        'pageCount' => $pageCount,
        'pagination' => $items));
    }
    return $this->redirectToRoute('adminLogin');
  }


  //------------------ Metodo add, agregar un MENTOR a la base de datos --------------------
  /**
  * @Route("/mentores/add",name="addMentores")
  */

  public function addAction()
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      #Creamos nuestro objeto mentor para poder acceder a cada una de las propiedades y metodos de nuestra entidad (mentor)
      $mentor = new Mentor();
      #Variable que llama al metodo creaCreateForm, creado luego
      $form = $this-> createCreateForm($mentor);
      return $this->render('MentoresBundle:Mentor:add.html.twig',array('form' =>$form->createView()));
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function createCreateForm(Mentor $entity)
  {
    $form = $this-> createForm(new MentorType(),$entity, array (
      'action' => $this->generateUrl('createMentores'),
      'method' => 'POST'
    ));

    return $form;
  }

  /**
  * @Route("/mentores/create",name="createMentores")
  * @Method({"POST"})
  */

  public function createAction(Request $request)
  {
    $mentor = new Mentor();
    $form = $this->createCreateForm($mentor);
    $em = $this->getDoctrine()->getManager();

    $emailExistente = $em->getRepository('DataBundle:Usuarios')->findByEmail($request->request->get('mentor')['email']);
    $documentoExistente = $em->getRepository('DataBundle:Usuarios')->findByNumeroDocumento($request->request->get('mentor')['numeroDocumento']);;

    $form->handleRequest($request);

    if(!empty($emailExistente)){
      $form->get('email')->addError(new FormError('El email ya se encuentra registrado'));
    }
    if(!empty($documentoExistente)){
      $form->get('numeroDocumento')->addError(new FormError('Documento ya registrado'));
    }

    #Validamos si el formulario se envio correctamente
    if($form->isValid())
    {
      $password = $form->get('password')->getData();
      $encoder = $this->container->get('security.password_encoder');
      $encoded = $encoder->encodePassword($mentor, $password);

      $mentor->setPassword($encoded);
      $mentor->setActivo(true);

      $numeroDocumento = $mentor->getNumeroDocumento();
      $ruta = "public/uploads/".$numeroDocumento."/";

      $imageProfile = $request->files->get('mentor')['urlImage'];
      if(!empty($imageProfile)){
        $fileName = $numeroDocumento.'.'.$imageProfile->guessExtension();
        $mentor->setUrlImage($ruta.$fileName);
        $imageProfile->move(
          $ruta,
          $fileName
        );
      }

      $em -> persist($mentor);
      $em -> flush();

      $this->addFlash('mensajeMentor','¡El mentor ha sido creado satisfactoriamente!');

      return $this->redirectToRoute('indexMentores');
    }
    #Renderizamos al formulario si existe algun problema
    return $this->render('MentoresBundle:Mentor:add.html.twig',array('form' =>$form->createView()));
  }

  //------------------ Metodo edit, editar un MENTOR de la base de datos --------------------

  /**
  * @Route("/mentores/edit/{numeroDocumento}",name="editMentores")
  */
  public function editAction($numeroDocumento)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $mentor = $em->getRepository('DataBundle:Mentor')->findOneByNumeroDocumento($numeroDocumento);
      $ruta = $mentor->getUrlImage();
      $accessor = PropertyAccess::createPropertyAccessor();

      if(!$mentor)
      {
        return $this->redirectToRoute('indexMentores');
      }

      if(file_exists($ruta)){
        $accessor->setValue($mentor,'urlImage',new File($ruta));
      }
      else{
        $accessor->setValue($mentor,'urlImage',new File('public/images/image-profile.png'));
      }

      $form = $this->createEditForm($mentor);
      return $this->render('MentoresBundle:Mentor:edit.html.twig', array('mentor'=>$mentor, 'form'=>$form->createView()));
    }
    return $this->redirectToRoute('adminLogin');
  }

  private function createEditForm(Mentor $entity)
  {
    $form = $this->createForm(new MentorType(), $entity, array('action' => $this->generateUrl('updateMentores', array('numeroDocumento' => $entity->getNumeroDocumento())), 'method' => 'PUT'));
    return $form;
  }

  /**
  * @Route("/mentores/update/{numeroDocumento}",name="updateMentores")
  * @Method({"POST","PUT"})
  */
  public function updateAction($numeroDocumento, Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $mentor = $em->getRepository('DataBundle:Mentor')->findOneByNumeroDocumento($numeroDocumento);
    $ruta = $mentor->getUrlImage();
    $accessor = PropertyAccess::createPropertyAccessor();

    if(!$mentor)
    {
      throw $this->createNotFoundException('El Mentor a Editar NO Existe');
    }

    if(file_exists($ruta)){
      $accessor->setValue($mentor,'urlImage',new File($ruta));
    }
    else{
      $accessor->setValue($mentor,'urlImage',new File('public/images/image-profile.png'));
    }

    $form = $this->createEditForm($mentor);
    $form->handleRequest($request);

    if($form->isValid())
    {
      $password = $form->get('password')->getData();

      //Verificamos si se puso una nueva contraseña
      if(!empty($password))
      {
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($mentor, $password);
        $mentor->setPassword($encoded);
      }
      else
      {
        $pass = $em->getRepository('DataBundle:Mentor')->recoverPass($numeroDocumento);
        $mentor->setPassword($pass[0]['password']);
      }

      $numeroDocumento = $mentor->getNumeroDocumento();
      $ruta = "public/uploads/".$numeroDocumento."/";

      $imageProfile = $request->files->get('mentor')['urlImage'];

      if(!empty($imageProfile)){
        $fileName = $numeroDocumento.'.'.$imageProfile->guessExtension();
        $mentor->setUrlImage($ruta.$fileName);
        $imageProfile->move(
          $ruta,
          $fileName
        );
      }

      $em -> flush();
      $this->addFlash('mensajeMentor','El mentor ha sido modificado satisfactoriamente');
      return $this->redirectToRoute('indexMentores');
    }
    return $this->render('MentoresBundle:Mentor:edit.html.twig',array('mentor' => $mentor, 'form' =>$form->createView()));
  }


  //------------------ Metodo view, carga un MENTOR seleccionado por parametro NumeroDocumento --------------------

  /**
  * @Route("/mentores/view/{id}",name="viewMentores")
  */
  public function viewAction(Request $request,$id)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $Repository = $this->getDoctrine()->getRepository('DataBundle:Mentor');
        $mentor = $em->getRepository('DataBundle:Mentor')->findById($id);

        if(!$mentor)
        {
          return $this->redirectToRoute('indexMentores');
        }

        return $this->render('MentoresBundle:Mentor:view.html.twig',array(
          'mentor' => $mentor[0]
        ));
      }
      return $this->redirectToRoute('indexMentores');
    }
    return $this->redirectToRoute('adminLogin');
  }

  //------------------ Metodo delete, eliminar un MENTOR de la base de datos --------------------

  /**
  * @Route("/mentores/delete/{id}",name="deleteMentores")
  * @Method({"POST","DELETE"})
  */
  public function deleteAction(Request $request, $id)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $mentor = $em->getRepository('DataBundle:Mentor')->find($id);
        if(count($mentor->getGrupos())==0){
          $em->remove($mentor);
          $em->flush();
          return new Response(Response::HTTP_OK);
        }
        return new Response('grupos assignados al mentor',Response::HTTP_NOT_FOUND);
      }
      return $this->redirectToRoute('indexMentores');
    }
    return new Response('user not loggin',Response::HTTP_NOT_FOUND);
  }

  /**
  * @Route("/mentores/inactivarMentor/{dni}", name="inactivarMentor")
  * @Method({"POST"})
  */
  public function inactivarMentorAction($dni)
  {
    $em = $this->getDoctrine()->getManager();
    $mentor = $em->getRepository('DataBundle:Mentor')->findOneByNumeroDocumento($dni);
    if($mentor->getActivo()){
      $mentor->setActivo("false");
    }
    else{
      $mentor->setActivo("true");
    }
    $em->flush();
    return new Response(Response::HTTP_OK);
  }

  //Metodo que permite generar un pdf con todos los mentores registrados
  /**
  * @Route("/getPdfMentores",name="getPdfMentores")
  */
  public function getPdfMentores(Request $request){
    $em = $this->getDoctrine()->getManager();
    $mentores = $em->getRepository('DataBundle:Mentor')->findAll();

    return new PdfResponse(
      $this->get('knp_snappy.pdf')->getOutputFromHtml($this->renderView('MentoresBundle:Mentor:plantillaPdfMentores.html.twig', array(
        'base_dir' => $this->get('kernel')->getRootDir().'/../web'. $request->getBasePath(),
        'mentores' => $mentores
      ))),
      'reporteMentores'.'.pdf'
    );
  }

  /**
  * @Route("/mentores/historicoGruposMentor/{id}", name="historicoGruposMentor")
  */
  public function getHistoricoGruposMentores($id, Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $historicoGrupos = $em->getRepository('DataBundle:Mentor_Grupos')->getHistoricoGrupos($id);

        return $this->render('MentoresBundle:Mentor:historicoGrupos.html.twig', array(
          'historicoGrupos' => $historicoGrupos
        ));
      }
      return $this->redirectToRoute('indexMentores');
    }
    return $this->redirectToRoute('adminLogin');
  }
}
