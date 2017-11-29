$(document).ready(function(){

  //Permite agregar un diplomado
  $('body').on('click','.btn-AddDiplomado',function(e){
    e.preventDefault();
    $.ajax({
      type:"GET",
      url: Routing.generate('addDiplomados'),
      success: function(html){
        $('#contentAddDiplomado').html(html);
      }
    });
  })

  //Permite editar un diplomado
  $('body').on('click','.btn-editDiplomado',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    e.preventDefault();
    $.ajax({
      type:"GET",
      url: Routing.generate('editDiplomados',{id:id}),
      success:function(html){
        $('#contentEditDiplomado').html(html);
      }
    })
  })

  //Creación del diplomado
  $('body').on('click','.btn-crearDiplomado',function(e){
    e.preventDefault();
    var data = $('#form_add_Diplomado').serialize();
    $.ajax({
      type:"POST",
      url: Routing.generate('createDiplomados'),
      data: data,
      success:function(html){
        $('#modalAddDiplomado').modal('hide');
        toastr.success("El diplomado ha sido creado exitosamente");
        setTimeout(function () {
        window.location.href = Routing.generate("indexDiplomados");
        },1000);
      },
      error:function(html){
        $('#contentAddDiplomado').html(html.responseText);
      }
    })
  })

  //Actualización del diplomado
  $('body').on('click','.btn-editarDiplomado',function(e){
    e.preventDefault();
    var id = $('#idDiplomado').val();
    var data = $('#form_edit_diplomado').serialize();
    $.ajax({
      type:"PUT",
      url: Routing.generate('updateDiplomados',{id:id}),
      data: data,
      success: function(html){
        $('#modalEditDiplomado').modal('hide');
        toastr.success("El diplomado ha sido editado exitosamente");
        setTimeout(function () {
        window.location.href = Routing.generate("indexDiplomados");
        },1000);
      },
      error:function(html){
        $('#contentEditDiplomado').html(html.responseText);
      }
    })
  })

  //Permite visualizar en modal los detalles de un diplomado
  $('body').on("click",'.btnVerDiplomado',function(e){
    e.preventDefault();
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:'GET',
      url: Routing.generate('viewDiplomados',{id:id}),
      success: function(html){
        $("#contentViewDiplomado").html(html);
      }
    })
  })

  //Permite eliminar un diplomado
  $('body').on('click','.btnDelDiplomado',function(e){
    e.preventDefault();
    var row = $(this).parents('tr');
    var id = row.data('id');
    var nombreDiplomado = $('#nombreDiplomado-'+id).html();
    bootbox.confirm({
      message: "¿Esta seguro que desea eliminar al diplomado: "+"<b>"+nombreDiplomado+"?</b>",
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
          eliminarDiplomado(id).done(function(){
            toastr.success("Se ha eliminado el diplomado de manera correcta");
            window.setTimeout(function(){
              window.location.href = Routing.generate('indexDiplomados');
            }, 1000);
          }).fail(function(data){
            toastr.error(data.responseText);
          })
        }
      }
    });
  })

  //Permite realizar la busqueda en la pestaña de diplomados
  $('body').on('keyup','#queryBusquedaDiplomado',function(e){
    e.preventDefault();
    var busqueda = $(this).val();
    $.ajax({
      type:"GET",
      url: Routing.generate('indexDiplomados'),
      data:{
        valorBusqueda: busqueda
      },
      success:function(html){
        $('#tabla_diplomados').replaceWith($(html).find('#tabla_diplomados'));
        $('#paginationDiplomados').twbsPagination('destroy');
        crearPaginadorDiplomados();
      }
    })
  })

  //Permite obtener todos los diplomados cuando se le da click en
  //mostrar todos
  $('body').on('click','.btnMostrarDiplomados',function(e){
    e.preventDefault();
    $('#queryBusquedaDiplomado').val('');
    $.ajax({
      type:"GET",
      url: Routing.generate('indexDiplomados'),
      data:{
        btnMostrarMentores: "btnMostrarDiplomados"
      },
      success:function(html){
        $('#tabla_diplomados').replaceWith($(html).find('#tabla_diplomados'));
        $('#paginationDiplomados').twbsPagination('destroy');
        crearPaginadorDiplomados();
      }
    })
  })

  //funcion que realiza el llamado al metodo de eliminar el diplomado
  function eliminarDiplomado(id)
  {
    return $.ajax({
      type:'DELETE',
      url: Routing.generate('deleteDiplomados',{id:id}),
    })
  }

  //Metodo que crea el paginador de los diplomados
  var crearPaginadorDiplomados = function(){
    var totalPages = $('#tabla_diplomados').attr('data-pageCount');
    if(totalPages != 0){
      $('#paginationDiplomados').twbsPagination({
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
            url: Routing.generate('indexDiplomados'),
            data:{
              pageActive: page,
            },
            success:function(html){
              $('#tabla_diplomados').replaceWith($(html).find('#tabla_diplomados'));
              headerSorter();
            }
          })
        }
      })
    }
    headerSorter();
  }

  crearPaginadorDiplomados();

  //Metodo que implementa el ordenamiento en las cabeceras de la tabla de mentores
  function headerSorter(){
    $('#tableItemsDiplomados').tablesorter({
      headers:{
        4:{sorter:false},5:{sorter:false},6:{sorter:false},7:{sorter:false}
      }
    });
  }

  //tooltip
  $(document).tooltip({
    selector:'[data-toggle="tooltip"]',
    placement:'top'
  });

})
