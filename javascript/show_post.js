

$(document).ready(function () {
	var memberID=$("input[name='memberID']").val();
	var postID=$("input[name='postID']").val();
	//如果comment數不超過5的話將button hidden
	if(commentAmount > 4){
		$("span.expandComment").css("display","block");

	}

	//如果已經登入的話
	if(typeof memberID !== 'undefined'){
		
		//處理gpbp
		$("img.goodPoint,img.badPoint").click( function () { 
			$(this).next().text( function(index,origintext) {
				return parseInt(origintext)+1;
			});
			$.post("/forum/ajax/show_post/point.php",{
				'pointName':$(this).next().attr('class'),
				'postID':postID,
				'memberID':memberID

			},
			function(data, status){
					$('div.fuckyour').text("Data: "+data+"\nStatus: " + status);
			});
		});
		//handle comment
		//
		$("input[name='comment']").keypress(function (e) {
			console.log('keypress active');
			var key = e.which;
			//if enter is press
			//新增留言
			if(key==13){
				$.post("/forum/ajax/show_post/comment.php",{
					'content':$(this).val(),
					'postID':postID,
					'memberID':memberID
				},
				function(data, status){
						$('div.comment').append("<div>"+data+"</div>");
				});
				$(this).val('');

			}
			
		});
	}
	//if not login 想新增留言或按gpbp就會背阻止
	else{
		$("img.goodPoint,img.badPoint, input[name='comment']").click( function () { 
				alert('you need to login');
		});
		$("input[name='comment']").keypress(function (e) {
				alert('you need to login');
		});
	}
	//不管有沒有登錄都可以用的
		//toogle comment
	$("span.expandComment").click(function (e) {
		if($("div.default").css("display")=="none"){
			$("div.default").css("display","block");
			$("div.expandComment").css("display","none");
			$("span.expandComment").text("收起留言");
		}
		//我也不知道為什麼空的內容有5個字的長度
		else if($("div.default").css("display")=="block" && $("div.expandComment").text().length !==5){
			$("div.default").css("display","none");
			$("div.expandComment").css("display","block");
			$("span.expandComment").text("展開留言");

		}
		else{
			$.post("/forum/ajax/show_post/expandComment.php",{
				'postID':postID
			},
			function(data, status){
				$('div.comment > div.expandComment').html(data);
			});
			$('div.comment > div.default').css("display","none");
			$('div.comment > div.expandComment').css("display","block");
		}

	});
			

});    

