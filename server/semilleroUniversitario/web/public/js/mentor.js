$(document).ready(function(){

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
})
