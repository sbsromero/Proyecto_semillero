$(document).ready(function(){

  var clickListar = false;
  var idActividad = 0;
  var idSegmento = 0;

  $('body').on('click','.btnListarActividades', function(e){
    $(this).attr('disabled',true);
    if(!clickListar){
      idSegmento = $('#segmentosGrupo').val();
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
        setTimeout(function () {
          $('.btnListarActividades').click();
        },1000);
      },
      error: function(data){
        $('#contentEditarActividad').html(data.responseText);
      }
    })
  })

  $("#segmentosGrupo" ).change(function() {
    $('.bodyListaActividades').hide();
  });

  $('body').on('click','.btnCalificarActividad', function(e){
    idActividad = $(this).data('id');
    segmentoGrupo = $('#segmentosGrupo').val();
    window.location.href = Routing.generate("calificacionesUsuarios",{segmento: segmentoGrupo, idActividad:idActividad});
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

  // $('body').on('click','#btnGuardarCalificaciones',function(e){
  //   $('#formGuardarCalificaciones').submit( function(e) {
  //     e.preventDefault();
  //     $.ajax({
  //       url: Routing.generate('guardarCalificaciones',{idActividad:idActividad}),
  //       success: function(){
  //
  //       }
  //     })
  //   });
  //
  // })



  crearPaginadorCalificaciones();
  //Metodo que crea el paginador de las semillas para la calificacion
  //de una actividad realizada
  function crearPaginadorCalificaciones(){
    var totalPages = $('#tablaCalificaciones').attr('data-pagecount');
    idSegmento = $('#segmento').data('id');
    idActividad = $('#actividad').data('id');
    if(totalPages != 0){
      $('#paginadorCalificacion').twbsPagination({
        startPage: 1,
        totalPages: totalPages,
        visiblePages: 6,
        initiateStartPageClick: false,
        first:'Primero',
        last: 'Último',
        prev: '<span aria-hidden="true">&laquo;</span>',
        next: '<span aria-hidden="true">&raquo;</span>',
        onPageClick: function (event, page) {
          $.ajax({
            type: "GET",
            url: Routing.generate("calificacionesUsuarios",{segmento: idSegmento, idActividad:idActividad}),
            data:{
              pageActive: page,
            },
            success:function(html){
              $('#tablaCalificaciones').replaceWith($(html).find('#tablaCalificaciones'));
            }
          })
        }
      })
    }
  }

  //tooltip
  $(document).tooltip({
    selector:'[data-toggle="tooltip"]',
    placement:'top'
  });

});
