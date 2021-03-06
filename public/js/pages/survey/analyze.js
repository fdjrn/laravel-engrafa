function getWP(input){
  $('#m_u_file').modal('show');
  $('#curWP').val(input);
  $('#wp-title').html(input.split(",",1));

  var table = {
    el: {},
    id: '#table-wp'
  };

  table.el = $(table.id).DataTable({
      serverSide: false,
      "bDestroy": true,
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
              let action = "Document Unavailable";
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