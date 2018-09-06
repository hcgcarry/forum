

<?php

if ($msg->hasMessages()) $msg->display(); 
$sql = "select profile,selfDetail from members where memberID=:memberID";
$data_array['memberID'] = $_SESSION['memberID'];
$result = Database::get()->execute($sql, $data_array);
if (isset($result[0]) and count($result[0] > 0)) {
	foreach ($result[0] as $key => $item) {
		${$key} = $item;
	}
}
$nickname = $_SESSION['nickname'];
$username = $_SESSION['username'];
$memberID = $_SESSION['memberID'];
if (!isset($selfDetail)) {
	$selfDetail = 'To be continued';
}
if (!isset($selfDetail)) {
	$selfDetail = 'To be continued';
}
logArrayRecoder::error(Database::get()->getErrorMessage(), $msg);
echo "<input type='text' name='memberID' style='display:none' value='".$_SESSION['memberID']."'>";
?>




<div class="container">
	<div class="row">
		<div class="col-12 mx-auto pt-3">

			<div class="card bg-dark mb-3">
				<div class='card-header mx-auto'>
					<?= $_SESSION['nickname'] ?>的小屋
				</div>
				<div class="card-body">
					<div class="card-text">

						<!-- profile-->
						<div class="card mx-auto mb-4" style="background-color:green;width:400px">
							<img class="card-img-top" src="<?= $profile ?>" style='width:100%' alt="Card image">
							<div class="card-body">
								<div class="nickname card-title d-flex justify-content-center"><?= $nickname ?></div>
								<span class='badge badge-primary d-flex justify-content-center'>ID:<?= $username ?></span>

									<div class='card-text'>
											<span class='badge badge-dark'>名言:</span>
											<div class='selfDetail'>
												<span class='selfDetailText d-flex justify-content-center'><?= nl2br($selfDetail) ?></span>
											</div>
											<!--edit-->
											<div class='editSelfDetail' style='display:none'>
												<div class="form-group">
													<textarea rows='3' name="selfDetial"  class="form-control input-lg" placeholder="在這裡輸入名言" tabindex="2"></textarea>
												</div>
												<button type='button' class='editSubmit btn btn-primary'>儲存</button>
												<button type='button' class='cancelEditSubmit btn btn-primary'>取消</button>
											</div>
									</div>
							</div>

						</div>
					</div>
					<!-- upload profile-->

					<div class='row'>
						<div class='ml-3 p-3 col-4 mx-auto bg-secondary'style='border:2px solid red;border-radius: 5px;'>
					
						<div>選擇要當大頭貼的照片</div>
					<form id="form" action="" method="post" enctype="multipart/form-data">
						<span class='selfDetailEditButton btn btn-light mr-3'style='position:absolute;right:0px;button:0px;'>編輯名言</span>

						<input id="uploadImage" type="file" accept="image/*" name="image" />
						<input class="btn btn-success" type="submit" value="上傳">
					</form>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

