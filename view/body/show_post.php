<?php
$postID = $_GET['postID'];
if ($msg->hasMessages()) {
	$msg->display();
}
?>
<!--名片-->

<!--文章-->
<?php
$sql = "SELECT 
        posts.content,posts.topic,posts.date,posts.postID,members.nickname,members.username,categories_name 
      FROM 
        posts
      LEFT JOIN members
      ON posts.memberID=members.memberID
      LEFT JOIN categories
      ON posts.categoriesID=categories.categoriesID
      WHERE 
        postID=" . $postID;

$post = Database::get()->execute($sql);
if (!isset($post) OR empty($post)) {
	$error = Database::get()->getErrorMessage();
	if (isset($error) AND ! empty($error)) {
		foreach ($error as $row) {
			$msg->error($row);
		}
	}
	$msg->error('文章找不到');
} else {
	foreach ($post[0] as $key => $value) {
		${$key} = $value;
	}
	///////////////////////個人資訊

	echo "
<div class='container mt-3 mb-3'> <div class='row'>
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
    <div class='card' style='min-height:350px;max-height:1000px'> 
      <div class='card-body'>
        <div class='d-flex align-items-center ' style='font-size:25px;font-weight:900' class='card-title'>
          <span class='badge badge-dark'> $categories_name</span>$topic 
        </div>
          <span class='badge badge-info'>$date</span>
          <div class='pt-3'>" . nl2br($content) . "</div>

          
          </div>
        </div>
      </div>
  </div>
</div>

  ";
}
?>












</div>
