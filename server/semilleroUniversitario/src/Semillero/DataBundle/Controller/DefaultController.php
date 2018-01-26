<?php

namespace Semillero\DataBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/algo")
     */
    public function indexAction()
    {
        return $this->render('DataBundle:Default:index.html.twig');
    }
}
