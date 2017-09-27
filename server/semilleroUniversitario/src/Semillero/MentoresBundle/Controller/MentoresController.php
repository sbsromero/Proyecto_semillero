<?php

namespace Semillero\MentoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

use Semillero\DataBundle\Entity\Mentor;
use Semillero\DataBundle\Form\MentorType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class MentoresController extends Controller
{

  #Definición de rutas las rutas para el sistema CRUD MENTORES

  //------------------Metodo index, carga todos los mentores registrados en la base de datos --------------------
  /**
  * @Route("/mentores/index",name="semillero_mentores_index")
  */

  public function indexAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();
    //$mentores = $em->getRepository('DataBundle:Mentor')->findAll();

    //------------------------------------------------------
    $dql = "SELECT m FROM DataBundle:Mentor m";
    $mentores = $em->createQuery($dql);
    //------------------------------------------------------

    $paginator = $this->get('knp_paginator');
    $pagination = $paginator->paginate(
      $mentores, $request->query->getInt('page',1),
      5
    );

    return $this->render('MentoresBundle:Mentor:index.html.twig',array('pagination' => $pagination));

    #Estructura: Bundle, Carpeta que contiene la vista, accion que se redirijira, tiene el mismo nombre de la plantilla
    #El array contiene el valor que nosostros queremos mandar a la plantilla, Lo que posee misMntores().
    #return $this->render('MentoresBundle:Mentor:index.html.twig',array('Mentor' => $misMentores));
  }


  //------------------ Metodo add, agregar un MENTOR a la base de datos --------------------
  /**
  * @Route("/mentores/add",name="semillero_mentores_add")
  */

  public function addAction()
  {
    #Creamos nuestro objeto mentor para poder acceder a cada una de las propiedades y metodos de nuestra entidad (mentor)
    $mentor = new Mentor();
    #Variable que llama al metodo creaCreateForm, creado luego
    $form = $this-> createCreateForm($mentor);

    return $this->render('MentoresBundle:Mentor:add.html.twig',array('form' =>$form->createView()));
  }

  private function createCreateForm(Mentor $entity)
  {
    $form = $this-> createForm(new MentorType(),$entity, array (
      'action' => $this->generateUrl('semillero_mentores_create'),
      'method' => 'POST'
    ));

    return $form;
  }

  /**
  * @Route("/mentores/create",name="semillero_mentores_create")
  * @Method({"POST"})
  */

  public function createAction(Request $request)
  {
    $mentor = new Mentor();
    $form = $this->createCreateForm($mentor);
    $form->handleRequest($request);

    #Validamos si el formulario se envio correctamente
    if($form->isValid())
    {
      // dump($request->request->all());
      $password = $form->get('password')->getData();

      //Validamos de que la contraseña no se guarde vacia
      $passwordConstraint = new Assert\NotBlank();
      $errorList = $this->get('validator')->validate($password, $passwordConstraint);

      //Si no hay ningun error con la contraseña, entonces procedemos a crearla
      if(count($errorList) == 0)
      {
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($mentor, $password);

        $mentor->setPassword($encoded);

        $em = $this->getDoctrine()->getManager();
        $em -> persist($mentor);
        $em -> flush();

        $this->addFlash('mensaje','¡El mentor ha sido creado satisfactoriamente!');

        return $this->redirectToRoute('semillero_mentores_index');
      }
      else //Si la contraseña esta vacia o presenta algun error, se notifica
      {
        $errorMessage = new FormError($errorList[0]->getMessage());
        $form->get('password')->addError($errorMessage);
      }

    }
    #Renderizamos al forumlario si existe algun problema
    return $this->render('MentoresBundle:Mentor:add.html.twig',array('form' =>$form->createView()));
  }

  //------------------ Metodo edit, editar un MENTOR de la base de datos --------------------

  /**
  * @Route("/mentores/edit/{numeroDocumento}",name="semillero_mentores_edit")
  */
  public function editAction($numeroDocumento)
  {
    #$Repository = $this->getDoctrine()->getRepository('DataBundle:Mentor');

    #Para buscar un mentor por cualquier atributo, entonces realizamos la siguiente modificación teniendo en cuenta que toca modificar todo el parametro a dicho atributo.
    #$mentor = $Repository->findOneByNumeroDocumento($numeroDocumento);

    $em = $this->getDoctrine()->getManager();
    $mentor = $em->getRepository('DataBundle:Mentor')->findOneByNumeroDocumento($numeroDocumento);

    if(!$mentor)
    {
      throw $this->createNotFoundException('El Mentor a Editar NO Existe');
    }

    $form = $this->createEditForm($mentor);

    return $this->render('MentoresBundle:Mentor:edit.html.twig', array('mentor'=>$mentor, 'form'=>$form->createView()));
  }

  private function createEditForm(Mentor $entity)
  {
    $form = $this->createForm(new MentorType(), $entity, array('action' => $this->generateUrl('semillero_mentores_update', array('numeroDocumento' => $entity->getNumeroDocumento())), 'method' => 'PUT'));
    return $form;
  }

  /**
  * @Route("/mentores/update/{numeroDocumento}",name="semillero_mentores_update")
  * @Method({"POST","PUT"})
  */
  public function updateAction($numeroDocumento, Request $request)
  {
    $em = $this->getDoctrine()->getManager();

    $mentor = $em->getRepository('DataBundle:Mentor')->findOneByNumeroDocumento($numeroDocumento);
    if(!$mentor)
    {
      throw $this->createNotFoundException('El Mentor a Editar NO Existe');
    }

    $form = $this->createEditForm($mentor);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
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

      $em -> flush();
      $this->addFlash('mensaje','¡El mentor ha sido modificado satisfactoriamente!');
      return $this->redirectToRoute('semillero_mentores_index', array('numeroDocumento' => $mentor->getNumeroDocumento()));
    }
    return $this->render('MentoresBundle:Mentor:edit.html.twig',array('mentor' => $mentor, 'form' =>$form->createView()));
  }


  //------------------ Metodo view, carga un MENTOR seleccionado por parametro NumeroDocumento --------------------

  /**
  * @Route("/mentores/view/{numeroDocumento}",name="semillero_mentores_view")
  */
  public function viewAction($numeroDocumento)
  {
    $Repository = $this->getDoctrine()->getRepository('DataBundle:Mentor');

    #Para buscar un mentor por cualquier atributo, entonces realizamos la siguiente modificación teniendo en cuenta que toca modificar todo el parametro a dicho atributo.
    #$mentor = $Repository->find($numId);
    #$mentor = $Repository->findOneByNombres($nombres);
    $mentor = $Repository->findOneByNumeroDocumento($numeroDocumento);

    if(!$mentor)
    {
      throw $this->createNotFoundException('El Mentor a Editar NO Existe');
    }

    $deleteForm = $this->createDeleteForm($mentor);

    return $this->render('MentoresBundle:Mentor:view.html.twig',array('mentor' => $mentor, 'delete_form' => $deleteForm->createView()));
    //return new Response('Mentor: ' . $mentor->getNombres() .' '.$mentor->getApellidos() . '  Cc: '.$mentor->getNumeroDocumento());
  }

  private function createDeleteForm($mentor)
  {
    return $this->createFormBuilder()
    ->setAction($this->generateUrl('semillero_mentores_delete',array('id' => $mentor->getId())))
    ->setMethod('DELETE')
    ->getForm();
  }

  //------------------ Metodo delete, eliminar un MENTOR de la base de datos --------------------

  /**
  * @Route("/mentores/delete/{id}",name="semillero_mentores_delete")
  * @Method({"POST","DELETE"})
  */

  public function deleteAction(Request $request, $id)
  {
    $em = $this->getDoctrine()->getManager();

    $mentor = $em->getRepository('DataBundle:Mentor')->find($id);

    if(!$mentor)
    {
      throw $this->createNotFoundException('El Mentor a eliminar NO Existe');
    }

    $form = $this->createDeleteForm($mentor);
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {

      $em->remove($mentor);
      $em -> flush();

      $this->addFlash('mensaje','¡El mentor ha sido eliminado satisfactoriamente!');
      return $this->redirectToRoute('semillero_mentores_index', array('numeroDocumento' => $mentor->getNumeroDocumento()));

    }
  }




}
