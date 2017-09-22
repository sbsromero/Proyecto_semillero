<?php

namespace Semillero\MentoresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
      $em=$this->getDoctrine()->getManager();

      // $misMentores = $em->getRepository('DataBundle:Mentor')->findAll();

      $dql = "SELECT m FROM DataBundle:Mentor m";
      $mentores = $em->createQuery($dql);

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

//------------------ Metodo view, carga un MENTOR seleccionado por parametro NumeroDocumento --------------------

    /**
    * @Route("/mentores/view/{NumeroDocumento}",name="semillero_mentores_viewx")
    */
    public function viewAction($NumeroDocumento)
    {
      $Repository = $this->getDoctrine()->getRepository('DataBundle:Mentor');

      #Para buscar un mentor por cualquier atributo, entonces realizamos la siguiente modificación teniendo en cuenta que toca modificar todo el parametro a dicho atributo.
      #$mentor = $Repository->find($numId);
      #$mentor = $Repository->findOneByNombres($nombres);
      $mentor = $Repository->findOneByNumeroDocumento($NumeroDocumento);
      return new Response('Mentor: ' . $mentor->getNombres() .' '.$mentor->getApellidos() . '  Cc: '.$mentor->getNumeroDocumento());
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

        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($mentor, $password);
        // dump($encoded);exit();


        $mentor->setPassword($encoded);


        $em = $this->getDoctrine()->getManager();
        $em -> persist($mentor);
        $em -> flush();

        $this->addFlash('mensaje','¡El mentor ha sido creado satisfactoriamente!');

        return $this->redirectToRoute('semillero_mentores_index');
      }
      #Renderizamos al forumlario si existe algun problema
        return $this->render('MentoresBundle:Mentor:add.html.twig',array('form' =>$form->createView()));

    }


    /**
    * @Route("/mentores/create",name="semillero_mentores_create")
    */

    /**
    * @Route("/mentores/edit",name="semillero_mentores_edit")
    */

    /**
    * @Route("/mentores/delete",name="semillero_mentores_delete")
    */


}
