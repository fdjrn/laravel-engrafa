var $list_process = $("#d_process_list");

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

    $('.list-itgoal-purpose').find('input[name="i_itgoal[]"]:checked').prop('checked', false);
    changeProcessList();
  });

  $("#drivers_pain").change(function(){
    if(this.checked){
      $('.list-itgoal-pain').show();
    }else{
      $('.list-itgoal-pain').hide();
    }

    $('.list-itgoal-pain').find('input[name="i_itgoal[]"]:checked').prop('checked', false);
    changeProcessList();
  });

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $('input[name="i_itgoal[]"]').each(function (index, element) {
    $(this).change(function(){
      changeProcessList();
    });
  });

});

function changeProcessList(){
  var it_goals = $('.c_itgoal').serialize();
  $list_process.empty();
  $('.l_process_list').show();

  $.ajax({
      type: 'POST',
      url: base_url+'/assessment/get_process_list',
      data: it_goals,
      success: function (data) {
          // the next thing you want to do 
          let item = JSON.parse(data);
          if(item.status > 0){
            $.each(item.data, function(index,valuee) {
              $list_process.append(
                        '<div class="form-group" id="process-'+valuee.process+'" data-process="0" style="padding-right: 9px;">'+
                        '<label class="col-sm-6 control-label" for="sName"  style="padding-right:1px;">'+valuee.process+'&nbsp;&nbsp;Target : </label>'+
                        '<input type="hidden" name="i_itgoal_process['+valuee.process+']" value="'+valuee.process+'">'+
                        '<div class="col-sm-6" style="padding-left: 2px; padding-right: 2px;">'+
                        '<select name="i_itgoal_process_level['+valuee.process+']" class="form-control s_level" id="sName" data-placeholder="Select Level">'+
                        $.map(item.level, function(v,k) {
                          if(v.level == 0){
                            return '<option value="'+v.level+'" selected>Level&nbsp;'+v.level+'</option>';
                          }else{
                            return '<option value="'+v.level+'">Level&nbsp;'+v.level+'</option>';
                          }
                        })+
                        '</select>'+
                        '<input name="i_itgoal_process_percent['+valuee.process+']" value="100" type="hidden" class="form-control" />'+
                        '</div>'+
                        '</div>'
              );
            });

            //manually trigger a change event for the contry so that the change handler will get triggered
            $list_process.change();

            $('.s_level').each(function () {
                $(this).select2({
                  width : '100%',
                  allowClear:true,
                  dropdownParent: $(this).parent()
                });
            });
          }
      },
      complete: function(data){
        $('.l_process_list').hide();
      }
  });
}

function clearNSurveyModal(){
  $('#i_n_name_survey').val(null);
  $('#i_n_expire').val(null);
  $('#modal-n-survey').find('input[type=checkbox]:checked').prop('checked', false);
  $('.list-itgoal-purpose').hide();
  $('.list-itgoal-pain').hide();
  $('.l_process_list').hide();
  $list_process.empty();
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