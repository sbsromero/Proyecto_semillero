$(document).ready(function(){

  //Permite visualizar el historico de grupos por los que se a pasado un mentor
  $('body').on('click','.btnHistoricoMentor', function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      url: Routing.generate('historicoGruposMentor',{id:id}),
      success: function(html){
        $('#contentHistorico').html(html);
      }
    })
  })

  //Permite visualizar en modal los detalles de un mentor
  $('body').on('click','.btnVerMentor',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:'GET',
      url: Routing.generate('viewMentores',{id:id}),
      success: function(html){
        $("#contentViewMentor").html(html);
      }
    })
  })

  //Permite eliminar un mentor
  $('body').on('click','.btnDelMentor',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    var dni = $('#dniMentor-'+id).html();
    bootbox.confirm({
      message: "Esta seguro que desea eliminar al mentor con número de documento: "+"<b>"+dni+"</b>",
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
          eliminarMentor(id).done(function(data){
            toastr.success("Se ha eliminado el mentor de manera correcta");
            window.setTimeout(function(){
              window.location.href = Routing.generate('indexMentores');
            }, 1000);
          }).fail(function(data){
            toastr.error('No se pudo eliminar el mentor, tiene grupos asignados');
          })
        }
      }
    });
  })

  //Permite realizar la busqueda en la pestaña de mentores
  $('body').on('keyup','#queryBusquedaMentor',function(e){
    e.preventDefault();
    var busqueda = $(this).val();
    $.ajax({
      type:"GET",
      url: Routing.generate('indexMentores'),
      data:{
        valorBusqueda: busqueda
      },
      success:function(html){
          $('#tabla_mentores').replaceWith($(html).find('#tabla_mentores'));
          $('#paginationMentores').twbsPagination('destroy');
          crearPaginadorMentores();
      }
    })
  })

  //Permite obtener todos los mentores cuando se le da click en
  //mostrar todos
  $('body').on('click','.btnMostrarMentores',function(e){
    e.preventDefault();
    $('#queryBusquedaMentor').val('');
    $.ajax({
      type:"GET",
      url: Routing.generate('indexMentores'),
      data:{
        btnMostrarMentores: "btnMostrarMentores"
      },
      success:function(html){
        $('#tabla_mentores').replaceWith($(html).find('#tabla_mentores'));
        $('#paginationMentores').twbsPagination('destroy');
        crearPaginadorMentores();
      }
    })
  })


  //funcion que realiza el llamado al metodo de eliminar el mentor
  function eliminarMentor(id)
  {
    return $.ajax({
      type:'DELETE',
      url: Routing.generate('deleteMentores',{id:id}),
    })
  }

  //funcion que realiza la inactivacion de un mentor
  $('body').on('click','.btnInactivarMentor', function(e){
    e.preventDefault();
    var row = $(this).parents('tr');
    var id = row.data('id');
    var dni = $('#dniMentor-'+id).html();
    $.ajax({
      type:"POST",
      url: Routing.generate('inactivarMentor', {dni:dni}),
      success: function(){
        toastr.success("El estado del mentor ha sido actualizado");
        window.setTimeout(function(){
          window.location.href = Routing.generate('indexMentores');
        }, 1000);
      }
    })
  })

  //Calendario para las fechas en la vista de mentores
  $('.js-datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: "es",
    todayHighlight: true,
    endDate: "today",
    autoclose: true
  });

  //Imprime los menajes de exito
  var mensajeMentor = $('#mensajeMentor').val();
  if(mensajeMentor!="" && mensajeMentor!=undefined){
    toastr.success(mensajeMentor);
  }

  //Metodo que crea el paginador de los mentores
  var crearPaginadorMentores = function(){
    var totalPages = $('#tabla_mentores').attr('data-pageCount');
    if(totalPages != 0){
      $('#paginationMentores').twbsPagination({
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
            url: Routing.generate('indexMentores'),
            data:{
              pageActive: page,
            },
            success:function(html){
              $('#tabla_mentores').replaceWith($(html).find('#tabla_mentores'));
              headerSorter();
            }
          })
        }
      })
    }
    headerSorter();
  }

  crearPaginadorMentores();

  //Metodo que implementa el ordenamiento en las cabeceras de la tabla de mentores
  function headerSorter(){
    $('#tableItemsMentores').tablesorter({
      headers:{
        8:{sorter:false},9:{sorter:false},10:{sorter:false},11:{sorter:false}
        ,12:{sorter:false},13:{sorter:false}
      }
    });
  }

  //tooltip
  $(document).tooltip({
    selector:'[data-toggle="tooltip"]',
    placement:'top'
  });
})
