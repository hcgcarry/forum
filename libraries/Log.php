<?php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Log {
    function error($msg,$page=__FILE__ ){        

        $logger = new Logger($page);
        $logger->pushHandler(new StreamHandler('log/error.log', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        $logger->error(Ip::get().': '.$msg);
    }

    function info($msg,$page=__FILE__ ){        
        $logger = new Logger($page);
        $logger->pushHandler(new StreamHandler('log/info.log', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        $logger->info(Ip::get().': '.$msg);
    }

    function warning($msg,$page=__FILE__ ){        
        $logger = new Logger($page);
        $logger->pushHandler(new StreamHandler('log/warning.log', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        $logger->warning(Ip::get().': '.$msg);
    }
}