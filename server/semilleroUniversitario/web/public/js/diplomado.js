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
    var id = $('#idDiplomado').val();
    e.preventDefault();
    var data = $('#form_edit_diplomado').serialize();
    $.ajax({
      type:"POST",
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
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:'GET',
      url: Routing.generate('viewDiplomados',{id:id}),
      success: function(html){
        $("#contentViewDiplomado").html(html);
        $("#modalViewDiplomado").modal('show');
      }
    })
  })

  //Permite eliminar un diplomado
  $('body').on('click','.btnDelDiplomado',function(e){
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
            window.location.href = Routing.generate('adminLogin');
          })
        }
      }
    });
  })

  //funcion que realiza el llamado al metodo de eliminar el diplomado
  function eliminarDiplomado(id)
  {
    return $.ajax({
      type:'DELETE',
      url: Routing.generate('deleteDiplomados',{id:id}),
    })
  }

  var mensajeDiplomados = $('#mensajeDiplomados').val();
  if(mensajeDiplomados!="" && mensajeDiplomados!=undefined){
    toastr.success(mensajeDiplomados);
  }

})
