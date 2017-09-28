<?php

namespace Semillero\SeguridadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
  /**
  * @Route("/administrativos/home", name="homeAdministrativos")
  */
  //home users..
  public function homeAdministrativos()
  {
    return $this->render('AdministrativosBundle:Mentor:homeAdministrativos.html.twig');
  }
}
