$(document).ready(function(){

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
            window.location.href = Routing.generate('adminLogin');
          })
        }
      }
    });
  })

  //funcion que realiza el llamado al metodo de eliminar la semilla
  function eliminarSemilla(id)
  {
    return $.ajax({
      type:'DELETE',
      url: Routing.generate('deleteSemillas',{id:id}),
    })
  }

  $('.js-datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: "es",
    todayHighlight: true,
    endDate: "today",
    autoclose: true
  });

})
