$(document).ready(function(){

});


function cleanModal(){
	$('#user_id').val(null);
	$("#nama_depan").val(null);
	$("#nama_belakang").val(null);
	$("#username").val(null);
	$("#roles").val(null).trigger('change');
	$("#email").val(null);
	$("#telepon").val(null);
	$("#password").val(null);
	$("#password_confirmation").val(null);
	$("#password").show();
	$("#password_confirmation").show();
}

function openModals(type,userId){
	cleanModal();
	if(type == 'create'){
      	$('#form_n_user').attr('action','');
  		$('.modal-title').html('<i class="fa fa-user-plus"></i>&nbsp;Create New User');
		$('#m_new_user').modal('show');
	}else if(type == 'edit'){
      	$('#form_n_user').attr('action','users/edit_user');
		$("#password").hide();
		$("#password_confirmation").hide();
  		$('.modal-title').html('<i class="fa fa-edit"></i>&nbsp;Edit Existing User');
  		$('#user_id').val(userId);
		$('#m_new_user').modal('show');
		$.ajax({
			url:
			  base_url + '/setting/users/'+userId,
			  method: 'get',
			success: function(response) {
				let parse = JSON.parse(response);
				console.log(parse);
				$("#nama_depan").val(parse.first_name);
				$("#nama_belakang").val(parse.last_name);
				$("#username").val(parse.username);
					$("#roles").val(parse.role).trigger('change');
				$("#email").val(parse.email);
				$("#telepon").val(parse.phone);
				$("#password").val(null);
				$("#password_confirmation").val(null);
			}
		});
	}
};

$("#form_n_user").submit(function(e) {
  e.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  var formData = new FormData(this);
  var messages = 'Create User Success';
  if(url){
  	messages = 'Edit User Success';
  }

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
              text: messages
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