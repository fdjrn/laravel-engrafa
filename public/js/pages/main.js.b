$(document).ready(function(){
  $('.select2').each(function () {
      $(this).select2({
        width : '100%',
        allowClear:true,
        dropdownParent: $(this).parent()
      });
  });

  clearNSurveyModal();

  $("#mn_create_new_team").click(function(){
    clearNSurveyModal();
    $('#modal-n-survey').modal('show');
    init_n_survey_user("#i_n_surveyor");
    $('#i_n_surveyor').on("change", function(e) { 
      init_n_survey_user("#i_n_client",1);
    });
  });
  
  $('#i_n_expire').datetimepicker({});

  $("#drivers_purpose").change(function(){
    if(this.checked){
      $('.list-itgoal-purpose').show();
    }else{
      $('.list-itgoal-purpose').hide();
    }
  });

  $("#drivers_pain").change(function(){
    if(this.checked){
      $('.list-itgoal-pain').show();
    }else{
      $('.list-itgoal-pain').hide();
    }
  });

  $('input[name="i_itgoal[1-Purpose][]"]').each(function (index, element) {
    $(this).change(function(){
      var c_id = "#1-Purpose-"+$(this).val();
      if(this.checked){
        $(c_id).show();
      }else{
        $(c_id).hide();
      }
    });
  });

  $('input[name="i_itgoal[2-Pain][]"]').each(function (index, element) {
    $(this).change(function(){
      var c_id = "#2-Pain-"+$(this).val();
      if(this.checked){
        $(c_id).show();
      }else{
        $(c_id).hide();
      }
    });
  });

  var ads = '1-Purpose';
  var vss = '02';
  $('input[name="testing['+ads+'][]"][value="'+vss+'"]').hide();

});

function clearNSurveyModal(){
  $('#i_n_name_survey').val(null);
  $('#i_n_expire').val(null);
  $('#modal-n-survey').find('input[type=checkbox]:checked').prop('checked', false);
  $('.list-itgoal-purpose').hide();
  $('.list-itgoal-pain').hide();
  $('.list_edm').each(function(){
    $(this).hide();
  });
}

function init_n_survey_user(id_element,v_check){
  $.ajax({
      type: 'GET',
      url: base_url+'/assessment/0/ajax_get_list_user/no',
      success: function (data) {
          // the next thing you want to do 
          var $v_select = $(id_element);
          var item = JSON.parse(data);
          $v_select.empty();
          $v_select.append("<option value=''></option>");
          if(!v_check){
            $.each(item, function(index,valuee) {
                $v_select.append("<option value='"+valuee.id+"'>@"+valuee.username+"</option>");
            });
          }else{
            var selectedValues = $('#i_n_surveyor').val();
            $.each(item, function(index,valuee) { 
              if(selectedValues.indexOf(valuee.id.toString()) == -1){
                $v_select.append("<option value='"+valuee.id+"'>@"+valuee.username+"</option>");
              }
            });
          }

          //manually trigger a change event for the contry so that the change handler will get triggered
          $v_select.change();
      }
  });
}

$("#form_n_survey").submit(function(e) {
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
              text: 'Create New Assessment Success'
            });
            location.href = base_url+parse.messages;
          } else {
            swal({
              type: 'error',
              title: 'Gagal',
              html:parse.messages
            });
          }
         },
         cache: false,
         contentType: false,
         processData: false
       });
});