<!DOCTYPE html>

<?php
require_once "../php/init_php.php";
require_once "../php/init_db.php";
 
// точка входа index.php
$url = trim($_SERVER['REQUEST_URI'], "/");
//$url_array = explode("/", $url);
$url_array = explode("?", array_pop(explode("/", $url))); 
$url_name = $url_array[0]; 
$tag_name = $url_array[1]; 

if ($url_name == "index.php")
{
	header("Location: /mpcms/index.php");
	exit;
} 

$is_txt = TRUE;

function page_not_found()
{
	global $url;
	
//	header("HTTP/1.0 404 Not Found");

//	header("Location: /".urldecode($url));
	header("Location: /notfound.php?page=".urldecode($url));
	exit;	
}

function get_txt()
{
    global $tid, $nik, $dt, $cat_name, $header, $url, $txt, $js1, $is_txt, $url_name, $tag_name, $user_id, $man_id;

	$is_txt = TRUE;
	$sql = "
		SELECT b.text_id, m.logname, b.dt, c.cat_name, b.header, m.user_id, b.about, b.content AS txt 
			FROM (( mp_texts b
				LEFT JOIN mp_cats c ON c.cat_id = b.cat_rf)
				LEFT JOIN mp_users m ON m.user_id = b.user_rf)
		WHERE b.url = \"". $url_name. "\"" 	
	;

	if (!($q=mysql_query_s($sql))) // Просто ошибка SQL
	{
    	echo 'Error (ошибка): ' . mysql_error() . "\n<br>";
		page_not_found();
	}

// Если нет такого текста, возможно это категория и надо вывести каталог нужной категории
	if (mysql_num_rows($q) != 1) 
	{
		$is_txt = FALSE;
		
		$url_name = urldecode($url_name);
		
		$sql = "
			SELECT cat_name, cat_id  
				FROM mp_cats
			WHERE cat_name = \"". $url_name. "\"" 	
		;
		if (!($q=mysql_query_s($sql))) // Просто ошибка SQL
		{
    		echo 'Error (ошибка): ' . mysql_error() . "\n<br>";
			page_not_found();
		}
		if (mysql_num_rows($q) != 1) 
		{
			page_not_found();
		}	
	}
	else // Это сам текст, а не категория каталога
	{
		$f = mysql_fetch_array($q);

		$tid = $f[text_id];
		$nik = $f[logname];
		$user_id = $f[user_id];
		$man_id = $f[user_id];
		$dt = $f[dt];
		$cat_name = $f[cat_name];
		$header = $f[header];
		$about = $f[about];
		$txt = $f[txt];
	}
  
$js1 = " 
<script language=\"JavaScript\">
	window.onload = function() { document.createElement('img').src = '/php/mpcounter.php?pgname=".$url_name."&isload=1';	};
	window.onunload = function () {	document.createElement('img').src = '/php/mpcounter.php?pgname=".$url_name."&isload=0';	}
</script>
"; 
  
	return;
}

get_txt();

?> 

<html>
<head>
	<title><?php echo $header; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
	<link rel="stylesheet" href="/css/mp.css">
	<style>	</style>
	<?php echo $js1; ?>

	<script type="text/javascript" language="javascript" src="../js/a-lib.js"></script>
	<script type="text/javascript" language="javascript" src="/js/blog-dir.js"></script>

	
</head>
<body>


<!-- =================================== ШАПКА ===================================== -->
<div class="head"> <!-- ШАПКА -->

<?php include "../mpcms/itis-header.php" ?>

</div> <!-- ШАПКА -->

<!-- ================================ СЕРЕДИНА ПО ВЕРТИКАЛИ ======================== -->
<div class="wrapper_1">
<div class="leftcol"> <!-- ЛЕВАЯ КОЛОНКА -->

<?php
  if ($is_txt)  // ТЕКСТ 
  {
	include "../mpcms/itis-left-text.php"; 
  }
  else  // КАТАЛОГ 
  {
	include "../mpcms/itis-left-blog.php"; 
	
	if (isset($_SESSION['ss_nick']))  
	echo '
	<script language = "javascript"> 
		document.getElementById("dtb").value="'.$_SESSION['dtb'].'";
		document.getElementById("dte").value="'.$_SESSION['dte'].'";
 		document.getElementById("srtt").value="'.$_SESSION['srtt'].'";
 		document.getElementById("srtk").value="'.$_SESSION['srtk'].'";
	</script>';
  }

?>	

</div> <!-- ЛЕВАЯ КОЛОНКА -->


<!-- =============================== ЦЕНТР, ОСНОВНАЯ ИНФА ========================== -->
	
<div class="center"> 


<?php	if (($ss_nick == 'Admin') or ($ss_nick == 'cbw')) { ?>
<div class="buttons2">		
<a href="/mpcms/blog-editor.php" alt="Добавить новый текст" title="Добавить новый текст"><img src="/img/txt-new.png" alt="" /></a>
</div>
<?php }  ?>

<?php
if ($is_txt)  // ТЕКСТ 
{
	include "../mpcms/blog-text.php";
}
else 
{
	include "../mpcms/blog-catalog.php";
}
?> 

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