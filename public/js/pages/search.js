$(document).ready(function(){
	$("#textSearch").keyup(function(event){
		if (event.keyCode === 13) {
			search($('#textSearch').val());
		};
	});
});

function searchBtn(){
	search($('#textSearch').val());
}

function search(textSearch){
	
	if (textSearch === "") {
		searchDataNotFound();
	}else{
		$.ajax({
	         type: "GET",
	         url: base_url + '/search/' + textSearch,
	         success: function(data)
	         {
	         	let Data = $.parseJSON(data);
	         	if (Data.length > 0) {
	         		// console.log(Data);
	         		searchDataFound(Data);
	         	}else{
	         		searchDataNotFound();
	         	}
	         }
    	});
	}
}

function searchDataNotFound(){
	$('#searchData').text('');
}

function searchDataFound(data){
	$("#searchData").empty();
	
	for (var i = data.length - 1; i >= 0; i--) {

			var url = "#";
			if (data[i].type === "survey") {
				url = base_url + "/assessment/" + data[i].id;
			}else if(data[i].type === "schedule"){
				url = base_url + "/calendar";
			}else if(data[i].type === "task"){
				url = base_url + "/assessment/" + data[i].id + "/task";
			}else if(data[i].type === "user"){
				url = base_url + "/chat/";
			}else if(data[i].type === "quisioner"){
				url = base_url + "/quisioner/view/" + data[i].id;
			}

			$("#searchData").append(
				$("<li/>").append(
					$("<a/>", {href: url, text: data[i].name})
				)
			)	
		}	
}
