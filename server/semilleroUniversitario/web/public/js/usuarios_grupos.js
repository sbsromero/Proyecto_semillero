$(document).ready(function(){


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
  $('body').on('click','.verDatos', function(e){
    $.ajax({
      type:"GET",
      url: Routing.generate('verDatosPersonales'),
      success: function(html){
        $('#contentPersonales').html(html);
      }
    })
  })

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

  //tooltip
  $(document).tooltip({
    selector:'[data-toggle="tooltip"]',
    placement:'top'
  });


});
