<!DOCTYPE html>
<html>
<head>
	<title>Метапознание</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="/css/mp.css">
	<style>	</style>

</head>
<body>

<!--TODO Похоже этот файл тоже лишний???-->

<!-- =================================== ШАПКА ===================================== -->
<div class="head"> <!-- ШАПКА -->

<?php include "../mpcms/itis-header.php" ?>

</div> <!-- ШАПКА -->

<!-- ================================ СЕРЕДИНА ПО ВЕРТИКАЛИ ======================== -->
<div class="wrapper_1">
<div class="leftcol"> <!-- ЛЕВАЯ КОЛОНКА -->

<?php include "../mpcms/itis-left-index.php" ?>

</div> <!-- ЛЕВАЯ КОЛОНКА -->


<!-- =============================== ЦЕНТР, ОСНОВНАЯ ИНФА ========================== -->
	
<div class="center"> 

<div class="i">
<h2>НОВОСТИ САЙТА !!!</h2>
<p>
<b>20.06.2014 13:07</b><br/>
Делаю этот сайт сам.<br/>
По пути обучаюсь сайтостроительству и описываю историю его создания.<br/>
<br/>
Пока готов только <a href="/Tексты">БЛОГ</a>.<br/>
Постепенно расширяю его функционал.<br/>
<br/>
Заходите ещё. 
</p>

</div>


<h2 id="h21">НОВОСТИ САЙТА</h2>

<script type="text/javascript" language="javascript" src="/js/blog-editor.js"></script>
<script type="text/javascript" language="javascript" src="/js/blog-dir.js"></script>

<form name="dir">
	<input class='text' type='text' name='cat' id='cat' value="Сайт" />
	<input class='text' hidden="hidden" type='text' name='tag' id='tag' value="" />
</form>


<span id="err"></span>
<div id="cats"></div>

<input type="button"  class="button" title="Показать больше текстов" value="ЕщЁ" onclick="return show_texts()"/>

<script type="text/javascript"> 
	get_txt_ids();
	show_texts();
</script>


</div> <!-- СЕРЕДИНА -->

<!-- ================================ ПРАВАЯ КОЛОНКА =============================== -->

<div class="rightcol"> <!-- ПРАВАЯ КОЛОНКА -->

<?php include "../mpcms/itis-right-index.php" ?>

</div> <!-- ПРАВАЯ КОЛОНКА -->

</div> <!-- WRAPPER -->

<!-- ================================ НИЗ ========================================== -->

<div class="footer">

<?php include "../mpcms/itis-footer.php" ?>

</div>


</body>
</html>