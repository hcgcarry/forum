<?php
$postID = htmlspecialchars($_GET['postID']);
if ($msg->hasMessages()) {
	$msg->display();
}

?>
<?php 
	if(isset($_SESSION['memberID']) and !empty($_SESSION['memberID'])){
		echo "<input type='text' name='memberID' value='".$_SESSION['memberID']."' style='display:none;'>";
	}

?>


<?php
$sql = "SELECT 
        posts.goodPoint,posts.badPoint,posts.content,posts.topic,posts.date,posts.postID,members.nickname,members.username,categories_name 
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
if (!isset($post) OR empty($post)) {
	$error = Database::get()->getErrorMessage();
	if (isset($error) AND ! count($error) > 0) {
		foreach ($error as $row) {
			$msg->error($row);
		}
	}
	$msg->error('文章找不到');
} else {
	foreach ($post[0] as $key => $value) {
		${$key} = $value;
	}
	echo "<input type='text' name='postID' value='$postID' style='display:none;'>";
	///////////////////////個人資訊

	echo "
<div class='container mt-3 mb-3'> 
  <div class='row'>
	<div class='col-2'>
      <div class='card' style='width:180px min-height:350px max-height:500px;'>
        <img class='card-img-top' src='" . Config::BASE_URL . "pictures/codegeass/P_20180422_135037_vHDR_Auto.jpg' alt='Card image' style='width:100%'>
        <div class='card-body'>
          <div style='font-size:16px;font-weight:900;'>$nickname</div>
          <span style='font-size:12px;'><span class='badge badge-primary'>ID:$username</span>

          <div class='card-text'>
              <span class='badge badge-dark'>名言:</span>
              <div>   我將世界毀滅 又將世界創造</div>
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
          <span class='badge badge-dark'> $categories_name</span>$topic 
        </div>
	    <span class='badge badge-info'>$date</span>
			<div class='pt-3 '>" . nl2br($content) . "</div>
			


          
	   </div>
	   <div class='card-footer'>
			<div class='row'>
				<div class='col-2'>
					<span class='btn btn-dark expandComment'>展開留言</span>
				</div>
				<div class='col-2 offset-2'>
					<img  class='point btn btn-secondary' src='".Config::BASE_URL."pictures/website/icon/like.png' alt='like'>
					<span class='goodPoint'>$goodPoint</span>
				</div>
				<div class='col-2'>
					<img  class='point btn btn-secondary' src='".Config::BASE_URL."pictures/website/icon/dislike.png' alt='dislike'>
					<span class='badPoint'>$badPoint</span>
				</div>
			</div>
			";


	echo "
			<div class='comment bg-info mt-1'>
				<div class='default'>
			";
								/////////////////	//comment
						$table='comment';
						$data_array['postID']=$postID;
						$fields='content,date,memberID';
						$order_by='date DESC';
						$limit='5';
						$numberOfRow=5;
						$sql="SELECT
							comments.content,comments.date,members.nickname
						FROM
							comments
						LEFT JOIN members
							ON comments.memberID=members.memberID
						WHERE comments.postID=:postID
							ORDER BY comments.date DESC
						LIMIT $numberOfRow ";
						$data_array[':postID']=$postID;

						$result=Database::get()->execute($sql,$data_array);
						///if result not empty
						if(isset($result) and count($result[0]) > 0){
							foreach($result as $key => $item){
								$row=$result[4-$key];
								echo "<div class='row'>

										<div class='col-12 pl-3'>".$row['nickname'].":".$row['content']."</div>
										<div class='col-12 pl-3' style='height:10px;font-size:10px;'>".$row['date']."</div>
									</div>";


							}

						}
		
		echo "
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

<div class="fuckyour"></div>



</div>