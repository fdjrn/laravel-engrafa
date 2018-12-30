var table_edm = {
  el: {},
  id: '#table_edm'
};
var table_done = {
  el: {},
  id: '#table_done'
};

$(document).ready(function(){
  table_edm.el = $(table_edm.id).dataTable({
    "order": []
  });
  table_done.el = $(table_done.id).dataTable({
    "order": []
  });
    initialize_inv_user("#inv_surveyor");
    $('#inv_surveyor').on("change", function(e) { 
      initialize_inv_user("#inv_responden",1);
    });
});

$("#o_invite_user").click(function(){
  $('#m_invite_user').modal('show');
});

function initialize_inv_user(id_element,v_check){
  var s_id = $("#s_id").val();
  if(s_id){
    $.ajax({
        type: 'GET',
        url: base_url+'/survey/'+s_id+'/ajax_get_list_user/'+s_id,
        success: function (data) {
            // the next thing you want to do 
            var $v_select = $(id_element);
            $v_select.empty();
            $v_select.append("<option value=''></option>");
            var item = JSON.parse(data);
            if(!v_check){
              $.each(item, function(index,valuee) {
                  $v_select.append("<option value='"+valuee.id+"'>@"+valuee.username+"</option>");
              });
            }else{
              var selectedValues = $('#inv_surveyor').val();
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
}

$("#form_i_user").submit(function(e) {
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
              text: 'Invite User Success'
            });
            location.href = base_url+parse.messages;
          } else {
            swal({
              type: 'error',
              title: 'Gagal',
              html: parse.messages
            });
          }
         },
         cache: false,
         contentType: false,
         processData: false
       });
});