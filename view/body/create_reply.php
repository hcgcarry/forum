
<div class="container">
  <div class="row">
    <div class="col-sm-10 col-lg-10 mx-auto pt-3">
      <div class="card mb-3"> 
        <div class="card-body">
          <center>
            <h2>回覆</h2>
            <?php if ($msg->hasMessages()) $msg->display(); ?>
          </center>
          <form role="form" method="post" action="" autocomplete="off">
            <p class="card-text">

            <div class="form-group">
              <textarea rows='15' name="content"  class="form-control input-lg" placeholder="在這裡輸入" tabindex="2"></textarea>
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



