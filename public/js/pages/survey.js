var table_edm = {
  el: {},
  id: '#table_edm'
};
var table_done = {
  el: {},
  id: '#table_done'
};
var table_members = {
  el: {},
  id: '#table_members'
};

$(document).ready(function(){
  table_edm.el = $(table_edm.id).dataTable({
    "order": []
  });
  table_done.el = $(table_done.id).dataTable({
    "order": []
  });
  table_members.el = $(table_members.id).dataTable({
    "order": [],
    "dom": "<'row'<'col-sm-6'l><'col-sm-6'Bf>>" +
            "<'row'<'col-sm-6'><'col-sm-6'>>" +
            "<'row'<'col-sm-12't>><'row'<'col-sm-12'ip>>",
    buttons: {
      dom: {
        button: {
          tag: 'button',
          className: ''
        }
      },
      buttons: [
        {
          text: '<i class="fa fa-user-plus"></i> Invite', className: 'btn btn-sm btn-default add-user',
            action: function ( e, dt, node, config ) {
              $('#m_invite_user').modal('show');
            }
        },
      ]
    },
  });

    initialize_inv_user("#inv_surveyor");
    $('#inv_surveyor').on("change", function(e) { 
      initialize_inv_user("#inv_responden",1);
    });
});

$("#o_invite_user").click(function(){
  $('#m_invite_user').modal('show');
});

$(".o_m_e_members").click(function(){
  var user_id = $(this).data('id');
  var username = $(this).data('username');
  var role = $(this).data('role');

  $('#user_id').val(user_id);
  $('#i_username').val(username);
  $('#i_role').val(role).trigger('change');

  $('#m_e_members').modal('show');
});


$(".o_m_e_process").click(function(){
  var process = $(this).data('process');
  var targetLevel = $(this).data('targetlevel');

  $('#i_process').val(process);
  $('#i_target_level').val(targetLevel).trigger('change');

  $('#m_e_process').modal('show');
});

$(".b_del_user").click(function(){
  var dataurl = $(this).data('url');
  Swal.fire({
    title: 'Apakah anda yakin?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.value) {
      $.ajax({
         type: "POST",
         url: dataurl,
         success: function(data)
         {
          let parse = JSON.parse(data);
          if (parse.status > 0) {
            swal({
              type: 'success',
              title: 'Berhasil',
              text: 'Delete Member Berhasil'
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
    }
  })
});

function initialize_inv_user(id_element,v_check){
  var s_id = $("#s_id").val();
  if(s_id){
    $.ajax({
        type: 'GET',
        url: base_url+'/assessment/'+s_id+'/ajax_get_list_user/'+s_id,
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
              text: 'Invite User Berhasil'
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

$("#form_e_members").submit(function(e) {
  e.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  var formData = new FormData(this);

  Swal.fire({
    title: 'Apakah anda yakin?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.value) {
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
            text: 'Edit Member Berhasil'
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
    }
  })

});

$("#form_e_process").submit(function(e) {
  e.preventDefault();
  var form = $(this);
  var url = form.attr('action');
  var formData = new FormData(this);

  Swal.fire({
    title: 'Apakah anda yakin?',
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes'
  }).then((result) => {
    if (result.value) {
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
            text: 'Edit Process Berhasil'
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
    }
  })

});