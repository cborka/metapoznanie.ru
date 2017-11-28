
<div class="divtxtb">
<h4>О блоге</h4>
<p class="p9">
Здесь разные тексты, в основном мои.
</p>
</div>

<div class="divtxtb">
    <h4>Категории</h4>
    <p class="plotno">
        <span class="i" id="cat0"> </span>
    </p>
</div>

<div class="divtxtb">
    <h4>Метки</h4>
    <p class="plotno">
        <span id="tagcloud"></span>
    </p>
</div>


<?php if (isset($_SESSION['ss_nick'])) { ?>

<div class="divtxtb">
<h4 class="plotno">Показывать за период</h4>

   <table class="ed"> <col width="15%">

		<tr><td class="l9">C </td><td class="r">
			<input class="dt9" type='date' name='dtb' id='dtb' value='2014-04-24' min="2014-04-24" onchange="SetDtb()" />
			</td></tr>
		<tr><td class="l9">по </td><td class="r">
			<input class="dt9" type='date' name='dte' id='dte' value='<?php echo date("Y-m-d"); ?>' min="2014-04-24" onchange="SetDte()" />
			</td></tr>
	</table>
	
<h4 class="plotno">Сортировка</h4>
	<table class="ed"> 
		<tr><td class="r"> 
	<select size="1" name='srtt' id='srtt' onchange="SetSrtt()">
		<option value="Новые">Новые впереди</option>
		<option value="Старые">Старые впереди</option>
	</select>
		</td></tr>
		
		<tr><td class="r"> 
	<select size="1" name='srtk' id='srtk' onchange="SetSrtk()" title="Учитывать ли дату последнего комментария при сортировке?">
		<option value="СКомментариями" title="Учитывать дату последнего комментария">С комментариями</option>
		<option value="ТолькоТексты" title="Учитывать только дату написания текстов">Только тексты</option>
	</select>
		</td></tr>

		<tr><td class="r">
		<input type="button" class="aslink9" title="" value="Применить" onclick="refresh_dir()"/>
		<input type="button" class="aslink9" title="Установить значения по умолчанию" value="Сброс" onclick="init_dt()"/>
		</td></tr>

	</table>

</div>


<!--
<p class="p9">
с &nbsp;&nbsp; <input class="dt9" type='date' name='dtb' id='dtb' value='2014-04-24' min="2014-04-24" onchange="SetDtb()" />
<br/>
по <input class="dt9" type='date' name='dte' id='dte' value='<?php echo date("Y-m-d"); ?>' min="2014-04-24" onchange="SetDte()" />
<br/>
<input type="button" class="aslink9" title="" value="Применить" onclick="refresh_dir()"/>
<br/>
	<select size="1" name='srt' id='srtt' onchange="refresh_dir()">
		<option value="Старые">Старые впереди</option>
		<option value="Новые">Новые впереди</option>
	</select>

</p>
</div>-->

<?php } ?>


