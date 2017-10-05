$(document).ready(function(){

  //Permite eliminar un grupo
  $('body').on('click','.btnDelDiplomado',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    var nombreDiplomado = $('#nombreDiplomado').html();
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

  $('.js-datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: "es",
    todayHighlight: true,
    endDate: "today",
    autoclose: true
  });

})
