<?php
// Инициализация PHP

//header('Content-Type: text/html; charset=windows-1251');
header('Content-Type: text/html; charset=UTF8');

// Установка локали
//setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
setlocale(LC_ALL, 'ru_RU.UTF-8', 'Russian_Russia.65001');

global $ver;
$ver = "ver=5";

function ero($msg)
{
    echo "<span class='err'>" . $msg . "</span>";
}

function oke($msg)
{
    echo "<span class='oke'>" . $msg . "</span>";
}

function mes($msg)
{
    echo "<span class='mes'>" . $msg . "</span>";
}

function input_filter($txt)
{
    return strip_tags(htmlspecialchars($txt));
}

?>
