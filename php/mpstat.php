<?php

//sleep(11);

require_once "init_php.php";
require_once "init_db.php";

$totall=do_sql("select count(*) from mpstat"); 
$hits=do_sql("select count(*) from mpstat where TO_DAYS(NOW()) = TO_DAYS(dtb) "); 
$hosts=do_sql("select count(distinct ip) from mpstat where TO_DAYS(NOW()) = TO_DAYS(dtb)"); 

//echo "<h4 class='left'>Статистика</h4><p class='stat'>All: <b>$totall</b> Hits: <b>$hits</b> Hosts: <b>$hosts</b></p>";

//echo "<div class='i'><h4 class='left'>Статистика</h4><p class='stat'>Страниц всего: <b>$totall</b> <br/> Страниц сегодня: <b>$hits</b> <br/> Посетителей сегодня: <b>$hosts</b></p></div>";


?>

<?php
echo "All: <b>$totall</b> Hits: <b>$hits</b> Hosts: <b>$hosts</b>";
?>

