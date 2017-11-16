// В АРХИВ
// Здесь функции для асинхронного обращения к серверу
// Похоже, что файл нужен только для справки
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

//
// Проверка готовности
//
xmlhttp.onreadystatechange=function()
{
  if (xmlhttp.readyState != 4) 
  {
  //	alert("xmlhttp.readyState != 4");
  	return;
  }

  clearTimeout(timeout); // очистить таймаут при наступлении readyState 4

  if (xmlhttp.status == 200) // Все ок
  {
//    alert(xmlhttp.responseText);
	document.getElementById("time").innerHTML = xmlhttp.responseText;

  } 
  else 
  {
      handleError(">>>>>"+xmlhttp.statusText); // вызвать обработчик ошибки с текстом ответа
  }
}

//
// Таймаут
//
onTimeout=function()
{ 
	xmlhttp.abort();
	handleError("Time ooover") 
}; 

//var timeout = setTimeout(onTimeout, 5000);

// var timeout = setTimeout(onTimeout, 5000);

//
// Если ошибка
//
function handleError(message) {
document.getElementById("err").innerHTML = "=Ошибка: "+message;
//  alert("=Ошибка: "+message)
}


