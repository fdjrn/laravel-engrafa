$(document).ready(function(){

	var surveyId = $('#surveyId').val();
	var labels = [];
	var levelTercapai = [];
	var targetLevel = [];
	var jmlhProcessTercapai = 0;
	var jmlhProcessBelumTercapai = 0;
	var surveyProcessOutcomes;


	$.ajax({
	  type : 'GET',
	  url : '/assessment/aggregat/'+surveyId,
	  cache : false,
	  contentType : false,
	  processData : false,
	  success : function (data) {

	  	surveyProcessOutcomes = data.surveyProcessOutcomes;

	  	for (var i = data.surveyProcess.length - 1; i >= 0; i--) {
	  		labels.push(data.surveyProcess[i].process);
	  		if(data.surveyProcess[i].level !== null){
	  			levelTercapai.push(data.surveyProcess[i].level);
	  		}else{
	  			levelTercapai.push(NaN);
	  		}
	  		targetLevel.push(data.surveyProcess[i].target_level);
	  	}

	  	showChart();
	  	showSummaryProgress();
	  	showDetailProgress();
	  },
	  error : function(xhr, textStatus, errorThrown){
	    console.log("Error : " + (xhr.responseJSON.message));
	  }
	});


	function showChart(){
		var ctx = document.getElementById("processChart").getContext('2d');
		var myRadarChart = new Chart(ctx, {
			type: 'radar',
			data: {
			    labels: labels,
			    datasets: [
			    {
			        fill: true,
			        backgroundColor : "rgb(255, 153, 153, 0.5)",
			        pointBackgroundColor : "#f56954",
			        pointBorderColor : "#f56954",
			        label : 'Target Level',
			        data: targetLevel
			    },
			    {
			        fill: true,
			        backgroundColor : "rgba(114, 175, 210, 0.5)",
			        pointBackgroundColor : "#3c8dbc",
			        pointBorderColor : "#3c8dbc",
			        label : 'Level Tercapai',
			        data: levelTercapai
			    }]
			},
		    options: {
		      tooltips: {
		          enabled: true,
		          mode: 'single',
		          callbacks: {
		            title: function(tooltipItem, data) {
		              return data['labels'][tooltipItem[0]['index']];
		            },
		            label: function(tooltipItem, data) {
			            if(data['datasets'][tooltipItem.datasetIndex]['data'][tooltipItem['index']] >= 0){
			              return data['datasets'][tooltipItem.datasetIndex]['label']+': '+data['datasets'][tooltipItem.datasetIndex]['data'][tooltipItem['index']];
			            }
		            },
		          }
		      },
		    scale: {
		        ticks: {
		        	min: 0,
		        	stepSize: 1,
		            max: 5
		        }
		    }
		    }
		});
	}

	function showSummaryProgress(){

		for (var i = labels.length - 1; i >= 0; i--) {
			if (levelTercapai[i] !== null){
				if (levelTercapai[i] >= targetLevel[i]) {
					jmlhProcessTercapai++;
				}else{
					jmlhProcessBelumTercapai++;
				}
			}else{
				jmlhProcessBelumTercapai++;
			}
		}

		var percentTercapai = Math.round(jmlhProcessTercapai/labels.length*100);
		var percentBelumTercapai = 100 - percentTercapai;

		$('#totalProcess').text(labels.length);
		$('#processCapaiTarget').text(jmlhProcessTercapai+" ("+percentTercapai+"%)");
		$('#processBelumCapaiTarget').text(jmlhProcessBelumTercapai+" ("+percentBelumTercapai+"%)");
	}

	function showDetailProgress(){
		$('#data-detail-process').text('');
		// console.log("show detail");
		for (var i = 0; i <= surveyProcessOutcomes.length - 1; i++) {
			var name = surveyProcessOutcomes[i].process+surveyProcessOutcomes[i].it_related_goal;
			$('#data-detail-process').append(
				' <tr>'
		          +'<td>'+(i+1)+'</td>'
		          +'<td>'+surveyProcessOutcomes[i].process+'</td>'
		          +'<td id="'+name+'1">'+surveyProcessOutcomes[i].percentLevel1+'% ('+surveyProcessOutcomes[i].ratingLevel1+')</td>'
		          +'<td id="'+name+'2">'+surveyProcessOutcomes[i].percentLevel2+'% ('+surveyProcessOutcomes[i].ratingLevel2+')</td>'
		          +'<td id="'+name+'3">'+surveyProcessOutcomes[i].percentLevel3+'% ('+surveyProcessOutcomes[i].ratingLevel3+')</td>'
		          +'<td id="'+name+'4">'+surveyProcessOutcomes[i].percentLevel4+'% ('+surveyProcessOutcomes[i].ratingLevel4+')</td>'
		          +'<td id="'+name+'5">'+surveyProcessOutcomes[i].percentLevel5+'% ('+surveyProcessOutcomes[i].ratingLevel5+')</td>'
		        +'</tr>'
			)

			changeColorByRating(name+"1",surveyProcessOutcomes[i].ratingLevel1);
			changeColorByRating(name+"2",surveyProcessOutcomes[i].ratingLevel2);
			changeColorByRating(name+"3",surveyProcessOutcomes[i].ratingLevel3);
			changeColorByRating(name+"4",surveyProcessOutcomes[i].ratingLevel4);
			changeColorByRating(name+"5",surveyProcessOutcomes[i].ratingLevel5);
		}
	}

	function changeColorByRating(name, rating){
		// console.log("change color : " + name);
		if (rating == 'N') {
			$("#"+name).css('background-color','#f39c12');
		}else if (rating == 'P') {
			$("#"+name).css('background-color','#ff851b');
		}else if (rating == 'L') {
			$("#"+name).css('background-color','#f39c12');
		}else if (rating == 'F') {
			$("#"+name).css('background-color','#00a65a');
		}
	}
})