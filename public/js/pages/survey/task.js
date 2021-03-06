$(document).ready(function(){
  cleanModal();
  $('#i_n_due_date').datetimepicker({});
  
  initialize_user_task("#i_n_assignee");

  $('#i_n_assignee').on("select2:selecting", function(e) { 
    initialize_user_task("#i_n_participant",1);
    $('#div_i_n_participant').show();
  });
});

function initialize_user_task(id_element,v_check){
  var survey_id = $('#i_n_survey_id').val();
  $.ajax({
      type: 'GET',
      url: base_url+'/assessment/'+survey_id+'/ajax_get_list_user/task',
      success: function (data) {
          // the next thing you want to do 
          var $v_select = $(id_element);
          var item = JSON.parse(data);
          $v_select.empty();
          $v_select.append("<option value=''></option>");
          if(!v_check){
            $.each(item, function(index,valuee) {
                $v_select.append("<option value='"+valuee.id+"'>@"+valuee.username+"</option>");
            });
          }else{
            $.each(item, function(index,valuee) {
              if(valuee.id != $("#i_n_assignee").val()){
                $v_select.append("<option value='"+valuee.id+"'>@"+valuee.username+"</option>");
              }
            });
          }

          //manually trigger a change event for the contry so that the change handler will get triggered
          $v_select.change();
      }
  });
}

function cleanModal(){
  $('#div_i_n_participant').hide();
  $('#i_n_name_task').val(null);
  $('#i_type_modal').val('create');
  $('#i_n_due_date').val(null);
  $('#i_n_assignee').val(null).trigger('change');
  $('#i_n_progress').val(0).trigger('change');
  $('#i_n_progress_gr').hide();
  $('#i_n_participant').val([]).trigger('change');
  $('#i_n_detail').val(null);
  $('#i_n_color').val('CD5C5C').trigger('change');
  $('#i_n_priority').val('3-Low').trigger('change');
  $('#i_n_name_task').attr('readonly', false);
  $('#i_n_due_date').attr('readonly', false);
  $('#i_n_assignee').attr('readonly', false);
  $('#i_n_progress').attr('readonly', false);
  $('#i_n_progress_gr').attr('readonly', false);
  $('#i_n_participant').attr('readonly', false);
  $('#i_n_detail').attr('readonly', false);
  $('#i_n_color').attr('readonly', false);
  $('#i_n_priority').attr('readonly', false);
  $('#m_footer_task').show();
}

function openModals(type,taskId){
  cleanModal();
  var survey_id = $('#i_n_survey_id').val();
  $('#i_type_modal').val(type);
  if(type == 'create'){
    $('#m_title_task').html('<i class="fa fa-plus"></i>&nbsp;Create New Task');
    $('#form_n_task').attr('action','');
    $('#btn_delete').hide();
    $('#btn_submit').show();
    $('#m_new_task').modal('show');
  }else if(type == 'edit'){
    $('#div_i_n_participant').show();
    $('#m_title_task').html('<i class="fa fa-edit"></i>&nbsp;Edit Existing Task');
    $('#form_n_task').attr('action','/assessment/'+survey_id+'/task/update/'+taskId);
    $('#i_n_progress_gr').show();
    $('#btn_delete').show();
    $('#btn_delete').click(function(){ delete_task(survey_id, taskId); });
    $('#m_new_task').modal('show');
    ajax_modal(survey_id,taskId);
  }else{
    console.log("complete task");
    $('#div_i_n_participant').show();
    $('#m_title_task').html('<i class="fa fa-eye"></i>&nbsp;View Existing Task');
    $('#form_n_task').attr('action','/assessment/'+survey_id+'/task/update/'+taskId);
    $('#i_n_progress_gr').show();
    // $('#m_footer_task').hide();
    $('#btn_submit').hide();
    $('#m_new_task').modal('show');
    $('#i_n_name_task').attr('readonly', true);
    $('#i_n_due_date').attr('readonly', true);
    $('#i_n_assignee').attr('readonly', true);
    $('#i_n_progress').attr('readonly', true);
    $('#i_n_progress_gr').attr('readonly', true);
    $('#i_n_participant').attr('readonly', true);
    $('#i_n_detail').attr('readonly', true);
    $('#i_n_color').attr('readonly', true);
    $('#i_n_priority').attr('readonly', true);
    $('#btn_delete').show();
    $('#btn_delete').click(function(){ delete_task(survey_id, taskId); });
    ajax_modal(survey_id,taskId);
  }
}

function ajax_modal(survey_id,taskId){
    $.ajax({
      url:
        base_url + '/assessment/'+survey_id+'/task/'+taskId,
        method: 'get',
      success: function(response) {
        let parse = JSON.parse(response.tasks);
        let participants = JSON.parse(response.task_participant);
        $('#i_n_name_task').val(parse.name);
        $('#i_n_due_date').val(parse.due_dates)
        $('#i_n_assignee').val(parse.assign).trigger('change');
        $('#i_n_color').val(parse.color).trigger('change');
        $('#i_n_priority').val(parse.priority).trigger('change');
        $('#i_n_progress').val(parse.progress).trigger('change');
        $.ajax({
           url:initialize_user_task("#i_n_participant",1),
           success:function(){
            for (val in participants){
              var member = participants[val].team_member;
              $("#i_n_participant option[value="+member+"]").prop("selected",true).trigger("change")
            }
          }
        });
        $('#i_n_detail').val(parse.detail);
      }
    });
}

$("#form_n_task").submit(function(e) {
  e.preventDefault();

  if($('#i_type_modal').val() == 'view'){
    return;
  }
  var form = $(this);
  var url = form.attr('action');
  var formData = new FormData(this);
  var messages = 'Create New Task Success';
  if(url){
    messages = 'Edit Task Success';
  }

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
              text: messages
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

function delete_task(surveyId, taskId){
  console.log("hapus task " + taskId);

  Swal.fire({
          title: 'Apakah anda yakin akan menghapus task?',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes'
        }).then((result) => {
          if (result.value) {
            $.ajax({
              url:
                base_url + '/assessment/'+surveyId+'/task/'+taskId,
                method: 'delete',
              success: function(response) {
                console.log("hapus task " + taskId);
                swal({
                  type: 'success',
                  title: 'Berhasil',
                  text: 'Berhasil Hapus Task'
                });

                $('tr[name='+taskId+']').remove();
                $('#m_new_task').modal('hide');
              }
            });
          }
        })
};

Chart.pluginService.register({
  beforeDraw: function (chart) {
    if (chart.config.options.elements.center) {
      //Get ctx from string
      var ctx = chart.chart.ctx;
      
      //Get options from the center object in options
      var centerConfig = chart.config.options.elements.center;
      var fontStyle = centerConfig.fontStyle || 'Arial';
      var txt = centerConfig.text;
      var color = centerConfig.color || '#000';
      var sidePadding = centerConfig.sidePadding || 20;
      var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
      //Start with a base font of 30px
      ctx.font = "30px " + fontStyle;
      
      //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
      var stringWidth = ctx.measureText(txt).width;
      var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

      // Find out how much the font can grow in width.
      var widthRatio = elementWidth / stringWidth;
      var newFontSize = Math.floor(30 * widthRatio);
      var elementHeight = (chart.innerRadius * 2);

      // Pick a new font size so it will not be larger than the height of label.
      var fontSizeToUse = Math.min(newFontSize, elementHeight);

      //Set font settings to draw it correctly.
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
      var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
      ctx.font = fontSizeToUse+"px " + fontStyle;
      ctx.fillStyle = color;
      
      //Draw text in center
      ctx.fillText(txt, centerX, centerY);
    }
  }
});

$('.pieChart').each(function (index, element) {
    var ctx = element.getContext('2d');
    var progress = $(this).attr('data-progress');
    var sisa = 100 - progress;
    pcolor = '#'+$(this).attr('data-color');
    window.myBar = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: [
          "Finished",
          "Unfinished"
        ],
        datasets: [{
          data: [progress, sisa],
          backgroundColor: [
            pcolor,
            "#f3f3f3"
          ],
          hoverBackgroundColor: [
            pcolor,
            "#f3f3f3"
          ]
        }]
      },
    options: {
     legend: {
        display: false
     },
      tooltips: {
          enabled: true,
          mode: 'single',
          callbacks: {
            title: function(tooltipItem, data) {
              return data['labels'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
              return data['datasets'][0]['data'][tooltipItem['index']]+"%";
            },
          }
      },
      elements: {
        center: {
          text: progress+"%",
          color: pcolor, // Default is #000000
          fontStyle: 'Arial', // Default is Arial
          sidePadding: 30 // Defualt is 20 (as a percentage)
        }
      }
    }
  });

});