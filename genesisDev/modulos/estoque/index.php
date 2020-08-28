<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
include "../../includes/library/myLibrary.inc";

if($FW_DADOS_OK == false){?>
	<script type="text/javascript"><?php
		$MENSAGEM_RETORNO = "<strong>Ausência de dados importantes!!!</strong>";
		echo "window.location = '../../index.php?MENSAGEM_RETORNO=" . $MENSAGEM_RETORNO . "';";?>
	</script><?php
	
	echo "</head><body></body></html>";

} else {
	session_start();
	$_SESSION["SS_IN_MANUT"] = false;
	
	if($_SESSION["SS_IN_MANUT"] == false) {
		ini_set("display_errors", 0); 
	}
	
	include "estoqueInc.inc";?>
  
  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css">

	<link rel="stylesheet" type="text/css" href="../../includes/jquery-ui-1.11.4.custom/jquery-ui.css">
	<script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
  <script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/jquery-ui.js" charset="utf-8"></script>
  
	<script type="text/javascript" src="../../includes/js/FW_v2.js"     charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/makeGrid.js"  charset="utf-8"></script>
  <script type="text/javascript" src="../../includes/js/gen_geral.js" charset="utf-8"></script>

  <script type="text/javascript">
			var aguarde_azul    = "<img src=\"../../imagens/aguarde_azul.gif\" />", 
			    GEN_DOC_HEIGHT  = <?php echo $GEN_DOC_HEIGHT;?>,
			    GEN_DOC_WIDTH   = <?php echo $GEN_DOC_WIDTH;?>,
			    DIV_FORM_MODAL  = null,
			    RELOAD_LIST_ARM = false,
					RELOAD_LIST     = false,
					DIV_FORM_MODAL_TBL_AUX = null;

		function setFiltroCheck(pClass){
			try {
				$("." + pClass).each(function() {
					$(this).prop("checked", !($(this).is(":checked")));
				});
			} catch(e){}
		}		
		
		function fecharFormModalTblAux()  {
			DIV_FORM_MODAL_TBL_AUX.dialog("close");
		}
		function formModalTblAux(pSwitch) {
			DIV_FORM_MODAL_TBL_AUX.dialog("open");
			
			$("#DIV_FORM_MODAL_TBL_AUX_AGUARDE").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"150\" />" + 
				"</div>"
			).show();
			//==========================================================================================<?php 
			
			$GEN_IFRAME_WIDTH  = (((int)$GEN_DOC_WIDTH  * 29.3) / 100);
			$GEN_IFRAME_HEIGHT = (((int)$GEN_DOC_HEIGHT * 49.8) / 100);
			
			if($GEN_NAVEGADOR == "FIREFOX")    { 
				$GEN_IFRAME_WIDTH  = (((int)$GEN_DOC_WIDTH  * 28.95) / 100);
				$GEN_IFRAME_HEIGHT = (((int)$GEN_DOC_HEIGHT * 50.50) / 100);
				
				if($GEN_IFRAME_WIDTH  < 330) $GEN_IFRAME_WIDTH  = 330; 
				if($GEN_IFRAME_HEIGHT < 270) $GEN_IFRAME_HEIGHT = 270;
				
			} 
			elseif($GEN_NAVEGADOR == "SAFARI") {
				$GEN_IFRAME_WIDTH  = (((int)$GEN_DOC_WIDTH  * 29.3) / 100);
				$GEN_IFRAME_HEIGHT = (((int)$GEN_DOC_HEIGHT * 49.8) / 100);
				
				if($GEN_IFRAME_WIDTH  < 320) $GEN_IFRAME_WIDTH  = 320; 
				if($GEN_IFRAME_HEIGHT < 265) $GEN_IFRAME_HEIGHT = 265;

			} 
			else {
				$GEN_IFRAME_WIDTH  = (((int)$GEN_DOC_WIDTH  * 29.65) / 100);
				$GEN_IFRAME_HEIGHT = (((int)$GEN_DOC_HEIGHT * 49.8) / 100);
				
				if($GEN_IFRAME_WIDTH  < 330) $GEN_IFRAME_WIDTH  = 330;
				if($GEN_IFRAME_HEIGHT < 270) $GEN_IFRAME_HEIGHT = 270;
				
			}?> 

			var GEN_IFRAME_WIDTH  = <?php echo $GEN_IFRAME_WIDTH;?>;
			var GEN_IFRAME_HEIGHT = <?php echo $GEN_IFRAME_HEIGHT;?>;

			var iframeFormCSS = "   height: " + GEN_IFRAME_HEIGHT + "px;" +
			                    "    width: " + GEN_IFRAME_WIDTH  + "px;" +
													" overflow: hidden;" +
													"  display: block; " +
													"  padding: 0px;   " +
													"   margin: 0px;   " + 
													"   border: 0px solid red;";

			var pagina = "tabelasAuxIndex.php?<?php echo $GEN_PARAMETROS;?>&SWITCH_FORM=" + pSwitch;
			
			$("#IFRM_FORM_MODAL_TBL_AUX").attr("style", iframeFormCSS).attr("src", pagina);
			
		} 
		function formModalTblAuxShow()    {
			$("#DIV_FORM_MODAL_TBL_AUX_AGUARDE").hide();
			$("#IFRM_FORM_MODAL_TBL_AUX").show();
		}
		function formModalArmacaoReload() {
			doSubmit("formGrid", "indexHidden.php", "SELECT_ARMACAO_LST");
		}
		function formModalGeneroReload()  {
			doSubmit("formGrid", "indexHidden.php", "SELECT_GENERO_LST");
		}

		function selectGridEstoque()      {
			$("#DIV_CONTENT_RIGHT_GRID").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"150\" />" + 
				"</div>"
			);
			doSubmit("formGrid", "indexHidden.php", "SELECT_GRID_ESTOQUE");

		}
		function imprimirRelatorio(pID)   {
			$("#GRID_SET_IDS").val($("#GRID_SET_IDS_" + pID).val());
			$("#formReport").submit();
		}
		
		function ativarFormModal(pID) {
			DIV_FORM_MODAL.dialog("open");
			FW_setFonteStyleDado(pID);
			$("#E01_ID_SEL").val(pID);
			
			$("#DIV_FORM_MODAL_AGUARDE").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"150\" />" + 
				"</div>"
			).show(); 
			 
			var GEN_IFRAME_HEIGHT;
			var GEN_IFRAME_WIDTH;<?php 
			
			$GEN_IFRAME_WIDTH  = (((int)$GEN_DOC_WIDTH  * 50.7) / 100);
			$GEN_IFRAME_HEIGHT = (((int)$GEN_DOC_HEIGHT * 47.2) / 100);
			
			if($GEN_NAVEGADOR == "FIREFOX") { 
				$GEN_IFRAME_WIDTH  = (((int)$GEN_DOC_WIDTH  * 48.6) / 100);
				$GEN_IFRAME_HEIGHT = (((int)$GEN_DOC_HEIGHT * 47.1) / 100);
				
				if($GEN_IFRAME_WIDTH  < 639)  $GEN_IFRAME_WIDTH = 639;
				if($GEN_IFRAME_HEIGHT < 290) $GEN_IFRAME_HEIGHT = 290;
				
			} 
			elseif($GEN_NAVEGADOR == "SAFARI") {
				$GEN_IFRAME_WIDTH  = (((int)$GEN_DOC_WIDTH  * 50.6) / 100);
				$GEN_IFRAME_HEIGHT = (((int)$GEN_DOC_HEIGHT * 48.5) / 100);
				
				if($GEN_IFRAME_WIDTH  < 690) $GEN_IFRAME_WIDTH  = 690;
				if($GEN_IFRAME_HEIGHT < 312) $GEN_IFRAME_HEIGHT = 302;
				
			} else {
				$GEN_IFRAME_WIDTH  = (((int)$GEN_DOC_WIDTH  * 48.2) / 100);
				$GEN_IFRAME_HEIGHT = (((int)$GEN_DOC_HEIGHT * 46.5) / 100);
				
				if($GEN_IFRAME_WIDTH  < 640) $GEN_IFRAME_WIDTH  = 640;
				if($GEN_IFRAME_HEIGHT < 291) $GEN_IFRAME_HEIGHT = 291;
				
			}?> 

			GEN_IFRAME_HEIGHT = <?php echo $GEN_IFRAME_HEIGHT;?>;
			GEN_IFRAME_WIDTH  = <?php echo $GEN_IFRAME_WIDTH; ?>;
		
			var iframeFormCSS = "    height: " + GEN_IFRAME_HEIGHT + "px;" +
			                    "     width: " + GEN_IFRAME_WIDTH  + "px;" +
													"  overflow: hidden; " +
													"overflow-y: hidden; " +
													"   display: none;   " +
													"    border: 0px solid red";
													
			var pagina = "estoqueIndex.php?" + 
									 "E01_ID=" + pID + "&" +
									 "<?php echo $GEN_PARAMETROS;?>";

			$("#iframeForm").attr("style", iframeFormCSS).attr("src", pagina);	
			
		}
		function fecharFormModal()    {
			DIV_FORM_MODAL.dialog("close");
			if(RELOAD_LIST == true) selectUsuarios();	
		}
		function formModalShow()      {
			$("#iframeForm").show();
			$("#DIV_FORM_MODAL_AGUARDE").hide();	
		}
		
		function selectListas() {
			$("#DIV_CONTENT_LEFT_TPM").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"50\" /><br /><br />" + 
				"</div>"
			);

			$("#DIV_CONTENT_LEFT_GEN").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"50\" />" + 
				"</div>"
			);

			$("#DIV_CONTENT_RIGHT_GRID").html(
				"<div align=\"center\"><br /><br /><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"150\" />" + 
				"</div>"
			);
					
			$("#DIV_CONTENT_LEFT_M_FILTRO").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"50\" /><br /><br />" + 
				"</div><br />" + 
				
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"50\" /><br /><br />" + 
				"</div>"
				
			);

			doSubmit("formGrid", "indexHidden.php", "SELECT_LISTAS");
			
		}
		
		function relatorioMovimento()   {
			$("#DIV_CONTENT_RIGHT_M_RELATORIO").html(
				"<div align=\"center\"><br /><br /><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"150\" />" + 
				"</div>"
			);
			//=======================================================================================
					
			doSubmit("formGrid", "indexHidden.php", "SELECT_RELAT_MOV");
			
		}
		
		$(function(){<?php 
			$GEN_DOC_WIDTH_  = (((int)$GEN_DOC_WIDTH  * 30.8) / 100);
			$GEN_DOC_HEIGHT_ = (((int)$GEN_DOC_HEIGHT * 57.6) / 100);

			if($GEN_NAVEGADOR     == "FIREFOX"){
				$GEN_DOC_WIDTH_  = (((int)$GEN_DOC_WIDTH  * 30.8) / 100);
				$GEN_DOC_HEIGHT_ = (((int)$GEN_DOC_HEIGHT * 58.5) / 100);
				
				if($GEN_DOC_WIDTH_  < 354) $GEN_DOC_WIDTH_  = 354; 
				if($GEN_DOC_HEIGHT_ < 320) $GEN_DOC_HEIGHT_ = 320;

			} 
			elseif($GEN_NAVEGADOR == "SAFARI") {
				$GEN_DOC_HEIGHT_ = (((int)$GEN_DOC_HEIGHT * 57.6) / 100);
				$GEN_DOC_WIDTH_  = (((int)$GEN_DOC_WIDTH  * 30.8) / 100);
				
				if($GEN_DOC_WIDTH_  < 340) $GEN_DOC_WIDTH_  = 340; 
				if($GEN_DOC_HEIGHT_ < 320) $GEN_DOC_HEIGHT_ = 320;
				
			} 
			else {
				$GEN_DOC_WIDTH_  = (((int)$GEN_DOC_WIDTH  * 31.5) / 100);
				$GEN_DOC_HEIGHT_ = (((int)$GEN_DOC_HEIGHT * 57.6) / 100);
				
				if($GEN_DOC_WIDTH_  < 350) $GEN_DOC_WIDTH_  = 350;
				if($GEN_DOC_HEIGHT_ < 320) $GEN_DOC_HEIGHT_ = 320;

			}?>			

			GEN_FORM_WIDTH  = <?php echo $GEN_DOC_WIDTH_;?>;
			GEN_FORM_HEIGHT = <?php echo $GEN_DOC_HEIGHT_;?>;
			
			DIV_FORM_MODAL_TBL_AUX = $("#DIV_FORM_MODAL_TBL_AUX").dialog({
       resizable: false,				
				autoOpen: false,
					height: GEN_FORM_HEIGHT,
					 width: GEN_FORM_WIDTH,
					 modal: true,
					 close: function() {$("#IFRM_FORM_MODAL_TBL_AUX").attr("src", "").hide();},
        position: {my: "top", at: "top+100"}
					 
			}); <?php 
			
			$GEN_DOC_WIDTH_  = (((int)$GEN_DOC_WIDTH  * 51) / 100);
			$GEN_DOC_HEIGHT_ = (((int)$GEN_DOC_HEIGHT * 53) / 100);
			
			if($GEN_NAVEGADOR == "FIREFOX")   {
				$GEN_DOC_WIDTH_  = (((int)$GEN_DOC_WIDTH  * 48.70) / 100);
				$GEN_DOC_HEIGHT_ = (((int)$GEN_DOC_HEIGHT * 48.00) / 100);
				
				if($GEN_DOC_WIDTH_  < 641) $GEN_DOC_WIDTH_  = 641;
				if($GEN_DOC_HEIGHT_ < 299) $GEN_DOC_HEIGHT_ = 299;
				
			} 
			elseif($GEN_NAVEGADOR == "SAFARI"){
				$GEN_DOC_WIDTH_  = (((int)$GEN_DOC_WIDTH  * 50.4) / 100);
				$GEN_DOC_HEIGHT_ = (((int)$GEN_DOC_HEIGHT * 48.5) / 100);

				if($GEN_DOC_WIDTH_  < 693) $GEN_DOC_WIDTH_  = 693; 
				if($GEN_DOC_HEIGHT_ < 312) $GEN_DOC_HEIGHT_ = 312; 

			}
			else {
				$GEN_DOC_WIDTH_  = (((int)$GEN_DOC_WIDTH  * 48.40) / 100);
				$GEN_DOC_HEIGHT_ = (((int)$GEN_DOC_HEIGHT * 47.90) / 100);
				
				if($GEN_DOC_WIDTH_  < 642) $GEN_DOC_WIDTH_  = 642;
				if($GEN_DOC_HEIGHT_ < 300) $GEN_DOC_HEIGHT_ = 300;
				
			}?>
			
			GEN_DOC_HEIGHT_ = <?php echo $GEN_DOC_HEIGHT_;?>;
			GEN_DOC_WIDTH_  = <?php echo $GEN_DOC_WIDTH_;?>;

			DIV_FORM_MODAL = $("#DIV_FORM_MODAL").dialog({
				autoOpen: false,
			 resizable: false,				
					height: GEN_DOC_HEIGHT_,
					 width: GEN_DOC_WIDTH_,
					 modal: true,
        position: {my: "top", at: "top+100"},
				
					create: function (event, ui) {
						$(".ui-widget-header").hide();
					},						 
				
					 close: function() {
						 fecharFormModal();
					 },
					 hideCloseButton: true
					 
			});
			
			$("#estoqueTabs").tabs();
			$(".bttGridClass").button();
			selectListas();
			
		});
		setInterval(function(){$(".bttGridClass").button();}, 100);
		
	</script>

  <style type="text/css">
		body {<?php 
	 		if($_SESSION["SS_IN_MANUT"] == false) {
				echo "overflow: hidden;";
			}?>
		} 

		#DIV_FORM_MODAL {
			  margin: 0px;
			 padding: 0px;
			overflow: hidden;
		}
	</style>
  
</head><body>
  <div id="DIV_PRINC_USUARIO" style="background-color: #004080; height: 50px; overflow: none;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr><td valign="top" width="20%" align="center">
      <div style="color:#FFF; padding: 10px; font-size: 25px; ">
        G&nbsp;&Ecirc;&nbsp;N&nbsp;E&nbsp;S&nbsp;I&nbsp;S&nbsp;&nbsp;&nbsp;1&nbsp;.&nbsp;0
      </div>
    
    </td><td valign="middle" width="70%">
      <div align="center" style="color: #FFF; font-size: 20px;" class="semMargPadd">
				C&nbsp;O&nbsp;N&nbsp;T&nbsp;R&nbsp;O&nbsp;L&nbsp;E&nbsp;&nbsp;
        D&nbsp;E&nbsp;&nbsp;
        E&nbsp;S&nbsp;T&nbsp;O&nbsp;Q&nbsp;U&nbsp;E
        
      </div><div align="center" 
      style="color: #CC6; font-style: italic; font-size: 15px;" class="semMargPadd"><?php 
				echo $GEN_NOME;?>
        
      </div>
      
    </td><td valign="middle" align="center">
      <a href = "RETORNAR" 
      onclick = "$('#formReturn').submit(); return false;" 
        style = "color: #FFF; font-style: normal">RETORNAR&nbsp;</a>
      
    </td></tr>
    </table>
  </div><?php 

	$DIV_CONTEUDO_TAB_HEIGHT = (((int)$GEN_DOC_HEIGHT * 86) / 100);
	$DIV_CONTEUDO_HEIGHT     = (((int)$DIV_CONTEUDO_TAB_HEIGHT  * 98) / 100);
	
	$DIV_CONTENT_LEFT_WIDTH  = (((int)$GEN_DOC_WIDTH  * 21) / 100);
	$DIV_CONTENT_RIGHT_WIDTH = (((int)$GEN_DOC_WIDTH  * 77) / 100);
	
	if($GEN_NAVEGADOR == "FIREFOX")    {
		$DIV_CONTEUDO_TAB_HEIGHT = (((int)$GEN_DOC_HEIGHT * 86) / 100);
		
		//SE ALTERAR AQUI, ALTERAR NAS FUNÇÕES filtroTipoModelo, filtroGenero
		if($DIV_CONTEUDO_HEIGHT     < 412) $DIV_CONTEUDO_HEIGHT     = 386;
		
		if($DIV_CONTENT_LEFT_WIDTH  < 170) $DIV_CONTENT_LEFT_WIDTH  = 200;
		if($DIV_CONTENT_RIGHT_WIDTH < 617) $DIV_CONTENT_RIGHT_WIDTH = 580;
		
	} 
	elseif($GEN_NAVEGADOR == "SAFARI") {
		$DIV_CONTEUDO_TAB_HEIGHT = (((int)$GEN_DOC_HEIGHT * 85.6) / 100);
		
		//SE ALTERAR AQUI, ALTERAR NAS FUNÇÕES filtroTipoModelo, filtroGenero
		if($DIV_CONTEUDO_HEIGHT <= 400) $DIV_CONTEUDO_HEIGHT = 375.5;
		
		if($DIV_CONTENT_LEFT_WIDTH  < 170) $DIV_CONTENT_LEFT_WIDTH  = 200;
		if($DIV_CONTENT_RIGHT_WIDTH < 617) $DIV_CONTENT_RIGHT_WIDTH = 580;
		
	} 
	else {
		$DIV_CONTEUDO_TAB_HEIGHT = (((int)$GEN_DOC_HEIGHT * 86) / 100); 
		$DIV_CONTEUDO_HEIGHT     = (((int)$DIV_CONTEUDO_TAB_HEIGHT  * 98) / 100);
		
		$DIV_CONTENT_LEFT_WIDTH  = (((int)$GEN_DOC_WIDTH  * 21) / 100); 
		$DIV_CONTENT_RIGHT_WIDTH = (((int)$GEN_DOC_WIDTH  * 77) / 100);
		
		if($DIV_CONTEUDO_HEIGHT < 426) $DIV_CONTEUDO_HEIGHT = 402; //425.32
		
	//if($DIV_CONTEUDO_HEIGHT     < 412) $DIV_CONTEUDO_HEIGHT     = 386;
		if($DIV_CONTENT_LEFT_WIDTH  < 200) $DIV_CONTENT_LEFT_WIDTH  = 200;
		if($DIV_CONTENT_RIGHT_WIDTH < 617) $DIV_CONTENT_RIGHT_WIDTH = 580;
		
	}
	//echo $DIV_CONTEUDO_HEIGHT;?>
	
  <div id="DIV_FORM_MODAL_TBL_AUX" style="overflow: hidden" class="semMargPadd">
  	<div id="DIV_FORM_MODAL_TBL_AUX_AGUARDE" style="display: none;"></div>
  	<iframe id="IFRM_FORM_MODAL_TBL_AUX" frameborder="0" class="semMargPadd"></iframe>
  </div>
  
	<div id="DIV_FORM_MODAL" align="center">
  	<div id="DIV_FORM_MODAL_AGUARDE" style="display: none"></div>
  	<iframe id="iframeForm" frameborder="0" style="display: none"></iframe>
  </div>
  
  <form id="formGrid" name="formGrid" method="post" target="iframeGeral"><?php
    $STYLE_AUX = "
         height: " . $DIV_CONTEUDO_TAB_HEIGHT . "px; 
     overflow-x: auto; 
        padding: 0; 
         margin: 0;";	?>
    
    <div id="estoqueTabs">
      <ul>
        <li><a href="#tabs-1">&Oacute;culos</a></li>
        <li><a href="#tabs-2" onclick="relatorioMovimento();">Movimenta&ccedil;&atilde;o</a></li>
      </ul>
      
      <div id="tabs-1" style=" <?php echo $STYLE_AUX;?>">
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="padding-top: 5px">
        <tr><td valign="top">
          <div id="DIV_CONTENT_LEFT" 
          style="width: <?php echo $DIV_CONTENT_LEFT_WIDTH;?>px;
                border: 1px solid #DDF;
                height: <?php echo $DIV_CONTEUDO_HEIGHT;?>px">

            <div id="DIV_CONTENT_LEFT_TPM"></div>
            <div id="DIV_CONTENT_LEFT_GEN"></div>
          </div>
          
        </td>
        <td valign="top" width="5px">&nbsp;
        	
        	
        </td><td valign="top">
          <div id="DIV_CONTENT_RIGHT" 
          style="width: <?php echo $DIV_CONTENT_RIGHT_WIDTH;?>px; 
                border: 1px solid #DDF;
                height: <?php echo $DIV_CONTEUDO_HEIGHT;?>px">
            <div style="padding-bottom: 7px; padding-top: 5px;" align="center">
              <input 
                  type="button" 
                  class="bttGridClass" style="margin: 0; font-size: 14px; width: 100px" 
                  value="  Atualizar  " onclick="selectGridEstoque();" />
              &nbsp;
              <input 
                  type="button" 
                  class="bttGridClass" style="margin: 0; font-size: 14px; width: 100px" 
                  value="  Filtro  " onClick="FW_gridAtivarFiltro('EST_GRID');" />
              &nbsp;
              <input 
                  type="button"
                  class="bttGridClass" style="margin: 0; font-size: 14px; width: 100px" 
                  value="Novo" onClick="ativarFormModal('')" />
              &nbsp;
              <input <?php
                  $GRID_ID = "P01_GRID_USUARIOS";?>
                  type="button"
                  class="bttGridClass" style="margin: 0; font-size: 14px; width: 120px" 
                  value="Impress&atilde;o" onclick="imprimirRelatorio('EST_GRID')" />
                  
            </div> 
            <div id="DIV_CONTENT_RIGHT_GRID"></div>
         	</div>
          
        </td></tr>
        </table>
      
      </div>
      <div id="tabs-2" style=" <?php echo $STYLE_AUX;?>">
        <table border="0" cellspacing="0" cellpadding="0" align="center" style="padding-top: 5px">
        <tr><td valign="top">
          <div id="DIV_CONTENT_LEFT_M" 
          style="width: <?php echo $DIV_CONTENT_LEFT_WIDTH;?>px;
                border: 1px solid #DDF;
                height: <?php echo $DIV_CONTEUDO_HEIGHT;?>px">
						<div id="DIV_CONTENT_LEFT_M_FILTRO"></div>
            
          </div>

        </td><td valign="top" width="5px">&nbsp;
        	
        </td><td valign="top" width="5px">
          <div id="DIV_CONTENT_RIGHT_M" 
          style="  width: <?php echo $DIV_CONTENT_RIGHT_WIDTH;?>px; 
                  border: 1px solid #DDF;
                  height: <?php echo $DIV_CONTEUDO_HEIGHT;?>px; 
                overflow: auto">
          	<div id="DIV_CONTENT_RIGHT_M_RELATORIO"></div>
					</div>
        	
        </td></tr>
        </table>
      
      </div> 
      
    </div>
    
    <input type="hidden" name="DIV_CONTENT_LEFT_WIDTH" value="<?php echo $DIV_CONTENT_LEFT_WIDTH;?>"   />
    
    <input type="hidden" id="E01_ID_SEL" name="E01_ID_SEL" />
    <input type="hidden" name="GEN_ID"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="GEN_NOME"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS" value="<?php echo $GEN_USER_STATUS;?>" />
    
    <input type="hidden" name="GEN_ACAO_GERAL" id="GEN_ACAO_GERAL" />
    <input type="hidden" name="GEN_DOC_WIDTH"  value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT" value="<?php echo $GEN_DOC_HEIGHT;?>" />
    <input type="hidden" name="DIV_CONTEUDO_HEIGHT" 
    value="<?php echo $DIV_CONTEUDO_HEIGHT;?>" />
    
    <input type="hidden"  name="GRID_USER_SELECTED" id="GRID_USER_SELECTED" />
    
  </form>
  
  <form id="formReport" name="formReport" action="estoqueReport.php" method="post" target="_blank">
  	<input type="hidden" id="GRID_SET_IDS" name="GRID_SET_IDS" />
  </form>
  
  <form id="formReportMov" name="formReportMov" action="estoqueReportMov.php" method="post" target="_blank">
  	<input type="hidden" id="REPORT_MOV_CONTENT" name="REPORT_MOV_CONTENT" />
  </form>

  <form id="formReturn" name="formReturn" action="../index.php" method="post">
    <input type="hidden" name="GEN_ID_"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="GEN_NOME_"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS_" value="<?php echo $GEN_USER_STATUS;?>" />
    <input type="hidden" name="GEN_DOC_WIDTH_"   value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT_"  value="<?php echo $GEN_DOC_HEIGHT;?>" />
  
  </form>
  
	
		<?php 

	$DISPLAY_AUX = "none";
	if($_SESSION["SS_IN_MANUT"] == true) $DISPLAY_AUX = "block";?>
	
	<div style="background-color:#FFF; width: 100%; display: <?php echo $DISPLAY_AUX;?>">
		<iframe id="iframeGeral" name="iframeGeral" style="width: 100%; height: 300px;"></iframe>
	</div>
  
</body></html><?php 
}?>