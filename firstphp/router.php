<?php

include('libraries/Router.php');
include('libraries/Request.php');
$route = new Router(Request::uri()); //搭配 .htaccess 排除資料夾名稱後解析 URL

if($route->getParameter(1) == "")
    include('view/main.php');
else 
    include('view/'.$route->getParameter(1).'.php');