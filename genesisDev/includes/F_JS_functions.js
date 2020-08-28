	var FW_PATH_IMAGE = "http://" + window.location.host + "/genesis/imagens/";	

//FW_createAutoComplete__[
	var OLD_CASE = "";
	function FW_doSubmit(pUrl, pAcao)       					{
		OLD_CASE = $("#ACAO_CASE").val();
		
		document.getElementById("frmGeral").action = pUrl;
		document.getElementById("ACAO_CASE").value = pAcao;
		
		document.getElementById("frmGeral").submit();
		$("#ACAO_CASE").val(OLD_CASE);
	
	}
	function FW_autoComplete(pNome, pEvent) 					{
		var inputText = document.getElementById(pNome);
		var hdd_path = document.getElementById("hdd_path_" + pNome).value;
		var hdd_case = document.getElementById("hdd_case_" + pNome).value;
		
		var keynum = (pEvent.keyCode ? pEvent.keyCode : pEvent.which);
	
		if(((keynum == 8) || (keynum == 46)) && (inputText.value.length == 0)) {
			$("#" + $("#hdd_id_" + pNome).val()).val("");
			FW_fecharAutoComplete(pNome);
			return;
			
		}
	
		if(((keynum >= 48) && (keynum <= 90))  || 
			 ((keynum >= 97) && (keynum <= 122)) || (keynum == 8)) {
	
			inputText.value = inputText.value.replace("&", "%");
			inputText.value = inputText.value.replace("*", "%");
			inputText.value = inputText.value.replace("'", "´");
	
			if(inputText.value.length > 1) {
				$("#" + pNome).addClass("autoCompleteClass");
				FW_doSubmit(hdd_path, hdd_case);
				
			} else {
				$("#" + pNome).removeClass("autoCompleteClass");	
				
			}
			
		} else if(inputText.value.length == 0) {
			$("#" + pNome).removeClass("autoCompleteClass");	
			FW_fecharAutoComplete(pNome);
			
		}
	}
	function FW_fecharAutoComplete(pNome)   					{
		if($("#" + $("#hdd_id_" + pNome).val()).val().length == 0) {
			$("#" + pNome).val("");
			$("#div_" + pNome).hide();
			
		} else {
			$("#div_" + pNome).hide();
			
		}
		
		$("#" + pNome).removeClass("autoCompleteClass");
		
	}  
	function FW_divInnerHML(pNome, pInnerHML)					{
		$("#div_" + pNome).html(pInnerHML).show();
		$("#" + pNome).removeClass("autoCompleteClass");	
	
	}
	function FW_AplicarAutoComplete(pNome, pId, pText){
		$("#" + pNome).val(pText);
		$("#div_" + pNome).hide();
		
		$("#" + $("#hdd_id_" + pNome).val()).val(pId);
		
	}
	function FW_autoCompleteBlur(pNome)               {
		if($("#" + $("#hdd_id_" + pNome).val()).val().length == 0) {
			$("#" + pNome).val("");
			FW_fecharAutoComplete(pNome);
		}
	}
//]
//FW_makeGrid____________[
	var FW_IMAGE_GRID = FW_PATH_IMAGE;
	
	function FW_gridCheck(pId)           	          {
		try {
			$(".checkIdGridClass_" + pId).each(function() {
				$(this).prop("checked", !($(this).is(":checked")));
			});
		} catch(e){}
	}
	function FW_gridSubmit(pId)											{
		var hdd_path  = $("#HDD_" + pId + "_PATH");
	
		document.getElementById("frmGeral").action = hdd_path.val();
		document.getElementById("frmGeral").submit();
		
	}
	function FW_gridDeleteRow(pIdTBody)             {
		try{ $("#" + pIdTBody).remove(); } catch(e){}
		
	}	
	function FW_gridAtivarFiltro(pId)  	            {
		var hdd_filtro  = $("#HDD_" + pId + "_FILTRO");
		
		if(hdd_filtro.val() == "close") {
			$(".DIV_" + pId + "_FILTRO_CLASS").show();
			hdd_filtro.val("open");
			
			document.getElementById("IMG_FILTRO_" + pId).src = FW_IMAGE_GRID + "removefiltro.gif";
			$(".PRI_GRID_FILTRO").focus();
			
		} else if(hdd_filtro.val() == "open") {
			$(".DIV_" + pId + "_FILTRO_CLASS").hide();
			hdd_filtro.val("close");
			
			document.getElementById("IMG_FILTRO_" + pId).src = FW_IMAGE_GRID + "filtro.gif";
			
			$(".TEXT_" + pId + "_FILTRO_CLASS").val("");
			FW_gridSubmit(pId)
		}

	}
	function FW_gridOrdem(pId, pCampo) 	            {
		var hdd_ordem = $("#HDD_" + pId + "_ORDEM");
		var hdd_campo = $("#HDD_" + pId + "_CAMPO");
		
		if((hdd_ordem.val() == "ASC") || (hdd_ordem.val() == "")) {
			hdd_ordem.val("DESC");
			$("#IMG_" + pCampo + "_CAMPO").attr("src", FW_IMAGE_GRID + "downC.gif");
			
		} else {
			hdd_ordem.val("ASC");	
			$("#IMG_" + pCampo + "_CAMPO").attr("src", FW_IMAGE_GRID + "upC.gif");
			
		}
		
		hdd_campo.val(pCampo);
		$(".DIV_" + pId + "_CAMPO_CLASS").hide();
		$("#DIV_" + pCampo + "_CAMPO").show();
		FW_gridSubmit(pId)
	
	}
	function FW_gridFiltrar(pEvent, pId)             {
		var keynum = (pEvent.keyCode ? pEvent.keyCode : pEvent.which);
		if(keynum == 13) FW_gridSubmit(pId);
		
	}
	function FW_ativarGridAguarde(pNome, pId)				{
		if(pNome == "") return;
		
		var FW_ID_AUX = "#DIV_AGUARDE_" + pNome;
		if(pId != "") FW_ID_AUX += "_" + pId;
	
		$(FW_ID_AUX).toggle();
	
	}
	function FW_gridAplicarFiltro(pId, pTxt, pCampo) {
		$("#HDD_" + pId + "_FILTRO").val("close");
		FW_gridAtivarFiltro(pId);
		
		$("#" + pCampo).val(pTxt);
		FW_gridSubmit(pId)
		
	}
//]


	function FW_imgError(image) {
		image.onerror = "";
		image.src = FW_PATH_IMAGE + "pessoas/perfil.jpg";
		
		return true;
	}	



	function FW_setAbaUi(pId, pIndex) {
		$(pId).accordion({active: pIndex});
	}


	function setMsgRetorno(pIdContent, pIdMsg, pTxtMsg) {
		$("#" + pIdMsg).html(pTxtMsg);
		
		$("#" + pIdContent).fadeIn("slow", function(){
			$(this).delay(3000).fadeOut("slow");
		});
	}	