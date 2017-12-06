<!DOCTYPE html>
<html>
<head>
	<title>Запросы к серверу</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">   
	<style>	</style>

	<script language="JavaScript">
	
		window.onload = function() { 
			document.createElement('img').src = '../php/mpcounter.php?pgname=Colors3&isload=1';	};
		window.onunload = function () {	
			document.createElement('img').src = '../php/mpcounter.php?pgname=Colors3&isload=0';	}

		function hx(i) {
			return Number(i).toString(16);
		}

		function colors3() {

			for (i = 0; i <= 0xF; i = i + 3)
			{
				for (j = 0; j <= 0xF; j = j + 3)
				{
					for (k = 0; k <= 0xF; k = k + 3)
					{
	  					clr = "#"+ hx(i) + hx(j) + hx(k);
	  			
			  			if (clr < "#666") 
	  						tclr = "white"
	  					else
	  						tclr = "black";	
	  			  			
			  			document.write ("\
	  					<div style=\"\
	  						width: 77px; \
			  				height: 21px; \
	  						border: solid 0px; \
	  						margin: 1px; \
			  				display:  inline-block; \
	  						text-align: center; \
	  						background-color: "+clr+"; \
			  				color: "+tclr+"\";> \
	  						<span style=\"vertical-align: middle;\">"+
	  						clr+
			  				"</span> \
  						</div> \
  						");
					}
		//			if (j % 2) 
					document.writeln("<br/>"); 
				}
			}
		}
	function colors1(clr, nm) {

			  			if (clr < "#666") 
	  						tclr = "white"
	  					else
	  						tclr = "black";	
	  				
	  				
//	  	ff = 0xffffff;
//	  	nm1 = (ff - Number("0x"+clr.substring(1,7)));
//	  	tclr = "#"+nm1.toString(16);				
		document.write ("\
	  					<div style=\"\
	  						width: 177px; \
			  				height: 21px; \
	  						border: solid 0px; \
	  						margin: 1px; \
			  				display:  inline-block; \
	  						text-align: center; \
	  						background-color: "+clr+"; \
			  				color: "+tclr+"\";> \
	  						<span style=\"vertical-align: middle;\">"+
	  						clr+" "+nm+
			  				"</span> \
  						</div> \
  						");
	}
	function colors2(clr, nm) {
		colors1(clr, nm);
		document.write ("<br>");
	}
	</script>
</head>
<body>
	<a href="/">[ На главную ]</a><br>



<br/>16 основных цветов<br/>
	<script language="JavaScript">
 		colors1("#000000", "black");
 		colors1("#808080", "grey");
 		colors1("#c0c0c0", "silver");
 		colors2("#ffffff", "white");
 		colors1("#800000", "maroon");
  		colors1("#ff0000", "red");
 		colors1("#808000", "olive");
 		colors2("#ffff00", "yellow");
 		colors1("#008000", "green");
 		colors1("#00ff00", "lime");
 		colors1("#008080", "teal");
 		colors2("#00ffff", "aqua");
 		colors1("#000080", "navy");
 		colors1("#0000ff", "blue");
 		colors1("#800080", "purple");
 		colors1("#ff00ff", "fuchsia");
	</script>

<br/><br/>ЦВЕТА из ЮКОЗ-ГРАФФИТИ<br/>
	<script language="JavaScript">
 		colors1("#f26520", "");
 		colors1("#f7941d", "");
 		colors1("#fdf202", "");
 		colors1("#00a650", "");
 		colors1("#00a99e", "");
  		colors2("#00adef", "");
 		colors1("#0171bb", "");
 		colors1("#0054a5", "");
 		colors1("#2e3192", "");
 		colors1("#652d92", "");
 		colors1("#8e288e", "");
 		colors2("#ee008c", "");
 		colors1("#ee1157", "");
 		colors1("#9d0a10", "");
 		colors1("#a1410f", "");
 		colors1("#a4620b", "");
 		colors1("#aca000", "");
 		colors2("#588528", "");
 	
	</script>
<br/><br/>Градации серого<br/>
	<script language="JavaScript">
 		colors1("#ffffff", "");
 		colors1("#f1f1f1", "");
 		colors1("#e1e1e1", "");
 		colors1("#d1d1d1", "");
 		colors1("#c2c2c2", "");
 		colors2("#b7b7b7", "");
  		colors1("#acacac", "");
 		colors1("#a0a0a0", "");
 		colors1("#959595", "");
 		colors1("#898989", "");
 		colors1("#7d7d7d", "");
 		colors2("#707070", "");
 		colors1("#626262", "");
 		colors1("#555555", "");
 		colors1("#464646", "");
 		colors1("#363636", "");
 		colors1("#262626", "");
 		colors2("#000000", "");
	</script>
<br/><br/>Цвета с названиями<br/>
	<script language="JavaScript">
 		colors1("#4b0082", "indigo");
 		colors1("#800080", "purple");
 		colors1("#9400d3", "darkviolet");
 		colors2("#8a2be2", "blueviolet");
 		colors1("#ffd700", "gold");
 		colors1("#e6e6fa", "lavender");
 		colors1("#dcdcdc", "gainsboro");
 		
	</script>
<br/><br/>Цвета тремя цифрами кратными трём<br/>
	<script language="JavaScript">
 		colors3();
	</script>

	<a href="/">[ На главную ]</a><br>
	
</body>
</html>