//
// Функции для асинхронного обращения к серверу
// сначала файл назывался blog-editor.js
//
function getXmlHttp(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}

var xmlhttp = getXmlHttp();
var deftimeout = 3000;
var q_executed = true;
var q_is_async = true; 
var q_count = 0;

//
//Проверка готовности
//
xmlhttp.onreadystatechange=function()
{
	if (xmlhttp.readyState != 4) 
	{
		return;
	}

	clearTimeout(timeout); // очистить таймаут при наступлении readyState 4
	q_executed = true;
	
	if (xmlhttp.status == 200) // Все ок
	{
		onOK();
	} 
	else 
	{
		handleError("xmlhttp: "+xmlhttp.statusText); // вызвать обработчик ошибки с текстом ответа
	}
}

//
// Таймаут 
//
onTimeout=function()
{ 
	xmlhttp.abort();

	if (query_executed)
		mes("Поспешай не спеша.");
	else
		handleError("Time over. Время вышло.") 
};  

//
// Запуск асинхронного запроса на выполнение
//
function doquery (phpscript, params, millisec)
{
//	oke(q_is_async);
	q_count = q_count + 1;
	q_executed = false;
	
	timeout = setTimeout(onTimeout, millisec);
	xmlhttp.open("POST", phpscript, q_is_async); 
	xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
	xmlhttp.send(params);
	q_is_async = true;
}


// var timeout = setTimeout(onTimeout, 5000);

//
// Если ошибка
//
function handleError(message) 
{
	//document.getElementById("err").innerHTML = "Ошибка: "+message;
	ero("Ошибка: "+message);
}

function ero(msg) {	document.getElementById("err").innerHTML = "<span class='err'>"+msg+"</span>"; }
function oke(msg) {	document.getElementById("err").innerHTML = "<span class='oke'>"+msg+"</span>"; }
function mes(msg) {	document.getElementById("err").innerHTML = "<span class='mes'>"+msg+"</span>"; }


//========================================================

function insert_tag(obj_name, tag_b, tag_e)
{
var area=document.getElementsByName(obj_name).item(0);

// Mozilla и другие НОРМАЛЬНЫЕ браузеры
// ЕСЛИ есть что-либо выделенное, ТО
	if (document.getSelection)
	{ 
		if (tag_e == "")
		{
			area.value=
			area.value.substring(0,area.selectionStart)+
			tag_b+ 
//			area.value.substring(area.selectionStart, area.selectionEnd)+ 
//			tag_e+
			area.value.substring(area.selectionEnd,area.value.length);
		}
		else
		{
			area.value=
			area.value.substring(0,area.selectionStart)+
			tag_b+ 
			area.value.substring(area.selectionStart, area.selectionEnd)+ 
			tag_e+
			area.value.substring(area.selectionEnd,area.value.length);
		}
	}
// Иначе заплатка для Internet Explorer
	else
	{ // берем текст
		var selectedText=document.selection.createRange().text;
 // ЕСЛИ имеется какой-то выделенный текст, ТО
		if (selectedText!='')
		{
			if (tag_e == "")
				var newText=tag_b+selectedText+tag_e;
			else
				var newText=tag_b;
				
			document.selection.createRange().text=newText;
		}
		else
		{
			if (document.selection) 
			{ //For browsers like IE
				var obj=document.getElementsByName(obj_name).item(0);
				obj.focus();
				sel = document.selection.createRange();
				sel.text = tag_b+tag_e;
				obj.focus();
			}
		}
	}
}// insert_tag


//========================================================

//
// Вывод JS-даты в формате mySQL
//
function formatDate(date1) {
  return date1.getFullYear() + '-' +
    (date1.getMonth() < 9 ? '0' : '') + (date1.getMonth()+1) + '-' +
    (date1.getDate() < 10 ? '0' : '') + date1.getDate() 

     + ' ' +
    (date1.getHours() < 10 ? '0' : '') + date1.getHours() + ':' +
    (date1.getMinutes() < 10 ? '0' : '') + date1.getMinutes() + ':' +
    (date1.getSeconds() < 10 ? '0' : '') + date1.getSeconds() 
    ;
}
function formatYYYYMMDD(date1) {
  return date1.getFullYear() + '-' +
    (date1.getMonth() < 9 ? '0' : '') + (date1.getMonth()+1) + '-' +
    (date1.getDate() < 10 ? '0' : '') + date1.getDate()
    ;
}

//
// Делаю URL из строки, перевожу всё в нижний латинский регистр игнорируя некоторые символы,
// пробелы заменяю на тире
//
function mkURL (rs) 
{
	// Взял с интернета 
	var A = new Array(); 
        A["Ё"]="yo";A["Й"]="i";A["Ц"]="ts";A["У"]="u";A["К"]="k";A["Е"]="e";
        A["Н"]="n";A["Г"]="g";A["Ш"]="sh";A["Щ"]="sch";A["З"]="z";A["Х"]="h"; 
        A["ё"]="yo";A["й"]="i";A["ц"]="ts";A["у"]="u";A["к"]="k";A["е"]="e";
        A["н"]="n";A["г"]="g";A["ш"]="sh";A["щ"]="sch";A["з"]="z";A["х"]="h"; 
        A["Ф"]="f";A["Ы"]="i";A["В"]="v";A["А"]="a";A["П"]="p";A["Р"]="r";
        A["О"]="o";A["Л"]="l";A["Д"]="d";A["Ж"]="zh";A["Э"]="e"; 
        A["ф"]="f";A["ы"]="i";A["в"]="v";A["а"]="a";A["п"]="p";A["р"]="r";
        A["о"]="o";A["л"]="l";A["д"]="d";A["ж"]="zh";A["э"]="e"; 
        A["Я"]="ya";A["Ч"]="ch";A["С"]="s";A["М"]="m";A["И"]="i";A["Т"]="t";A["Б"]="b";A["Ю"]="yu"; 
        A["я"]="ya";A["ч"]="ch";A["с"]="s";A["м"]="m";A["и"]="i";A["т"]="t";A["б"]="b";A["ю"]="yu"; 
        A["a"]="a";A["A"]="a";A["b"]="b";A["B"]="b";A["c"]="c";A["C"]="c";A["d"]="d";A["D"]="d";
        // а это я добавил
        A["e"]="e";A["E"]="e";A["f"]="f";A["F"]="f";A["g"]="g";A["G"]="g";A["h"]="h";A["H"]="h";
        A["i"]="i";A["I"]="i";A["j"]="j";A["J"]="j";A["k"]="k";A["K"]="k";A["l"]="l";A["L"]="l";
        A["m"]="m";A["M"]="m";A["n"]="n";A["N"]="n";A["o"]="o";A["O"]="o";A["p"]="p";A["P"]="p";
        A["q"]="q";A["Q"]="q";A["r"]="r";A["R"]="r";A["s"]="s";A["S"]="s";A["t"]="t";A["T"]="t"; 
        A["u"]="u";A["U"]="U";A["V"]="v";A["v"]="v";A["w"]="w";A["W"]="w";A["x"]="x";A["X"]="x";
        A["y"]="y";A["Y"]="y";A["z"]="z";A["Z"]="z";
        A[" "]="-";A["_"]="-";  
        A["1"]="1";A["2"]="2";A["3"]="3";A["4"]="4";A["5"]="5";A["6"]="6";A["7"]="7";A["8"]="8";
        A["9"]="9";A["0"]="0"; 

	
	var s = "-"; // задаю тип строка
	var s = rs;
	var n = s.length;
	
	if (n > 64) n = 64;
	
	var ls = "";
	for(i=0; i<n; i++){
		if (typeof A[s[i]] != 'undefined') {
		  ls = ls + A[s[i]];	
		}
//		else { ls = ls + "-"; } // игнорирую некоторые символы
	}
    return ls;	
}

