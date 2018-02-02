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
        $('.panelAdministracionUsuarios').html(html);
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

  //Accion que permite visualizar todo el detalle de una actividad seleccionada
  $('body').on('click','.btnDetalleActividad', function(e){
    idActividad = $(this).data('id');
    $.ajax({
      url: Routing.generate('getDetalleActividadUsuarios',{idActividad:idActividad}),
      success:function(html){
        $('#contentDetalleActividad').html(html);
      }
    })
  })


  //Metodo que crea el paginador de mentores en la modal de asignar
  //mentor a un grupo
  var paginadorGestionAcademica = function(){
    var totalPages = $('#tabla_actividades').attr('data-pagecount');
    // var id = $('#nombreGrupo').data('idgrupo');
    if(totalPages != 0){
      $('#paginationGestionAcademica').twbsPagination({
        startPage: 1,
        totalPages: totalPages,
        visiblePages: 3,
        initiateStartPageClick: false,
        first:'Primero',
        last: 'Último',
        prev: '<span aria-hidden="true">&laquo;</span>',
        next: '<span aria-hidden="true">&raquo;</span>',
        onPageClick: function (event, page) {
          $.ajax({
            type: "GET",
            url: Routing.generate('gestionAcademica'),
            data:{
              pageActive: page,
            },
            success:function(html){
              $('#tabla_actividades').replaceWith($(html).find('#tabla_actividades'));
            }
          })
        }
      })
    }
  }
paginadorGestionAcademica();

});
