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
              if(mtype == 'answer'){
               action = "<input type='file' name='files["+row.id+"]' style='width:100%;' accept='"+supported_type+"' />";
              }
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