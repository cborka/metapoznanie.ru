<!DOCTYPE html>
<html>
<head>
	<title>Метапознание</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="/css/mp.css">
	<style>	</style>

	<script  type="text/javascript">
		window.onload = function() { document.createElement('img').src = '/php/mpcounter.php?pgname=Index&isload=1';	};
		window.onunload = function () {	document.createElement('img').src = '/php/mpcounter.php?pgname=Index&isload=0';	}
//		window.onbeforeunload = function () { }


	</script>
	
	<script type="text/javascript" src="/js/a-lib.js"></script>
	<script type="text/javascript" src="/js/blog-dir.js"></script>

</head>
<body>
<!--mpcms/index.php-->

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
<br/>

<div class="divtxtbp">

<h3 class='h3main'>ЗДЕСЬ ТУТ ФРАГМЕНТЫ<br/>
МОЕЙ КАРТИНЫ НАШЕГО МИРА</h3>

<!--<h2 class='h2main'>Здесь,</h2>
<h3 class='h3main'>на этом сайте,</h3>
<h3 class='h3main'>я просто делюсь </h3>
<h3 class='h3main'>своими представлениями о том, как устроен </h3>
<h2 class='h2main'>этот мир, </h2>
<h3 class='h3main'>частью которого все мы являемся</h3>-->

</div>

<br/>
<h2 id="h21" class="h2hdr2">НОВОСТИ САЙТА</h2>
<br/>
<form name="dir">
	<input class='text' hidden="hidden" type='text' name='cat' id='cat' value="История сайта" />
	<input class='text' hidden="hidden" type='text' name='tag' id='tag' value="" />
</form>

<span id="err"></span>
<div id="cats"></div>

<input type="button"  class="lnk2" title="" value="Показать больше текстов" onclick="return show_texts()"/>
<br/><br/>

<script type="text/javascript"> 
	get_txt_ids();
	show_texts();
</script>


</div> <!-- СЕРЕДИНА -->

<!-- ================================ ПРАВАЯ КОЛОНКА =============================== -->

<div class="rightcol"> <!-- ПРАВАЯ КОЛОНКА -->

<?php include "../mpcms/itis-right.php" ?>

</div> <!-- ПРАВАЯ КОЛОНКА -->

</div> <!-- WRAPPER -->

<!-- ================================ НИЗ ========================================== -->

<div class="footer">

<?php include "../mpcms/itis-footer.php" ?>

</div>


</body>
</html>