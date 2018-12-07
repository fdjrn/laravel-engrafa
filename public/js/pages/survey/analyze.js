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
      url: base_url+'/survey/get_process_outcome_wp/'+input,
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
                action="<a href='/survey/downloadWp/"+row.fileid+"' class='btn btn-sm btn-default'><i class='fa fa-download'></i></a>"+
                "&nbsp;&nbsp;&nbsp;<a href='/survey/viewWp/"+row.fileid+"'>"+row.filename+"</a>";
              }
              return action;
              }
          }
      ]
  });
}