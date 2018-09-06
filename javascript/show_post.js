

$(document).ready(function () {

	//如果已經登入的話讓前端判斷要顯示什麼東西而已
	//這個處理也可以繞過的所以因該要再後端也加處理
	var memberID=$("input[name='visiterMemberID']").val();
	if(typeof memberID !== 'undefined'){
		//處理gpbp
		$("img.goodPoint,img.badPoint").click( function () { 
			var pointName=$(this).next().attr('class');
			var currentObject=$(this);
			if(pointName=='goodPoint'){
				var index=$("img.goodPoint").index($(this));
			}
			else if(pointName=='badPoint'){
				var index=$("img.badPoint").index($(this));
			}
			var postOrReplyID=$("input[name='postOrReplyID']").eq(index).val();
			console.log(postOrReplyID);

			//傳入index式用來判斷式postorreply的
			$.post("/forum/ajax/show_post/point.php",{
				'pointName':pointName,
				'postOrReplyID':postOrReplyID,
				'index':index
			},

			function(data, status){
					$('div.toast').css('display','block');
					$(".toast").fadeOut(1500);
					if(data=='do'){
						$('div.toast').text('給分成功');
						currentObject.next().text( function(index,origintext) {
							return parseInt(origintext)+1;
						});

					}
					else{
						$('div.toast').text('復原成功');
						currentObject.next().text( function(index,origintext) {
							return parseInt(origintext)-1;

						});

					}
			});
		});
		//handle comment
		//
		$("input[name='comment']").keypress(function (e) {
			var index=$("input[name='comment']").index($(this));
			var postOrReplyID=$("input[name='postOrReplyID']").eq(index).val();
			console.log('keypress active');
			var key = e.which;
			//if enter is press
			//新增留言
			if(key==13){
				$.post("/forum/ajax/show_post/comment.php",{
					'content':$(this).val(),
					'postOrReplyID':postOrReplyID,
					'index':index
				},
				function(data, status){
						$('div.comment').eq(index).append("<div>"+data+"</div>");
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
		var index=$("span.expandComment").index($(this));
		var postOrReplyID=$("input[name='postOrReplyID']").eq(index).val();
		//重全部的comment返回成5個comment
		if($("div.default").eq(index).css("display")=="none"){
			$("div.default").eq(index).css("display","block");
			$("div.expandComment").eq(index).css("display","none");
			$("span.expandComment").eq(index).text("收起留言");
		}
		/*
		//我也不知道為什麼空的內容有5個字的長度
		//如果已經取得過了就無再取得而是給他display改變
		else if($("div.default").eq(index).css("display")=="block" && $("div.expandComment").eq(index).text().length !==5){
			$("div.default").eq(index).css("display","none");
			$("div.expandComment").eq(index).css("display","block");
			$("span.expandComment").eq(index).text("展開留言");

		}
		*/
		else{
			//去的全部的comment
			$.post("/forum/ajax/show_post/expandComment.php",{
				'postOrReplyID':postOrReplyID,
				'index':index
			},
			function(data, status){
				$('div.comment > div.expandComment').eq(index).html(data);
			});
			$('div.comment > div.default').eq(index).css("display","none");
			$('div.comment > div.expandComment').eq(index).css("display","block");
		}

	});

	//如果comment數不超過5的話將button hidden
	var replyAmount=$("input[name='replyAmount']").val();
	var index=0;
	for(index=0;index<=replyAmount;index++){
		var commentAmount=$("input[name='commentAmount']").eq(index).val();
		if($("input[name='commentAmount']").eq(index).val() > 4){
			$("span.expandComment").eq(index).css("display","block");

		}

	}

});    

/*
$(document).ready(function () {
	$('editContent').click(function(){
			var currentObject=$(this);
			var postOrReplyID=$("input[name='postOrReplyID']").eq(index).val();
			var content=$("div.content").text();

			//傳入index式用來判斷式postorreply的
			$.post("/forum/ajax/show_post/point.php",{
				'content':content,
				'postOrReplyID':postOrReplyID,
				'index':index
			},

			function(data, status){
					$('div.toast').css('display','block');
					$(".toast").fadeOut(1500);
					$(".toast").)
					}
			});

	})
}
*/