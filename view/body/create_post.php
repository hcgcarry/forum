<div class="container">
  <div class="row">
	  <div class="col-sm-10 col-lg-10 mx-auto pt-3">
				<div class="card mb-3"> 
						<div class="card-body">
            <center>
								<h2>發表文章</h2>
							<?php if ($msg->hasMessages()) $msg->display(); ?>
            </center>
						<form role="form" method="post" action="" autocomplete="off">
  <?php
echo "  <select name='categoriesID' class='custom-select-sm'>
        <option value='' selected>類別</option>";
if (isset($categoriesArray) AND count($categoriesArray)>0){
  foreach($categoriesArray as $row){
    printf("<option value='%s'>%s</option>",$row['categoriesID'],$row['categories_name']);

  }
}

  echo " </select> ";
?>
						<p class="card-text">
							


							<div class="form-group">
								<input type="text" name="topic"  class="form-control input-lg" placeholder="topic" tabindex="1">
							</div>

							<div class="form-group">
								<textarea rows='15' name="content"  class="form-control input-lg" placeholder="在這裡輸入文章" tabindex="2"></textarea>
							</div>
							
							<hr>

					</p>
          <div class="submit" style='position:fixed;bottom:0;left:0;'>
            <input type="submit"  name="submit" value="提交" class="btn btn-primary btn-block btn-lg" tabindex="5">
          </div>
						</form>
        </div>
      </div>
    </div>

