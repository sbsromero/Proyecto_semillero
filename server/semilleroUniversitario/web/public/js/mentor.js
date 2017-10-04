$(document).ready(function(){

  //Permite visualizar en modal los detalles de un mentor
  $('body').on("click",'.btnVerMentor',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:'GET',
      url: Routing.generate('viewMentores',{id:id}),
      success: function(html){
        $("#contentViewMentor").html(html);
        $("#modalViewMentor").modal('show');
      }
    })
  })

  //Permite eliminar un mentor
  $('body').on('click','.btnDelMentor',function(e){
    var row = $(this).parents('tr');
    var id = row.data('id');
    var dni = $('#dniMentor').html();
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
          eliminarMentor(id).done(function(){
            toastr.success("Se ha eliminado el mentor de manera correcta");
            window.setTimeout(function(){
              window.location.href = Routing.generate('indexMentores');
            }, 1000);
          }).fail(function(data){
            window.location.href = Routing.generate('adminLogin');
          })
        }
      }
    });
  })

  //funcion que realiza el llamado al metodo de eliminar el mentor
  function eliminarMentor(id)
  {
    return $.ajax({
      type:'DELETE',
      url: Routing.generate('deleteMentores',{id:id}),
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
