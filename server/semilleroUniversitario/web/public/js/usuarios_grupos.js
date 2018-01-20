$(document).ready(function(){

  var idEncuentro = 0;

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
    agregarEncuentro(idSegmento);

  })

  $('body').on('click','.btnListarEncuentros', function(e){
    var idSegmento = $('#segmentosGrupo').val();
    listarEncuentros(idSegmento);
  })

  $('body').on('click','.btnAgregarActividad', function(e){
    idEncuentro = $(this).data('id');
    $.ajax({
      url: Routing.generate('agregarActividad'),
      success:function(html){
        // $('.bodyListaEncuentros').html(html);
        // $('.bodyListaEncuentros').show();
        $('#contentActividad').html(html);
      }
    })
  })

  $('body').on('click','.btnRegistrarActividad', function(e){
    var data = $('#form_add_actividad').serializeArray();
    data.push({name:'idEncuentro',value:idEncuentro});
    $.ajax({
      type: "POST",
      url: Routing.generate('registrarActividad'),
      data: data,
      success: function(data){
        data = JSON.parse(data);
        toastr.success(data.msg);
        $('#numActividaes').html(data.numActividades);
        $('#modalActividad').modal('hide');
      },
      error: function(data){
        if(data.status == 404){
          toastr.error(data.responseText);
        }
        else{
          $('#contentActividad').html(data.responseText);
        }
      }
    })
  })

  function agregarEncuentro(idSegmento){
    $.ajax({
      type:"POST",
      url: Routing.generate('agregarEncuentro'),
      data:{
        idSegmento: idSegmento
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
