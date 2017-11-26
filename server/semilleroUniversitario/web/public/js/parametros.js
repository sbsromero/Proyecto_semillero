$(document).ready(function(){

  //Agregar un semestre
  $('body').on('click','.btnAddSemestre',function(e){
    e.preventDefault();
    $.ajax({
      type:"GET",
      url: Routing.generate('addSemestre'),
      success: function(html){
        $('#contentAddSemestre').html(html);
      }
    });
  })

  //Creación del semestre
  $('body').on('click','.btn-crearSemestre',function(e){
    e.preventDefault();
    var data = $('#form_add_semestre').serialize();
    $.ajax({
      type:"POST",
      url: Routing.generate('createSemestre'),
      data: data,
      success:function(html){
        $('#modalAddSemestre').modal('hide');
        toastr.success("El semestre sido creado exitosamente");
        setTimeout(function () {
        window.location.href = Routing.generate("indexSemestres");
        },1000);
      },
      error:function(html){
        $('#contentAddSemestre').html(html.responseText);
      }
    })
  })

  //Permite activar un semestre
  $('body').on('click','.activarSemestre', function(e){
    e.preventDefault();
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:"POST",
      url: Routing.generate('activarSemestre', {id:id}),
      success: function(){
        toastr.success("El semestre seleccionado ha sido activado");
        window.setTimeout(function(){
          window.location.href = Routing.generate('indexSemestres');
        }, 1000);
      }
    })
  })

  //Permite inactivar un semestre
  $('body').on('click','.inactivarSemestre',function(e){
    e.preventDefault();
    var row = $(this).parents('tr');
    var id = row.data('id');
    $.ajax({
      type:"POST",
      url: Routing.generate('inactivarSemestre', {id:id}),
      success: function(){
        toastr.success("El semestre seleccionado ha sido inactivado");
        window.setTimeout(function(){
          window.location.href = Routing.generate('indexSemestres');
        }, 1000);
      }
    })
  })

  //tooltip
  $(document).tooltip({
    selector:'[data-toggle="tooltip"]',
    placement:'top'
  });

})
