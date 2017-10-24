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
            window.location.href = Routing.generate('adminLogin');
          })
        }
      }
    });
  })

  //funcion que realiza el llamado al metodo de eliminar el grupo
  function eliminarGrupo(id)
  {
    return $.ajax({
      type:'DELETE',
      url: Routing.generate('deleteGrupos',{id:id}),
    })
  }

})
