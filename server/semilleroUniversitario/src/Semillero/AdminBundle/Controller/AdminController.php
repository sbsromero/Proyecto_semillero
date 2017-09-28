<?php

namespace Semillero\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AdminController extends Controller
{

  /**
  * @Route("/admin/home", name="homeAdmin")
  */
  public function homeAdmin()
  {
    return $this->render('AdminBundle:Admin:homeAdmin.html.twig');
  }
}
