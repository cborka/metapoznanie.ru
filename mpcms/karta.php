<!DOCTYPE html>
<html>
<head>
	<title>Карта сайта</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="/css/mp.css">
	<style>	</style>

	<script  type="text/javascript">
window.onload = function() { document.createElement('img').src = '/php/mpcounter.php?pgname=Karta&isload=1';	};
		window.onunload = function () {	document.createElement('img').src = '/php/mpcounter.php?pgname=Karta&isload=0';	}
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

            <h3 class='h3main'>КАРТА САЙТА</h3>

        </div>

        <br/>


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