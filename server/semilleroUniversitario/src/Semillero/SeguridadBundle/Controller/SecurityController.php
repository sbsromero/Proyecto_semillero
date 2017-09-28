<?php

namespace Semillero\SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{

  //--------------Metodos de inicio de sesion para el mentor------------------
  /**
  * @Route("/semillas/login", name="mentorLogin")
  */
  public function loginMentorAction()
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->redirectToRoute("homeMentor");
    }
    $authenticationUtils = $this->get('security.authentication_utils');
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('SeguridadBundle:Mentor:loginMentor.html.twig', array('last_username' => $lastUsername, 'error' => $error));
  }

  /**
  * @Route("/semillas/login_check", name="mentorLogin_check")
  */
  public function mentorLoginCheckAction()
  {
  }

  /**
  * @Route("/semillas/logout", name="mentorLogout")
  */
  public function mentorLogoutAction()
  {
  }

  //---------------Metodos para inicio de sesion del administrador-----------------
  /**
  * @Route("/administrativos/login", name="administrativosLogin")
  */
  public function loginAdminAction()
  {
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->redirectToRoute("adminHome");
    }
    $authenticationUtils = $this->get('security.authentication_utils');
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('SeguridadBundle:Administrativos:loginAdministrativos.html.twig', array('last_username' => $lastUsername, 'error' => $error));
  }

  /**
  * @Route("/administrativos/login_check", name="administrativosLogin_check")
  */
  public function adminLoginCheckAction()
  {
  }

  /**
  * @Route("/administrativos/logout", name="administrativosLogout")
  */
  public function adminLogoutAction()
  {
  }


}
