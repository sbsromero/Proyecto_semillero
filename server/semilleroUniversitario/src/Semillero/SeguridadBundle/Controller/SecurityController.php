<?php

namespace Semillero\SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
  /**
  * @route("/", name="homepage")
  */
  public function redirigirFormularioSemillas(){
    return $this->redirectToRoute('registrarSemilla');
  }
  //--------------Metodos de inicio de sesion para los usuarios (mentor, semillas)------------------
  /**
  * @Route("/usuarios/login", name="usuariosLogin")
  */
  public function loginUsersAction()
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      $user = $this->container
       ->get('security.context')
       ->getToken()
       ->getUser();
       $role = $user->getRoles()[0];
       if($role == "ROLE_SEMILLA"){
         return $this->redirectToRoute('indexSemillasUsuarios');
       }
      return $this->redirectToRoute("indexGrupos_usuarios");
    }
    $authenticationUtils = $this->get('security.authentication_utils');
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('SeguridadBundle:Usuarios:loginUsuarios.html.twig', array('last_username' => $lastUsername, 'error' => $error));
  }

  /**
  * @Route("/usuarios/login_check", name="usuariosLogin_check")
  */
  public function usuariosLoginCheckAction()
  {
  }

  /**
  * @Route("/usuarios/logout", name="usuariosLogout")
  */
  public function usuariosLogoutAction()
  {
  }

  //---------------Metodos para inicio de sesion del administrador-----------------
  /**
  * @Route("/admin/login", name="adminLogin")
  */
  public function loginAdminAction()
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->redirectToRoute("indexAdmin");
    }
    $authenticationUtils = $this->get('security.authentication_utils');
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('SeguridadBundle:Admin:loginAdmin.html.twig', array('last_username' => $lastUsername, 'error' => $error));
  }

  /**
  * @Route("/admin/login_check", name="adminLogin_check")
  */
  public function adminLoginCheckAction()
  {
  }

  /**
  * @Route("/admin/logout", name="adminLogout")
  */
  public function adminLogoutAction()
  {
  }


}
