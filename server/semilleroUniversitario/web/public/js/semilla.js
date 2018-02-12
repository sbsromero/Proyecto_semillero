$(document).ready(function(){

  var idSemilla;
  //Permite visualizar la modal en la cual se asignara un grupo a una semilla
  $('body').on('click','.btnAsignarGrupo', function(e){
    var row = $(this).parents('tr');
    idSemilla = row.data('id');
    $.ajax({
      url: Routing.generate('getAsignarGrupo',{idSemilla:idSemilla}),
      success: function(html){
        $('#contentAsignarGrupo').html(html);
        crearPaginadorAsignarGrupo(idSemilla);
      }
    })
  })

  //Permite visualizar en modal los detalles de una semilla
  $('body').on("click",'.btnVerSemilla',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:'GET',
      url: Routing.generate('viewSemillas',{id:id}),
      success: function(html){
        $("#contentViewSemilla").html(html);
        $("#modalViewSemilla").modal('show');
      }
    })
  })

  //Permite eliminar una semilla
  $('body').on('click','.btnDelSemilla',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    var dni = $('#dniSemilla-'+id).html();
    bootbox.confirm({
      message: "Esta seguro que desea eliminar a la semilla con número de documento: "+"<b>"+dni+"</b>",
      buttons: {
        confirm: {
          label: 'Confirmar',
          className: 'btn-success'
        },
        cancel: {
          label: 'Cancelar',
          className: 'btn-danger'
        }
      },
      callback: function (result) {
        if(result){
          eliminarSemilla(id).done(function(){
            toastr.success("Se ha eliminado la semilla de manera correcta");
            window.setTimeout(function(){
              window.location.href = Routing.generate('indexSemillas');
            }, 1000);
          }).fail(function(data){
            toastr.error(data.responseText)
          })
        }
      }
    });
  })

  //Permite realizar la busqueda en la pestaña de semillas
  $('body').on('keyup','#queryBusquedaSemilla',function(e){
    e.preventDefault();
    var busqueda = $(this).val();
    $.ajax({
      type:"GET",
      url: Routing.generate('indexSemillas'),
      data:{
        valorBusqueda: busqueda
      },
      success:function(html){
          $('#tabla_semillas').replaceWith($(html).find('#tabla_semillas'));
          $('#paginationSemillas').twbsPagination('destroy');
          crearPaginadorSemillas();
      }
    })
  })

  //Permite obtener todos los semillas cuando se le da click en
  //mostrar todos
  $('body').on('click','.btnMostrarSemillas',function(e){
    e.preventDefault();
    $('#queryBusquedaSemilla').val('');
    $.ajax({
      type:"GET",
      url: Routing.generate('indexSemillas'),
      data:{
        btnMostrarSemillas: "btnMostrarSemillas"
      },
      success:function(html){
        $('#tabla_semillas').replaceWith($(html).find('#tabla_semillas'));
        $('#paginationSemillas').twbsPagination('destroy');
        crearPaginadorSemillas();
      }
    })
  })

  //Permite visualizar el historico de grupos por los que se a pasado un mentor
  $('body').on('click','.btnHistoricoSemilla', function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      url: Routing.generate('historicoGruposSemillas',{id:id}),
      success: function(html){
        $('#contentHistoricoSemilla').html(html);
      }
    })
  })

  //funcion que realiza el llamado al metodo de eliminar la semilla
  function eliminarSemilla(id)
  {
    return $.ajax({
      type:'DELETE',
      url: Routing.generate('deleteSemillas',{id:id}),
    })
  }

  //Calendario para las fechas en la vista de semillas
  $('.js-datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: "es",
    todayHighlight: true,
    endDate: "today",
    autoclose: true
  });

  //Imprime los mensajes de exito
  var mensajeSemilla = $('#mensajeSemilla').val();
  if(mensajeSemilla!="" && mensajeSemilla!=undefined){
    toastr.success(mensajeSemilla);
  }

  //Metodo que crea el paginador de las semillas
  var crearPaginadorSemillas = function(){
    var totalPages = $('#tabla_semillas').attr('data-pageCount');
    if(totalPages != 0){
      $('#paginationSemillas').twbsPagination({
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
            url: Routing.generate('indexSemillas'),
            data:{
              pageActive: page,
            },
            success:function(html){
              $('#tabla_semillas').replaceWith($(html).find('#tabla_semillas'));
              headerSorter();
            }
          })
        }
      })
    }
    headerSorter();
  }
  crearPaginadorSemillas();

  //Metodo que crea el paginador de las semillas
  var crearPaginadorAsignarGrupo = function(id){
    var totalPages = $('#tablaAsignarGrupo').attr('data-pageCount');
    if(totalPages != 0){
      $('#paginationAsignarGrupo').twbsPagination({
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
            url: Routing.generate('getAsignarGrupo',{idSemilla:id}),
            data:{
              pageActive: page,
            },
            success:function(html){
              $('#tablaAsignarGrupo').replaceWith($(html).find('#tablaAsignarGrupo'));
            }
          })
        }
      })
    }
  }

  //Metodo que permite asignar una semilla a un grupo
  $('body').on('click','.checkAsignarSemilla', function(e){
    var row = $(this).parents('tr');
    var idGrupo = row.data('id');
    var tr = $(this).parents('tr');
    tr.attr('style','background-color: #c5e1fb !important')
    bootbox.confirm({
      message: "¿Esta seguro que desea asignar esta semilla al grupo?",
      buttons: {
        confirm: {
          label: 'Si',
          className: 'btn-success'
        },
        cancel: {
          label: 'No',
          className: 'btn-danger'
        }
      },
      callback: function (result) {
        if(result){
          $.ajax({
            type: "POST",
            url: Routing.generate('asignarGrupo'),
            data:{
              idGrupo: idGrupo,
              idSemilla: idSemilla
            },
            success: function(html){
              $('#modalAsignarGrupo').modal('hide');
              toastr.success("la semilla fue asignada al grupo");
              setTimeout(function () {
                window.location.href = Routing.generate("indexSemillas")
              }, 1500);
            },
            error: function(html){
              toastr.error(html.responseText);
            }
          })
        }
        else{
          tr.attr('style','')
        }
      }
    });
  });


  //Metodo que implementa el ordenamiento en las cabeceras de la tabla de semillas
  function headerSorter(){
    $('#tableItemsSemillas').tablesorter({
      headers:{
        7:{sorter:false},8:{sorter:false},9:{sorter:false},10:{sorter:false},11:{sorter:false},
        12:{sorter:false},13:{sorter:false}
      }
    });
  }

  //tooltip
  $(document).tooltip({
    selector:'[data-toggle="tooltip"]',
    placement:'top'
  });


})
