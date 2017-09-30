<?php

namespace Semillero\UsuariosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
    return $this->render('UsuariosBundle:Dashboard:dashboardUsuarios.html.twig');
  }
}
