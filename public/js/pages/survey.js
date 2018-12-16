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
});