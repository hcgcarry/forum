<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Log {
    function error($msg,$path='log/error.log',$page=__FILE__ ){        

        $logger = new Logger($page);
        $logger->pushHandler(new StreamHandler($path, Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        $logger->error(Ip::get().': '.$msg);
    }

    function info($msg,$path='log/info.log',$page=__FILE__ ){        
        $logger = new Logger($page);
        $logger->pushHandler(new StreamHandler($path, Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        $logger->info(Ip::get().': '.$msg);
    }

    function warning($msg,$path='log/warning.log',$page=__FILE__ ){        
        $logger = new Logger($page);
        $logger->pushHandler(new StreamHandler($path, Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        $logger->warning(Ip::get().': '.$msg);
    }
}