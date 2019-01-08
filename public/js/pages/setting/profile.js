$(document).ready(function(){
  var btnCancel = "#btn_cancel";
  
  //handling button cancel
  $(btnCancel).unbind('click');
  $(btnCancel).click(function(){
    var base_url = window.location.origin;
    window.location.href = base_url+'/setting';
  });

});