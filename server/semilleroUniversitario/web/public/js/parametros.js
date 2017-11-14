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

  //Creación del diplomado
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
        // window.location.href = Routing.generate("indexSemestres");
        },1000);
      },
      error:function(html){
        $('#contentAddSemestre').html(html.responseText);
      }
    })
  })

})
