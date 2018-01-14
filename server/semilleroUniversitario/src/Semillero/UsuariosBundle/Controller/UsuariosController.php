<?php

namespace Semillero\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* @Route("/usuarios")
*/
class UsuariosController extends Controller
{
  /**
  * @Route("/dashboard", name="dashboardUsuarios")
  */
  public function dashboardUsuariosAction()
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->render('UsuariosBundle:Dashboard:dashboardUsuarios.html.twig');
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  //Metodo que se encarga de administrar los grupos asignados a un mentor
  /**
  * @Route("/index", name="indexGrupos_usuarios")
  */
  public function indexGrupos (Request $request)
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $user = $this->container->get('security.context')->getToken()->getUser();
      $gruposPorMentor = $em->getRepository('DataBundle:Mentor_Grupos')->gruposAsignadosPorMentor($user->getId());
      return $this->render('UsuariosBundle:Grupos:indexGrupos.html.twig',array(
        'user' => $user,
        'gruposPorMentor' => $gruposPorMentor
      ));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/gestionGruposAsignados", name="gestionGruposAsignados")
  */
  public function gestionGruposAsignados (Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $em = $this->getDoctrine()->getManager();
      $idGrupo = $request->query->get('idGrupo');
      $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);

      return $this->render('UsuariosBundle:Grupos:administracionGrupos.html.twig',array(
        'grupo' => $grupo
      ));
    }
    return $this->redirectToRoute('usuariosLogin');
  }

  /**
  * @Route("/datosPersonales",name="verDatosPersonales")
  */
  public function verDatosPersonales(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      if ($request->isXmlHttpRequest()) {
        $em = $this->getDoctrine()->getManager();
        $mentor = $this->container->get('security.context')->getToken()->getUser();

        return $this->render('MentoresBundle:Mentor:view.html.twig',array(
          'mentor' => $mentor
        ));
      }
      return $this->redirectToRoute('gestionGruposAsignados');
    }
    return $this->redirectToRoute('usuariosLogin');
  }
}
