$(document).ready(function(){

  $('body').on('click','.btnListarActividades', function(e){
    var idSegmento = $('#segmentosGrupo').val();
    listarActividades(idSegmento);
  })

  function listarActividades(idSegmento){
    $.ajax({
      url: Routing.generate('getListActividadesUsuarios',{idSegmento: idSegmento}),
      success:function(html){
        $('.bodyListaActividades').html(html);
        $('.bodyListaActividades').show();
      },error:function(){
        $('.bodyListaActividades').hide();
      }
    });
  }

});
