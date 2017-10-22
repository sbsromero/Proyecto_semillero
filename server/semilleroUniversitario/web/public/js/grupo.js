$(document).ready(function(){

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

  $('body').on('click','.btn-crearGrupo',function(e){
    e.preventDefault();
    var data = $('#form_add_Grupo').serialize();
    $.ajax({
      type:"POST",
      url: Routing.generate('createGrupos'),
      data: data,
      success:function(html){
        toastr.success("El grupo ha sido creado exitosamente");
        setTimeout(function () {
        window.location.href = Routing.generate("indexGrupos");
        },2000);
      },
      error:function(html){
        $('#contentAddGrupo').html(html.responseText);
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
        $("#modalViewGrupo").modal('show');
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
