<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
	include "../../includes/library/myLibrary.inc";
	include "pessoasInc.inc";	?>

  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css">
  <link rel="stylesheet" type="text/css" href="../../includes/jquery-ui-1.11.4.custom/jquery-ui.min.css" />

	<script type="text/javascript" src="../../includes/js/jquery-1.11.3.min.js" charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/jquery-ui.min.js" charset="utf-8"></script>
  
	<script type="text/javascript" src="../../includes/js/FW_v2.js" charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/makeGrid.js" charset="utf-8"></script>

  <script type="text/javascript">
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
		
/*		function filtrarPorGrupo() {
			var valores = "";
			
			if($("#A05_ID_F").val() == FW_V2_null) return;
			
			$("input[name*='A05_ID_FN']").each(function(){
				if(valores != "") valores = valores + ", ";
				valores = valores + $(this).val();
			});
			
			$("#A05_ID_FILTRO").val(valores);
			$("#DIV_AGUARDE_FILTRO").show();
			doSubmit("formGrid", "indexFiltroHidden.php", "MAKE_FILTRO_GRUPO");
		}
*/		
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
		
	</style>
  
</head><body><?php 
$printHeadParam = "
<table border='0' cellspacing='0' cellpadding='0' style='width: 100%; margin-top: 10px;'>
<tr><td valign='top' width='90%'>
	<div class='semMargPadd' align='center' style='color: #FFF; font-size: 20px'>
		G&nbsp;E&nbsp;S&nbsp;T&nbsp;&Atilde;&nbsp;O
		&nbsp;&nbsp;D&nbsp;E&nbsp;&nbsp;
		C&nbsp;I&nbsp;D&nbsp;A&nbsp;D&nbsp;&Atilde;&nbsp;O&nbsp;S
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
<script type="application/javascript">
	var aguarde_azul = "<img src=\"../../imagens/aguarde_azul.gif\" />";
	
	function selectFiltro()      {
		var DIV_ID = "";
		var index  = $("#SEL_FILTRO").val();		
		
		if(index == "") return;
		
		switch(index) {
			case "0": DIV_ID = "#DIV_CONTEUDO_FILTRO_GRUPO";      break;
			case "1": DIV_ID = "#DIV_CONTEUDO_FILTRO_LOCALIDADE"; break;
			case "2": DIV_ID = "#DIV_CONTEUDO_FILTRO_DATA_NASC";  break;
		}
	
		$(".DIV_CONTEUDO_FORM").hide();
		if(DIV_ID != "") $(DIV_ID).show();
	}
	function selectFiltroGrupo() {
		if($("#A05_ID_FILTRO").val() == FW_V2_null) return;
		
		$("#GEN_ACAO_GERAL").val("MAKE_FILTRO_GRUPO");
		$("#DIV_CONTEUDO_FILTRO_GRUPO_AGUARDE").html(aguarde_azul);		
		$("#formGrid").attr("action", "indexFiltroHidden.php").submit();
		
	}
</script>
  
  
    <div id="DIV_CONTEUDO_FILTRO" class="DIV_CONTEUDO">
      <table border="0" cellspacing="0" cellpadding="0">
      <tr><td valign="top" nowrap><?php
				FW_V2_drawTitle("Filtrar por: &nbsp;", "font-size: 14px; color:#000 ");?>
        
      </td><td valign="bottom"><?php 
				$OPTIONS = "
				<option></option>
				<option value='0'>Grupo de pessoas</option>
				<option value='1'>Localidade</option>
				<option value='2'>Data nascimento</option>";
				
				FW_V2_componenteHtml(
					array(
						"FW_V2_CSSTITULO"  => "",
						"FW_V2_IDCOMP"     => "SEL_FILTRO",
						"FW_V2_TIPOCOM"    => "SELECT",
						"FW_V2_FUNCBLUR"   => "selectFiltro()",
						"FW_V2_OPTIONLIST" => rawurlencode($OPTIONS),
						"FW_V2_DICA"       => "Clique aqui para selecionar",
					)
				);?>
      </td></tr>
      </table><br /><?php
			
			makeFiltroGrupo();?>
    	<div id="DIV_CONTEUDO_FILTRO_LOCALIDADE" class="DIV_CONTEUDO_FORM" style="display: none;">DIV_CONTEUDO_FILTRO_LOCALIDADE</div>
    	<div id="DIV_CONTEUDO_FILTRO_DATA_NASC"  class="DIV_CONTEUDO_FORM" style="display: none;">DIV_CONTEUDO_FILTRO_DATA_NASC</div>
			<div id="DIV_CONTEUDO_ITENS"><?php
			
			
			
			?>
    </div>
    
  </td><td valign="top">
    <div id="DIV_CONTEUDO_GRID" class="DIV_CONTEUDO"></div>
    
  </td></tr>
  </table>
  
  <input type="hidden" id="GEN_ACAO_GERAL" name="GEN_ACAO_GERAL" />
</form>

<div style="top:70%; position: absolute; width: 100%; display: block">
  <iframe id="iframeGeral" name="iframeGeral" style="width: 95%; height: 150px;"></iframe>
</div>

</body></html>