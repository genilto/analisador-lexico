// BUSCA OBJETOS NO DOCUMENTO

function GetObject(obj){
	if (document.getElementById) {
		return document.getElementById(obj);
	} else if (document.all) {
		return document.all[obj];
	}
}

// MOSTRA MENSAGEM DE CARREGANDO
function showLoadBar(show){
	if(show){
		GetObject("wait").style.display = "";
		GetObject("codigo").disabled = "true";
	}else{
		GetObject("wait").style.display = "none";
		GetObject("codigo").disabled = "";
	}
}

// INICIA INSTÂNCIA XMLHTTP
function ajaxInit(){
	
	var http_request = false;

	if (window.XMLHttpRequest) { // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
		if (http_request.overrideMimeType) {
        	http_request.overrideMimeType('text/html');
            // See note below about this line
		}
	} else if (window.ActiveXObject) { // IE
		try {
			http_request = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try {
				http_request = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e) {
				http_request = false;
			}
		}
	}
	return http_request;
}

// FAZ A REQUISIÇÃO E VALIDA A PALAVRA DIGITADA
function efetuaAnaliseLexica(codigo){

	// Mostra a barra Carregando.
	showLoadBar(true);
	
	var http_request = ajaxInit();
	
	if (!http_request) {
		return false;
	}

	http_request.open("POST", "analiseLexica.php", true);
	http_request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=iso-8859-1");
	http_request.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
	http_request.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
	http_request.setRequestHeader("Pragma", "no-cache");
	
	http_request.send("codigo="+encodeURIComponent(codigo));
	
	http_request.onreadystatechange = function(){
		if(http_request.readyState == 4) {
			if(http_request.responseText){
				// Carrega o div com o conteúdo recebido
				GetObject("status").innerHTML = http_request.responseText;
				// Oculta a barra Carregando.
				showLoadBar(false);
			}else{
				// Oculta a barra Carregando.
				showLoadBar(false);
				return false;
			}
		}
	}
	return true;
}

// CHAMA AS FUNÇÕES CONFORME SUPORTE DE BROWSER
function analisar(codigo){
	if(!efetuaAnaliseLexica(codigo)){
		alert("Erro ao efetuar análise.\nTalvez seu navegador não tenha suporte a Ajax.");
	}
}