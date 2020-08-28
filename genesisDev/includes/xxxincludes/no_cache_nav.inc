<?php 
header("Content-Type: text/html; charset=UTF-8");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");				// Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");	// always modified
header("Cache-Control: no-store, no-cache, must-revalidate");	// HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");										// HTTP/1.0
//=======================================================================================================

error_reporting (E_ALL ^ E_NOTICE); 

if (!isset($_POST['action'])) {
	//If not isset -> set with dumy value 
	$_POST['action'] = "undefine"; 
}
//=======================================================================================================

$browser            = -1; //'other';
$fatorHeight        = 89.1; //IE
$divBodyRContent    = 83.5;
$fatorWidth         = 80.5;
$divFormContentTop  = 7;
$divFormContentLeft = 18;
$useragent          = $_SERVER['HTTP_USER_AGENT'];

if(preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
	$browser_version = $matched[1];
	$browser         = 0; //'IE';
	$fatorHeight     = 89.7;
	$fatorWidth      = 88.4;
	
} elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
	$browser_version=$matched[1];
	$browser     = 1; //'Opera';
	$fatorHeight = 89.7;
	$fatorWidth  = 88.4;
	
} elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
	$browser_version =$matched[1];
	$browser            = 2; //'Firefox';
	$fatorHeight        = 88.6;
	$fatorWidth         = 79.4;
	$divFormContentTop  = 7;
	$divFormContentLeft = 19;
	$divBodyRContent    = 82.2;
	
} elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
	$browser_version =$matched[1];
	$browser            = 3; //'Chrome';
	$fatorHeight        = 89.4;
	$fatorWidth         = 79.5;
	$divFormContentTop  = 7;
	$divFormContentLeft = 18;
	$divBodyRContent    = 83.3;	
	
} elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
	$browser_version = $matched[1];
	$browser         = 4; //'Safari';
	$fatorHeight     = 89.7;
	$fatorWidth      = 88.4;
	
}
//=======================================================================================================

$PATH_IMAGE = "http://" . $_SERVER["SERVER_NAME"] . "/s_r_comercio/images";	

if(($_SERVER["SERVER_NAME"] == "127.0.0.1") or ($_SERVER["SERVER_NAME"] == "localhost")) {
	$PATH_IMAGE = "http://" . $_SERVER["SERVER_NAME"] . ":70/exodoweb/images";	
}
//=======================================================================================================?>


<link rel="stylesheet" type="text/css" href="includes/stylepage.css"/>
<link rel="stylesheet" type="text/css" href="includes/jquery-ui.css"/>

<meta charset="UTF-8" >
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >

<script type="text/javascript" src="includes/FW_functions.js"></script>
<script type="text/javascript" src="includes/jquery.js" charset="utf-8"></script>
<script type="text/javascript" src="includes/jquery-ui.js" charset="utf-8"></script>
<script type="text/javascript" src="includes/jquery.mask.min.js" charset="utf-8"></script>

<script type="text/javascript">
	function resolucao() {
		var windowHeight = $(window).height();
		var windowWidth  = $(window).width();
		
		var divHeadHeight   = ((windowHeight * 5.5)/100) + "px";
		var divBodyHeight   = ((windowHeight * <?php echo $fatorHeight?>)/100) + "px";
		var divBodyRContent = ((windowHeight * <?php echo $divBodyRContent?>)/100) + "px";
		
		var rightWidth      = ((windowWidth  * <?php echo $fatorWidth; ?>)/100) + "px";
		var leftWidth       = ((windowWidth  * <?php echo $fatorWidth; ?>)/500) + "px";

		$("#divHead").css("height", divHeadHeight);
		$("#divBody").css("height", divBodyHeight);
		
		$("#divBodyLeft").css("height", divBodyHeight);
		$("#divBodyLeft").css("width" , leftWidth);
		
		$("#divBodyRight").css("height", divBodyHeight);
		
		//$("#divBodyRight").css("width", divBodyWidthR);
		
		$(".divFormContent").css("background", "url(<?php echo $PATH_IMAGE;?>/fundoBranco.png)");	
		
	}
	setInterval(function(){resolucao()}, 1000);
	
	function setMenuList(pObj) 			 {
		$(".listMenu").css({
			"color": "#000",
			"font-size": "16px",
			"font-weight":"normal"
		});
		
		$("#" + pObj).css({
			"color": "#00F",
			"font-weight":"bold"
		});
	}
	function buscarConteudo(pUrl) 		{
		doSubmit("modulos/indexModulos.php", pUrl);
	}
	
	$(document).ready(function(e)    {
		resolucao();
		$("#accordion").accordion({heightStyle: "content"});
	});
	
	
	function ativarDivForm()    {
		$("#divForm").show();
		$("#divFormContent").show();
		$("#divFormContent").html("<div align='center'>" + 
															"<br /><br /><img src=\"images/aguarde.gif\" /></div>");
		
	}
	function desativarDivForm() {
		$("#divForm").hide();	
		$("#divFormContent").hide();
	}
	
	function setFrmGeral(pUrl, pAcao) 	{
		document.getElementById("frmGeral").action = pUrl;
		document.getElementById("ACAO_CASE").value = pAcao;

	}
	function doSubmit(pUrl, pAcao)     {
		var ACAO_CASE_OLD   = $("#ACAO_CASE").val();
		var FORM_ACTION_OLD = document.getElementById("frmGeral").action;

		setFrmGeral(pUrl, pAcao);
		document.getElementById("frmGeral").submit();
		
		$("#ACAO_CASE").val(ACAO_CASE_OLD);
		document.getElementById("frmGeral").action = FORM_ACTION_OLD;
		
	}
	function setRadioOpc()             {
		$("#radioset").buttonset();
	}
	
	//EMPRESA_______[
	function selectEmpresa(pId) 			{
		var pagina = "modulos/cadastros/pessoaJurCRUD.php?" + 
		             "ACAO_CASE=SELECT&C01_ID_J=" + pId;
								 
		ativarDivForm();
		$("#iframeGeral").attr("src", pagina);
		
	}
	function cancelarEdtEmpresa(pId) {
		var pagina = "modulos/cadastros/pessoaJurCRUD.php?" + 
		             "ACAO_CASE=SELECT&C01_ID_J=" + pId;
								 
		$("#divButtonEmpresaAguarde").show();
		$("#iframeGeral").attr("src", pagina);
		
	}
	function selectCep(pTp)     			{
		var C01_CEP = $("#C01_CEP" + pTp).val();
		
		var pagina = "modulos/cadastros/pessoasAC.php?" + 
		             "ACAO_CASE=SELECT_CEP&C01_CEP=" + C01_CEP + 
								 "&C01_TIPOPESSOA=" + pTp;

		$("#C01_CEP" + pTp).addClass("autoCompleteClass");
		$("#iframeGeral").attr("src", pagina);
				
		}
	function salvarEmpresa() 				 {
		ativarAguardePessoa();
		$("#divButtonEmpresaAguarde").show();
		doSubmit("modulos/cadastros/pessoaJurCRUD.php", "SALVAR");
		
	}
	function atualizarEmpresaGrid()	{
		$("#ACAO_CASE").val("EMPRESAS_GRID");
		$("#frmGeral").attr("action", "modulos/index.php").submit();
	}
	function empresaToContato(pBool) {
		if(pBool == true) {
				$("#EMPRESAS_FORM").fadeOut("fast");
				$("#EMP_CONT_FORM").fadeIn("slow");
				
		} else if(pBool == false) {
				$("#EMP_CONT_FORM").fadeOut("fast");
				$("#EMPRESAS_FORM").fadeIn("slow");
			
		}
	}
			
			
	function buscarEmpresasGrid()		  {
		var pagina = "modulos/index.php?ACAO_CASE=EMPRESAS_GRID";
		
		setMenuList("empresas_grid_menu");
		$("#divBodyRight").html("<img src=\"images/aguarde.gif\" />");
		$("#iframeGeral").attr("src", pagina);
		
	}
		
	function ativarAguardePessoa()		 {
		$("#divButtonEmpresaAguarde").toggle();
	}
	function acaoPessoa()              {
		var ACAO_PESSOA = parseInt($("#ACAO_PESSOA" + $("#C01_TIPOPESSOA").val()).val());
		
		switch(ACAO_PESSOA) {
			case 0:  salvarPessoas(); break;
			case 1:  selectCep(); break
		}
		
	}


	function mascaraInscEstadual()   	 {
		var maskTxt = "";
		var A01_ID  = parseInt($("#A01_IDJ").val());

		switch(A01_ID) {
			case 1:  maskTxt = "00.000.000/000-00"; break;  //AC	Acre
			case 2:  maskTxt = "000000000"; break;          //AL	Alagoas
			case 3:  maskTxt = "00.000.000-0"; break;       //AM	Amazonas
			case 4:  maskTxt = "000000000"; break;          //AP	Amapá
			case 5:  maskTxt = "000.000.00-0"; break;       //BA	Bahia
			case 6:  maskTxt = "00000000-0"; break;         //CE	Ceará
			case 7:  maskTxt = "00000000000-00"; break;     //DF	Distrito Federal
			case 8:  maskTxt = "000.000.00-0"; break;       //ES	Espírito Santo
			case 9:  maskTxt = "00.000.000-0"; break;       //GO	Goiás
			case 10: maskTxt = "000000000"; break;          //MA	Maranhão
			case 11: maskTxt = "000.000.000/0000"; break;   //MG	Minas Gerais
			case 12: maskTxt = "000000000"; break;  			   //MS	Mato Grosso do Sul
			case 13: maskTxt = "000000000"; break;  			   //MT	Mato Grosso
			case 14: maskTxt = "00-000000-0"; break;			   //PA	Pará
			case 15: maskTxt = "00000000-0"; break;			    //PB	Paraíba
			case 16: maskTxt = "00.0.000.0000000-0"; break; //PE	Pernambuco
			case 17: maskTxt = "000000000"; break;          //PI	Piauí
			case 18: maskTxt = "00000000-00"; break;        //PR	Paraná
			case 19: maskTxt = "00.000.00-0"; break;        //RJ	Rio de Janeiro
			case 20: maskTxt = "00.000.000-0"; break;       //RN	Rio Grande do Norte
			case 21: maskTxt = "000.00000-0"; break;        //RO	Rondônia
			case 22: maskTxt = "00000000-0"; break;         //RR	Roraima
			case 23: maskTxt = "000-0000000"; break;        //RS	Rio Grande do Sul
			case 24: maskTxt = "000.000.000"; break;        //SC	Santa Catarina
			case 25: maskTxt = "000000000-0"; break;        //SE	Sergipe
			case 26: maskTxt = "000.000.000.000"; break;    //SP	São Paulo
		}

		$("#C01_INSCESTADUAL").mask(maskTxt); 
		
	}

	//]
	//PESSOA________[	
	function salvarPessoaFis()      {
		$("#divButtonContatoAguarde").show();
		doSubmit("modulos/cadastros/pessoaFisCRUD.php", "SALVAR");
	}	
	function selectPessoaFis(pId) 	 {
		var C01_ID_F, C01_ID_J, pagina;
		
		C01_ID_F = pId;
		C01_ID_J = "";

		try {C01_ID_J = document.getElementById("C01_ID_J").value;} catch(e){}
		
		if(C01_ID_J == "") {
			ativarDivForm();
			try { $("#divButtonContatoAguarde").show();} catch(e){}
			
		} else if(C01_ID_J != "") {
		}

		pagina = "modulos/cadastros/pessoaFisCRUD.php" + 
             "?ACAO_CASE=SELECT" + 
						 "&C01_ID_F=" + C01_ID_F +
						 "&C01_ID_J=" + C01_ID_J;

		FW_ativarGridAguarde("CONTATOS_GRID", pId);
		$("#iframeGeral").attr("src", pagina);
		
	}
	function atualizarContatoGrid() {
		$("#ACAO_CASE").val("CONTATOS_GRID");
		$("#frmGeral").attr("action", "modulos/index.php").submit();
	}
	function buscarContatosGrid()   {
		var pagina = "modulos/index.php?ACAO_CASE=CONTATOS_GRID";
		
		setMenuList("pessoas_grid_menu");
		$("#divBodyRight").html("<img src=\"images/aguarde.gif\" />");
		$("#iframeGeral").attr("src", pagina);
		
	}
	
	function fecharContatosForm(pId)	 {
		$("#C01_TIPOPESSOA").val("J");
		$("#C01_ID").val(pId); 

		try {
			$("#divButtonContatoAguarde").show();
		} catch(e){}

		
		$("#ACAO_CASE").val("SELECT_CONT_GRID"); 
		$("#frmGeral").attr("action", "modulos/cadastros/pessoasCRUD.php");
		$("#frmGeral").submit(); 
	}
	function empresaParaContato(pBool) {
		if(pBool) {
			$("#EMPRESAS_FORM").hide("fast");
			$("#EMP_CONT_FORM").show("slow");
				
		} else {
			$("#EMP_CONT_FORM").hide("fast");
			$("#EMPRESAS_FORM").show("slow");
			
		}
		
	}
	//]
	//FONES_________[		
	function selectFone(pId) {
		pId = new String(pId);
		$("#C03_ID").val(pId);

		if(pId.length > 0) {
			FW_ativarGridAguarde("CONTATOS_FONES_GRID", pId);
			
			pagina = "modulos/cadastros/pessoasFone.php" + 
							 "?ACAO_CASE=SELECT" + 
							 "&C03_ID=" + pId;
		
			$("#iframeGeral").attr("src", pagina);
			
		} else {
				FW_setAbaUi("#foneAccordion", 1);
				$(".FONE_CAMPO").val("");
				$("#C03_TIPO").val("0");
				$("#C03_DDD").focus();
		}
		
	}
	function deleteFone(pId) {
		pId = new String(pId);
		
		var textoMens = "Deseja excluir esse item?";
		if(pId.length == 0) textoMens = "Deseja realmente excluir itens selecionados?";
		
		if(!confirm(textoMens)) return;
		//=============================================================================		
		
		if(pId.length > 0) {
			FW_ativarGridAguarde("CONTATOS_FONES_GRID", pId);
			$("#checkSel_CONTATOS_FONES_GRID_" + pId).prop("checked", true);
		}
		//=============================================================================		
		
		doSubmit("modulos/cadastros/pessoasFone.php", "DELETE");
		
	}
	function salvarFone()    {
		$("#divButtonContatoFoneAguarde").show();
		doSubmit("modulos/cadastros/pessoasFone.php", "SALVAR");
		
	}
	//]
	//MINUTA________[
	function salvarMunita()												{
		$("#divMinutaAguarde").html(
			"<div align='center'>"+
				"<img src='<?php echo $PATH_IMAGE;?>/aguarde.gif' />"+
			"</div>"
			
		).show();
		
		//$("#bttonSalvarMinuta").prop("disabled", true);

		doSubmit("modulos/movimentacao/minutaCRUD.php", "SALVAR_MINUTA");
		
	}
	function buscarMinutaGrid() 										{
		var pagina = "modulos/index.php?ACAO_CASE=MINUTA_GRID";
		
		setMenuList("minuta_grid_menu");
		$("#divBodyRight").html("<img src=\"images/aguarde.gif\" />");
		$("#iframeGeral").attr("src", pagina);
		
		}
	function buscarMinutaForm(pId) 								 {
		pagina = "modulos/movimentacao/minutaCRUD.php?" + 
             "ACAO_CASE=MINUTA_FORM&D01_ID="   + pId;

		ativarDivForm();
		$("#divFormContent").html("<div align='center'><br /><br />" + 
		                          "  <img src=\"images/aguarde.gif\" />" + 
															"</div>");

		$("#iframeGeral").attr("src", pagina);
		
		}
	function atualizarMinutaGrid() 								 {
		$("#divMenuAguardeMinuta").html("<img src=\"images/aguarde.gif\" width=\"32\" />");
		
		$("#ACAO_CASE").val("MINUTA_GRID");
		$("#frmGeral").attr("action", "modulos/index.php").submit();
	}
	function selectDadosPessoaMinuta(pId, pOrigem) {
		pagina = "modulos/movimentacao/minutaCRUD.php" + 
						 "?ACAO_CASE=DADOS_PESSOA" + 
						 "&C01_ID=" + pId + "&origem=" + pOrigem;

		$("#iframeGeral").attr("src", pagina);
		
	}
	function selectDadosPessoaShow(pOrigem) 				{
		if($("#C01_ID_" + pOrigem).val() == "") return;
		
		$("#divMinutaSelect_" + pOrigem).toggle();
		$("#divMinutaContent_" + pOrigem).toggle();
		
		try {
			$("#C01_DESCRICAO_" + pOrigem).focus();
			$("#C01_DESCRICAO_" + pOrigem).select();
		} catch(e){}
		
	}
	//]
	//ITENS_MINUTA__[
	function calcularSalvarItensMin(pCalcSavar) {
		$("#divItensMinutaAguarde").html(
			"<div align='center'>"+
				"<img src='<?php echo $PATH_IMAGE;?>/aguarde.gif' />"+
			"</div>"
			
		).show();

		doSubmit("modulos/movimentacao/minutaItensCRUD.php?CALC_SALVAR=" + pCalcSavar, "CALCULAR_SALVAR");
		
	}
	function buscarItensMinutaGrid(pId)				 {
		$("#divItensMinutaGrid").html(
			"<div align='center'>"+
				"<img src='<?php echo $PATH_IMAGE;?>/aguarde.gif' />"+
			"</div>"
			
		);
		var pagina = "modulos/movimentacao/minutaItensCRUD.php" + 
		             "?D01_ID=" + pId +
								 "&ACAO_GRID=MIN_ITENS_GRID";
								 
		$("#iframeGeral").attr("src", pagina);
	}
	function limparItensMinFormCampos()         {
		FW_AplicarAutoComplete("D00_DESCRICAO", "", "");
		
		$(".itensMinFormCampos").val("");
		$(".itensMinFormCamposSel").val("0");
		$("#D00_DESCRICAO").focus();
		
	}
	
	function selectItensMinuta(pId)						 {
		if(pId == "") {
			FW_setAbaUi(".itensMinAccordionClass", 1);
			limparItensMinFormCampos();
			
		} else if (pId != "") {
			var pagina = "modulos/movimentacao/minutaItensCRUD.php" + 
									 "?D02_ID=" + pId +
									 "&ACAO_CASE=SELECT";
			
			FW_ativarGridAguarde("G_MIN_ITENS_GRID", pId);
									 
			$("#iframeGeral").attr("src", pagina);
		}
	}
	function deleteItensMinuta(pId)						 {
		var textoMens = "Deseja excluir esse item?";
		if(pId == "") textoMens = "Deseja realmente excluir itens seleciona?";

		if(!confirm(textoMens)) return;
		
		if(pId != "") {
			$("#checkSel_" + pId).prop("checked", true);
			FW_ativarGridAguarde("G_MIN_ITENS_GRID", pId);
		}
		
		doSubmit("modulos/movimentacao/minutaItensCRUD.php", "DELETE");
		
	}
	
	function salvarStatusMinuta(pIdStatus) {
		if(!confirm("Deseja realmente realizar este procedimento?" + 
		            "\n\nEste procedimento não terá retorno")) return;
								
		$("#divMinutaAguarde").html(
			"<div align='center'>"+
				"<img src='<?php echo $PATH_IMAGE;?>/aguarde.gif' />"+
			"</div>"
			
		).show();
		
		var D01_ID = $("#D01_ID").val();
		var pagina = "modulos/movimentacao/minutaCRUD.php" + 
								 "?D01_STATUS=" + pIdStatus +
								 "&D01_ID="     + D01_ID    +
								 "&ACAO_CASE=UPDATE_STATUS";

		$("#iframeGeral").attr("src", pagina);

	}
	function showButtonsEdit(pBool) 	  		{
		if(pBool == true) {
			$(".buttonClass").show();
			
		} else if(pBool == false) {
			$(".buttonClass").hide();
			
		}
		
		$("#bttonSaieMinuta").show();
	}
	//]
	
</script>

<style type="text/css">
	#divForm {
		top: 0;
		display: none;
		background-color: #FFF;
		position: absolute;
		
		width: 100%;
		height: 100%;
		
		filter:alpha(opacity=50);
		opacity: 0.8;
		-moz-opacity:0.8;
		-webkit-opacity:0.8;
		
	}
	
	#divFormContent {
		top: 0px;
		left: 2px;
		width: 99.5%;
		height: 90%;
		display: none;
		
		position: absolute;
		
	}
</style>
