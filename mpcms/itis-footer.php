
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
<a href="https://metrika.yandex.ru/stat/?id=43836374&amp;from=informer"
   target="_blank" rel="nofollow"><img src="https://informer.yandex.ru/informer/43836374/3_1_EEEEEEFF_EEEEEEFF_0_pageviews"
                                       style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" class="ym-advanced-informer" data-cid="43836374" data-lang="ru" /></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter43836374 = new Ya.Metrika({
                    id:43836374,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/43836374" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- GoogleAnalytics counter -->
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-96451430-1', 'auto');
    ga('send', 'pageview');
</script>

<!--LiveInternet counter--><script type="text/javascript">
    document.write("<a href='//www.liveinternet.ru/click' "+
        "target=_blank><img src='//counter.yadro.ru/hit?t16.2;r"+
        escape(document.referrer)+((typeof(screen)=="undefined")?"":
            ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
            screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
        ";"+Math.random()+
        "' alt='' title='LiveInternet: показано число просмотров за 24"+
        " часа, посетителей за 24 часа и за сегодня' "+
        "border='0' width='88' height='31'><\/a>")
</script>
<!--/LiveInternet-->

<!-- Rating@Mail.ru counter -->
<script type="text/javascript">
    var _tmr = window._tmr || (window._tmr = []);
    _tmr.push({id: "2945281", type: "pageView", start: (new Date()).getTime()});
    (function (d, w, id) {
        if (d.getElementById(id)) return;
        var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
        ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
        var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
        if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
    })(document, window, "topmailru-code");
</script><noscript><div>
        <img src="//top-fwz1.mail.ru/counter?id=2945281;js=na" style="border:0;position:absolute;left:-9999px;" alt="" />
    </div></noscript>
<!-- //Rating@Mail.ru counter -->
<br>
<!-- Rating@Mail.ru logo -->
<a href="https://top.mail.ru/jump?from=2945281">
    <img src="//top-fwz1.mail.ru/counter?id=2945281;t=467;l=1"
         style="border:0;" height="31" width="88" alt="Рейтинг@Mail.ru" /></a>
<!-- //Rating@Mail.ru logo -->

<!--Openstat-->
<span id="openstat2386700"></span>
<script type="text/javascript">
    var openstat = { counter: 2386700, image: 5083, color: "8f46b9", next: openstat };
    (function(d, t, p) {
        var j = d.createElement(t); j.async = true; j.type = "text/javascript";
        j.src = ("https:" == p ? "https:" : "http:") + "//openstat.net/cnt.js";
        var s = d.getElementsByTagName(t)[0]; s.parentNode.insertBefore(j, s);
    })(document, "script", document.location.protocol);
</script>
<!--/Openstat-->

<!--Яндекс. Индекс цитирования - ->
<a href="http://yandex.ru/cy?base=0&amp;host=metapoznanie.ru"><img src="http://www.yandex.ru/cycounter?мой_сайт" width="88" height="31" alt="Индекс цитирования" border="0" /></a>.
 -->