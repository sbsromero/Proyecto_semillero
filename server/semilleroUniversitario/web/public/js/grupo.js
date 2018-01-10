$(document).ready(function(){

  //Muestra la modal para agregar grupos
  $('body').on('click','.btn-AddGrupo',function(e){
    e.preventDefault();
    $.ajax({
      type:"GET",
      url: Routing.generate('addGrupos'),
      success: function(html){
        $('#contentAddGrupo').html(html);
      }
    });
  })

  //Envia la información para crear un grupo
  $('body').on('click','.btn-crearGrupo',function(e){
    e.preventDefault();
    var data = $('#form_add_Grupo').serialize();
    $.ajax({
      type:"POST",
      url: Routing.generate('createGrupos'),
      data: data,
      success:function(html){
        $('#modalAddGrupo').modal('hide');
        toastr.success("El grupo ha sido creado exitosamente");
        setTimeout(function () {
        window.location.href = Routing.generate("indexGrupos");
      },1000);
      },
      error:function(html){
        $('#contentAddGrupo').html(html.responseText);
      }
    })
  })

  //Muestra la modal de edición de grupos
  $('body').on('click','.btn-editGrupo',function(e){
    e.preventDefault();
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:"GET",
      url: Routing.generate('editGrupos',{id:id}),
      success: function(html){
        $('#contentEditGrupo').html(html);
      }
    })
  })

  //Metodo que permite mostrar la modal para asignar un mentor
  //a un grupo
  $('body').on('click','.btnAsignarMentor', function(e){
    e.preventDefault();
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:"GET",
      url: Routing.generate('getAsignarMentor',{id:id}),
      success: function(html){
        $('#contentAsignarMentor').html(html);
        createPaginationMentores();
      }
    })
  })

  //Metodo que crea el paginador de mentores en la modal de asignar
  //mentor a un grupo
  var createPaginationMentores = function(){
    var totalPages = $('#tablaMentores').attr('data-pagecount');
    var id = $('#nombreGrupo').data('idgrupo');
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
            url: Routing.generate('getAsignarMentor',{id:id}),
            data:{
              pageActive: page,
            },
            success:function(html){
              $('#tablaMentores').replaceWith($(html).find('#tablaMentores'));
            }
          })
        }
      })
    }
  }


  $('body').on('click','.checkAsignarMentor', function(e){
    var idGrupo = $('#nombreGrupo').data('idgrupo');
    var idMentor = $(this).parents('tr').data('id');
    var tr = $(this).parents('tr');
    tr.attr('style','background-color: #c5e1fb !important')
    bootbox.confirm({
      message: "¿Esta seguro que desea asignar este mentor al grupo?",
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
            url: Routing.generate('setMentor'),
            data:{
              idGrupo: idGrupo,
              idMentor: idMentor
            },
            success: function(html){
              console.log(html);
              $('#modalAsignarMentor').modal('hide');
              // window.location.href = Routing.generate("indexGrupos")
            },
            error: function(html){
              toastr.error("No se pueden asignar mas grupos a este mentor");
            }
          })
        }
        else{
          tr.attr('style','')
        }
      }
    });
  })

  //Actualización de grupo
  $('body').on('click','.btn-editarGrupo',function(e){
    e.preventDefault();
    var id = $('#idGrupo').val();
    var data = $('#form_edit_grupo').serialize();
    $.ajax({
      type: "PUT",
      url: Routing.generate('updateGrupos',{id:id}),
      data:data,
      success: function(html){
        $('#modalEditGrupo').modal('hide');
        toastr.success("El grupo ha sido editado exitosamente");
        setTimeout(function () {
        window.location.href = Routing.generate("indexGrupos");
        },1000);
      },
      error: function(html){
        $('#contentEditGrupo').html(html.responseText);
      }
    })
  })

  //Permite visualizar en modal los detalles de un grupo
  $('body').on("click",'.btnVerGrupo',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:'GET',
      url: Routing.generate('viewGrupos',{id:id}),
      success: function(html){
        $("#contentViewGrupo").html(html);
      }
    })
  })

  //Permite eliminar un grupo
  $('body').on('click','.btnDelGrupo',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    var nombreGrupo = $('#nombreGrupo-'+id).html();
    bootbox.confirm({
      message: "¿Esta seguro que desea eliminar al grupo: "+"<b>"+nombreGrupo+"?</b>",
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
          eliminarGrupo(id).done(function(){
            toastr.success("Se ha eliminado el grupo de manera correcta");
            window.setTimeout(function(){
             window.location.href = Routing.generate('indexGrupos');
            }, 1000);
          }).fail(function(data){
            toastr.error(data.responseText);
          })
        }
      }
    });
  })

  //Permite realizar la busqueda en la pestaña de grupos
  $('body').on('keyup','#queryBusquedaGrupo',function(e){
    e.preventDefault();
    var busqueda = $(this).val();
    $.ajax({
      type:"GET",
      url: Routing.generate('indexGrupos'),
      data:{
        valorBusqueda: busqueda
      },
      success:function(html){
        $('#tabla_grupos').replaceWith($(html).find('#tabla_grupos'));
        $('#paginationGrupos').twbsPagination('destroy');
        crearPaginadorGrupos();
      }
    })
  })

  //Permite obtener todos los grupos cuando se le da click en
  //mostrar todos
  $('body').on('click','.btnMostrarGrupos',function(e){
    e.preventDefault();
    $('#queryBusquedaGrupo').val('');
    $.ajax({
      type:"GET",
      url: Routing.generate('indexGrupos'),
      data:{
        btnMostrarGrupos: "btnMostrarGrupos"
      },
      success:function(html){
        $('#tabla_grupos').replaceWith($(html).find('#tabla_grupos'));
        $('#paginationGrupos').twbsPagination('destroy');
        crearPaginadorGrupos();
      }
    })
  })

  //funcion que realiza el llamado al metodo de eliminar el grupo
  function eliminarGrupo(id)
  {
    return $.ajax({
      type:'DELETE',
      url: Routing.generate('deleteGrupos',{id:id}),
    })
  }

  //Metodo que crea el paginador de los grupos
  var crearPaginadorGrupos = function(){
    var totalPages = $('#tabla_grupos').attr('data-pageCount');
    if(totalPages != 0){
      $('#paginationGrupos').twbsPagination({
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
            url: Routing.generate('indexGrupos'),
            data:{
              pageActive: page,
            },
            success:function(html){
              $('#tabla_grupos').replaceWith($(html).find('#tabla_grupos'));
              headerSorter();
            }
          })
        }
      })
    }
    headerSorter();
  }

  crearPaginadorGrupos();

  //Metodo que implementa el ordenamiento en las cabeceras de la tabla de grupos
  function headerSorter(){
    $('#tableItemsGrupos').tablesorter({
      headers:{
        7:{sorter:false},8:{sorter:false},9:{sorter:false},10:{sorter:false}
      }
    });
  }

  //tooltip
  $(document).tooltip({
    selector:'[data-toggle="tooltip"]',
    placement:'top'
  });

  })
