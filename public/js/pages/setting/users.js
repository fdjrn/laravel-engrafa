$(document).ready(function(){
	$("#o_new_user").click(function(){
		$('#m_new_user').modal('show');
	});

});

$("#form_n_user").submit(function(e) {
  e.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  var formData = new FormData(this);

  $.ajax({
         type: "POST",
         url: url,
         data: formData, // serializes the form's elements.
         success: function(data)
         {
          let parse = JSON.parse(data);
          if (parse.status > 0) {
            swal({
              type: 'success',
              title: 'Berhasil',
              text: 'Create User Success'
            });
            location.href = base_url+parse.messages;
          } else {
            swal({
              type: 'error',
              title: 'Gagal',
              html:true,
              text: parse.messages
            });
          }
         },
         cache: false,
         contentType: false,
         processData: false
       });
});