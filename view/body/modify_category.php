<div class="container">
  <div class="row">
	  <div class="col-sm-10 col-lg-6 mx-auto pt-3">
				<div class="card mb-3">
					<div class="card-body">
								<h2>create category</h2>
						<p class="card-text">
						<form role="form" method="post" action="" autocomplete="off">
							
							<?php if ($msg->hasMessages()) $msg->display(); ?>


							<div class="form-group">
								<input type="text" name="categories_name"  class="form-control input-lg" placeholder="categories name" tabindex="1">
							</div>

							<div class="form-group">
								<textarea name="categories_describtion"  class="form-control input-lg" placeholder="input some categories describtion" tabindex="2"></textarea>
							</div>
							
							<hr>
							<div class="row">
								<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="create_categories" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
							</div>

						</form>
					</p>
        </div>
      </div>
    </div>

	  <div class="col-sm-10 col-lg-6 mx-auto pt-3">
				<div class="card mb-3">
					<div class="bg-success card-body">
						<h2>categories</h2>	
						<p class="card-text">
						<form role="form" method="post" action="" autocomplete="off">
            <div style='padding:10px;border:solid 3px black;'>
							<?php if ($msg->hasMessages()) $msg->display(); ?>

            <?php if(isset($categoriesNameArray) AND !empty($categoriesNameArray)){
                    foreach($categoriesNameArray as $name){
                      echo "<div>";
                      echo "<input type='checkbox' name='".$name['categories_name']."' value='".$name['categories_name']."'>";
                      echo $name['categories_name'];
                      echo "</div>";
                    }

                  }
        ?>
            </div>
				

							
							<hr>
							<div class="row">
								<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="delete_categories" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
							</div>

						</form>
					</p>
        </div>
      </div>
    </div>
  </div>
</div>

