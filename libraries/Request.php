<?php
//如果輸入 localhost/forum/login?id=1 Request::uri() 會返回login
class Request {
    public static function uri()
    {
        $uri = str_replace(static::getFolderName(), "", static::redirect_url());
        /*
        echo 'php_self:  '.$_SERVER['PHP_SELF'];
        echo '<br>';
        echo 'query string:  '.$_SERVER['QUERY_STRING'];
        echo '<br>';
        echo 'redicrect-url:  '.$_SERVER['REDIRECT_URL'];
        echo '<br>';
        echo 'REQUEST_URI:  '.$_SERVER['REQUEST_URI'];
        echo '<br>';
        echo 'uri:  ',$uri;
        echo '<br>';
         */
        return trim($uri, '/');
    }

    private static function redirect_url() {
        //redirect_url返回/forum/login
        //request_uri返回/forum/login?id=1
        
        if( isset($_SERVER['REDIRECT_URL']) )
            return $_SERVER['REDIRECT_URL'];
        return explode("?", $_SERVER['REQUEST_URI'] )[0];
        
    }

    private static function getFolderName()
    {
      //$server['php_self']會返回call這個函數的Php的 :/forum/index.php
        $folder_name = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
        return $folder_name;
    }
    //public static function get
    public static function getQueryString(){
      return $_SERVER['QUERY_STRING'];
    }
}
