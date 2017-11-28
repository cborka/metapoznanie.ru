<!--// ЛОГОТИП -->
<div class="logo">
<?php
session_start(); // Записывает куки, а запись куков должна быть до того как что-то ещё выводить будем

if ($_SERVER['REQUEST_URI'] <> '/')
{
echo '<a title="На главную" href="/"><img src="/img/mp21.bmp" alt="" /></a>';
}
else
{
echo '<img src="/img/mp21.bmp" alt="" />';
}
?>
</div>

<!--// РЕГИСТРАЦИЯ -->
<div class="reg">
<?php include_once "../php/log-in.php"; ?>
</div>


<div class="hd2">
<p class="titul"><span class="meta">МЕТА</span><span class="poznanie">ПОЗНАНИЕ</span></p>
</div>

<?php include_once "../php/menu1.php"; ?>


<?php 
function show_nick() 
{
//	global $ss_nick;
	
//	if ($ss_nick == 'Admin')
//		ero("<b>[ АДМИНИЩЩЩЕ ]</b>"); 
//	else 
//		echo "&nbsp;";	

//echo "[".$_SESSION['ss_nick']."]"; 

//	if (! isset($ss_nick))	echo "[-NONAME-]"; 
//		echo "[".$ss_nick."]"; 
//	else	
//		echo "[NONAME]"; 

//$ss_nick = 'noname';
}
//show_nick();
//echo "[".$ss_nick."]";


?>

