<?php
//配合Request物件使用的 假設url輸入localhost/forum/login Request 回傳login 再使用Router否配出login 還是login/test/...
//並返回
class Router {
    private $routes = [
        "^([a-zA-Z0-9-_]+)\/?$",
        "^([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/?$",
        "^([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/?$",
        "^([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/([a-zA-Z0-9-_]+)\/?$"
    ];
    private $parameters = [];
    public function __construct($url) {
        foreach ($this->routes as $route) {
            if (!preg_match("/" . $route . "/", $url, $matches))
                continue;
            $this->parameters = array_slice($matches, 1);
        }
    }
    public function getParameter($index){
      if(isset($this->parameters[($index-1)])){
        return $this->parameters[($index-1)];
      }else{
        return "";
      }
    }
}
