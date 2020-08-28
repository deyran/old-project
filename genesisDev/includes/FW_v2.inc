<%
FW_V2_null = "]|.NULL.|["
function drawTitle(pTitle, pClass, pCss)'______________________[
	if(pClass = "") then pClass = "titleField"%>
	<div class="<%=pClass%>" style="<%=pCss%>" align='left'><%=pTitle%></div><%
end function']
function FW_V2_componenteHtml(pTipo, pId, pTitulo, pVarFunc)'__[
	if(len(pId) = 0) then 
		response.write("O campo <strong>'pId'</strong> é obrigatório!!")
		response.end()
		
	end if
	'-----------------------------------------------------------------------------------------

	dim FW_V2_tipoCom, FW_V2_value, FW_V2_descricao, FW_V2_optionList, FW_V2_dica, _
	    FW_V2_cssTitulo, FW_V2_css, FW_V2_cssRelat, FW_V2_funcBlur, FW_V2_funcHidden, _
			FW_V2_mascara, FW_V2_maxLength, FW_V2_descNome, FW_V2_startIN, FW_V2_selectNome, _
			FW_V2_cssDivContent

	'-----------------------------------------------------------------------------------------
	
	dim tipoComp, varFuncAux, varFunc
	
	tipoComp = pTipo
	if(pTipo = "") then tipoComp = "TEXT"
	
	varFunc = "FW_V2_tipoCom=" & tipoComp & "|" & pVarFunc
	'-----------------------------------------------------------------------------------------
	
	if(len(trim(pVarFunc)) = 0)then
		response.write("A variável <strong>pVarFunc</strong> " & _
		               "deve ser devidamente preenchida!!!")
		response.end()
	end if
	
	'response.write(varFunc)
	'response.End()
		 
	if(inStr(varFunc, "FW_V2_css")       	= 0) then varFunc = varFunc & "|FW_V2_css="
	if(inStr(varFunc, "FW_V2_value")     	= 0) then varFunc = varFunc & "|FW_V2_value="
	if(inStr(varFunc, "FW_V2_cssRelat")  	= 0) then varFunc = varFunc & "|FW_V2_cssRelat="

	if((pTipo <> "CHECK") and (pTipo <> "RADIO")) then
		if(inStr(varFunc, "FW_V2_dica")   	 = 0)  then varFunc = varFunc & "|FW_V2_dica="
		if(inStr(varFunc, "FW_V2_mascara")   = 0)  then varFunc = varFunc & "|FW_V2_mascara="		
		if(inStr(varFunc, "FW_V2_maxLength") = 0)  then varFunc = varFunc & "|FW_V2_maxLength="		
		if(inStr(varFunc, "FW_V2_funcBlur")  = 0)  then varFunc = varFunc & "|FW_V2_funcBlur="	
		if(inStr(varFunc, "FW_V2_funcHidden")	= 0) then varFunc = varFunc & "|FW_V2_funcHidden="
	  if(inStr(varFunc, "FW_V2_hddValue")  	= 0) then varFunc = varFunc & "|FW_V2_hddValue="
		
	else
		if(inStr(varFunc, "FW_V2_hddValue")  	= 0) then varFunc = varFunc & "|FW_V2_hddValue=false"
		
	end if
		
	if(tipoComp = "AUTO") then'__[
		if(inStr(varFunc, "FW_V2_startIN") = 0)   	  then varFunc = varFunc & "|FW_V2_startIN=3"
		if(inStr(varFunc, "FW_V2_descricao") = 0) 	  then varFunc = varFunc & "|FW_V2_descricao="
		if(inStr(varFunc, "FW_V2_selectNome") = 0)	  then varFunc = varFunc & "|FW_V2_selectNome="
		if(inStr(varFunc, "FW_V2_cssDivContent") = 0) then varFunc = varFunc & "|FW_V2_cssDivContent="		
		
	']
	end if	
	'-----------------------------------------------------------------------------------------
			
	varFuncArr0 = null
	varFuncArr1 = split(varFunc, "|")

	dim k, varFuncRedit
	
	varFuncRedit = ""
	
	for k = 0 to uBound(varFuncArr1)
		if(len(trim(varFuncArr1(k))) > 0) then
			varFuncAux = replace(varFuncArr1(k), "=", "=""") & """"
		
			if(varFuncRedit <> "") then varFuncRedit = varFuncRedit & "|"
			varFuncRedit = varFuncRedit & varFuncArr1(k)
		
			execute varFuncAux
			'response.write("<br />" & varFuncAux)
			'response.end()
		end if
	next
	
	varFunc = varFuncRedit
	'-----------------------------------------------------------------------------------------
	
	if(FW_V2_cssRelat = "") then FW_V2_cssRelat = FW_V2_css	
	
	if(tipoComp = "AUTO") then'___________________________[
		if(len(FW_V2_descNome) = 0) then 
			response.write("O campo <strong>'FW_V2_descNome'</strong> é obrigatório!!")
			response.end()
			
		end if

		if(len(FW_V2_funcHidden) = 0) then 
			response.write("O campo <strong>'FW_V2_funcHidden'</strong> é obrigatório!!")
			response.end()
			
		end if
	']
	elseif((pTipo = "CHECK")or(pTipo = "RADIO")) then'____[
		if(inStr(varFunc, "FW_V2_checked") = 0) then 
			response.write("O campo <strong>'FW_V2_checked (true/false)'</strong> é obrigatório!!")
			response.end()
			
		end if
		
		if(len(FW_V2_value) = 0) then 
			response.write("O campo <strong>'FW_V2_value'</strong> é obrigatório!!")
			response.end()
			
		end if

		if(len(FW_V2_descricao) = 0) then 
			response.write("O campo <strong>'FW_V2_descricao'</strong> é obrigatório!!")
			response.end()
			
		end if

		if(len(FW_V2_checked) = 0) then 

			response.write("O campo <strong>'FW_V2_checked (true/false)'</strong> é obrigatório!!")
			response.end()
			
		end if
	']
	elseif((pTipo = "TEXT_AREA")or(pTipo = "READ")) then'_[
		FW_V2_value = unEscape(FW_V2_value)']
	end if
	'-----------------------------------------------------------------------------------------
		
	dim classComp
	classComp = "FW_V2_container"
	if(pTitulo <> "") then classComp = "FW_V2_containerMargin"
	'-----------------------------------------------------------------------------------------
	
	dim idArr, nomeComp, idComp
	idArr = split(pId, "|")
	
	if(uBound(idArr) > 0) then
		idComp = trim(idArr(0))
		nomeComp = trim(idArr(1))

	else
		idComp   = trim(pId)
		nomeComp = trim(pId)
		
	end if
	'-----------------------------------------------------------------------------------------%>
	
	<div id="FW_V2_DIV_CONTAINER_<%=idComp%>" style="padding: 0px; margin: 0px"><%
		if(pTitulo <> "") then%>
			<div id="FW_V2_TITULO_<%=idComp%>" class="FW_V2_Titutlo" <%
			if(FW_V2_cssTitulo <> "") then%> style=" <%=FW_V2_cssTitulo%>" <%end if%>><%=pTitulo%></div><%
		end if
		
		if(FW_V2_value <> "") then'__[
			if(pTipo = "TEXT_AREA") then
				valueTextAux = replace(trim(FW_V2_value), "  "  , "&nbsp;&nbsp;")
				valueTextAux = replace(valueTextAux, vbCrLf, "<br />")
				
			elseif(pTipo = "SELECT") then
				valueTextAux = FW_V2_descricao
			
			elseif(pTipo = "AUTO") then
				valueTextAux = FW_V2_descricao
				
				if(FW_V2_descricao = "") then 
					valueTextAux = "<span class='FW_V2_content_dica'>" & FW_V2_dica & "</span>"
				end if

			elseif(pTipo = "FLOAT") then
				valueTextAux = FW_V2_value
				if(FW_V2_value <> "") then FW_V2_value = replace(FW_V2_value, ",", ".")
				
			else
				valueTextAux = FW_V2_value
				
			end if
			
		else
			if(FW_V2_dica <> "") then
				valueTextAux = "<span class='FW_V2_content_dica'>" & FW_V2_dica & "</span>"
				
			else
				valueTextAux = "<div>&nbsp;<br /></div>"
				
			end if

		end if']
		if(valueTextAux = "") then'__[
			'valueTextAux = "<div>&nbsp;<br /></div>"
			
			if(FW_V2_dica <> "") then 
				valueTextAux = "<span class='FW_V2_content_dica'>" & FW_V2_dica & "</span>"	
			end if
				
		end if']		
		
		if(pTipo = "READ") then'______________________________[
			valueTextAux = FW_V2_value
			if(FW_V2_descricao <> "") then valueTextAux = FW_V2_descricao%>
			
			<div id="FW_V2_TEXT_<%=idComp%>" 
			style="color: #000000; <%=FW_V2_cssRelat%>" class="<%=classComp%>"><%=valueTextAux%></div><%
		
		']
		elseif(pTipo = "AUTO") then'__________________________[
			dim FW_V2_MYPATH, FW_V2_HTTP_X_FORWARDED_HOST, FW_V2_MYPATH_IMAGE
			
			FW_V2_MYPATH_IMAGE = ""
			FW_V2_MYPATH = "http://" & request.serverVariables("SERVER_NAME") & "/"
			FW_V2_HTTP_X_FORWARDED_HOST = request.serverVariables("HTTP_X_FORWARDED_HOST")
			
			if(FW_V2_HTTP_X_FORWARDED_HOST <> "") then
				FW_V2_SERVER_NAME = HTTP_X_FORWARDED_HOST
				FW_V2_MYPATH = "http://" & FW_V2_SERVER_NAME & "/sgestord/"
				
			end if
			
			FW_V2_MYPATH_IMAGE = FW_V2_MYPATH & "imagens/"%>
			
			<div id="FW_V2_A_CONTENT_<%=idComp%>" class="FW_V2_content" style="display: block;" 
			onmouseover="$('#FW_V2_DIV_CONTAINER_<%=idComp%>').addClass('tdGridAuto');" 
			onmouseout ="$('#FW_V2_DIV_CONTAINER_<%=idComp%>').removeClass('tdGridAuto');">
				<table border="0" cellspacing="0" cellpadding="0">
				<tr><td>
					<div id="FW_V2_TEXT_<%=idComp%>" style="cursor:auto; <%=FW_V2_cssRelat%>;" class="<%=classComp%>">
						<%=valueTextAux%>
					</div>
					
				</td>
				<td style="padding-left: 4px">
					<a href="/editar" class="FW_V2_content"
						onfocus="FW_V2_apenasNada(); return false;"
						onmouseup="FW_V2_apenasNada(); return false;"
						onmousedown="FW_V2_apenasNada(); return false;"
						onclick="FW_V2_componenteHtml('<%=idComp%>'); return false;">
						<img src="<%=FW_V2_MYPATH_IMAGE%>nodes/lupa.gif" border="0" />
					</a>
				</td></tr>
				</table>
				
			</div>
			<div id="FW_V2_COMP_<%=idComp%>" class="<%=classComp%>"></div>
			
			<input type="hidden" id="<%=idComp%>" name="<%=nomeComp%>" value="<%=FW_V2_value%>" />
			<input type="hidden" id="hdd_info_<%=idComp%>" value="<%=varFunc%>" /><%
			
		']
		elseif((pTipo = "CHECK") or (pTipo = "RADIO")) then'__[
			dim tipoCheckRadio
			tipoCheckRadio = "checkbox"
			if(pTipo = "RADIO") then tipoCheckRadio = "radio"%>

			<div id="FW_V2_TEXT_<%=idComp%>" class="<%=classComp%> FW_V2_content"
			style=" <%=FW_V2_cssRelat%>"><%
				FW_V2_checkedAux = "&nbsp;"
				if(FW_V2_checked = "true") then FW_V2_checkedAux = "•"%>
				<table border="0" cellspacing="0" cellpadding="0">
				<tr><td style="width: 10px">
						<div id="FW_V2_DIV_CONTENT|<%=idComp%>|<%=FW_V2_value%>" class="FW_V2_DIV_CONTENT_<%=nomeComp%>" 
						style="width: 20px;  height: 18px; font-size: 16px;" align="center"><%=FW_V2_checkedAux%></div>
				</td><td>
					<div onclick="FW_V2_checkRadioHtml('<%=idComp%>', '<%=nomeComp%>', '<%=tipoCheckRadio%>'); return false;">
				 	<%=FW_V2_descricao%></div>
				</td></tr>
				</table>
			</div>
			<div id="FW_V2_COMP_<%=idComp%>" class="FW_V2_COMP_<%=nomeComp%>"></div><%
			
		']
		else'_________________________________________________[%>
			<div id="FW_V2_A_CONTENT_<%=idComp%>" style="display: block;">
				<a href="#/editar" class="FW_V2_content" style="display: block;" 
				
				onmouseover="$('#FW_V2_DIV_CONTAINER_<%=idComp%>').addClass('tdGridAuto');" 
				onmouseout ="$('#FW_V2_DIV_CONTAINER_<%=idComp%>').removeClass('tdGridAuto');" 
				
				onclick="FW_V2_apenasNada(); return false;"
				onmouseup="FW_V2_apenasNada(); return false;"
				onmousedown="FW_V2_apenasNada(); return false;"
				

				onfocus="setTimeout(function(){FW_V2_componenteHtml('<%=idComp%>'); return false;}, 100)">
					<div id="FW_V2_TEXT_<%=idComp%>" style="display: block; <%=FW_V2_cssRelat%>;" class="<%=classComp%>" 
					onclick="FW_V2_componenteHtml('<%=idComp%>'); return false;"><%=valueTextAux%></div>
				</a>
			</div>
			<div id="FW_V2_COMP_<%=idComp%>" class="<%=classComp%>"></div>

			<input type="hidden" id="<%=idComp%>" name="<%=nomeComp%>" value="<%=FW_V2_value%>" />
			<input type="hidden" id="hdd_info_<%=idComp%>" value="<%=varFunc%>" /><%
		']
		end if%>
		
	</div><%

end function']
%>