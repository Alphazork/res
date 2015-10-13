$(document).ready(function() {
	$(".w").click(function() {
		$.ajax({
			url: 'submitweek.php',
			data: {weekSelected: $(this).attr('id')},
			success:function(result){
				$("#result").html(result);
			}
		})
		.done(function() {
			console.log("success");
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
		
	});
});