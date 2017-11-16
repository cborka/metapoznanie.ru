<div class="hdmenu">

<?php

//echo '>>'.$_SESSION['ss_nick'];
if (isset($_SESSION['ss_nick']) )
  if ($_SESSION['ss_nick'] == 'Admin')
{
?>
<div class="menuitem"><a class="btnm" href="/mpcms/mans.php" title="Люди"><p class="mmi">Пользователи</p></a></div>
<div class="menuitem"><a class="btnm" href="/mpcms/cats.php" title="Категории"><p class="mmi">Категории</p></a></div>
<div class="menuitem"><a class="btnm" href="/php/mpstat1.php" title="Вывод статистики"><p class="mmi">Статистика</p></a></div>
<div class="menuitem"><a class='btnm' href="/test/colors3.html"><p class="mmi">Цвета</p></a></div>
<?php
}
?>
<div class="menuitem"><a class='btnm' href="/"><p class="mmi">На главную</p></a></div>

<div class="menuitem"><a class='btnm' href="o-temah-etogo-saita"><p class="mmi">О сайте</p></a></div>

<div class="menuitem"><a class='btnm' href="/Tексты" title="Каталог текстов"><p class="mmi">Блог</p></a></div>

<p class="mmi5">&nbsp;</p>
 
 
<!-- <a class='btnm' href="/"><p class="mmi">На главную</p></a><a href="/Tексты" title="Каталог текстов"><p class="mmi">Блог</p></a><a class='btnm' href="/test/colors3.html" title="Цвета"><p class="mmi">Цвета</p></a>
-->

</div>

