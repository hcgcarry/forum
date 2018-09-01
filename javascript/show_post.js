/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
	$("div.card-body > span > img").click(function () {
		$(this).next().text(function(index,origintext){
			return parseInt(origintext)+1;
		});
			$.post("controller/show_post.php",{"pointName":$(this).next().attr('class')});
	});
});


