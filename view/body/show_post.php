<?php
//initial
$postID = htmlspecialchars($_GET['postID']);
if ($msg->hasMessages()) {
	$msg->display();
}

if(isset($_SESSION['memberID']) and !empty($_SESSION['memberID'])){
	echo "<input type='text' name='visiterMemberID' value='".$_SESSION['memberID']."' style='display:none;'>";
	$visiterMemberID=$_SESSION['memberID'];
}
echo "<input type='text' name='postOrReplyID' value='$postID' style='display:none;'>";

?>




									<!-- 分頁-->
<div class='container pt-3'>
  <div class='row'>
    <div class='col-1 offset-3' style='display:inlie-block;'>
      <a  class="btn btn-primary" href="?page=1&postID=<?=$postID?>">回首頁</a>
    </div>
    <div class='col-4 offset-0'>
      <ul class="pagination pagination-sm justify-content-center" >
										<!--php-->

<?php
if(!isset($_GET['page']) OR empty($_GET['page'])){
	$page=1;
}
else{
	$page=htmlspecialchars($_GET['page']);

}
if($page > 1){
	$limitReplyAmount=10;
}
else{
	$limitReplyAmount=9;
}

if($page < 5){
	$count=0;
}
else{
	$count=$page-3;
}

$sql='select count(replyID) from replys 
	where postID=:postID';
$data_array[':postID']=$postID;
$result=Database::get()->execute($sql,$data_array);
$totalPageNum=ceil($result[0][0]/10);

for ($index = 0; $index < 7; $index = $index + 1) {
	$count = $count + 1;
	if ($count <= $totalPageNum) {
		if ($count == $page) {
			printf('<li class="page-item"><a class="bg-dark page-link" href="?page=%d&postID=%d">%d</a></li>'
			, ($count), ($postID),($count));
		}
	    else {
			printf('<li class="page-item"><a class="page-link" href="?page=%d&postID=%d">%d</a></li>'
			, ($count), ($postID),($count));
		}

	}
}
	$count = $count - 7;
?>


      </ul>
    </div>
  </div>
								<!-- 分頁結束-->


<?php
							////////////////search post information
$sql = "SELECT 
        posts.hasEdit,posts.goodPoint,posts.badPoint,posts.content,posts.topic,posts.date,posts.postID,members.nickname,members.username,members.selfDetail,members.profile,categories_name,members.memberID 
      FROM 
        posts
      LEFT JOIN members
      ON posts.memberID=members.memberID
      LEFT JOIN categories
      ON posts.categoriesID=categories.categoriesID
      WHERE 
      postID=:postID";
$data_array['postID']=$postID;

$post = Database::get()->execute($sql,$data_array);
if (!isset($post) OR empty($post) or $page > 1) {
	$error = Database::get()->getErrorMessage();
	if (isset($error) AND ! count($error) > 0) {
		foreach ($error as $row) {
			$msg->error($row);
		}
	}
} else {
	///////////////////////////////////////////文章有找到
	foreach ($post[0] as $key => $value) {
		${$key} = $value;
	}
	//writememberID 用來判斷編輯功能要不要呈獻出來
	echo "<input type='text' name='writeMemberID' value='$memberID' style='display:none'>";
	///////////////////////個人資訊

	echo "
<div class='container mt-3 mb-3'> 
  <div class='row'>
	<div class='col-2'>
      <div class='card' style='width:250px min-height:350px max-height:700px;'>
        <img class='card-img-top' src='".$profile." ' alt='Card image' style='width:100%'>
        <div class='card-body'>
          <div style='font-size:16px;font-weight:900;'>$nickname</div>
          <span style='font-size:12px;'><span class='badge badge-primary'>ID:$username</span>

          <div class='card-text'>
              <span class='badge badge-dark'>名言:</span>
              <div class='selfDetail'> 
				  <span>".nl2br($selfDetail)."</span>
			  </div>
          </div>
            
            <a href='#' class='d-flex align-items-center justify-content-center btn btn-primary' style='height:30px;'>See Profile</a>
        </div>

      </div>
    </div>
    ";
	//////////////////文章
	echo "
  <div class='col-10 '> 
    <div class='card' > 
      <div class='card-body ' style='min-height:350px;max-height:10000px'>
        <div class='d-flex align-items-center ' style='font-size:25px;font-weight:900' class='card-title'>
          <span class='badge badge-dark'> $categories_name</span><div>$topic </div>
        </div>
	    <span class='badge badge-info'>$date</span>";
				if($hasEdit==1){
					echo "
					<span class='badge badge-light'>
						已編輯
					</span>";
				}
				echo "
			<div class='pt-3 content'><div style='word-wrap: break-word;'>" . ($content) . "</div></div>
	   </div>


										<!-- footer -->

	   <div class='card-footer'>
			<div class='row'>
				<div class='col-2'>
					<span style='display:none' class='btn btn-dark expandComment'>展開留言</span>
				</div>
				<div class='col-2 offset-2'>
					<img  class='goodPoint btn btn-secondary' src='".Config::BASE_URL."pictures/website/icon/like.png' alt='like'>
					<span class='goodPoint'>$goodPoint</span>
				</div>
				<div class='col-2'>
					<img  class='badPoint btn btn-secondary' src='".Config::BASE_URL."pictures/website/icon/dislike.png' alt='dislike'>
					<span class='badPoint'>$badPoint</span>
				</div>";
				
	//這邊只是單純看看這個item要不要顯示給按而已記得後端還是要做驗症
	if(isset($_SESSION['memberID']) and $_SESSION['memberID']==$memberID){
		echo "
		<a href='".Config::BASE_URL."modify_post?postID=$postID&location=".urlencode($_SERVER['REQUEST_URI'])."' class='btn btn-primary'>編輯文章</a>
				";
	}

		echo "
				
			</div>
			";

	////////////////////////////////////////comment

	echo "
			<div class='comment bg-info mt-1'>
				<div class='default'>
			";
	///////////////create default comment 
						$table='post_comments';
						$data_array['postID']=$postID;
						$fields='content,date,memberID';
						$order_by='date DESC';
						$limit='5';
						$numberOfRow=5;
						$sql="SELECT
							post_comments.content,post_comments.date,members.nickname
						FROM
							post_comments
						LEFT JOIN members
							ON post_comments.memberID=members.memberID
						WHERE post_comments.postID=:postID
							ORDER BY post_comments.date DESC
						LIMIT $numberOfRow ";
						$data_array[':postID']=$postID;

						$result=Database::get()->execute($sql,$data_array);
						///if result not empty
						$commentAmount=count($result);
						if(isset($result) and $commentAmount > 0){
							foreach($result as $key => $item){
								$row=$result[$commentAmount-1-$key];
								echo "<div class='row'>

										<div class='col-12 pl-3'><pre>".$row['nickname'].":".$row['content']."</pre></div>
										<div class='col-12 pl-3' style='height:10px;font-size:10px;'>".$row['date']."</div>
									</div>";


							}

						}
		
		echo "
				<input type='text' name='commentAmount' value='$commentAmount' style='display:none' >
				</div>
				<div style='display:none' class='expandComment'>
				</div>
			</div>
			<form action='javascript:void(0);'>
				<div class='form-group pt-3 '>
				  <input type='text' name='comment'  class='form-control input-lg' placeholder='在這裡輸入留言' tabindex='1'>
				</div>
			</form>
	   </div>

	</div>
 </ div>

  ";
}

?>
							<!--go to reply-->
<div class="create_reply" style='position:fixed;bottom:0;left:0;'>
	<a href="<?=Config::BASE_URL?>create_reply?postID=<?=$postID?>&location=<?=urlencode($_SERVER['REQUEST_URI'])?>" class="btn btn-primary">回覆</a>
</div>

<div class="test"></div>


<!-- post container end-->
</div>
												<!--reply container start-->
<?php


//select reply by postID
$sql = "SELECT 
        replys.goodPoint,replys.badPoint,replys.content,replys.date,replys.hasEdit,replys.replyID,members.nickname,members.username,members.selfDetail,members.profile,members.memberID 
      FROM 
        replys
      LEFT JOIN members
		  ON replys.memberID=members.memberID
      WHERE 
		  postID=:postID
	LIMIT :limitReplyAmount OFFSET :offset";
	$data_array=array();
	$data_array[':limitReplyAmount']=$limitReplyAmount;
	$data_array[':offset']=($page-1)*$limitReplyAmount;
	$data_array['postID']=$postID;

$reply = Database::get()->execute($sql,$data_array);
if (!isset($reply) OR empty($reply)) {
	$error = Database::get()->getErrorMessage();
	if (isset($error) AND ! count($error) > 0) {
		foreach ($error as $row) {
			$msg->error($row);
		}
	}
} 
//the post have reply and display it
else {
	foreach($reply as $replyitem){
		foreach ($replyitem as $key => $value) {
			/////////////////////////////////////////////改到這裡
			${$key} = $value;
		}
		echo "<input type='text' name='postOrReplyID' value='$replyID' style='display:none;'>";
		///////////////////////個人資訊

		echo "
	<div class='container mt-3 mb-3'> 
	  <div class='row'>
		<div class='col-2'>
		  <div class='card' style='width:180px min-height:350px max-height:500px;'>
			<img class='card-img-top' src='" .$profile." ' alt='Card image' style='width:100%'>
			<div class='card-body'>
			  <div style='font-size:16px;font-weight:900;'>$nickname</div>
			  <span style='font-size:12px;'><span class='badge badge-primary'>ID:$username</span>

			  <div class='card-text'>
				  <span class='badge badge-dark'>名言:</span>
				  <div class='selfDetail'> 
					  <span>  ".nl2br($selfDetail)."</span>
				  </div>
			  </div>
				
				<a href='#' class='d-flex align-items-center justify-content-center btn btn-primary' style='height:30px;'>See Profile</a>
			</div>

		  </div>
		</div>
		";
		//////////////////文章
		echo "
	  <div class='col-10 '> 
		<div class='card' > 
		  <div class='card-body ' style='min-height:350px;max-height:10000px'>
			<span class='badge badge-info'>$date</span>";
				if($hasEdit==1){
					echo "
			<span class='badge badge-light'>
					已編輯
					</span>";
				}
			echo "
				</span>
				<div class='pt-3 '><pre>" . ($content) . "</pre></div>
		   </div>


											<!-- footer -->

		   <div class='card-footer'>
				<div class='row'>
					<div class='col-2'>
						<span style='display:none' class='btn btn-dark expandComment'>展開留言</span>
					</div>
					<div class='col-2 offset-2'>
						<img  class='goodPoint btn btn-secondary' src='".Config::BASE_URL."pictures/website/icon/like.png' alt='like'>
						<span class='goodPoint'>$goodPoint</span>
					</div>
					<div class='col-2'>
						<img  class='badPoint btn btn-secondary' src='".Config::BASE_URL."pictures/website/icon/dislike.png' alt='dislike'>
						<span class='badPoint'>$badPoint</span>
					</div>";
					if(isset($_SESSION['memberID']) and $_SESSION['memberID']==$memberID){
						echo "
						<a href='".Config::BASE_URL."modify_post?replyID=$replyID&location=".urlencode($_SERVER['REQUEST_URI'])."' class='btn btn-primary'>編輯文章</a>
								";
					}
	echo "
				</div>
				";

		////////////////////////////////////////comment

		echo "
				<div class='comment bg-info mt-1'>
					<div class='default'>
				";
		///////////////create default comment 
							$data_array=array();
							$numberOfRow=5;
							$sql="SELECT
								reply_comments.content,reply_comments.date,members.nickname
							FROM
								reply_comments
							LEFT JOIN members
								ON reply_comments.memberID=members.memberID
							WHERE reply_comments.replyID=:replyID
								ORDER BY reply_comments.date DESC
							LIMIT $numberOfRow ";
							$data_array[':replyID']=$replyID;

							$result=Database::get()->execute($sql,$data_array);
							///if result not empty
							$commentAmount=count($result);
							if(isset($result) and $commentAmount > 0){
								foreach($result as $key => $item){
									$row=$result[$commentAmount-1-$key];
									echo "<div class='row'>

											<div class='col-12 pl-3'><pre>".$row['nickname'].":".$row['content']."</pre></div>
											<div class='col-12 pl-3' style='height:10px;font-size:10px;'>".$row['date']."</div>
										</div>";


								}

							}
			
			echo "
					<input type='text' name='commentAmount' value='$commentAmount' style='display:none' >
					</div>
					<div style='display:none' class='expandComment'>
					</div>
				</div>
				<form action='javascript:void(0);'>
					<div class='form-group pt-3 '>
					  <input type='text' name='comment'  class='form-control input-lg' placeholder='在這裡輸入留言' tabindex='1'>
					</div>
				</form>
		   </div>

		</div>
	 </ div>
	 </div>

	  ";
	}
}
?>

	<input type='text' name='replyAmount' value='<?=count($reply)?>' style='display:none;'>

