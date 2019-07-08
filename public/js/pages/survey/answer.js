function checkWP(input){

  var wp = input.split(",",1);

  $.ajax({
      type: "GET",
      url: base_url+'/assessment/get_process_outcome_wp/'+input,
      success: function(response)
      {
        var item = JSON.parse(response);
        var count = 0;
        $.each(item.data, function(index,valuee) {
          if(valuee.file != null){
            count++;
          }
        });
        if (count == 0) {
            $('input[name="metcriteria['+wp+']"][value="yes"]').prop('checked',false);
            $('input[name="metcriteria['+wp+']"][value="no"]').prop('checked',true);
            swal({
              type: 'error',
              title: 'Tidak ada working product terupload ditemukan!',
              html: 'Anda harus mengupload working product untuk menjawab <b>Yes</b>'
            });
        }
      }
  });
}

function getWP(input){
  $('#m_u_file').modal('show');
  $('#curWP').val(input);
  var mtype = $('#curTyp').val();
  $('#wp-title').html(input.split(",",1));

  var table = {
    el: {},
    id: '#table-wp'
  };

  table.el = $(table.id).DataTable({
      serverSide: false,
      "bDestroy": true,
      searching: false, paging: false, info: false,
      responsive: true,
      processing: true,
      ajax: {
      url: base_url+'/assessment/get_process_outcome_wp/'+input,
      method: 'GET',
      },
      columns: [
          {
              data: 'id',
              render: function(data, type, row, meta) {
              return data;
              }
          },
          {
              data: 'process',
              render: function(data, type, row, meta) {
              return data;
              }
          },
          {
              data: 'file',
              render: function(data, type, row, meta) {
                let action = "File Unavailable";
                if(mtype == 'answer' && row.process !== null){
                 action = "<input type='file' name='files["+row.id+"]' style='width:100%;' accept='"+supported_type+"' />";
                }
                if(data){
                  action="<a onClick='doWp(\""+row.fileid+"\",\"downloadWp\")' class='btn btn-sm btn-default'><i class='fa fa-download'></i></a>"+
                  "&nbsp;&nbsp;&nbsp;<a onClick='doWp(\""+row.fileid+"\",\"viewWp\")'>"+row.filename+"</a>";
                }
                return action;
              }
          }
      ]
  });
}

function doWp(fileid,doAction){
  // let doAction = $(this).attr('data-do-action');
  console.log(doAction);
  $.ajax({
      type: "GET",
      url: base_url+'/assessment/'+doAction+'/'+fileid,
      success: function(data)
      {
        if (data == 1) {
            swal({
              type: 'error',
              title: 'Gagal',
              text: 'File not found!'
            });
        }else{
            window.location.href = '/assessment/'+doAction+'/'+fileid;
        }
      }
  });
}

$("#form_w_product").submit(function(e) {
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
            getWP($('#curWP').val());
            swal({
              type: 'success',
              title: 'Berhasil',
              text: parse.messages
            });
          } else {
            swal({
              type: 'error',
              title: 'Gagal',
              text: parse.messages
            });
          }
         },
         cache: false,
         contentType: false,
         processData: false
       });
});