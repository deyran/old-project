	var FW_IMAGE_GRID = "http://" + window.location.host + "/genesisDev/imagens/";
	
	function FW_gridCheck(pId)           	           {
		try {
			$(".checkIdGridClass_" + pId).each(function() {
				$(this).prop("checked", !($(this).is(":checked")));
			});
		} catch(e){}
	}
	function FW_gridSubmit(pId)											{
		var hdd_path     = $("#HDD_" + pId + "_PATH").val();
		var hdd_formName = $("#HDD_" + pId + "_FORM_NAME").val();

		$("#" + hdd_formName).attr("action", hdd_path).submit();
		
	}
	function FW_gridDeleteRow(pIdTBody)              {
		try{ $("#" + pIdTBody).remove(); } catch(e){}
		
	}	
	function FW_gridAtivarFiltro(pId)  	            {
		var hdd_filtro    = $("#HDD_" + pId + "_FILTRO");
		var FILTRO_UPDATE = $("#HDD_" + pId + "_FILTRO_UPDATE").val();
		
		if(hdd_filtro.val() == "close") {
			$(".DIV_" + pId + "_FILTRO_CLASS").show();
			hdd_filtro.val("open");
			
		} else if(hdd_filtro.val() == "open") {
			$(".DIV_" + pId + "_FILTRO_CLASS").hide();
			hdd_filtro.val("close");
			
			$(".TEXT_" + pId + "_FILTRO_CLASS").val("");
		}
		
		if(FILTRO_UPDATE == "true") {
			FW_gridSubmit(pId);
			
		} else {
			if(hdd_filtro.val() == "open") {
				$(".PRI_" + pId + "_GRID_FILTRO").focus();
			}
			
		}
		
	}
	function FW_gridOrdem(pId, pCampo) 	             { 
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
	function FW_gridResultGrid(pId, pHtml, pDestino) {
		$("#" + pDestino).html(pHtml);
		
		try {
			if($("#HDD_" + pId + "_FILTRO").val() == "open") {
				$(".PRI_" + pId + "_GRID_FILTRO").focus().select();
			}
			
		} catch(e) {
		}
		
	}
	function FW_setFonteStyleDado(pId)               {
		$(".FW_CSS_DADOS").attr("style", "font-size: 15px; font-weight: normal");
		$(".FW_CSS_DADOS_" + pId).attr("style", "font-size: 15px; font-weight: bold");
	}