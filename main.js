var selectedDevice = 0;
var selectedWeek = 0;

$(document).ready(function() {
	updateTable();
	$("#week1").children().first().html(getWeek(0));
	$("#week2").children().first().html(getWeek(1));
	$("#week3").children().first().html(getWeek(2));

	$(".cBtn").each(function(i, e){
		$(e).click(function(){
			selectedDevice = i;
			updateTable();
			updateClasses(i, ".cBtn");
			console.log(i);
		});
	});

	$(".cWeek").each(function(i, e){
		$(e).click(function(){
			selectedWeek = i;
			updateTable();
			updateClasses(i, ".cWeek");
		});
	});
});

function updateClasses(idx, str){
	$("#dropdown1").removeClass("active");
	$("#dropdown2").removeClass("active");
	$(str).each(function(i, e){
		$(e).removeClass("active");
		if(i == idx)$(e).addClass("active");
	});

	if(idx == 0 || idx == 1){
		$("#dropdown1").addClass("active");
	}

	if(idx ==2 || idx == 3){
		$("#dropdown2").addClass("active");
	}
}

function getWeek(i){
	var str= "";
	str += Date.parse("last monday").add({days: i*7}).toString("dd. MMM");
	str += " - " + Date.parse("last monday").add({days: i*7+4}).toString("dd. MMM")
	return str;
}

function updateTable(){
	$.ajax({
		url: "makeTable.php",
		data: {week: selectedWeek, device: selectedDevice},
		success: function(result){
			$("#tableContainer").html(result);
		}
	});
}