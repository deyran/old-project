<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
include "../../../includes/library/myLibrary.inc";

if($FW_DADOS_OK == false){?>
	<script type="text/javascript"><?php
		$MENSAGEM_RETORNO = "<strong>Ausência de dados importantes!!!</strong>";
		echo "window.location = '../../../index.php?MENSAGEM_RETORNO=" . $MENSAGEM_RETORNO . "';";?>
	</script><?php
	
	echo "</head><body></body></html>";

} else {
	session_start();
	$_SESSION["SS_IN_MANUT"] = true;
	
	if($_SESSION["SS_IN_MANUT"] == false) {
		ini_set("display_errors", 0); 
	}?>
  
  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../../../includes/css/gen_style.css">

	<link rel="stylesheet" type="text/css" href="../../../includes/jquery-ui-1.11.4.custom/jquery-ui.css">

	<script type="text/javascript" src="../../../includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
  <script type="text/javascript" src="../../../includes/jquery-ui-1.11.4.custom/jquery-ui.js" charset="utf-8"></script>
  
	<script type="text/javascript" src="../../../includes/js/FW_v2.js"     charset="utf-8"></script>
	<script type="text/javascript" src="../../../includes/js/makeGrid.js"  charset="utf-8"></script>
  <script type="text/javascript" src="../../../includes/js/gen_geral.js" charset="utf-8"></script>

  <script type="text/javascript">
		var aguarde_azul        = "<img src=\"../../../imagens/aguarde_azul.gif\" />", 
				GEN_DOC_HEIGHT      = <?php echo $GEN_DOC_HEIGHT;?>,
				GEN_DOC_WIDTH       = <?php echo $GEN_DOC_WIDTH;?>,
				DIV_AGUARDE_MODAL   = null,
				DIV_FILTRO = null;
		
		$(function(){
			DIV_FILTRO = $("#DIV_FILTRO").dialog({
			 resizable: false,								
					 modal: false,				
				autoOpen: false,
					height: 400,
					 width: 900,
        position: {my: "top", at: "top+150"},
				
					create: function (event, ui) {$(".ui-widget-header").hide();},						 
					
				 buttons: [{
						 text: "Aplicar",
						click: function() {
							//
						}
					},	{
						 text: "Sair",
						click: function() {
							$(this).dialog("close");
						}
					}]					 
			});
			
			$(".bttGridClass").button();
		  $(".selGridClass").selectmenu();
 			$("#GEN_FILTRAR_ELEITOR").focus();
			$("#DIV_FILTRO_TABS").tabs();

			$(".DIV_FILTRO_UF_CLASS").selectable({
				stop: function() {
					var result = "";
					$("#GEN_FILTRO_UF").val("");
					
					$(".ui-selected", this).each(function() {
						var index = $(".DIV_FILTRO_UF_CLASS li").index(this);
						
						if(index != -1)  {
							if(result != "") result += ", ";
							result += (index);
						}
						
					});
					
					$("#GEN_FILTRO_UF").val(result);
					
				}
			});
			$("#LI_UF_<?php echo $GEN_UF_ID;?>").addClass('ui-selected');
			
			DIV_FILTRO.dialog("open");

		});
	
		//FILTRO AVANÇADO
		function selectLocalidade(pACTION)       {
			$("#GEN_ACAO_GERAL_F").val(pACTION);
			$("#formFiltro").attr("action", "indexHidden.php").submit();
		}
		function selectLstLocalidade(pID, pTIPO) {
			$("#GEN_FILTRO_" + pTIPO).val(pID);
			$("#DIV_FILTRO_LST_" + pTIPO).hide();
			$("#GEN_ACAO_GERAL_F").val("LST_" + pTIPO);
			$("#DIV_FILTRO_LST_" + pTIPO + "_AGUARDE").show();          
			
			$("#formFiltro").attr("action", "indexHidden.php").submit();
		}
		function setLstLocalidade(pHTML, pTIPO)  {
			$("#DIV_FILTRO_LST_" + pTIPO).show();
			$("#DIV_FILTRO_LST_" + pTIPO).html(pHTML);
			$("#DIV_FILTRO_LST_" + pTIPO + "_AGUARDE").hide();          
		}
		
	</script>

  <style type="text/css">
		body {<?php 
	 		if($_SESSION["SS_IN_MANUT"] == false) {
				echo "overflow: hidden;";
			}?>
		} 

		.DIV_FILTRO_UF_CLASS .ui-selecting { background: #A8A8FF; }
		.DIV_FILTRO_UF_CLASS .ui-selected { background: #D9D9FF; color: #000; }
		.DIV_FILTRO_UF_CLASS { list-style-type: none; margin: 0; padding: 0; width: 174px; }
		.DIV_FILTRO_UF_CLASS li { margin: 3px; padding: 0.4em; float: left; width: 20px; font-size: 12px; height: 12px; cursor: pointer; 	}
		
		.FILTRO_CLASS {
			margin: 3px;
			color: #000;
			padding: 0.4em;
			font-size: 12px; 
			height: 14px;
			list-style-type: none;
			border: 1px solid #A8A8FF;
			text-transform: uppercase;
			vertical-align: central;
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
				G&nbsp;E&nbsp;S&nbsp;T&nbsp;Ã&nbsp;O&nbsp;
        D&nbsp;E&nbsp;
        E&nbsp;L&nbsp;E&nbsp;I&nbsp;T&nbsp;O&nbsp;R&nbsp;E&nbsp;S
        
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

	$DIV_CONTENT_HEIGHT = (((int)$GEN_DOC_HEIGHT * 90.5) / 100);
	$DIV_CONTENT_WIDTH  = (((int)$GEN_DOC_WIDTH  * 99.4) / 100);
	
	if($GEN_NAVEGADOR == "FIREFOX")    {
		$DIV_CONTENT_HEIGHT = (((int)$GEN_DOC_HEIGHT * 91) / 100);
		$DIV_CONTENT_WIDTH  = (((int)$GEN_DOC_WIDTH  * 99.4) / 100);

		if($DIV_CONTENT_HEIGHT < 446) $DIV_CONTENT_HEIGHT = 430.5;
		if($DIV_CONTENT_WIDTH  < 796) $DIV_CONTENT_WIDTH  = 792;
		
	} 
	elseif($GEN_NAVEGADOR == "SAFARI") {
		$DIV_CONTENT_HEIGHT = (((int)$GEN_DOC_HEIGHT * 91.0) / 100);
		$DIV_CONTENT_WIDTH  = (((int)$GEN_DOC_WIDTH  * 99.4) / 100);
		
		if($DIV_CONTENT_HEIGHT < 435) $DIV_CONTENT_HEIGHT = 417;
		if($DIV_CONTENT_WIDTH  < 796) $DIV_CONTENT_WIDTH  = 792;

	} 
	else {
		$DIV_CONTENT_HEIGHT = (((int)$GEN_DOC_HEIGHT * 91.2) / 100);
		$DIV_CONTENT_WIDTH  = (((int)$GEN_DOC_WIDTH  * 99.4) / 100);

		if($DIV_CONTENT_HEIGHT < 462) $DIV_CONTENT_HEIGHT = 447.2;
		if($DIV_CONTENT_WIDTH  < 796) $DIV_CONTENT_WIDTH  = 792;

	}?>
	
  <form id="formGrid" name="formGrid" method="post" target="iframeGeral">
    <div id="DIV_CONTENT" 
    style="width: <?php echo $DIV_CONTENT_WIDTH;?>px; 
          border: 1px solid #000; 
background-color: #FFF; 
          margin: 3px;
          height: <?php echo $DIV_CONTENT_HEIGHT;?>px; 
        overflow: auto">
      
      <table border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top: 5px">
      <tr><td valign="top" colspan="2"><?php
        FW_V2_drawTitle("Nome, endereço, fone e contatos", "font-size: 14px; font-style: italic");?>
        
      </td></tr>
      <tr><td valign="top">
        <input id="GEN_FILTRAR_ELEITOR" type="text" style="width: 400px; font-size: 14px; " class="textbox" />
        
      </td><td valign="middle" style="padding-left: 5px">
      	<a href="FILTRO_AVANÇADO" onclick="alert('Filtro avançado'); return false;" title="Filtro avançado">
        	<img src="<?php echo $FW_PATH_IMAGE;?>nodes/filtro.gif" />
        </a>
        
      </td></tr>
      </table>
      <table border="0" cellspacing="0" cellpadding="5" align="center">
      <tr><td valign="top" style="color: #000">
        0
      </td><td valign="top" style="color: #000;">
        de
      </td><td valign="top" style="color: #000;"><?php 
        $SQL_QUERY_GEN_AUX = "
        SELECT COUNT(P.P01_ID) AS P01_ID_QT
        FROM P01_PESSOA AS P";
        
        $P01_ID_QT    = 0;
        $CONECTAR_DB  = FW_conctarDB();
        $SQL_QUERY    = $SQL_QUERY_GEN_AUX;
        $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
        $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
        $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
        
        if($NUM_LINES_DB > 0) {
          while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
            $P01_ID_QT = $DADOS_ROW[0];
          }
        }
        
        echo $P01_ID_QT;
        
        FW_desconctarDB($CONECTAR_DB);?>
        
      </td></tr>
      </table>

      <table border="0" cellspacing="0" cellpadding="0" align="center" style=""><?php
			$STYLE_AUX = "margin: 0; font-size: 14px; width: 110px;";?>
      <tr><td valign="top">
        <input 
           type = "button" 
          class = "bttGridClass" 
          style = " <?php echo $STYLE_AUX;?>"
          value = "  Atualizar  " 
        onclick = "" />

      </td><td valign="top" style="padding-left: 14px">
        <input 
           type = "button" 
          class = "bttGridClass" 
          style = " <?php echo $STYLE_AUX;?>"
          value = "  Novo  " 
        onclick = "" />

      </td><td valign="top" style="padding-left: 14px">
        <input 
           type = "button" 
          class = "bttGridClass" 
          style = " <?php echo $STYLE_AUX;?>"
          value = "  Excluir  " 
        onclick = "" />

      </td><td valign="top" style="padding-left: 14px">
        <input 
           type = "button" 
          class = "bttGridClass" 
          style = " <?php echo $STYLE_AUX;?>"
          value = "  Impressão  " 
        onclick = "" />

      </td><td valign="top" style="padding-left: 14px">
        <input 
           type = "button" 
          class = "bttGridClass" 
          style = " <?php echo $STYLE_AUX;?>"
          value = "  Etiquetas  " 
        onclick = "" />

      </td></tr>
      </table>
      
    </div>
  
    <input type="hidden" name="GEN_ID"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="GEN_NOME"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS" value="<?php echo $GEN_USER_STATUS;?>" />
    
    <input type="hidden" name="GEN_ACAO_GERAL" id="GEN_ACAO_GERAL" />
    <input type="hidden" name="GEN_DOC_WIDTH"  value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT" value="<?php echo $GEN_DOC_HEIGHT;?>" />
    <input type="hidden" name="DIV_CONTENT_HEIGHT"  value="<?php echo $DIV_CONTENT_HEIGHT;?>" />
    
  </form>

  <form id="formReturn" name="formReturn" action="../../index.php" method="post">
    <input type="hidden" name="GEN_ID_"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="GEN_NOME_"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS_" value="<?php echo $GEN_USER_STATUS;?>" />
    <input type="hidden" name="GEN_DOC_WIDTH_"   value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT_"  value="<?php echo $GEN_DOC_HEIGHT;?>" />
  
  </form>
	
  <div id="DIV_FILTRO" class="semMargPadd">
    <form id="formFiltro" name="formFiltro" method="post" target="iframeGeral"> 
      <div id="DIV_FILTRO_TABS">
        <ul>
        <li><a href="#DIV_FILTRO_TABS_4">Localidade</a></li>
        <li><a href="#DIV_FILTRO_TABS_1">Atendimentos</a></li>
        <li><a href="#DIV_FILTRO_TABS_2">Grupos</a></li>
        <li><a href="#DIV_FILTRO_TABS_3">Aniversariantes</a></li>
        
        </ul>
        
        <div id="DIV_FILTRO_TABS_1"></div>
        <div id="DIV_FILTRO_TABS_2"></div>
        <div id="DIV_FILTRO_TABS_3"></div>
        <div id="DIV_FILTRO_TABS_4">
          <table border="0" cellspacing="5" cellpadding="0" align="center" style="padding-top: 0px">
          <tr><td valign="top"><?php
            $STYLE_AUX = "border-bottom: 1px solid #E4E4E4; font-size: 14px";
            FW_V2_drawTitle("Estados", $STYLE_AUX);?>
            
            <ol class="DIV_FILTRO_UF_CLASS semMargPadd" style="padding-left: 7px"><?php 
            for($i = 0; $i < 27; $i++) {
            echo "<li id='LI_UF_" . $i . "' class='ui-widget-content' title='" . $GEN_UF_ARR[$i][1] . "'>
            <div align='center'>" . 
            $GEN_UF_ARR[$i][0] . 
            "</div></li>";
            }?>
            
            </ol>      
            
            <input type="text" id="GEN_FILTRO_UF" name="GEN_FILTRO_UF" value="<?php echo $GEN_UF_ID;?>" />
          
          </td><td valign="top"><?php
            FW_V2_drawTitle("Munic&iacute;pios", $STYLE_AUX);?>
            <div id="DIV_GEN_MUN" style="padding-left: 7px"><?php
              $FW_V2_CSSDIVCONTENT = 
              "position: absolute; background-color: #FFFFFF; width: 250px;" 	.
              "height: 100px; overflow: auto; border: 1px solid #CCCCCC; $fonteSizeAux ";
              
              FW_V2_componenteHtml(
                array(
                "FW_V2_TIPOCOM"       => "AUTO",		
                "FW_V2_IDCOMP"        => "GEN_MUN_ID",
                "FW_V2_DESCNOME"      => "GEN_MUN_DESCRICAO",
                "FW_V2_VALUE"         => "",
                "FW_V2_DESCRICAO"     => "",			
                "FW_V2_DICA"          => "Clique aqui",
                "FW_V2_CSSDIVCONTENT" => $FW_V2_CSSDIVCONTENT,
                "FW_V2_FUNCHIDDEN"    => "selectLocalidade('SELECT_MUNICIPIO');",
                "FW_V2_CSS"           => "text-transform: uppercase; font-size: 12px; width: 250px; color: #3F5F8D; $fonteSizeAux",
                "FW_V2_TITULO"        => ""
                )	
              );?>
            </div>
  
            <div id="DIV_FILTRO_LST_MUNICIPIO"></div>
            <div id="DIV_FILTRO_LST_MUNICIPIO_AGUARDE" style="display: none">
            	<img src="<?php echo $FW_PATH_IMAGE . "aguarde_azul.gif";?>" />
            </div>
            
          </td><td valign="top"><?php
            FW_V2_drawTitle("Bairros", $STYLE_AUX);?>
            <div id="DIV_GEN_BAI" style="padding-left: 7px"><?php
              $FW_V2_CSSDIVCONTENT = 
              "position: absolute; background-color: #FFFFFF; width: 250px;" 	.
              "height: 100px; overflow: auto; border: 1px solid #CCCCCC; $fonteSizeAux ";
              
              FW_V2_componenteHtml(
                array(
                "FW_V2_TIPOCOM"       => "AUTO",		
                "FW_V2_IDCOMP"        => "GEN_BAI_ID",
                "FW_V2_DESCNOME"      => "GEN_BAI_DESCRICAO",
                "FW_V2_VALUE"         => "",
                "FW_V2_DESCRICAO"     => "",			
                "FW_V2_DICA"          => "Clique aqui",
                "FW_V2_CSSDIVCONTENT" => $FW_V2_CSSDIVCONTENT,
                "FW_V2_FUNCHIDDEN"    => "selectLocalidade('SELECT_BAIRRO');",
                "FW_V2_CSS"           => "text-transform: uppercase; font-size: 12px; width: 250px; color: #3F5F8D; $fonteSizeAux",
                "FW_V2_TITULO"        => ""
                )	
              );?>
            </div>
  
            <div id="DIV_FILTRO_LST_BAIRRO"></div>
            <div id="DIV_FILTRO_LST_BAIRRO_AGUARDE" style="display: none">
            	<img src="<?php echo $FW_PATH_IMAGE . "aguarde_azul.gif";?>" />
            </div>
            
          </td></tr>
          </table>
        
        </div>
      
      </div>
      
    	<input type="hidden" id="GEN_ACAO_GERAL_F"     name="GEN_ACAO_GERAL_F" />
      <input type="hidden" id="GEN_FILTRO_BAIRRO"    name="GEN_FILTRO_BAIRRO" />
      <input type="hidden" id="GEN_FILTRO_MUNICIPIO" name="GEN_FILTRO_MUNICIPIO" />      
      
    </form>
  </div>
    
    
    
	<?php 

	$DISPLAY_AUX = "none";
	if($_SESSION["SS_IN_MANUT"] == true) $DISPLAY_AUX = "block";?>
	
	<div style="background-color:#FFF; width: 100%; display: <?php echo $DISPLAY_AUX;?>">
		<iframe id="iframeGeral" name="iframeGeral" style="width: 100%; height: 300px;"></iframe>
	</div>
  
</body></html><?php 
}?>