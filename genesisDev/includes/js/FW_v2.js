	var FW_V2_timeout = null;
	var FW_V2_null    = "]|.NULL.|[";
	var FW_V2_keyCode = null;
	var FW_V2_valAux  = "<DIV>&nbsp;<BR></DIV>";
	
	function FW_V2_checkRadioHtml(pId, pNome, pTipo) {
		var nomeComp              = "FW_V2_" + pNome;
		var FW_V2_checkRadioClass = pTipo + "_" + pNome;
		var FW_V2_hasClass        = $(".FW_V2_DIV_CONTENT_" + pNome).find("." + FW_V2_checkRadioClass).length;
		
		if(FW_V2_hasClass == 0) {
			var valAcc   = "";
			var setCheck = true;
			//==================================================================
						
			$(".FW_V2_DIV_CONTENT_" + pNome).each(function() {
				DIV_CONTENT  = $(this).attr("id");
				DIV_CONTENTH = $(this).html();
				checkRadioID = DIV_CONTENT.split("|")[1];
				checkRadioVL = DIV_CONTENT.split("|")[2];
				//---------------------------------------------------------------
				
				componente = "<input " + 
				             "  type='" + pTipo        					 + "'" + 
				             "  name='" + nomeComp     					 + "'" + 
				             "    id='" + checkRadioID 					 + "'" + 
				             " value='" + checkRadioVL 					 + "'" + 
				             " class='" + FW_V2_checkRadioClass  + "'";
				//---------------------------------------------------------------	
	
				if((setCheck == true) && (DIV_CONTENTH == ".")) {
					if(valAcc != "") valAcc += ", ";
					valAcc += checkRadioVL;
					
					componente += " checked='checked'";
				}	
				componente += " >";			
				//---------------------------------------------------------------

				if(pTipo == "radio") {
					setCheck = false;
					
				} else if(pTipo == "checkbox") {
					setCheck = true;
					
				}
				//---------------------------------------------------------------
								
				$(this).html(componente);
			});
			//==================================================================
			
			var componenteVal  = null;
			var FW_V2_elements = $(".FW_V2_COMP_" + pNome);
			
			componenteVal = $("<input>").attr({
				type: "hidden",
				name: pNome
			}).val(valAcc);
			
			
			FW_V2_elements.eq(FW_V2_elements.length-1).html(componenteVal);
			//==================================================================
			
			if(FW_V2_timeout != null)	clearTimeout(FW_V2_timeout);
			FW_V2_timeout = setTimeout(function(){FW_V2_checkRadioToText(pNome)}, 2000);
			
		} else 
		if(FW_V2_hasClass > 0)  {
			if(pTipo == "checkbox") {
				$("#" + pId).attr("checked", !($("#" + pId).attr("checked")));
				
			} else {
				$("#" + pId).prop("checked", true);
				
			}
			
			if(FW_V2_timeout != null)	{
				clearTimeout(FW_V2_timeout);
				FW_V2_timeout = setTimeout(function(){FW_V2_checkRadioToText(pNome)}, 2000);
			}
			
		}
	}
	function FW_V2_checkRadioToText(pNome)           {
		var valAcc = "";
		
		$(".FW_V2_DIV_CONTENT_" + pNome).each(function() {
			valAux     = "&nbsp;";
			componente = $($(this).html());
			
			if(componente.is(":checked")) {
				if(valAcc != "") valAcc += ", ";
				valAcc += componente.val();
				
				valAux = ".";	
			}
			
			$(this).html(valAux);

		});
		//==============================================================
		
		if(valAcc == "") valAcc = FW_V2_null;
		//==============================================================
		
		var componenteVal = $("<input>").attr({
					type: "hidden",
					name: pNome
				}).val(valAcc);
		
		var FW_V2_elements = $(".FW_V2_COMP_" + pNome);
		
		FW_V2_elements.eq(FW_V2_elements.length-1).html(componenteVal);
		
	}
	
	function FW_V2_componenteHtml(pId) 	 		            {
		var tipoComp = null;
		var FW_V2_COMP      = $("#FW_V2_COMP_" + pId);
		var FW_V2_A_CONTENT = $("#FW_V2_A_CONTENT_" + pId);
		var infomCompArr    = $("#hdd_info_" + pId).val().split("|");
		
		for(i = 0; i < infomCompArr.length; i++) {
			if(infomCompArr[i] != "") {
				infomCompArrAux = infomCompArr[i].split("=");
				
				variavelPlot = "var " + infomCompArrAux[0] + " = \"" + infomCompArrAux[1] + "\";";
				try {eval(variavelPlot);} catch(e){alert(variavelPlot + " - " + i);}
			}
		}

		var componente    = null;
		var componenteImg = null;
		var componenteAux = null;
		
		valueCom = FW_V2_value;	
		//----------------------------------------------------------------------------------------------------

		switch(FW_V2_tipoCom) {
			case "TEXT_AREA"://__[
				FW_V2_mascara = "";
				FW_V2_timeoutAux = null;
				//=======================================================================

				componente = $("<textarea>").attr({
					 id: "FW_V2_ID_" + pId
				}).addClass("textbox");
				//=======================================================================
				
				componente
				.keyup(function(e) {
					var key = e.which;
					
					/*if((key != 27) && (key != 9)) {
						if(componenteAux.val() != "")	clearTimeout(componenteAux.val());
						FW_V2_timeoutAux = setTimeout(function(){FW_V2_componenteTexto(pId)}, 2000);
						componenteAux.val(FW_V2_timeoutAux);
					}*/
					
				})
				.keydown(function(e) {
					var key = e.which;
					
					if(key == 27) {//esc
						FW_V2_retornarTexto(pId, FW_V2_tipoCom);
						
					} else if(key == 9) {//tab
						FW_V2_componenteTexto(pId);
						
					}
					
				})
				.blur(function(){
					$("#" + pId).val($("#FW_V2_TEXT_" + pId).html());												 	
					FW_V2_componenteTexto(pId);
				
				});
									
				break;
			//]
			case "SELECT"://_____[
				FW_V2_mascara = "";
				//==========================================================
									
				componente = $("<select>").attr({
					 id: "FW_V2_ID_" + pId
				}).addClass("textbox");
				//==========================================================
				
				if(FW_V2_funcHidden == "") {
					componente.html(decodeURIComponent(FW_V2_optionList.replace(/\+/g, "%20")));
					if(FW_V2_value != "") componente.val(FW_V2_value);
					
				} else {
					componente.empty().html("<option selected>AGUARDE ...</option>");
					$("FW_V2_ID_" + pId + " option:eq(0)").prop("selected", true);
					
					setTimeout(FW_V2_funcHidden, 100);
					
				}
				//==========================================================
				
				FW_V2_keyCode = null;
				
				componente.keydown(function(e) {
					FW_V2_keyCode = e.which;
					
					if((FW_V2_keyCode == 13) || (FW_V2_keyCode == 27)) {
						$(this).blur();
						
					} else {
						FW_V2_keyCode = null;	
						
					}
					
				});	
				componente.change(function() {
					FW_V2_keyCode == 13;
					$(this).blur();
					
				});
				componente.blur(function(e)	   {
					if(FW_V2_keyCode == 27) {
						FW_V2_retornarTexto(pId, FW_V2_tipoCom);
						
					} else if((FW_V2_keyCode == 13) || 
					          (FW_V2_keyCode == 9)  || 
									  (FW_V2_keyCode == null)) {
						FW_V2_componenteTexto(pId);
						
					}
					
					FW_V2_keyCode = null;
					
				});				
				
				break;
			//]
			case "AUTO"://_______[
				componente = $("<input>").attr({
					 type: "text",
						 id: "FW_V2_ID_"   + pId,
					 name: FW_V2_descNome
				})
				.attr("autocomplete", "off")
				.addClass("textbox")
				.attr("style", "padding-right: 4px;");
				//==========================================================
				
				componenteAux = $("<input>").attr({
					 type: "hidden",
						 id: "hdd_auto_mouseOver_" + pId
				}).val("false");
				//==========================================================					
				
				var pathImg = location.protocol + "//" + location.hostname + 
						"/genesisDev/imagens/nodes/cinza-cross.gif";

				componenteImg = $("<img>").attr({
					id: "FW_V2_ID_IMG_" + pId,
				 src: pathImg
				 
				})
				.attr("title", "Clique aqui para fechar")
				.attr("style", "border: 1px solid transparent")
				.addClass("FW_V2_imgDateAuto")
				.mouseover(function(){
					$(this).attr("style", "border: 1px solid #666666");
					 
				})
				.mouseout(function(){
					$(this).attr("style", "border: 1px solid transparent");
				})
				.click(function(){
					FW_V2_fecharDivAuto(pId);
				})
				//==========================================================					


				componente
				.keyup(function(e)    {
					var keyOk         = null;
					var keynum        = e.which;
					var numCaracteres = $(this).val().length;
					var startIN       = parseInt(FW_V2_startIN);
					

					keyOk  = ((keynum >= 48) && (keynum <= 57)); // 0  to 9
					keyOk  = keyOk || ((keynum >= 65 ) && (keynum <= 90)); // 65 to 90
					keyOk  = keyOk ||  (keynum == 188);		// , <
					keyOk  = keyOk ||  (keynum == 8  ); 	// Backspace
					keyOk  = keyOk ||  (keynum == 46 ); 	// Delete
					keyOk  = keyOk ||  (keynum == 16 ); 	// shift
					keyOk  = keyOk || ((keynum >= 190) && (keynum <= 192)); // . > / ? ` ~
					keyOk  = keyOk || ((keynum >= 219) && (keynum <= 222)); // [ { \ | ] } ' "
					
					
					if(keynum == 16) return false;
					if((keynum != 32) && (keynum != 40)) $(".FW_V2_DIV_AUTO_CLASS_" + pId).remove();

					
					if(keynum == 40) {
						$("#hdd_auto_mouseOver_" + pId).val("true");
						try {
							$("#" + FW_V2_selectNome).focus();
							
						} catch(e){
							alert("Verifique se a varável FW_V2_selectNome e o <SELECT> tem o ID IGUAIS!!!");
						}
					}
					
					
					if((keyOk == true) && (numCaracteres >= startIN)) {
						$("#FW_V2_COMP_" + pId)
							.append(FW_V2_construirDivAuto(pId, FW_V2_cssDivContent));

						eval(FW_V2_funcHidden);
						
					} 
					
				})
				.keydown(function(e)  {
					var key = e.which;
					var numCaracteres = $(this).val().length;
					
					if(key == 13) {
						if($(this).val() == "")	{
							FW_V2_componenteTexto(pId);
							
						} else {
							FW_V2_fecharDivAuto(pId);	
						}

					} else if((key == 27) || (key == 9)) {
						FW_V2_fecharDivAuto(pId);
					
					}

				})
				.keypress(function(e) {
					var key = e.which;
					if(key == 13) return false;

				})
				.blur(function(e)     {
					if($("#hdd_auto_mouseOver_" + pId).val() == "false") {
						FW_V2_fecharDivAuto(pId);
					}
				});
				
				break;
			//]
			case "DATE"://_______[
				var pathImg = location.protocol + "//" + location.hostname + 
											"/genesisDev/imagens/icons/calendar.gif";
											
				FW_V2_mascara = "99/99/9999";
				if(FW_V2_css == "") FW_V2_css = "width: 70px";
				//=================================================================
				
				componente = $("<input>").attr({
					 type: "text",
						 id: "FW_V2_ID_" + pId
				})
				.attr("autocomplete", "off")
				.addClass("textbox")
				.attr("style", "padding-right: 4px;")
				.css("text-align", "right");
				//=================================================================
				
				componenteAux = $("<input>").attr({
					 type: "hidden",
						 id: "hdd_bloqueio_data_" + pId
				}).val("false");
				//=================================================================					

				componenteImg = $("<img>").attr({
					id: "FW_V2_ID_IMG_" + pId,
				 src: pathImg
				 
				})
				.attr("title", "Selecione uma data")
				.addClass("FW_V2_imgDateAuto")
				.click(function(){ 
					//Por alguma razão só funciona assim, 
					//chamando duas vezes a função
					FW_V2_calendarioUI(pId); 
					FW_V2_calendarioUI(pId);
					
				}).mouseover(function() {
					$("#hdd_bloqueio_data_" + pId).val("true");
						
				}).mouseout(function() {
					$("#hdd_bloqueio_data_" + pId).val("false");
						
				});
				//=================================================================

				
				FW_V2_keyCode = null;
				
				componente.keydown(function(e) {
					FW_V2_keyCode = e.which;
					
					if((FW_V2_keyCode == 13) || (FW_V2_keyCode == 27)) {
						$("#hdd_bloqueio_data_" + pId).val("false");
						$(this).blur();
						
					} else {
						FW_V2_keyCode = null;	
						
					}
					
				});	
				componente.blur(function(e)	   {
					if($("#hdd_bloqueio_data_" + pId).val() == "true") return;
					
					if(FW_V2_keyCode == 27) {
						FW_V2_retornarTexto(pId, FW_V2_tipoCom);
						
					} else if((FW_V2_keyCode == 13) || 
					          (FW_V2_keyCode == 9)  || 
									  (FW_V2_keyCode == null)) {
						FW_V2_componenteTexto(pId);
						
					}
					
					FW_V2_keyCode = null;
					
				});				


				break;
			//]
			
			case "TEXT":  case "HOUR": 
			case "FLOAT": case "INT":  
			case "PASSWORD"://___[
				var tipoAux = "password";
				if(FW_V2_tipoCom != "PASSWORD") tipoAux = "text"
				
				componente = $("<input>").attr({
					 type: tipoAux,
						 id: "FW_V2_ID_" + pId
				}).attr("autocomplete", "off").addClass("textbox");
				//==========================================================					
				
				componenteAux = $("<input>").attr({
					 type: "hidden",
						 id: "hdd_bloqueio_" + pId
				}).val("false");
				//==========================================================
				
				if(FW_V2_tipoCom == "FLOAT") {
					FW_V2_mascara = "";
					valueCom = FW_V2_replaceChar(valueCom, ".", ",");
					componente.css("text-align", "right");

					componente.keyup(function()   {
						var checkOK = "0123456789-,";
						FW_V2_formataNumber(document.getElementById($(this).attr("id")), checkOK);																		
					});
	
				} else if(FW_V2_tipoCom == "INT") {
					FW_V2_mascara = "";
					componente.css("text-align", "right");
					
					componente.keyup(function(e)   {
						var checkOK = "0123456789-";
						FW_V2_formataNumber(document.getElementById($(this).attr("id")), checkOK);
							
					});
					
				} else if(FW_V2_tipoCom == "HOUR") {
					FW_V2_mascara = "99:99";
					FW_V2_maxLength = 5;
				
				}
				//==========================================================					
				
				componente.keydown(function(e) {
					FW_V2_keyCode = e.which;
					
					if((FW_V2_keyCode == 13) || (FW_V2_keyCode == 27)) {
						$(this).blur();
						
					} else {
						FW_V2_keyCode = null;	
						
					}
					
				});	
				componente.blur(function(e)	   {
					if(FW_V2_keyCode == 27) {
						FW_V2_retornarTexto(pId, FW_V2_tipoCom);
						
					} else if((FW_V2_keyCode == 13) || 
					          (FW_V2_keyCode == 9)  || 
									  (FW_V2_keyCode == null)) {
						FW_V2_componenteTexto(pId);
						
					}
					
					FW_V2_keyCode = null;
					
				});				
				
				break;
				//]
			}
		//----------------------------------------------------------------------------------------------------
		
		try {if(FW_V2_css != "")       componente.attr("style", FW_V2_css);           } catch(e){} 
		try {if(FW_V2_mascara != "")   componente.mask(FW_V2_mascara);                } catch(e){} 
		try {if(FW_V2_maxLength != "") componente.attr("maxlength", FW_V2_maxLength); } catch(e){} 
		//----------------------------------------------------------------------------------------------------
			
		if(FW_V2_tipoCom == "DATE") 		 {
			componente
				.val(valueCom)
				.val(valueCom);
				
		} else 
		if(FW_V2_tipoCom == "AUTO") 		 {
			componente.val(FW_V2_descricao);
			
		} else 
		if(FW_V2_tipoCom == "TEXT_AREA") {
			var textAreaValue = new String(unescape(valueCom));

			textAreaValue = textAreaValue.split("&nbsp;&nbsp;").join("  ");
			textAreaValue = textAreaValue.replace(/<br\s*[\/]?>/gi, "\n");
			textAreaValue = FW_V2_replaceChar(textAreaValue, "|", "/");

			componente.val(textAreaValue);
			
		} 
		else {
			if((valueCom.indexOf("<BR></DIV>") >= 0) || 
				 (valueCom.indexOf("<br><div>")  >= 0))	{
				componente.val("");
				
			} else {
				componente.val(valueCom);	
			}

		}
		//----------------------------------------------------------------------------------------------------

		if(componenteImg == null) {
			FW_V2_COMP.html(componente);

		} 
		else {
			var tabela  = $("<table id='FW_V2_TBL_DATA_AUX_" + pId + "' border=\"0\" cellpadding=\"1\" cellspacing=\"0\">");
			var linha   = $("<tr/>");
			var coluna1 = $("<td/>");
			var coluna2 = $("<td/>");
			
			tabela.append(
				linha
					.append(coluna1.append(componente))
					.append(coluna2.append(componenteImg))
			);
			
			FW_V2_COMP.html(tabela);
			
		}
		
		if(componenteAux != null) FW_V2_COMP.append(componenteAux);
		//----------------------------------------------------------------------------------------------------

		FW_V2_A_CONTENT.hide();
		//----------------------------------------------------------------------------------------------------
		
		if(FW_V2_tipoCom == "SELECT") {
			componente.focus();
			
		}	else {
			componente.select();
			
		}

	}
  function FW_V2_componenteTexto(pId) 		             {
		var infomCompArr = $("#hdd_info_" + pId).val().split("|");
		
		for(i = 0; i < infomCompArr.length; i++) {
			if(infomCompArr[i] != "") {
				infomCompArrAux = infomCompArr[i].split("=");
				
				variavelPlot = "var " + infomCompArrAux[0] + " = \"" + infomCompArrAux[1] + "\";";
				try {eval(variavelPlot);} catch(e){alert(variavelPlot + " - " + i);}
			}
		}

		FW_V2_value = $("#" + pId).val();	
		FW_V2_tipoCom = FW_V2_tipoCom;		
		
		var valorComp = $("#FW_V2_ID_" + pId).val();
		//----------------------------------------------------------------------------------------------
		
		var tudoOK = true;
		var valorCompTxt = "";

		if(valorComp == "") {
			validacao    = true;
			
			if(FW_V2_dica != "") {
				valorCompTxt = "<div class='FW_V2_content_dica'>" + FW_V2_dica + "</div>";
			}
			
		} else {
			var validacao = true;
			valorCompTxt  = "";
			
			if(FW_V2_tipoCom == "HOUR")      {
				if(valorComp == "__:__") {
					validacao    = true;
					valorComp    = FW_V2_null;
					
					if(FW_V2_dica != "") valorCompTxt = "<span class='FW_V2_content_dica'>" + FW_V2_dica + "</span>";
					
				} 
				else {
					validacao = FW_V2_isHour(valorComp);
					
					if(validacao == true) {
						valorCompTxt = valorComp;
						
					} else {
						alert("ATENÇÃO!!\n\nA hora '" + valorComp + "' é inválido!!");
						FW_V2_componenteHtml(pId);
						$("#FW_V2_ID_" + pId).val(valorComp).focus().select();
						
					}
				}
				
			} else
			if(FW_V2_tipoCom == "FLOAT")     {
				valorFloat = FW_V2_replaceChar(valorComp, ",", ".");
				validacao  = (!!valorFloat.match(/^-?\d*\.?\d+$/));

				if(validacao == false) {
					alert("ATENÇÃO!!\n\nO valor '" + valorComp + "' é inválido!!");
					FW_V2_componenteHtml(pId);
					$("#FW_V2_ID_" + pId).val(valorComp).focus().select();
					
				} else {
					valorComp    = parseFloat(valorFloat).toFixed(2);
					valorCompTxt = FW_V2_replaceChar(valorComp, ".", ",");
				
				}
				
			} else
			if(FW_V2_tipoCom == "INT")       {
				valorCompTxt = valorComp;
				validacao    = (!!valorComp.match(/^-?\d*\.?\d+$/));

				if(validacao == false) {

					alert("ATENÇÃO!!\n\nO valor '" + valorComp + "' é inválido!!");
					FW_V2_componenteHtml(pId);
					$("#FW_V2_ID_" + pId).val(valorComp).focus().select();
				}
			
			} else
			if(FW_V2_tipoCom == "DATE")      {
				if(valorComp == "__/__/____") {
					valorComp    = "";
					if(FW_V2_dica != "") valorCompTxt = "<span class='FW_V2_content_dica'>" + FW_V2_dica + "</span>";

				} else {
					valorCompTxt = valorComp; 
					validacao = FW_V2_validaData(document.getElementById("FW_V2_ID_" + pId));
		
					if(validacao == false) return false;
				}
				
			} else
			if(FW_V2_tipoCom == "SELECT")    {
				valorCompTxt = $("#FW_V2_ID_" + pId + " option[value='" + valorComp + "']").text();
				
			} else
			if(FW_V2_tipoCom == "AUTO")      {
				valorComp    = $("#" + pId).val();
				valorCompTxt = $("#FW_V2_ID_" + pId).val();
				
			} else
			if(FW_V2_tipoCom == "TEXT_AREA") {
				textAreaValue = new String(valorComp);
				textAreaValue = textAreaValue.split("  ").join("&nbsp;&nbsp;");
				textAreaValue = textAreaValue.replace(/\n/g, "<br />");
				
				valorComp    = textAreaValue;
				valorCompTxt = textAreaValue;
				
			} 
			else {
				valorCompTxt = valorComp;
			}
			
			tudoOK = validacao;
			
		}
		//----------------------------------------------------------------------------------------------
		
		if(tudoOK) {
			try {
				valorComp = FW_V2_replaceChar(valorComp, "'", "´");
				valorComp = FW_V2_replaceChar(valorComp, "\"", "´");
				valorComp = FW_V2_replaceChar(valorComp, "|", "/");
				valorComp = valorComp.replace("]/.NULL./[", FW_V2_null); 
				
			} catch(err) {}
			
			try {
				valorCompTxt = FW_V2_replaceChar(valorCompTxt, "'", "´");
				valorCompTxt = FW_V2_replaceChar(valorCompTxt, "\"", "´");
				valorCompTxt = FW_V2_replaceChar(valorCompTxt, "|", "/");
				
			} catch(err) {}
				
			if(valorComp == "") valorComp = FW_V2_null;
			if(valorCompTxt == "") valorCompTxt = FW_V2_valAux;
			
			$("#" + pId).val(valorComp);
			
			if(FW_V2_tipoCom == "TEXT_AREA") {
				$("#FW_V2_TEXT_" + pId).html(unescape(valorCompTxt));
				
			} else {
				$("#FW_V2_TEXT_" + pId).html(valorCompTxt);
			}
			
		} 
		//----------------------------------------------------------------------------------------------
		
		if(tudoOK) {
			FW_V2_retornarTexto(pId, FW_V2_tipoCom);
		}		
		
		return false;
	}
	function FW_V2_retornarTexto(pId, pTipo)            {
		if($("#FW_V2_ID_" + pId).length == 0) return;
		
		var descricaoAux   = "";
		var hdd_info_acc   = "";
		var FW_V2_funcBlur = "";
		var hdd_info_aux   = null;
		var hdd_info_arr   = $("#hdd_info_" + pId).val().split("|");
				
		for(i = 0; i < hdd_info_arr.length; i++){
			if(hdd_info_arr[i] != "")	{	
				hdd_info_aux = hdd_info_arr[i].split("=");
				
				if(hdd_info_aux[0] == "FW_V2_value") 		{
					if($("#" + pId).val() == FW_V2_null) {
						hdd_info_aux[1] = "";
						
					} else {
						valorAux = $("#" + pId).val();

						if((valorAux.indexOf("<BR></DIV>") >= 0) || 
						   (valorAux.indexOf("<br><div>") >= 0) ||
							 (valorAux.indexOf("FW_V2_content_dica") >= 0)) {
							$("#" + pId).val(FW_V2_null);
							valorAux = "";

						}
						
						hdd_info_aux[1] = valorAux;
						
					}
				}
				if(hdd_info_aux[0] == "FW_V2_funcBlur") {
					FW_V2_funcBlur = hdd_info_aux[1];
				}
		
				if(pTipo == "AUTO") {
					if(hdd_info_aux[0] == "FW_V2_descricao") {
						hdd_info_aux[1] = $("#FW_V2_ID_" + pId).val();
						
					}
				}
				
				if(hdd_info_acc != "") hdd_info_acc += "|";
				hdd_info_acc += hdd_info_aux[0] + "=" + hdd_info_aux[1];
			}
		}

		$("#hdd_info_" + pId).val(hdd_info_acc);
		//----------------------------------------------------------------------------
		
		$("#FW_V2_A_CONTENT_" + pId).show();
		
		if(pTipo == "DATE") {
			$("#FW_V2_TBL_DATA_AUX_" + pId).hide();
			
		} else {
			$("#FW_V2_COMP_" + pId).hide();
			
			setTimeout(function(){
				$("#FW_V2_COMP_" + pId).html("");
				$("#FW_V2_COMP_" + pId).show();
				
			}, 20);
			
		}
		//----------------------------------------------------------------------------
		
		if(FW_V2_funcBlur != "") setTimeout(function(){eval(FW_V2_funcBlur);}, 15);
		//----------------------------------------------------------------------------

		return false;
	}
	function FW_V2_cancelarDivAuto(pId)             		 {
		var FW_V2_ID        = "";
		var FW_V2_DESCRICAO = "";
		var hdd_info_aux    = null;
		var hdd_info_arr    = $("#hdd_info_" + pId).val().split("|");
				
		for(i = 0; i < hdd_info_arr.length; i++){
			if(hdd_info_arr[i] != "")	{	
				hdd_info_aux = hdd_info_arr[i].split("=");
				
				if(hdd_info_aux[0] == "FW_V2_value")     FW_V2_ID        = hdd_info_aux[1];
				if(hdd_info_aux[0] == "FW_V2_descricao") FW_V2_DESCRICAO = hdd_info_aux[1];
								
			}
		}
		
		$("#FW_V2_ID_" + pId).val(FW_V2_DESCRICAO);
		
	}
	function FW_V2_fecharDivAuto(pId)             			 {
		FW_V2_cancelarDivAuto(pId);
		FW_V2_componenteTexto(pId);
		
		$("#FW_V2_ID_IMG_" + pId).remove();
		$("#hdd_auto_mouseOver_" + pId).remove();
		$(".FW_V2_DIV_AUTO_CLASS_" + pId).remove();		

	}
	function FW_V2_aplicarAutoValores(pId, pVal, pDesc) {
		$("#" + pId).val(pVal);
		$("#FW_V2_ID_" + pId).val(pDesc);
		
		FW_V2_componenteTexto(pId);
		
	}
	function FW_V2_construirDivAuto(pId, pCssDivContent){
		if(pCssDivContent == "") {
			pCssDivContent = "border: 1px solid #CCCCCC; padding: 5px; margin-top: 5px;";
		}
		
		var divAuto = $("<div>").attr({
			id: "FW_V2_DIV_AUTO_" + pId
		})
		.mouseover(function(){
			$("#hdd_auto_mouseOver_" + pId).val("true");
		})
		.mouseout(function(){
			$("#hdd_auto_mouseOver_" + pId).val("false");
		})
		.attr("style", pCssDivContent);
		
		return divAuto.html("AGUARDE ...").addClass("FW_V2_DIV_AUTO_CLASS_" + pId);
	}
	function FW_V2_autoAddContent(pId, pHtml)           {
		$("#FW_V2_DIV_AUTO_" + pId).html(pHtml);
		
	}

	function FW_V2_calendarioUI(pId)             			{
		var componente = $("#FW_V2_ID_" + pId);
		
		componente.focus();
		
		componente.datepicker({
					 closeClick: true,
					changeMonth: true,
					 changeYear: true,
					 dateFormat: "dd/mm/yy",
						 dayNames: ["Domingo","Segunda","Terça","Quarta","Quinta","Sexta","Sábado"],
					dayNamesMin: ["D","S","T","Q","Q","S","S","D"],
				dayNamesShort: ["Dom","Seg","Ter","Qua","Qui","Sex","Sáb","Dom"],
					 monthNames: ["Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro"],
			monthNamesShort: ["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],
						 nextText: "Próximo",
						 prevText: "Anterior",
			
			onClose: function() {
				FW_V2_componenteTexto(pId);
				$("#hdd_bloqueio_data_" + pId).val("false");
			}			
				
		});
	}
	function FW_V2_isHour(pVal)                       {
		var isHour = true;
		
		if(/^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(pVal)) {
			isHour = true;			
			
		} else {
			isHour = false;
			
		}
		
		return isHour;		

	}	
	function FW_V2_selectOptionsAdd(pId, pHtml, pVal) {
		var componente = $("#FW_V2_ID_" + pId);
		var decodeHtml = decodeURIComponent(pHtml);
		
		componente.empty().html(decodeHtml);
		if(pVal != "") componente.val(pVal);
		
		return decodeHtml;
		
	}
	function FW_V2_replaceChar(objStr, de, para) 			{
		ch = "";
		AUX = "";

		for(i = 0; objStr.length > i ; i++) {
			ch = objStr.charAt(i);
			if(ch == de) ch = ch.replace(de, para);
	
			AUX += ch;
		}

		return AUX;
	}
	function FW_V2_formataNumber(elm, checkOK)   			{
		var checkStr = String(elm.value);
		var valorNovo = "";
		
		for (i = checkStr.length-1;  i >= 0;  i--) {
			ch = checkStr.charAt(i);
			
			for (j = 0;  j < checkOK.length;  j++)
				if (ch == checkOK.charAt(j))
				
			break;
			
			if (j != checkOK.length)
				valorNovo = ch + valorNovo;
		}
		
		if (checkStr != valorNovo)
		 elm.value = valorNovo;
	}
	function FW_V2_validaData(str)                    {
		//alert(str.value);
		var dia = (str.value.substring(0,2)); 
		var mes = (str.value.substring(3,5)); 
		var ano = (str.value.substring(6,10)); 
	
		//	alert("dia="+dia+" mes="+mes+" ano="+ano);
		var cons = true; 
		
		// verifica se foram digitados números
		if (isNaN(dia) || isNaN(mes) || isNaN(ano)){
			alert("Preencha a data somente com números."); 
			str.value = "";
			str.focus(); 
			return false;
		}
			
			// verifica o dia valido para cada mes 
			if ((dia < 1)||(dia < 1 || dia > 30) && 
			(mes == 4 || mes == 6 || 
			 mes == 9 || mes == 11 ) || 
			 dia > 31) { 
				cons = false; 
		} 
	
		// verifica se o mes e valido 
		if (mes < 1 || mes > 12 ) { 
			cons = false; 
		} 
	
		// verifica se e ano bissexto 
		if (mes == 2 && ( dia < 1 || dia > 29 || 
			 ( dia > 28 && 
			 (parseInt(ano / 4) != ano / 4)))) { 
			cons = false; 
		} 
		
		if (dia == "")
			cons = true
	
		if (cons == false) { 
			alert( "A data inserida não é válida: " + str.value ); 
			return false;
		}
		return true;
	}	
	function FW_V2_apenasNada()          				     {
		return false;
	}