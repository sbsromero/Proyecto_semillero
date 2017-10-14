$(document).ready(function(){

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
    var nombreGrupo = $('#nombreGrupo').html();
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

  $('.js-datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: "es",
    todayHighlight: true,
    endDate: "today",
    autoclose: true
  });

})
