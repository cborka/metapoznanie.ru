не найдено
<?php


require "php/init_php.php";

global $url;


//$url = trim($_SERVER['REQUEST_URI'], "/");    // например, /contact
//echo "notfound: Страничка ".$url." не найдена!<br/>";


echo "notfound: Страница " . $_GET['page'] . " не найдена!<br/><br/>";
//echo "notfound: Страница ".$url." не найдена!<br/><br/>";

echo '<a href="/Tексты">[ В каталог ]</a><br>';
echo '<a href="/">[ На главную ]</a><br>';

header("HTTP/1.0 404 Not Found");


/*
if(file_exists("includes/modules/{$url}.php")){
    include "includes/modules/{$url}.php";    //модуль
}else if($uri == ''){
    include "include/modules/index.php";    // главная страница
}else{
    header("HTTP/1.0 404 Not Found");    // такого модуля нет
    die("Bad request!");
}
*/
?>