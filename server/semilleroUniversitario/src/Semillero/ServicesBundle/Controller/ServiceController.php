<?php

namespace Semillero\ServicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;

class ServiceController extends Controller
{

  //Metodo que permite generar un pdf con las semillas de un grupo
  /**
  * @Route("/getPdfGrupoSemillas",name="getPdfGrupoSemillas")
  * @PreAuthorize("hasAnyRole('ROLE_MENTOR','ROLE_ADMIN')")
  */
  public function getPdfGrupoSemillas(Request $request){
    $idGrupo = $request->query->get('id');
    $em = $this->getDoctrine()->getManager();
    $grupo = $em->getRepository('DataBundle:Grupo')->find($idGrupo);
    $m_g = $em->getRepository('DataBundle:Mentor_Grupos')->getMentorAsignadoPorGrupo($idGrupo);
    $mentor = (empty($m_g)) ? null : $m_g->getMentor();

    $grupo_semillas = $grupo->getSemillas();
    $semillas = array();
    foreach ($grupo_semillas as $grupo_semilla) {
      if($grupo_semilla->getActivo()){
        array_push($semillas, $grupo_semilla->getSemilla());
      }
    }
    return new PdfResponse(
         $this->get('knp_snappy.pdf')->getOutputFromHtml($this->renderView('MentoresBundle:Grupo:plantillaPdfGrupoSemillas.html.twig', array(
             'base_dir' => $this->get('kernel')->getRootDir().'/../web'. $request->getBasePath(),
             'grupo' => $grupo,
             'mentor' => $mentor,
             'semillas' => $semillas,
         ))),
         'semillas-'.trim($grupo->getNombre()).'.pdf'
     );
    // return $this->render('MentoresBundle:Grupo:plantillaPdfSemillas.html.twig',array(
    //   'grupo' => $grupo,
    //   'semillas' => $semillas,
    //   'base_dir' => $this->get('kernel')->getRootDir().'/../web'. $request->getBasePath()
    // ));
  }

}
