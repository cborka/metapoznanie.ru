
<div class="ftmenu">

 <p class="mmi2">Сайт основан 24.04.2014	</p>
 
 <div class="ftright">
 	<p class="mmi2" title="Статистика сайта"><?php include "../php/mpstat.php" ?></p>
 </div>
 
</div>


<div>

<div class="footerleft">
<br/>
&nbsp;
<br/>
</div>

<div class="footercenter">
<p class='stat' title="Счётчик флагов. На их сайте есть справочник по странам и флагам, только всё на английском">
<a href="http://info.flagcounter.com/N6Bu">
<img src="http://s01.flagcounter.com/count/N6Bu/bg_FFFFF1/txt_626262/border_dcdcdc/columns_3/maxflags_18/viewers_0/labels_1/pageviews_0/flags_0/" alt="Flag Counter" border="0">
</a>	
</p>
</div>


<div class="footerright">
<div class="divtxt statpro">
<p class="p9">
<?php
$ttime = microtime(true) - $tstart;
printf('Скрипт выполнялся %.4F сек.', $ttime);

global $squery_count;
echo '<br/>SQL запросов: '.$squery_count.'+';
?>
<script type="text/javascript"> 
	document.write(q_count);
//	document.write('<'+q_count+'>');
</script>
</p>
</div>
</div>

</div>




