<br/>
<div class="divtxtb">
<a class="btn" href="/Tексты" title="Блог"><b> МОЙ БЛОГ </b></a><br/>
</div>



<div class="divtxtb">
<a class="btn" href="/o-temah-etogo-saita" title="О сайте">О чём ЭТОТ сайт?</a><br/>
<a class="btn" href="/inf-gosha" title="Гоша">Мой инф (бот) Гоша</a><br/>

<!--
<a class="btn" href="http://cborka.clan.su/" target="_blank" title="Мои тексты на юкозе">Мой предыдущий сайт</a>
<br/>
<a class="btn" href="http://cborka777.wix.com/cborka" target="_blank" title="Это моя проба в WIX">Я на WIX</a>
<br/>
-->

<?php
if (isset($_SESSION['ss_nick']) )
    if (($_SESSION['ss_nick'] == 'Admin') or ($_SESSION['ss_nick'] == 'cbw'))
    {
?>
<br/>
<span class="red">Админка<br/></span>
<a class="btn" href="/php/create_sitemap.php" title="Пересоздание карты сайта">Карта сайта</a><br/>
<a href="/php/mpstat1.php" title="Вывод статистики">Статистика</a><br/>
<!-- <a href="/test/sess.php" title="Сессии">Тест работы сессий</a><br/>-->
<?php
    }
?>

</div>

