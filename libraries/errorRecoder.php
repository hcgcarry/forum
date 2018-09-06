<?php
class logArrayRecoder{
  public static function error($error,$msg){
    if(isset($error) AND count($error) > 0){
        foreach( $error as $e) {
          $msg->error($e);
          Log::error($e);

          
        }
		return true;
    }
	else{
		return false;

	}
  }
  public static function warning($warning,$msg){
    if(isset($warning) AND count($warning) > 0){
        foreach( $warning as $e) {
          $msg->warning($e);
          Log::warning($e);
          
        }
		return true;
    }
	else{
		return false;

	}
  }
  public static function info($info,$msg){
    if(isset($info) AND count($info) > 0){
        foreach( $info as $e) {
          $msg->info($e);
          Log::info($e);
          
        }
		return true;
    }
	else{
		return false;

	}
  }
  public static function errorLog($error){
    if(isset($error) AND count($error) > 0){
        foreach( $error as $e) {
          Log::error($e);
          
        }
		return true;
    }
	else{
		return false;

	}
  }
}
?>
