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

  //Metodo que recupera todas las actividades asociadas a un grupo.
  public function getlistaActividades($em, $grupo){
      $segmentos = $grupo->getSegmentos();
      $listActividades = array();
      foreach ($segmentos as $segmento) {
        $encuentros = $segmento->getEncuentros();
        if(count($encuentros)!=0){
          $aux = $this->getActividades($encuentros);
          $listActividades = array_merge($listActividades,$aux);
        }
      }
      return $listActividades;
  }

  //Metodo que retorna la nota de una actividad para una semilla
  public function getNotaActividadSemillaAction($idSemilla,$idActividad){
    $em = $this->getDoctrine()->getManager();
    $nota = $em->getRepository('DataBundle:semilla_actividad')->getRegistroDetalleActividad($idSemilla,$idActividad);
    if(!empty($nota)){
      return new Response($nota[0]->getNotaActividad());
    }
    else{
      return new Response("0");
    }
  }

  //Metodo que retorna la asistencia para una semilla en una actividad
  public function getAsistenciaActividadSemillaAction($idSemilla,$idActividad){
    $em = $this->getDoctrine()->getManager();
    $nota = $em->getRepository('DataBundle:semilla_actividad')->getRegistroDetalleActividad($idSemilla,$idActividad);
    if(!empty($nota)){
      // $notaAsistencia = ($nota[0]->getNotaAsistencia() == 0) ? "No asistio" : $nota[0]->getNotaAsistencia();
      return new Response("Asistió");
    }
    else{
      return new Response("No asistió");
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
    $listActividades = array();
    foreach ($encuentros as $encuentro) {
      $actividades = $encuentro->getActividades();
      foreach ($actividades as $actividad) {
        array_push($listActividades,$actividad);
      }
    }
    return $listActividades;
  }

}
