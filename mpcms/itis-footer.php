
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

<!-- ИНФОРМЕРЫ -->

<!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=88767502&amp;from=informer"
   target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/88767502/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
                                       style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" /></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(88767502, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/88767502" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- /Yandex.Metrika иконка ИКС -->
<a href="https://webmaster.yandex.ru/siteinfo/?site=https://mp.metapoznanie.ru"><img width="88" height="31" alt="" border="0" src="https://yandex.ru/cycounter?https://mp.metapoznanie.ru&theme=light&lang=ru"/></a>