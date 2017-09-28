<?php

namespace Semillero\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
* @Route("admin")
*/
class AdminController extends Controller
{

  /**
  * @Route("/dashboard", name="dashboardAdmin")
  */
  public function dashboardAdmin()
  {
    return $this->render('AdminBundle:Admin:dashboardAdmin.html.twig');
  }

  /**
  * @Route("/administracion", name="indexAdmin")
  */
  public function administracion()
  {
    return $this->render('AdminBundle:Admin:indexAdmin.html.twig');
  }
}
