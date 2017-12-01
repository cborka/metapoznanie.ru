<?php
/**
 * Created by PhpStorm.
 * User: bor
 * Date: 01.12.2017
 * Time: 9:33
 */
?>

<NOINDEX>
<span class="robots-nocontent">

<?php require_once "../php/do-itis-right.php" ?>

<br/>
<br/>
<div class="divtxtb">
    <h4>Случайная фраза</h4>
    <span id="tvit"><?php echo get_tvit(); ?></span>
</div>
<br/>
<?php echo get_today(); // События дня ?>

</span>
</NOINDEX>


<!--
<iframe src="test/colors3.html" width="100%"  align="left">
    Ваш браузер не поддерживает плавающие фреймы!
</iframe>

<a href="../test/colors3.php" title="Цвета">[Цвета]</a><br/>
hello2<br />
<iframe src="/test/colors3.php" width="100%" align="left">
    Ваш браузер не поддерживает плавающие фреймы!
</iframe>

-->
