<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Bootstrap Example</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	</head>
	<body>

		<div class="container">
			<h2>Modal Example</h2>
			<!-- Button to Open the Modal -->
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
				Open modal
			</button>

			<!-- The Modal -->
			<div class="modal" id="myModal">
				<div class="modal-dialog">
					<div class="modal-content">

						<!-- Modal Header -->
						<div class="modal-header">
							<h4 class="modal-title">Modal Heading</h4>
							<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<!-- Modal body -->
						<div class="modal-body">
							Modal body..
						</div>

						<!-- Modal footer -->
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>

					</div>
				</div>
			</div>

		</div>
		<form role="form" method="post" action="http://carry.000webhostapp.com/forum/create_post" autocomplete="off">
            <!-- categories -->
			<?php
			echo "  <select name='categoriesID' class='custom-select-sm'>
        <option value='' selected>類別</option>";
			if (isset($categoriesArray) AND count($categoriesArray) > 0) {
				foreach ($categoriesArray as $row) {
					printf("<option value='%s'>%s</option>", $row['categoriesID'], $row['categories_name']);
				}
			}

			echo " </select> ";
			?>
            <p class="card-text">



            <div class="form-group">
				<input type="text" name="topic"  class="form-control input-lg" placeholder="topic" tabindex="1">
            </div>
            <div class="form-group">
				<input type="text" name="categoriesID"  class="form-control input-lg" value='10' placeholder="categories" tabindex="1">
            </div>

            <div class="form-group">
				<textarea rows='25' name="content"  class="form-control input-lg" placeholder="在這裡輸入文章" tabindex="2"></textarea>
            </div>

            <hr>

            </p>
            <div class="submit" style='position:fixed;bottom:0;left:0;'>
				<input type="submit"  name="submit" value="提交" class="btn btn-primary btn-block btn-lg" tabindex="5">
            </div>
		</form>

	</body>
</html>
