	function setFiltroCheck(pClass)					{
		try {
			$("." + pClass).each(function() {
				$(this).prop("checked", !($(this).is(":checked")));
			});
		} catch(e){}
	}
	function newAlert(text, tipe, posit) 		 {
		if(tipe == "")  tipe  = "info"
		if(posit == "") posit = "top"
		
		$.notice(text, {
			container: "body",
				 height: 30,
				timeout: 1700,
					level: tipe,
				 anchor: posit
		});
	}
	function doSubmit(pIdForm, pPath, pAcao) {
		if(pAcao != "") $("#GEN_ACAO_GERAL").val(pAcao);
		$("#" + pIdForm).attr("action", pPath).submit();
	}
	function fecharAguardeModal()            {
		DIV_AGUARDE_MODAL.dialog("close");
	}