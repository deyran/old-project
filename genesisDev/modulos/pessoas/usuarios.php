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
	}?>
  
  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css">

	<link rel="stylesheet" type="text/css" href="../../includes/jquery-ui-1.11.4.custom/jquery-ui.css">
	<script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
  <script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/jquery-ui.js" charset="utf-8"></script>
  
	<script type="text/javascript" src="../../includes/js/FW_v2.js" charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/makeGrid.js" charset="utf-8"></script>

  <script type="text/javascript">
		var aguarde_azul   = "<img src=\"../../imagens/aguarde_azul.gif\" />", 
		    GEN_DOC_HEIGHT = <?php echo $GEN_DOC_HEIGHT;?>,
				GEN_DOC_WIDTH  = <?php echo $GEN_DOC_WIDTH;?>,
				DIV_FORM_MODAL = null,
				RELOAD_LIST    = false;
		
		function setReloadList(pBool)     {
			RELOAD_LIST = pBool;
		}
		function ativarFormModal(pIdUser) {
			FW_setFonteStyleDado(pIdUser);
			$("#GRID_USER_SELECTED").val(pIdUser);<?php 
			
			$GEN_FORM_WIDTH    = (((int)$GEN_DOC_WIDTH  * 41.2) / 100);
			$GEN_FORM_HEIGHT   = (((int)$GEN_DOC_HEIGHT * 44.7) / 100);
			$GEN_IFRAME_WIDTH  = (((int)$GEN_DOC_WIDTH  * 41.4) / 100);
			$GEN_IFRAME_HEIGHT = (((int)$GEN_DOC_HEIGHT * 42.8) / 100);

			if($GEN_FORM_WIDTH  < 520) $GEN_FORM_WIDTH  = 510;
			if($GEN_FORM_HEIGHT < 265) $GEN_FORM_HEIGHT = 265;
			if($GEN_IFRAME_WIDTH  < 517) $GEN_IFRAME_WIDTH = 517;
			if($GEN_IFRAME_HEIGHT < 253) $GEN_IFRAME_HEIGHT = 253;?> 
			
			var GEN_FORM_WIDTH  = <?php echo $GEN_FORM_WIDTH;?>;
			var GEN_FORM_HEIGHT = <?php echo $GEN_FORM_HEIGHT;?>;

			var GEN_IFRAME_WIDTH	= <?php echo $GEN_IFRAME_WIDTH;?>;
			var GEN_IFRAME_HEIGHT = <?php echo $GEN_IFRAME_HEIGHT;?>;
						
			if(DIV_FORM_MODAL == null) {
				DIV_FORM_MODAL = $("#DIV_FORM_MODAL").dialog({
					autoOpen: false,
				 resizable: false,
						height: GEN_FORM_HEIGHT,
						 width: GEN_FORM_WIDTH,
						 modal: true,
						 
						create: function (event, ui) {
							$(".ui-widget-header").hide();
						},						 
						 
						 close: function() {
							 fecharFormModal();
						 },
						 
						 hideCloseButton: true
						 
				});
				
			}
			
			DIV_FORM_MODAL.dialog("open");
			
			var iframeFormCSS = "   height: " + GEN_IFRAME_HEIGHT + "px;" +
			                    "    width: " + GEN_IFRAME_WIDTH  + "px;" +
													" overflow: hidden;" +
													"   border: 0px solid red;" +
													"  display: none;";
													
			var pagina = "usuariosForm.php?" + 
									 "P01_ID="           + pIdUser                   + "&" +
									 "GEN_ID="           + "<?php echo $GEN_ID;?>"   + "&" +
									 "GEN_NOME="         + "<?php echo $GEN_NOME;?>" + "&" +
			             "<?php echo $GEN_PARAMETROS;?>";
									 
			$("#DIV_FORM_MODAL_AGUARDE").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"150\" />" + 
				"</div>"
			).show();
			
			$("#iframeForm").attr("style", iframeFormCSS).attr("src", pagina);	
			
		}
		function fecharFormModal()        {
			DIV_FORM_MODAL.dialog("close");
			if(RELOAD_LIST == true) selectUsuarios();	
		}
		function formModalShow()          {
			$("#iframeForm").show();
			$("#DIV_FORM_MODAL_AGUARDE").hide();	
		}
		
		function newAlert(text, tipe, posit) {
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
		function selectUsuarios()            {
			setReloadList(false);
			
			$("#DIV_CONTEUDO_GRID").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"300\" />" + 
				"</div>"
			);
			
			$("#GEN_ACAO_GERAL").val("SELECT_USUARIOS");
			$("#formGrid").attr("action", "usuariosHidden.php").submit();
		}
		function retornarAux(pPath)          {
			$("#DIV_CONTEUDO_GRID").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"300\" />" + 
				"</div>"
			);
			
			$("#formGrid").attr("action", pPath).submit();
		}
		
		function listaUsuarios(pID) {
			$("#GRID_TITULO_PRINT_REPORT").val($("#GRID_TITULO_PRINT_" + pID).val());
			$("#GRID_SQL_QUERY_REPORT").val($("#GRID_SQL_QUERY_" + pID).val());
			
			$("#formReport").submit();
		}
		
		$(function(){ 
			$(".bttGridClass").button();
			selectUsuarios();	
			
		});
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
				U&nbsp;S&nbsp;U&nbsp;&Aacute;&nbsp;R&nbsp;I&nbsp;O&nbsp;S
        
      </div><div align="center" 
      style="color: #CC6; font-style: italic; font-size: 15px;" class="semMargPadd"><?php 
				echo $GEN_NOME;?>
        
      </div>
      
    </td><td valign="middle" align="center">
      <a href = "RETORNAR" 
      onclick = "$('#formReturn').submit(); return false;" 
        style = "color: #FFF; font-style: normal">RETORNAR</a>
      
    </td></tr>
    </table>
  </div>
	
  <form id="formGrid" name="formGrid" method="post" target="iframeGeral"><?php
		$DIV_CONTEUDO_GRID_HEIGHT = (((int)$GEN_DOC_HEIGHT * 89) / 100);
			
		if($GEN_NAVEGADOR == "FIREFOX")    {
			$DIV_CONTEUDO_GRID_HEIGHT = (((int)$GEN_DOC_HEIGHT * 89) / 100);
			if($DIV_CONTEUDO_GRID_HEIGHT < 440) $DIV_CONTEUDO_GRID_HEIGHT = 417;

		} 
		elseif($GEN_NAVEGADOR == "SAFARI") {
			$DIV_CONTEUDO_GRID_HEIGHT = (((int)$GEN_DOC_HEIGHT * 89) / 100);
			if($DIV_CONTEUDO_GRID_HEIGHT < 430) $DIV_CONTEUDO_GRID_HEIGHT = 404;
				
		} else {
			$DIV_CONTEUDO_GRID_HEIGHT = (((int)$GEN_DOC_HEIGHT * 89) / 100);
		//	echo $DIV_CONTEUDO_GRID_HEIGHT;
			if($DIV_CONTEUDO_GRID_HEIGHT < 450) $DIV_CONTEUDO_GRID_HEIGHT = 433;
		}?>
    
    <div style="height: <?php echo $DIV_CONTEUDO_GRID_HEIGHT;?>px; overflow-x: auto; overflow-y: hidden" class="DIV_CONTEUDO">
      <div style="padding-bottom: 5px; padding-top: 3px; margin-bottom: 5px" align="center">
        <input 
            type="button" 
            class="bttGridClass" style="margin: 0; font-size: 14px; width: 100px" 
            value="  Atualizar  " onClick="selectUsuarios();" />
        &nbsp;&nbsp;
        <input 
            type="button" 
            class="bttGridClass" style="margin: 0; font-size: 14px; width: 100px" 
            value="  Filtro  " onClick="FW_gridAtivarFiltro('P01_GRID_USUARIOS');" />
        &nbsp;&nbsp;
        <input 
            type="button"
            class="bttGridClass" style="margin: 0; font-size: 14px; width: 100px" 
            value="Novo" onclick="ativarFormModal('')" />
        &nbsp;&nbsp;
        <input 
            type="button"
            class="bttGridClass" style="margin: 0; font-size: 14px; width: 120px" 
            value="Meus dados" onClick="ativarFormModal('<?php echo $GEN_ID;?>')" />
        &nbsp;&nbsp;
        <input 
            type="button"
            class="bttGridClass" style="margin: 0; font-size: 14px; width: 120px" 
            value="Impress&atilde;o" onClick="listaUsuarios('P01_GRID_USUARIOS')" />
            
      </div>    
    	<div id="DIV_CONTEUDO_GRID"></div>
    </div>
    
    <input type="hidden" name="GEN_ID"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="GEN_NOME"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS" value="<?php echo $GEN_USER_STATUS;?>" />
    
    <input type="hidden" name="GEN_ACAO_GERAL" id="GEN_ACAO_GERAL" />
    <input type="hidden" name="GEN_DOC_WIDTH"  value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT" value="<?php echo $GEN_DOC_HEIGHT;?>" />
    
		<input type="hidden"  name="GRID_USER_SELECTED" id="GRID_USER_SELECTED" />
    
  </form>
  
  <form id="formReport" name="formReport" action="usuariosReport.php" method="post" target="_blank">
    <input type="hidden" id="GRID_TITULO_PRINT_REPORT" name="GRID_TITULO_PRINT_REPORT" />
    <input type="hidden" id="GRID_SQL_QUERY_REPORT" name="GRID_SQL_QUERY_REPORT" />
  </form>  
  
  <form id="formReturn" name="formReturn" action="../index.php" method="post">
    <input type="hidden" name="GEN_ID_"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="GEN_NOME_"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS_" value="<?php echo $GEN_USER_STATUS;?>" />
    <input type="hidden" name="GEN_DOC_WIDTH_"   value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT_"  value="<?php echo $GEN_DOC_HEIGHT;?>" />
  
  </form>
  
	<div id="DIV_FORM_MODAL" align="center">
  	<div id="DIV_FORM_MODAL_AGUARDE" style="display: none"></div>
  	<iframe id="iframeForm" frameborder="0"></iframe>
  </div><?php 

	$DISPLAY_AUX = "none";
	if($_SESSION["SS_IN_MANUT"] == true) $DISPLAY_AUX = "block";?>
	
	<div style="background-color:#FFF; width: 100%; display: <?php echo $DISPLAY_AUX;?>">
		<iframe id="iframeGeral" name="iframeGeral" style="width: 100%; height: 300px;"></iframe>
	</div>
  
</body></html><?php 
}?>