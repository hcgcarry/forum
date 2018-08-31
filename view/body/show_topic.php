
																			<!-- initial-->
<?php
$numberOfRow=10;//一個分頁的row數
if(!isset($_GET['page']) OR empty($_GET['page'])){
	$page=1;
}
else{
	$page=$_GET['page'];
}
if(!isset($_GET['categoriesID']) OR empty($_GET['categoriesID'])){
	$_GET['categoriesID']=88888;
}
$categoriesID=$_GET['categoriesID'];
//get number of all data
if($categoriesID!=88888){
	//select pagenumber
	$sql='select COUNT(postID) from posts where categoriesID='.$categoriesID;

	$numOfData=Database::get()->execute($sql);
	if(isset($numOfData) AND !empty($numOfData)){
	  $totalPageNum=ceil(($numOfData[0][0])/$numberOfRow);

	}
	//select topic
	$sql="SELECT
	posts.topic,posts.date,posts.postID,members.nickname,members.username,categories_name
	FROM
	posts
	LEFT JOIN members
	ON posts.memberID=members.memberID
	LEFT JOIN categories
	ON posts.categoriesID=categories.categoriesID
	WHERE posts.categoriesID=".$categoriesID."
	ORDER BY posts.date DESC
	LIMIT ".$numberOfRow." OFFSET ".($page-1)*$numberOfRow;
}
else{
	$sql='select COUNT(postID) from posts';

	$numOfData=Database::get()->execute($sql);
	if(isset($numOfData) AND !empty($numOfData)){
	  $totalPageNum=round(($numOfData[0][0])/$numberOfRow);

	}
	$sql="SELECT
	posts.topic,posts.date,posts.postID,members.nickname,members.username,categories_name
	FROM
	posts
	LEFT JOIN members
	ON posts.memberID=members.memberID
	LEFT JOIN categories
	ON posts.categoriesID=categories.categoriesID
	ORDER BY posts.date DESC
	LIMIT ".$numberOfRow." OFFSET ".($page-1)*$numberOfRow;
}



//page 式分頁選單選到的分頁
//count 是在創造分頁得時候看創造道地幾個的數字
if($page < 5){
	$count=0;
}
else{
	$count=$page-3;
}
?>




									<!-- 分頁-->
<div class='container pt-3'>
  <div class='row'>
    <div class='col-1 offset-3' style='display:inlie-block;'>
      <a style='float:eft;display:inlie-block;' class="btn btn-primary" href="?page=1&categoriesID=<?=$categoriesID?>">回首頁</a>
    </div>
    <div class='col-4 offset-0'>
      <ul class="pagination pagination-sm justify-content-center" >
										<!--php-->

<?php
for ($index = 0; $index < 7; $index = $index + 1) {
	$count = $count + 1;
	if ($count <= $totalPageNum) {
		if ($count == $page) {
			printf('<li class="page-item"><a class="bg-dark page-link" href="?page=%d&categoriesID=%d">%d</a></li>'
			, ($count), ($categoriesID),($count));
		}
	    else {
			printf('<li class="page-item"><a class="page-link" href="?page=%d&categoriesID=%d">%d</a></li>'
			, ($count), ($categoriesID),($count));
		}

	}
}
	$count = $count - 7;
?>


      </ul>
    </div>
  </div>




                                            <!--類別選擇按鍵-->
  <div class='container '>
    <ul class='nav nav-tabs nav-justified'> 
      <li class=nav-item'><a class='nav-link text-light bg-primary' href='?categoriesID=88888&page=1'>全部</a></li>
                                                  <!--php-->
      <?php
      ///這個似乎只能執行一次, 我猜拭去取得categoreisnamearray食材會執行query
      $selectCategoriesSql="SELECT categories_name,categoriesID FROM categories";
      $postArray=Database::get()->execute($selectCategoriesSql);
      if (isset($postArray) AND count($postArray) > 0){
        foreach($postArray as $row){
          if($_GET['categoriesID']==$row['categoriesID']){
          printf("<li class='nav-item'><a  class='active nav-link' href='?categoriesID=%s&page=%d'>%s</a></li>",$row['categoriesID'],1,$row['categories_name']);
          }
          else{
            printf("<li class='nav-item'><a  class='nav-link' href='?categoriesID=%s&page=%d'>%s</a></li>",$row['categoriesID'],1,$row['categories_name']);
          }
        }

      }
        $categoriesID=$_GET['categoriesID'];
      ?>
												  <!--類別選擇按鍵php end-->
    </ul>
  </div>




								  <!--文章列表-->
  <div class='container pt-2'>
    <table class="table table-hover table-dark table-striped">
      <thead>
        <tr class='d-flex '>
          <th class='col-1'>類別</th>
          <th class='col-8'>題目</th>
          <th class='col-2'>暱稱/ID</th>
          <th class='col-1'>發表時間</th>
        </tr>
      </thead>
      <tbody>


<?php


$postArray=Database::get()->execute($sql);

if (isset($postArray) AND count($postArray) > 0){
	foreach($postArray as $row){
		printf("<tr class='d-flex '>
		<td class='col-1 style='font-size:12px;'>%s</td>
		<td class='topic col-8 font-weight-bold' style='font-size:18px;'><a href='%s'>%s</td>
		<td class='col-2' style='font-size:14px;'>
		<div class='row'>
		<div class='col-12'>%s</div>
		<div class='col-12'>%s</div>
		</div>
		</td>
		<td class='col-1'><small>%s<small></td>
		</tr>"
		,$row['categories_name'],Config::BASE_URL."show_post?postID=".$row['postID'],$row['topic'],$row['nickname'],$row['username'],$row['date']);
	}
}

?>


      </tbody>
    </table>
  </div>

<div class='container pt-3'>
  <div class='row'>
    <div class='col-4 offset-4'>
      <ul class="pagination pagination-sm justify-content-center" >

        <!-- 分頁-->
<?php 


for($index=0;$index<7;$index=$index+1){
	$count=$count+1;
	if($count <= $totalPageNum){
		if($count==$page){
			printf('<li class="page-item"><a class="bg-dark page-link" href="?page=%d&categoriesID=%d">%d</a></li>'
			,($count),($categoriesID),($count));
		}
		else{
			printf('<li class="page-item"><a class="page-link" href="?page=%d&categoriesID=%d">%d</a></li>'
			,($count),($categoriesID),($count));
		}
	}
}

?>
      </ul>
    </div>
  </div>
