<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
	include "../../includes/library/myLibrary.inc";
	include "pessoasInc.inc";	?>

  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css">

	<link rel="stylesheet" type="text/css" href="../../includes/jquery-ui-1.11.4.custom/jquery-ui.css">
	<script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
  <script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/jquery-ui.js" charset="utf-8"></script>
  
	<script type="text/javascript" src="../../includes/js/FW_v2.js" charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/makeGrid.js" charset="utf-8"></script>

  <script type="text/javascript">
		var aguarde_azul = "<img src=\"../../imagens/aguarde_azul.gif\" />";
		
		function getDocHeight() {
			var D = document;
			return Math.max(
					D.body.scrollHeight, D.documentElement.scrollHeight,
					D.body.offsetHeight, D.documentElement.offsetHeight,
					D.body.clientHeight, D.documentElement.clientHeight
			);
		}
		function getDocWidth()  {
			var D = document;
			return Math.max(
					D.body.scrollWidth, D.documentElement.scrollWidth,
					D.body.offsetWidth, D.documentElement.offsetWidth,
					D.body.clientWidth, D.documentElement.clientWidth
			);
		}
		
		function doSubmit(pIdForm, pPath, pAcao) {
			$("#GEN_ACAO_GERAL").val(pAcao);
			$("#" + pIdForm).attr("action", pPath).submit();
		}
		
		$(function(){
			$(".DIV_CONTEUDO").css({"height": (getDocHeight() - 75) + "px"});
			
			$("#DIV_CONTEUDO_FILTRO").css({"width": "270px"});
			$("#DIV_CONTEUDO_GRID").css({"width": (getDocWidth() - 320) + "px"});
			
		});
		//=============================================================================================================
		
		var DIV_FORM_MODAL_FILTRO;
		
		function ativarFiltroModal() 	 {
			DIV_FORM_MODAL_FILTRO = $("#DIV_FORM_MODAL").dialog({
					autoOpen: false,
						height: (getDocHeight() - 100),
						 width: (getDocWidth() - 400),
						 modal: true,
			 beforeClose: function( event, ui ) {
				 							$(".DIV_MODELO_LABEL_CLASS").attr("style", "width: 95%; float: none");
				            },
					 buttons: [{
							 text: "Ok",
							click: function() {
								aplicarFiltro();
							}
					 },
					 {
							 text: "Cancelar",
							click: function() {
								$(this).dialog("close");
							}
					 }]
			});

			var DIV_EMPTY = true;
			try {DIV_EMPTY = !$.trim( $("#DIV_FORM_MODAL_OPC_CONTENT").html())} catch(e) {alert("HERE!!!");}

			if(DIV_EMPTY == true) {
				$("#DIV_FORM_MODAL").html(aguarde_azul);
				$("#GEN_DOC_HEIGHT").val(getDocHeight());
				doSubmit("formGrid", "indexFiltroHidden.php", "FILTRO_FORM");

			} else {
				$(".DIV_MODELO_LABEL_CLASS").attr("style", "width: auto; float: left");
				DIV_FORM_MODAL_FILTRO.dialog({title: "ADICIONAR FILTROS"}).dialog("open");
				
			}
		}
		function setFiltroModal(pHtml) {
			DIV_FORM_MODAL_FILTRO.dialog({title: "ADICIONAR FILTROS"}).dialog("open");
						
			$("#DIV_FORM_MODAL").html(pHtml);
			$("#DIV_FORM_MODAL_OPC").accordion();
			$("#TD_FORM_MODAL_OPC_LEFT").attr("style", "width: 300px;");
			$("#TD_FORM_MODAL_OPC_RIGHT").attr("style", "width: " + (getDocWidth() - 300) + "px;");
			
		}
		function setFiltroContent(pID) {
			var arrayId   = new String(pID).split("|");
			var modeloAux = $("#DIV_MODELO_LABEL").html();
			var labelID   = arrayId[5];
			
			modeloAux = modeloAux.replace("__ID_FILTRO_LABEL__", arrayId[0]);
			modeloAux = modeloAux.replace("__ID_FILTRO_LABEL__", arrayId[0]);
			modeloAux = modeloAux.replace("__CLASS__", arrayId[1] + " DIV_MODELO_LABEL_CLASS");
			modeloAux = modeloAux.replace("__NAME__", arrayId[2]);
			modeloAux = modeloAux.replace("__ID__", arrayId[3]);
			modeloAux = modeloAux.replace("__DESCRICAO__", arrayId[4]);
			modeloAux = modeloAux.replace("__ID_LABEL__", arrayId[5]);

			$("#DIV_FORM_MODAL_OPC_CONTENT").append(modeloAux);
			$("#" + labelID).hide();
			
		}
		function aplicarFiltro() 			 {
			$("#DIV_CONTEUDO_FILTRO_LABELS").html($("#DIV_FORM_MODAL_OPC_CONTENT").html());
			$(".DIV_MODELO_LABEL_CLASS").attr("style", "width: 95%; float: none")
			
			DIV_FORM_MODAL_FILTRO.dialog("close");
			$("#DIV_CONTEUDO_GRID").html(aguarde_azul);
			doSubmit("formGrid", "indexFiltroHidden.php", "MAKE_GRID");

		}
		//=============================================================================================================
				
		var DIV_FORM_MODAL_CRUD_PESSOA, DIV_IFRAME_MODAL_CRUD_PESSOA;
		
		function ativarFormModalPessoas() {
			var GEN_DOC_HEIGHT  = (getDocHeight() - 100),
				  GEN_DOC_WIDTH   = (getDocWidth()  - 450),
					CRUD_PESSOA_SRC = "pessoas.php?" +
					                  "GEN_DOC_HEIGHT=" + GEN_DOC_HEIGHT + "&"+
					                  "GEN_DOC_WIDTH="  + GEN_DOC_WIDTH;

			DIV_FORM_MODAL_CRUD_PESSOA = $("#DIV_FORM_MODAL").dialog({
				autoOpen: false,
				  height: GEN_DOC_HEIGHT,
					 width: GEN_DOC_WIDTH,
					 modal: true,
			});
			
			DIV_FORM_MODAL_CRUD_PESSOA.dialog({title: "GÊNESIS: EDIÇÃO DE PESSOAS"}).dialog("open");

			DIV_IFRAME_MODAL_CRUD_PESSOA = $("<iframe>", {
				        src: CRUD_PESSOA_SRC,
				         id: "DIV_IFRAME_MODAL_CRUD_PESSOA",
				frameborder: 0,
						 height: GEN_DOC_HEIGHT,
						  width: GEN_DOC_WIDTH,
				  scrolling: "no"
			});
			
			$("#DIV_FORM_MODAL").html(DIV_IFRAME_MODAL_CRUD_PESSOA);
		}
		
		
  </script>
  
  <style type="text/css">
		body {
			  margin-left: 0px; 
			   margin-top: 0px; 
			 margin-right: 0px; 
			margin-bottom: 0px; 
			     overflow: hidden;
	 background-color: #DFDFFF;
		}
		
		#DIV_FORM_MODAL {
			  margin: 0px;
			 padding: 0px;
			overflow: hidden;
		}
		
		.GEN_CELULA_FILTRO_01 {
			padding: 2.5px; 
			margin: 2.5px; 
			color: #000; 
			background-color: #C4E1FF;
			cursor: pointer;
		}
	</style>
  
</head><body onLoad="ativarFormModalPessoas()"><?php 
$printHeadParam = "
<table border='0' cellspacing='0' cellpadding='0' style='width: 100%; margin-top: 10px;'>
<tr><td valign='top' width='90%'>
	<div class='semMargPadd' align='center' style='color: #FFF; font-size: 20px'>
		G&nbsp;E&nbsp;S&nbsp;T&nbsp;&Atilde;&nbsp;O
		&nbsp;&nbsp;D&nbsp;E&nbsp;&nbsp;
		P&nbsp;E&nbsp;S&nbsp;S&nbsp;O&nbsp;A&nbsp;S
	</div>
	
</td><td valign='middle' align='center'>
	<a href='../index.php' class='semMargPadd' style='font-style:normal; color:#FFF; font-size: 14px'>
		Retornar
	</a>
</td></tr>
</table>";

imprimirCabecalho($printHeadParam);?>

<form id="formGrid" name="formGrid" method="post" target="iframeGeral">
  <table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td valign="top">
  	<div id="DIV_CONTEUDO_FILTRO" class="DIV_CONTEUDO">
    	<input type="button" id="ativarFiltro" value="ativarFIltro" onClick="ativarFiltroModal()" />&nbsp;
      <input type="button" id="ativarFormModalPessoas" value="ativarFormModalPessoas" onClick="ativarFormModalPessoas()" />
      <div id="DIV_CONTEUDO_FILTRO_LABELS"></div>
    </div>
    
  </td><td valign="top">
    <div id="DIV_CONTEUDO_GRID" class="DIV_CONTEUDO"></div>
    
  </td></tr>
  </table>
  
  <input type="hidden" id="GEN_ACAO_GERAL" name="GEN_ACAO_GERAL" />
  <input type="hidden" id="GEN_DOC_HEIGHT" name="GEN_DOC_HEIGHT" />
</form>

<div id="DIV_FORM_MODAL"></div>

<div style="top:70%; position: absolute; width: 100%; display: block">
  <iframe id="iframeGeral" name="iframeGeral" style="width: 95%; height: 150px;"></iframe>
</div>

</body></html>