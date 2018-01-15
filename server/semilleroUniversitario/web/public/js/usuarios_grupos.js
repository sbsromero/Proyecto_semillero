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


});
