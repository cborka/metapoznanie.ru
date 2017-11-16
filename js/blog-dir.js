
	var ids = 0;
	var idss = 0;
	var beg = 0;
	var per_page = 3;
	var num_all = 0;
	var curr_ids = "";
	var ost = 0;


	var gCatId = "";
	var gTxtId = "";
	var gCommId = "";

	function writeOK()
	{ 
		document.getElementById("err").innerHTML = xmlhttp.responseText;
	};
	function writeOK2()
	{ 
		document.getElementById("err2").innerHTML = xmlhttp.responseText;
	};

	//
	// Получить список ид текстов через запятую
	//
	function getIds() 
	{ 
//		alert("--"+xmlhttp.responseText);
		idss = xmlhttp.responseText;
		ids = idss.split(",");
//		ids = xmlhttp.responseText.split(",");
		beg = 0;
//		per_page = 3;
		num_all = ids.length;
        if (idss.trim() == "") {
			num_all = 0;
		}
//		alert("Всего записей в <"+idss.trim()+">: "+num_all);
		if (ids[0] == "") 
		{
			num_all = 0;
			ids[0] = "0";
		}
		curr_ids = "";
		ost = 0;
		
		document.getElementById("msg").innerHTML = " записей: "+num_all;
//		"-"+xmlhttp.responseText+"["+ids+"]"+
//		mes("Всего записей: "+num_all);
	};
	function get_txt_ids() 
	{
		onOK=getIds;
//		onOK=writeOK; 
//		alert(document.getElementById("cat").value+","+document.getElementById("tag").value);
	
		var params = 
			'&mode=' + encodeURIComponent("get_txt_ids")+
			'&cat=' + encodeURIComponent(document.getElementById("cat").value)+
			'&tag=' + encodeURIComponent(document.getElementById("tag").value)
		;
					 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
		
		return false;
    }

	//
	// Показать тексты как блог
	//
	function textsShow() 
	{ 
//	alert(xmlhttp.responseText);
		document.getElementById("cats").innerHTML += xmlhttp.responseText;
	};
	function show_texts() // Вывожу очередную порцию текстов (по три штуки)
	{
		ero("");
		
		if(num_all == 0)	return false;
		
		onOK=textsShow;
		
		curr_ids = "";
		ost = num_all - beg; // Осталось
		if (ost > per_page) ost = per_page;
		
		for(i=1; i<ost; i++)
		{
			curr_ids = curr_ids + ids[beg++] + ",";	
		}
		curr_ids = curr_ids + ids[beg++];	

//		document.getElementById("cats").innerHTML += "ids="+curr_ids+".<br/>";

		if (curr_ids == "undefined")
			return false;

		var params = 
			'&ssnick=' + encodeURIComponent(document.getElementById("ssnick").innerHTML)+
			'&mode=' + encodeURIComponent("show_blog")+
			'&ids=' + encodeURIComponent(curr_ids)
		;
//alert(params);		 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
		
		return false;
    }
    
	function show_txt(tid) // Вывожу отдельный текст
	{
		ero("");
		onOK=textsShow;
		
		var params = 
			'&mode=' + encodeURIComponent("show_text")+
			'&ids=' + encodeURIComponent(tid)
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
		return false;
    }
	function aboutShow() 
	{ 
		document.getElementById("about").innerHTML = xmlhttp.responseText;
	};
	function show_about(tid) // Вывожу краткую инфу о тексте
	{
		ero("");
		onOK=aboutShow;
		
		var params = 
			'&mode=' + encodeURIComponent("show_about")+
			'&ids=' + encodeURIComponent(tid)
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
		return false;
    }

//============================ КОММЕНТАРИИ === BEGIN ==========================
	//
	// Получить список ид комментариев к заданному тексту через запятую
	// тут можно использовать те же переменные, что и для вывода каталога текстов, 
	// т.к. они используются на разных страничках
	//
	function getCommIds() 
	{ 
//		document.getElementById("msg").innerHTML = "=== Комментариев: 100500";

		idss = xmlhttp.responseText;
		ids = idss.split(",");
		beg = 0;
		num_all = ids.length;
//alert ("<"+ids[0]+">");
		if (ids[0].trim() == "") 
		{
			num_all = 0;
			ids[0] = "0";
		}
		curr_ids = "";
		ost = 0;
		
		document.getElementById("msg").innerHTML = "Комментариев: "+num_all; //+": "+idss;
	};
	function get_comm_ids() 
	{
		onOK=getCommIds;
	
		var params = 
			'&mode=' + encodeURIComponent("get_comm_ids")+
			'&tid=' + encodeURIComponent(document.getElementById("tid").value)
		;

		q_is_async = false; 
		doquery ("/php/do-comments.php", params, deftimeout);
		
		return false;
    }

	//
	// Показать комментарии
	//
	function commsShow() 
	{ 
		document.getElementById("comments").innerHTML += xmlhttp.responseText;
	};
	function show_comms() // Вывожу очередную порцию текстов (по три штуки)
	{
		ero("");
		onOK=commsShow;
		per_page = 7;
		
		curr_ids = "";
		ost = num_all - beg; // Осталось
		if (ost > per_page) ost = per_page;
		
		for(i=1; i<ost; i++)
		{
			curr_ids = curr_ids + ids[beg++] + ",";	
		}
		curr_ids = curr_ids + ids[beg++];	

//		document.getElementById("cats").innerHTML += "ids="+curr_ids+".<br/>";

		if (curr_ids == "undefined")
			return false;

		var params = 
			'&mode=' + encodeURIComponent("show_comms")+
			'&ids=' + encodeURIComponent(curr_ids)
		;
//alert(params);		 
		q_is_async = false; 
		doquery ("/php/do-comments.php", params, deftimeout);
		
		return false;
    }

    //
    // Удалить указанный комментарий
    //
	function writeOKComm()
	{ 
		document.getElementById("ercomm"+gCommId).innerHTML = xmlhttp.responseText;
	};
	function del_comm(comm_id)
	{
		onOK=writeOKComm;
		gCommId = comm_id;
		document.getElementById("ercomm"+gCommId).innerHTML = '';
		
		if (! confirm("Bы действительно хотите УДАЛИТЬ этот комментарий? Да?"))
			return;
		
		var params = 
			'&mode=' + encodeURIComponent("delete_comm")+
			'&comm_id=' + encodeURIComponent(comm_id)+
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)
		;
				 
		q_is_async = false; 
		doquery ("/php/do-comments.php", params, deftimeout);

		return;
	}   

//============================ КОММЕНТАРИИ === END ============================
      
	//
	// Обновить список выбора категорий
	//
	function catShow()
	{ 
		document.getElementById("cat").innerHTML = xmlhttp.responseText;
	};
	function refresh_cats() 
	{
		onOK=catShow;

		document.getElementById("cat").innerHTML = "";

		var params = 
			'&mode=' + encodeURIComponent("select")
		 ;
		q_is_async = false; 
		doquery ("/php/do-cats.php", params, deftimeout);
		
		return false;
    }

	//
	// Обновить список выбора ТЭГов
	//
	function tagShow()
	{ 
		document.getElementById("tag").innerHTML = xmlhttp.responseText;
	};
	function refresh_tags() 
	{
		onOK=tagShow;

		document.getElementById("tag").innerHTML = "";

		var params = 
			'&mode=' + encodeURIComponent("selecttag")
		 ;
		q_is_async = false; 
		doquery ("/php/do-cats.php", params, deftimeout);
		
		return false;
    }
    
    //
    // Удалить указанный текст
    //
	function del_txt(txt_id)
	{
		onOK=writeOK;
		
		if (! confirm("Bы действительно хотите УДАЛИТЬ этот текст?"))
			return;
		
		var params = 
			'&mode=' + encodeURIComponent("delete_txt")+
			'&txt_id=' + encodeURIComponent(txt_id)+
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);

		if (document.getElementById("err").innerHTML.slice(0, 1) == "-")
			document.getElementById("del"+txt_id).innerHTML = document.getElementById("err").innerHTML;

		return;
	}   
	
	//
	// Показать каталог текстов в виде таблицы
	//
	function dirShow()
	{ 
		document.getElementById("cats").innerHTML = xmlhttp.responseText;
	};
	function show_dir() 
	{
		ero("");
		onOK=dirShow;
		
		var params = 
			'&mode=' + encodeURIComponent("show_dir")+
			'&cat=' + encodeURIComponent(document.getElementById("cat").value)+
			'&tag=' + encodeURIComponent(document.getElementById("tag").value)
			'&passwd=' + encodeURIComponent(document.getElementById("passwd").value)
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
		
		return false;
    }
    
	//
	// Показать все выбранные ид текстов
	//
	function get_all_ids() 
	{
		oke(ids);
		return;
		
//		onOK=getIds;
		onOK=writeOK; 
		
		var params = 
			'&mode=' + encodeURIComponent("get_all_cat_ids")+
			'&cat=' + encodeURIComponent(document.getElementById("cat").value)
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
    }

	//
	// Показать цепочку категорий до заданной
	//
	function cats_chain()
	{ 
		document.getElementById("cats_chain").innerHTML = xmlhttp.responseText;
	};
  	function get_cats_chain() 
	{
		onOK=cats_chain; 
//	alert(encodeURIComponent(document.getElementById("cat").value));
		
		var params = 
			'&mode=' + encodeURIComponent("get_cats_chain")+
			'&cat=' + encodeURIComponent(document.getElementById("cat").value)
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
    }
  	function get_cats_chain_for_txt(txt_id) 
	{
		onOK=cats_chain; 
//		alert(txt_id+'!')
		var params = 
			'&mode=' + encodeURIComponent("get_cats_chain_for_txt")+
			'&txt_id=' + encodeURIComponent(txt_id);
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
    }
	function catsAbout()
	{ 
		document.getElementById("cats_about").innerHTML = xmlhttp.responseText;
	}
  	function show_cats_about(txt_id) 
	{
		onOK=catsAbout; 
		var params = 
			'&mode=' + encodeURIComponent("get_cats_about")+
			'&txt_id=' + encodeURIComponent(txt_id);
		;
			 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
    }

	//
	// Программный выбор тэга
	//
	function change_tags(tag_name)
	{
//		alert(tag_name+'!')
		document.getElementById("tag").value = tag_name;
		refresh_dir();
	}

	//
	// Программный выбор категории, например при нажатии на ссылку выбора категории
	//
	function change_cats(cat_name)
	{
		document.getElementById("cat").value = cat_name;
		refresh_dir();
	}
	
  	//
  	// Обновить каталог в соответствии с выбранными Категорией и ТЭГом
  	//
  	function refresh_dir() 
	{
		document.location.href = 
			"/"+document.getElementById("cat").value+
			"?"+document.getElementById("tag").value;
		return;
	}
	
	//
	// Показать каталог текстов в виде таблицы
	//
	function tagsCloudShow()
	{ 
		document.getElementById("tagcloud").innerHTML = xmlhttp.responseText;
	};
	function show_tags1() 
	{
		ero("");
		onOK=tagsCloudShow;
//		alert(idss);
		var params = 
			'&mode=' + encodeURIComponent("show_tags1")+
			'&idss=' + encodeURIComponent(idss)+
			'&cat=' + encodeURIComponent(document.getElementById("cat").value)+
			'&tag=' + encodeURIComponent("")
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
		
		return false;
    }

	//
	// Показать категории в виде дерева
	//
	function catsCloudShow()
	{ 
		document.getElementById("catcloud").innerHTML = xmlhttp.responseText;
	};
	function show_cats1() 
	{
		ero("");
		onOK=catsCloudShow;
//		alert(idss);
		var params = 
			'&cat=' + encodeURIComponent(document.getElementById("cat").value)+
			'&mode=' + encodeURIComponent("show_cats1")
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
		
		return false;
    }
    
    //
	// Показать подкатегории указанной категории
	//
	function subcatsShow()
	{ 
		document.getElementById("cat"+gCatId).innerHTML = xmlhttp.responseText;
	};
	function show_subcats(cat_id, shft) 
	{
		ero("");
		
		xx = document.getElementById("cat"+cat_id).innerHTML;
//		alert(cat_id + "---" + xx + "---" + shft);
		if (xx != " ") 
		{
			document.getElementById("cat"+cat_id).innerHTML = " ";
			return false;
		}
		
		onOK=subcatsShow;
		
		gCatId = cat_id;
//alert(cat_id+"-"+document.getElementById("cat").innerHTML);				 
		var params = 
			'&catm=' + encodeURIComponent(document.getElementById("cat").innerHTML)+
			'&cat=' + encodeURIComponent(cat_id)+
			'&shft=' + encodeURIComponent(shft)+
			'&mode=' + encodeURIComponent("show_subcats")
		;

		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
		
		return false;
    }
    
    //
	// Установка переменной СЕССИИ
	//
	function svShow()
	{ 
//		alert(xmlhttp.responseText);
	};
	function SetSV(nm, val) //SetSessionVariable
	{
		onOK=svShow;
		
		var params = 
			'&nm=' + encodeURIComponent(nm)+
			'&val=' + encodeURIComponent(val)+
			'&mode=' + encodeURIComponent("set_sv")
		;

		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);

		return false;
    }


    //
	// ФИЛЬТРА ПО ДАТЕ И ПОРЯДОК СОРТИРОВКИ
	//
  	function SetDtb() { SetSV('dtb',document.getElementById("dtb").value); };
  	function SetDte() { SetSV('dte',document.getElementById("dte").value); };
  	function SetSrtt() { SetSV('srtt',document.getElementById("srtt").value); };
  	function SetSrtk() { SetSV('srtk',document.getElementById("srtk").value); };

	function init_dt()
	{ 
	var today = new Date();
		document.getElementById("dtb").value = '2014-04-24'; SetDtb()
		document.getElementById("dte").value = formatYYYYMMDD(today); SetDte()
		document.getElementById("srtt").value = 'Новые'; SetSrtt();
//		document.getElementById("srtk").value = 'СКомментариями'; SetSrtk();
		
		refresh_dir()
	};
	
    //
	// ОЦЕНИТЬ ТЕКСТ
	//
	function lktUpd()
	{ 
		document.getElementById("like"+gTxtId).innerHTML = xmlhttp.responseText;
	};
   	function lkt(tid, lk) 
	{
		onOK=lktUpd; 
	
		gTxtId = tid;
		var params = 
			'&mode=' + encodeURIComponent("like_txt")+
			'&like=' + encodeURIComponent(lk)+
			'&txt_id=' + encodeURIComponent(tid);
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
    }
    //
	// ОЦЕНИТЬ КОММЕНТАРИЙ
	//
	function lkcUpd()
	{ 
		document.getElementById("likec"+gTxtId).innerHTML = xmlhttp.responseText;
	};
   	function lkc(tid, lk) 
	{
		onOK=lkcUpd; 
	
		gTxtId = tid;
		var params = 
			'&mode=' + encodeURIComponent("like_comm")+
			'&like=' + encodeURIComponent(lk)+
			'&txt_id=' + encodeURIComponent(tid);
		;
				 
		q_is_async = false; 
		doquery ("/php/do-blog-dir.php", params, deftimeout);
    }
