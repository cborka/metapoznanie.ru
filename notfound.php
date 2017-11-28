<?php
header("HTTP/1.0 404 Not Found"); // Должен быть первым

require "php/init_php.php";


echo "notfound: Страница <b>" . $_GET['page'] . "</b> не найдена!<br/><br/>";

echo '<a href="/Tексты">[ В каталог текстов ]</a><br>';
echo '<a href="/">[ На главную страницу ]</a><br>';

// var_dump(http_response_code());

?>