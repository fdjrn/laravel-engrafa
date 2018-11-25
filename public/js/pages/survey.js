$(document).ready(function(){
  $("#b_create_new_task").click(function(){
    $('#m_new_task').modal('show');
    initialize_select_user("#i_n_assignee");
    initialize_select_user("#i_n_participant");
  });
  
  $('#i_n_due_date').datetimepicker({});
  
  $('[data-toggle="tooltip"]').tooltip();
});

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

function initialize_select_user(id_element){
  $.ajax({
      type: 'GET',
      url: base_url+'/survey/ajax_get_list_user',
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