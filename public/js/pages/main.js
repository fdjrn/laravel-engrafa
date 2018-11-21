$(document).ready(function(){
	$("#mn_create_new_team").click(function(){
		$('#modal-n-survey').modal('show');
	});

  $("#b_create_new_team").click(function(){
    $('#modal-n-survey').modal('show');
  });

    initialize_select_user("#i_n_surveyor");
    initialize_select_user("#i_n_client");
    $('.select2').select2({
              placeholder: "Pilih Dari List"
    });
    $('#i_n_expire').datetimepicker({});

});

function initialize_select_user(id_element){
  $.ajax({
      type: 'GET',
      url: base_url+'/survey/ajax_get_list_user',
      // data: {
      //     'anakunit': idUnit
      // },
      success: function (data) {
          // the next thing you want to do 
          var $v_select = $(id_element);
          var item = JSON.parse(data);
          $v_select.empty();
          $v_select.append("<option value=''></option>");
          $.each(item, function(index,valuee) {        
              $v_select.append("<option value='"+valuee.id+"'>@"+valuee.username+"</option>");
          });

          //manually trigger a change event for the contry so that the change handler will get triggered
          $v_select.change();
      }
  });
}