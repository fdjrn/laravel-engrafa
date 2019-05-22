$(document).ready(function(){
	var btnSubmit = '#btn_save_share_quisioner';

	$("ol").html("");

	$('.btn-answer-asking').click(function(){
		$("ol").html("");
	    handlingProccess(this, 'asking');
	});

	$('.btn-answer-checkbox').click(function(){
		$("ol").html("");
	    handlingProccess(this, 'checkbox');
	});

	$('.btn-answer-slider').click(function(){
		$("ol").html("");
	    handlingProccess(this, 'slider');
	});

	$('.btn-answer-rating').click(function(){
		$("ol").html("");
	    handlingProccess(this, 'rating');
	});


	$('#btn_cancel_view').click(function(){
	    window.location.href = window.location.origin + '/quisioner';
	});

	$(btnSubmit).unbind('click');
	$(btnSubmit).unbind('url');
	$(btnSubmit).click(function(){
		handlingProccessShare();
	});

	var handlingProccess = function(params, type){
	    if(type == 'asking'){
	    	var base_url = window.location.origin;
	    	var share_url = base_url+"/quisioner/quisioneranswerasking";
	    	var id_quisioner = params.getAttribute('data-idquisioner');
		    var id_question = params.getAttribute('data-idquestion');
		    var id_quisioner_answer = params.getAttribute('data-idanswer');
	    }else if(type == 'checkbox'){
	    	var base_url = window.location.origin;
	    	var share_url = base_url+"/quisioner/quisioneranswercheckbox";
	    	var id_quisioner = params.getAttribute('data-idquisioner');
		    var id_question = params.getAttribute('data-idquestion');
		    var id_quisioner_answer = params.getAttribute('data-idanswer');
	    }else if(type == 'slider'){
	    	var base_url = window.location.origin;
	    	var share_url = base_url+"/quisioner/quisioneranswerslider";
	    	var id_quisioner = params.getAttribute('data-idquisioner');
		    var id_question = params.getAttribute('data-idquestion');
		    var id_quisioner_answer = '';
	    }else if(type == 'rating'){
	    	var base_url = window.location.origin;
	    	var share_url = base_url+"/quisioner/quisioneranswerrating";
	    	var id_quisioner = params.getAttribute('data-idquisioner');
		    var id_question = params.getAttribute('data-idquestion');
		    var id_quisioner_answer = '';
	    }

	    $.ajaxSetup({
	      headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	      }
	    });

	    $.ajax({
	      type: "POST",
	      url: share_url,
	      data: {idQuisioner: id_quisioner, idQuestion: id_question, idQuisionerAnswer: id_quisioner_answer},
	      success: function (response) {
	        if(response.status == 1){
	        	for(var i=0; i<response.data.length; i++){
	        		$("ol").append("<li>"+response.data[i].user_name+"</li>");
	        	}
	        }else{
	            $("ol").append("No Data Available");
	        }
	      },
	      error: function (XMLHttpRequest, textStatus, errorThrown) {
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