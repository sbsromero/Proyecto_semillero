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

  //Metodo que retorna la vista para hacer el cambio de la clave de la semilla
  $('body').on('click','.cambiarClave', function(e){
    $.ajax({
      url: Routing.generate('getCambiarClave'),
      success: function(html){
        $('.panel-body').html(html);
      }
    })
  })

  //Metodo que restaura la contraseña de la semilla
  $('body').on('click','#guardar_clave', function(e){
    e.preventDefault();
    var claveActual = $('#cambio_clave_actual').val();
    var nuevaClave = $('#cambio_clave_nueva').val();
    var confirmacion = $('#cambio_clave_confirmacion').val();
    if(claveActual!="" && nuevaClave !="" && confirmacion !=""){
      $('.div_message_error').hide();
      $('#message_error').hide();
      $.ajax({
        type: "POST",
        url: Routing.generate("cambiarClave"),
        data:{
          claveActual: claveActual,
          nuevaClave: nuevaClave,
          confirmacion: confirmacion
        },
        success: function(data){
          toastr.success("La contraseña ha sido modificada exitosamente");
          window.setTimeout(function(){
           window.location.href = Routing.generate('informacionPersonal');
          }, 1000);
        },error: function(data){
          $('.div_message_error').show();
          $('#message_error').html(data.responseText);
          $('#message_error').show();
        }
      })
    }
    else{
      if(claveActual==""){
        $('.div_message_error').show();
        $('#message_error').html("El campo clave actual no puede estar vacio");
        $('#message_error').show();
        $('#cambio_clave_actual').focus();
      }
      else if(nuevaClave==""){
        $('.div_message_error').show();
        $('#message_error').html("El campo nueva clave no puede estar vacio");
        $('#message_error').show();
        $('#cambio_clave_nueva').focus();
      }
      else{
        $('.div_message_error').show();
        $('#message_error').html("El campo confirmar nueva clave no puede estar vacio");
        $('#message_error').show();
        $('#cambio_clave_confirmacion').focus();
      }
    }
  })
});
