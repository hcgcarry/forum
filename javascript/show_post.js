/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
	var memberID=$("input[name='memberID']").val();

	if(typeof memberID !== 'undefined'){
		$("div.card-body > span > img").click( function () { 
				$(this).next().text( function(index,origintext) {
					return parseInt(origintext)+1;
				});
				$.post("/forum/ajax/show_post.php",{
					'pointName':$(this).next().attr('class'),
					'postID':$("input[name='postID']").val(),
					'memberID':memberID

				},
				function(data, status){
						$('div.fuckyour').text("Data: "+data+"\nStatus: " + status);
				});
			});
	}
	else{
		$("div.card-body > span > img").click( function () { 
				alert('you need to login');
		});
	}

});
/*
$(document).ready(function () {
	$("div.card-body > span > img").click(
		function () { 
			$(this).next().text(
				function(index,origintext){ return parseInt(origintext)+1;
			});
			$.post("/forum/ajax/show_post.php",{
				pointName:$(this).next().attr('class'),
				postID:$("input[name='postID']").val(),
			},
			function(data, status){
					$('div.fuckyour').text("Data: "+data+"\nStatus: " + status);
			});
		});
});
*/


			   /*
$(document).ready(function () {
	$("div.card-body > span >img").submit(function (e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "add_new_post.php",
			data: $("#postcontent").serialize(),
			beforeSend: function () {
				$(".post_submitting").show().html("<center><img src='images/loading.gif'/></center>");
			},
			success: function (response) {
				alert(response);
				$("#return_update_msg").html(response);
				$(".post_submitting").fadeOut(1000);
			}
		});
		e.preventDefault();
	});

});
*/