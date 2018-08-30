因為.htaccess 的重導向 只要式網址沒找到的文件或資料夾都會去開index.php
然後index.php 會去call route.php 決定該開啟controller下面哪一個資料夾

composer 可以讓自訂的一些資料夾下面的文件可以背整個專案使用
不要去用url開controller下面的網頁 會顯示Warning: include(): Failed opening 'view/header/default.php' for inclusion (include_path='.:/usr/share/php') in /var/www/html/forum/controller/showTopic.php on line 4
因為他們include的東西式相對index.php的
Php檔案名最好不要有大寫!!!!
