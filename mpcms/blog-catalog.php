
<!-- Это часть страницы blog-index2.php  -->


<div class="divtxt">
<h2 id="h21">КАТАЛОГ ТЕКСТОВ</h2>
<span class="p">
	<span id="cats_chain"></span> (<span id="tag"></span>) - <span id="msg"></span>
	<br/><br/>
</span>
</div>

<form name="dir">

	<span class="p" id="cat" hidden="hidden"></span
	
<?php	if (($ss_nick == 'Admin') or ($ss_nick == 'cbw')) { ?>
  
    <table class="ed"> <col width="15%">

		<tr><td class="l">Пароль</td><td class="r"><input class='text' type='password' name='passwd' id='passwd' /></td></tr>
	
		<tr><td class="l"> 	

	<input type="button" class="aslink11" title="Показать каталог в виде таблицы" value="Как список" onclick="show_dir()"/>
	<input type="button" class="aslink11" title="Показать ид текстов" value="Показать ids" onclick="get_all_ids()" />
		</td><td  class="l"></td></tr>

		</table>
		<br/>
<?php }  ?>		
</form>

<span id="err"></span>
<div id="cats"></div>

<div class="alignleft">
<input type="button" class="aslink11" title="" value="Показать больше текстов" onclick="return show_texts()"/>
</div>

<div class="alignright">		
<a class="btn11" href="../mpcms/index.php">На главную</a>
</div>

<br/ >
<br/ >

<?php 
echo 
'<script type="text/javascript"> 
//	refresh_cats();		
	document.getElementById("cat").value = "'.$url_name.'";
	document.getElementById("cat").innerHTML = "'.$url_name.'";
	get_cats_chain();

//	refresh_tags();
	document.getElementById("tag").value = "'.urldecode($tag_name).'";
	document.getElementById("tag").innerHTML = "'.urldecode($tag_name).'";
	
	get_txt_ids();
	
	show_texts();

	cidss = document.getElementById("cids").innerHTML;
	cids = cidss.split(",");
	cidsn = cids.length;
	
	sh = "";
	for(i=0; i<cidsn; i++)
	{
//		alert(cids[i] + sh);	
		show_subcats(cids[i], sh);	
		sh = sh + " -";
	}
    if (cidsn == 1) 
		show_subcats(1," -");
		
//	show_subcats(0,"");
//	show_subcats(1," -");
//	show_subcats(5," - -");
//	show_cats1();

	show_tags1();
</script>';

?>
