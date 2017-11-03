<?php

namespace Semillero\ParametrosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
* @Route("/admin")
*/
class ParametrosController extends Controller
{
  /**
  * @Route("/indexParametros",name="indexParametros")
  */
  public function indexAction(Request $request){
    if($this->isGranted('IS_AUTHENTICATED_FULLY')){
      return $this->render('ParametrosBundle:Parametros:index.html.twig');
    }
    return $this->redirectToRoute('adminLogin');
  }
}
