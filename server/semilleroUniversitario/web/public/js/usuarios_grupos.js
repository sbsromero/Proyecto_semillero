$(document).ready(function(){

  var contadorEncuentro = 0;

  // $('body').on('click','.btn-usuariosGrupo',function(e){
  //   idGrupo = $( "#selectIdGrupo option:selected" ).val();
  //   if(idGrupo == "" || idGrupo == undefined){
  //     toastr.error("Debe seleccionar un grupo para continuar");
  //   }
  //   else{
  //     $.ajax({
  //       type: "GET",
  //       url: Routing.generate('gestionGruposAsignados',{idGrupo:idGrupo}),
  //       success: function(){
  //
  //       },
  //       error: function(){
  //
  //       }
  //     })
  //   }
  // });
  //Metodo que muestra toda la informacion de los datos personales del mentor
  $('body').on('click','.verDatos', function(e){
    $.ajax({
      type:"GET",
      url: Routing.generate('verDatosPersonales'),
      success: function(html){
        $('#contentPersonales').html(html);
      }
    })
  })

  //Metodo que muestra el detalle de un grupo
  $('body').on('click','.btnDetalleGrupo', function(e){
    var row = $(this).parents('div').parents('div');
    var id = row.data('id');
    $.ajax({
      url: Routing.generate('getDetalleGrupo',{idGrupo:id}),
      success:function(html){
        $('#contentDetalleGrupo').html(html);
      }
    })
  })

  $('body').on('click','.btnAgregarEncuentro', function(e){
    var idSegmento = $('#segmentosGrupo').val();
    contadorEncuentro++;
    agregarEncuentro(idSegmento, contadorEncuentro);

  })

  $('body').on('click','.btnListarEncuentros', function(e){
    var idSegmento = $('#segmentosGrupo').val();
    listarEncuentros(idSegmento);
  })

  $('body').on('click','.btnAgregarActividad', function(e){
    var idEncuentro = $(this).data('id');
    $.ajax({
      url: Routing.generate('agregarActividad',{idEncuentro}),
      success:function(html){
        $('#contentActividad').html(html);
      }
    })
  })

  function agregarEncuentro(idSegmento){
    $.ajax({
      type:"POST",
      url: Routing.generate('agregarEncuentro'),
      data:{
        idSegmento: idSegmento,
        contador : contadorEncuentro
      },
      success:function(data){
        listarEncuentros(idSegmento);
      },error:function(data){
        toastr.error(data.responseText);
      }
    })
  }

  function listarEncuentros(idSegmento){
    $.ajax({
      url: Routing.generate('getEncuentros',{idSegmento: idSegmento}),
      success:function(html){
        $('.bodyListaEncuentros').html(html);
        $('.bodyListaEncuentros').show();
      },error:function(){
        $('.bodyListaEncuentros').hide();
      }
    });
  }

  //tooltip
  $(document).tooltip({
    selector:'[data-toggle="tooltip"]',
    placement:'top'
  });


});
