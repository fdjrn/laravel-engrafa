$(document).ready(function(){
  $('.select2').each(function () {
      $(this).select2({
        width : '100%',
        allowClear:true,
        dropdownParent: $(this).parent()
      });
  });

  $("#mn_create_new_team").click(function(){
    $('#modal-n-survey').modal('show');
    initialize_select_user("#i_n_surveyor");
    $('#i_n_surveyor').on("change", function(e) { 
      initialize_select_user("#i_n_client",1);
    });
  });
    $('#i_n_expire').datetimepicker({});

    if($("#i_n_survey_type").val() !== ""){
      var stype = $("#i_n_survey_type").val();
      if(!stype){
        $('.list-itgoal-purpose').hide();
        $('.list-itgoal-pain').hide();
      }else if(stype === '1-Purpose'){
        $('.list-itgoal-purpose').show();
        $('.list-itgoal-pain').hide();
      }else if(stype === '2-Pain'){
        $('.list-itgoal-pain').show();
        $('.list-itgoal-purpose').hide();
      }
    }else{
      $("#list-itgoal").hide();
    }

    $("#i_n_survey_type").on('change',function(){
      var stype = $(this).val();
      if(!stype){
        $("#list-itgoal").hide();
        $('.list-itgoal-purpose').hide();
        $('.list-itgoal-pain').hide();
      }else if(stype === '1-Purpose'){
        $("#list-itgoal").show();
        $('.list-itgoal-purpose').show();
        $('.list-itgoal-pain').hide();
      }else if(stype === '2-Pain'){
        $("#list-itgoal").show();
        $('.list-itgoal-pain').show();
        $('.list-itgoal-purpose').hide();
      }
    });

});

function initialize_select_user(id_element,v_check){
  $.ajax({
      type: 'GET',
      url: base_url+'/survey/0/ajax_get_list_user/no',
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
              text: 'Create New Survey Success'
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