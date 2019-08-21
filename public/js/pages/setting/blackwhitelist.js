$(document).ready(function(){
  var btnSwitch = "#btnSwitch";
  var dataOnArr = [];
  var dataOffArr = [];

  //handling switch on off
  $("input[type='checkbox']").unbind('change');
  $("input[type='checkbox']").change(function() {
    if(this.checked) {
      $('#'+this.id).attr('checked', true);
    }else{
      $('#'+this.id).attr('checked', false);
    }
  });
  
  //handling button switch
  $(btnSwitch).unbind('click');
  $(btnSwitch).unbind('url');
  $(btnSwitch).click(function(){
    dataOnArr = [];
    dataOffArr = [];
    $("#table_whitelist input[type='checkbox']").each(function(){
      if(this.checked) {
        dataOnArr.push(this.id);
      }else{
        dataOffArr.push(this.id);
      }
    });
    $("#table_blacklist input[type='checkbox']").each(function(){
      if(this.checked) {
        dataOnArr.push(this.id);
      }else{
        dataOffArr.push(this.id);
      }
    });

    var base_url = window.location.origin;
    var updateUrl = base_url+'/setting/updateblackwhitelist';

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      type: "POST",
      url: updateUrl,
      data: {dataBlack: dataOffArr, dataWhite: dataOnArr},
      success: function (result) {
          //console.log(result.status);
          if(result.status == 'success'){
            window.location.href = base_url+'/setting/blackwhitelist';
          }
      }
    });

  });

});