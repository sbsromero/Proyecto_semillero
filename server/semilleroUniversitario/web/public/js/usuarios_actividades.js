$(document).ready(function(){

  var clickListar = false;
  var idActividad = 0;

  $('body').on('click','.btnListarActividades', function(e){
    $(this).attr('disabled',true);
    if(!clickListar){
      var idSegmento = $('#segmentosGrupo').val();
      listarActividades(idSegmento);
      clickListar = true;
    }else{
      $(this).off("click");
    }
  })

  $('body').on('click','.btnDetalleActividad', function(e){
    var idActividad = $(this).data('id');
    $.ajax({
      url: Routing.generate('getDetalleActividadUsuarios',{idActividad:idActividad}),
      success: function(html){
        $('#contentDetalleActividad').html(html);
      }
    })
  });

  $('body').on('click','.btnEditarActividad', function(e){
    idActividad = $(this).data('id');
    $.ajax({
      url: Routing.generate('editarActividadUsuarios',{idActividad:idActividad}),
      success: function(html){
        $('#contentEditarActividad').html(html);
      }
    })
  })

  $('body').on('click','.btnModificarActividad', function(e){
    var data = $('#form_edit_actividad').serializeArray();
    console.log(idActividad);
    $.ajax({
      type: "POST",
      url: Routing.generate('modificarActividadUsuarios',{idActividad: idActividad}),
      data: data,
      success: function(data){
        toastr.success("La actividad ha sido modificada");
        $('#modalEditarActividad').modal('hide');
        $('.btnListarActividades').click();
      },
      error: function(data){
        $('#contentEditarActividad').html(data.responseText);
      }
    })
  })

  function listarActividades(idSegmento){
    $.ajax({
      url: Routing.generate('getListActividadesUsuarios',{idSegmento: idSegmento}),
      success:function(html){
        $('.bodyListaActividades').html(html);
        $('.bodyListaActividades').show();
        clickListar = false;
        $('.btnListarActividades').removeAttr('disabled');
      },error:function(){
        $('.bodyListaActividades').hide();
        clickListar = false;
        $('.btnListarActividades').removeAttr('disabled');
      }
    });
  }

  //tooltip
  $(document).tooltip({
    selector:'[data-toggle="tooltip"]',
    placement:'top'
  });

});
