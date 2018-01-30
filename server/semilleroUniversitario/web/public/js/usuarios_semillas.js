$(document).ready(function(){

  //Metodo que muestra toda la informacion de los datos personales de la semilla
  $('body').on('click','.verDatos', function(e){
    $.ajax({
      type:"GET",
      url: Routing.generate('verDatosPersonalesSemilla'),
      success: function(html){
        $('#contentDatosPersonales').html(html);
      }
    })
  })
});
