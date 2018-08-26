<div class="container">
  <div class="row">
	  <div class="col-sm-10 col-lg-6 mx-auto pt-3">
      <h2>create category</h2>
				<div class="card mb-3">
					<div class="card-body">
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
								<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="submit" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
							</div>

						</form>
					</p>
        </div>
      </div>
    </div>
  </div>
</div>

