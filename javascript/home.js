/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function (e) {
	$("#form").on('submit', (function (e) {
		e.preventDefault();
		$.ajax({
			url: "/forum/ajax/home/upload_images.php",
			type: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			beforeSend: function ()
			{
			},
			success: function (data) {
				if (data == 'invalid') {
					// invalid file format.
					$(".toast").text("Invalid File").fadeIn();
					console.log('invalid');
				} else {
					// view uploaded file.
					$(".toast").html(data+" press F5 to reload").fadeIn();
					$("#form")[0].reset();
					console.log('success ');
				}
			},
			error: function (e)
			{
				$(".toast").html(e).fadeIn();
					console.log('error');
			}
		});
	}));
});

//edit self detail
$(document).ready(function(){
	var memberID=$("input[name='memberID']").val();
	$(".selfDetailEditButton").click(function(){
		$(".selfDetail").css("display","none");
		$(".editSelfDetail").css("display","block");
	});
	$("button.editSubmit").click(function(){
		var content=$("textarea[name='selfDetial']").val();
		$.post("/forum/ajax/home/selfDetail.php",{
			'content':content
		},

		function(data, status){
			$(".selfDetail").css("display","block");
			$(".editSelfDetail").css("display","none");
			$(".selfDetailText ").text(data);
			

		});
		

	})
	$("button.cancelEditSubmit").click(function(){
		$(".selfDetail").css("display","block");
		$(".editSelfDetail").css("display","none");
	});

});
