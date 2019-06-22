$(document).ready(function(){
	var btnSubmit = '#btn_save_share_quisioner';

	$('#btn_cancel_view').click(function(){
	    window.location.href = window.location.origin + '/quisioner';
	});

	$(btnSubmit).unbind('click');
	$(btnSubmit).unbind('url');
	$(btnSubmit).click(function(){
		handlingProccessShare();
	});

	var handlingProccessShare = function(){
	    var base_url = window.location.origin;
	    var share_url = base_url+"/quisioner/saveshare";
	    var id_quisioner = $('#share_qeustioner_id').val();
	    var id_user = $('#share_qeustioner_user').val();

	    $.ajaxSetup({
	      headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      }
	    });

	    $.ajax({
	      type: "POST",
	      url: share_url,
	      data: {idQuisioner: id_quisioner, idUser: id_user},
	      success: function (response) {
	        if(response.status == 1){
	          swal({
	              type: "success",
	              title: "Success",
	              text: 'Quisioner has been shared',
	              timer: 4000
	          }).then(function() {
	              window.location.href = base_url+'/quisioner';
	          });
	        }else if(response.status == 2){
	        	swal({
		            type: "error",
		            title: "Error",
		            text: 'Quisioner or user field must be filled',
		            timer: 4000
		        });
	        }else if(response.status == 3){
	        	swal({
		            type: "error",
		            title: "Error",
		            text: 'Quisioner has beed shared to user',
		            timer: 4000
		        });
	        }else{
	          //toastr.error(response.message,'Error');
	          swal({
	              type: "error",
	              title: "Error",
	              text: 'Quisioner shared failed',
	              timer: 4000
	          });
	        }
	        $("#btn_save_share_quisioner").button('reset');
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
	          //toastr.error("Internal Server Error",'Error');
	          swal({
	              type: "error",
	              title: "Error",
	              text: 'Internal Server Error',
	              timer: 2000
	          });
	      }
	    });

	}

});