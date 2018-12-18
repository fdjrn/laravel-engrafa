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
    initialize_inv_user("#inv_responden");
    initialize_inv_user("#inv_surveyor");
});

$("#o_invite_user").click(function(){
  $('#m_invite_user').modal('show');
});

function initialize_inv_user(id_element){
  var s_id = $("#s_id").val();
  if(s_id){
    $.ajax({
        type: 'GET',
        url: base_url+'/survey/ajax_get_list_user/'+s_id,
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