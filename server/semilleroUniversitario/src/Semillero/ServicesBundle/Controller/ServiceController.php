<?php

namespace Semillero\ServicesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use JMS\SecurityExtraBundle\Annotation\PreAuthorize;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{

  /**
  * @Route("/getPdfGrupoSemillas/{id}", name="getPdfGrupoSemillas")
  */
  public function getPdfGrupoSemillasPrueba($id, Request $request){
    $em = $this->getDoctrine()->getManager();
    $grupo = $em->getRepository('DataBundle:Grupo')->find($id);
    $m_g = $em->getRepository('DataBundle:Mentor_Grupos')->getMentorAsignadoPorGrupo($id);
    $mentor = (empty($m_g)) ? null : $m_g->getMentor();

    $grupo_semillas = $grupo->getSemillas();
    $semillas = array();
    foreach ($grupo_semillas as $grupo_semilla) {
      if($grupo_semilla->getActivo()){
        array_push($semillas, $grupo_semilla->getSemilla());
      }
    }
    $nombreArchivo = str_replace(' ','_',$this->quitar_tildes($grupo->getNombre()));

    return new PdfResponse(
         $this->get('knp_snappy.pdf')->getOutputFromHtml($this->renderView('MentoresBundle:Grupo:plantillaPdfGrupoSemillas.html.twig', array(
             'base_dir' => $this->get('kernel')->getRootDir().'/../web'.$request->getBasePath(),
             'grupo' => $grupo,
             'mentor' => $mentor,
             'semillas' => $semillas,
         ))),
         'semillas_'.$nombreArchivo.'.pdf'
     );
  }

  public function getlistaActividades($grupo){
      $em = $this->getDoctrine()->getManager();
      $segmentos = $grupo->getSegmentos();
      $listActividades = array();
      foreach ($segmentos as $segmento) {
        $encuentros = $segmento->getEncuentros();
        foreach ($encuentros as $encuentro) {
          $this->getActividades($encuentros);
        }
      }
  }

  private function quitar_tildes($cadena) {
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
  }

  //Metodo que obtiene todas las actividades registradas en un grupo por encuentros
  private function getActividades($encuentros){
    // $listActividades = array();
    foreach ($encuentros as $encuentro) {
      $actividades = $encuentro->getActividades();
      foreach ($actividades as $actividad) {
        array_push($listActividades,$actividad);
      }
    }
    return $listActividades;
  }

}
