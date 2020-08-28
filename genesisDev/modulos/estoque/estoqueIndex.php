<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
  include "../../includes/library/myLibrary.inc";
  include "estoqueInc.inc";
	
	session_start();
	$_SESSION["SS_IN_MANUT"] = false;	
	
	$E01_ID = "";
	$MENSAGEM_RETORNO = "";
	
	if(isset($_GET["E01_ID"])) $E01_ID = $_GET["E01_ID"];
	if(isset($_REQUEST["MENSAGEM_RETORNO"])) $MENSAGEM_RETORNO = $_REQUEST["MENSAGEM_RETORNO"];
	//--------------------------------------------------------------------------------------------

	$E01_QTD       = 0;
	$EA1_ID        = "";
	$EA1_DESCRICAO = "";
	$EA0_ID        = "";
	$EA0_DESCRICAO = "";
	$E01_MODELO    = "";
	$E01_TAMANHO   = "";
	$E01_LOCAL_ARM = "";
	$P01_DESCRICAO = $GEN_NOME;
	
	if(strlen(trim($E01_ID)) > 0) {
		$SQL_QUERY_GEN_AUX = "
		SELECT T.EA1_ID,
					 T.EA1_DESCRICAO,
					 G.EA0_ID,
					 G.EA0_DESCRICAO,
					 O.E01_MODELO,
					 O.E01_TAMANHO,
					 O.E01_QTD,
					 O.E01_LOCAL_ARM,
					 
					 P.P01_DESCRICAO
					 
		FROM E01_OCULOS AS O
				 LEFT JOIN EA1_TIPO_ARMACAO AS T ON O.EA1_ID = T.EA1_ID
				 LEFT JOIN EA0_GENERO       AS G ON O.EA0_ID = G.EA0_ID
				 LEFT JOIN P01_PESSOA       AS P ON O.E01_EMISSOR = P.P01_ID
				 
		WHERE O.E01_ID = $E01_ID";
		
		$CONECTAR_DB  = FW_conctarDB();
		$SQL_QUERY    = $SQL_QUERY_GEN_AUX;
		$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
		$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
		$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
		
		if($NUM_LINES_DB > 0) {
			while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
				$EA1_ID        = $DADOS_ROW[0];
				$EA1_DESCRICAO = $DADOS_ROW[1];
				$EA0_ID        = $DADOS_ROW[2];
				$EA0_DESCRICAO = $DADOS_ROW[3];
				$E01_MODELO    = $DADOS_ROW[4];
				$E01_TAMANHO   = $DADOS_ROW[5];
				$E01_QTD       = $DADOS_ROW[6];
				$E01_LOCAL_ARM = $DADOS_ROW[7];
				$P01_DESCRICAO = $DADOS_ROW[8];
			
			}
		}
		
		FW_desconctarDB($CONECTAR_DB);		
		
	}

	if(strlen(trim($E01_LOCAL_ARM)) > 49) $E01_LOCAL_ARM = substr(trim($E01_LOCAL_ARM), 0, 49);
	if(strlen(trim($EA1_DESCRICAO)) > 43) $EA1_DESCRICAO = substr(trim($EA1_DESCRICAO), 0, 43);?>
  
  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css">

	<link rel="stylesheet" type="text/css" href="../../includes/jquery-ui-1.11.4.custom/jquery-ui.css">
	<script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
  <script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/jquery-ui.js" charset="utf-8"></script>
  
	<script type="text/javascript" src="../../includes/js/FW_v2.js"     charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/makeGrid.js"  charset="utf-8"></script>
 	<script type="text/javascript" src="../../includes/js/notice.js"    charset="utf-8"></script>
  <script type="text/javascript" src="../../includes/js/gen_geral.js" charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/jquery.maskedinput.min.js" charset="utf-8"></script>

  <script type="text/javascript">
		var aguarde_azul      = "<img src=\"../../imagens/aguarde_azul.gif\" />", 
		    GEN_DOC_HEIGHT    = <?php echo $GEN_DOC_HEIGHT;?>,
				GEN_DOC_WIDTH     = <?php echo $GEN_DOC_WIDTH;?>,
				DIV_FORM_MODAL    = null,
				DIV_AGUARDE_MODAL = null;
				DIV_IMG_LOADING   = "<div align=\"center\"><br />" + 
														"		<img src=\"../../imagens/loading_img.gif\" width=\"150\" />" + 
														"</div>";

		function fecharAguardeModal() {
			DIV_AGUARDE_MODAL.dialog("close");
		}
		function reloadPage(pID)      {
			$("#formReload")
			.attr("action", "estoqueIndex.php?E01_ID=" + pID).submit();			
		}
		
		$(function(){
			DIV_AGUARDE_MODAL = $("#DIV_AGUARDE_MODAL").dialog({
				autoOpen: false,
					height: 180,
					 width: 300,
					 modal: true,
				position: {my: "top", at: "top"},
						open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog | ui).hide(); }
					 
			});<?php
				
			if($FW_DADOS_OK == true) {?>
				$("#DIV_TABS").tabs();
				$(".bttClass").button();
				parent.formModalShow(); <?php
				
				if(trim($MENSAGEM_RETORNO) != "") {?>
					newAlert("<span style='font-size: 18px'><?php echo $MENSAGEM_RETORNO?></span>", "", "");<?php
				}
				
			} elseif($FW_DADOS_OK == false) {?>
				var pagina = "../../index.php?MENSAGEM_RETORNO=<strong>Ausência de dados importantes!!!</strong>";
				
				try {
					parent.window.location = pagina;
					
				} catch(e){
					window.location = pagina;
					
				}<?php
								
			}?>
			
		});	
		
	</script>

  <style type="text/css">
		body {
			background-color: #FFF; <?php 
	 		if($_SESSION["SS_IN_MANUT"] == false) {
				echo "overflow: hidden;";
			}?>
		}
		
		.DIV_BUTTONS {
			  border-top: 1px solid #E5E5E5; 
			     z-index: 1001; 
			  margin-top: 15px; 
		   padding-top: 10px; 
		   	   display: block			
		}  
   </style>
  
</head><body>
	<div id="DIV_AGUARDE_MODAL" title="GÊNESIS - AGUARDE ...">
  	<div align="center">
	  	<img src="../../imagens/loading_img.gif" width="100" />
    </div>
  </div>

  <form id="formGeral" name="formGeral" method="post" target="iframeGeral"><?php
		$DIV_TAB_WIDTH = (((int) $GEN_DOC_WIDTH  * 49.7) / 100); //678.902
		$DIV_TAB_HEIGHT = (((int)$GEN_DOC_HEIGHT * 36) / 100);
    
		if($GEN_NAVEGADOR == "FIREFOX") {
			$DIV_TAB_WIDTH = (((int) $GEN_DOC_WIDTH  * 47.6) / 100);
			$DIV_TAB_HEIGHT = (((int)$GEN_DOC_HEIGHT * 36) / 100);
			
			if($DIV_TAB_WIDTH < 630) $DIV_TAB_WIDTH = 630;
			if($DIV_TAB_HEIGHT< 220) $DIV_TAB_HEIGHT = 220;	

		} elseif($GEN_NAVEGADOR == "SAFARI") {
			$DIV_TAB_WIDTH = (((int) $GEN_DOC_WIDTH  * 49.7) / 100);
			
			if($DIV_TAB_WIDTH < 630) $DIV_TAB_WIDTH  = 630; //397.6
			if($DIV_TAB_HEIGHT< 225) $DIV_TAB_HEIGHT = 225;	//161.5;
			
		} else {
			$DIV_TAB_WIDTH = (((int) $GEN_DOC_WIDTH  * 47.6) / 100);
			$DIV_TAB_HEIGHT = (((int)$GEN_DOC_HEIGHT * 36) / 100);
			
			if($DIV_TAB_WIDTH < 630) $DIV_TAB_WIDTH = 630;
			if($DIV_TAB_HEIGHT< 220) $DIV_TAB_HEIGHT = 220;	
			
		}?>
    
    <table border="0" cellspacing="0" cellpadding="0" align="center">
    <tr><td valign="top">
      <div id="DIV_TABS" style="border: 0px solid; width: <?php echo $DIV_TAB_WIDTH;?>px">
        <ul>
          <li><a href="#DIV_TABS-1" tabindex="-1">Registros</a></li><?php
					
					if(strlen(trim($E01_ID)) > 0) {?>
						<li><a href="#DIV_TABS-2" tabindex="-1">Movimenta&ccedil;&atilde;o</a></li>	
            <li>
              <a   href = "#DIV_TABS-3" 
               tabindex = "-1"
                onclick = "$('#DIV_GRID_HIST_MOV').html(DIV_IMG_LOADING); 
                           doSubmit('formGeral', 'estoqueIndexHidden.php', 'HIST_MOV_GRID')">
              	Hist&oacute;rico
              </a>
            </li><?php
						
					}?>
        </ul><?php
        
        $fonteSizeAux      = " font-size: 16px; ";
        $fonteSizeTitleAux = " font-size: 16px; ";
				$DIV_TAB_FORM_HEIGHT = (((int) $DIV_TAB_HEIGHT * 79) / 100);?>
          
        <div id="DIV_TABS-1" class="semMargPadd" 
        style="height: <?php echo $DIV_TAB_HEIGHT;?>px; ">
        	<div style="height: <?php echo $DIV_TAB_FORM_HEIGHT;?>px">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr><td valign="top"><?php 
              $E01_MODELO_WIDTH = (((int) $DIV_TAB_WIDTH  * 29.3) / 100);
                
              FW_V2_componenteHtml(
                array(
                  "FW_V2_IDCOMP"    => "E01_MODELO",
                  "FW_V2_TIPOCOM"   => "TEXT",
                  "FW_V2_VALUE"     => $E01_MODELO,
                  "FW_V2_DICA"      => "Clique aqui",
                  "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
                  "FW_V2_CSS"       => "width: " . $E01_MODELO_WIDTH . "px; color: #3F5F8D; $fonteSizeAux",
                  "FW_V2_TITULO"    => "Modelo",
									"FW_V2_MAXLENGTH" => 30
                )	
              );?>
             
            </td><td valign="top" style="padding-left: 7px;"><?php
              $EA1_DESCRICAO_WIDTH = (((int) $DIV_TAB_WIDTH  * 41) / 100);
              
              $FW_V2_CSSDIVCONTENT = 
              "position: absolute; z-index: 1000; background-color: #FFFFFF; width: " . $EA1_DESCRICAO_WIDTH . "px;" 	.
              "height: 140px; overflow: auto; border: 1px solid #CCCCCC; $fonteSizeAux ";
              
              FW_V2_componenteHtml(
                array(
                  "FW_V2_TIPOCOM"       => "AUTO",		
                  "FW_V2_IDCOMP"        => "EA1_ID",
                  "FW_V2_DESCNOME"      => "EA1_DESCRICAO",
                  "FW_V2_VALUE"         => $EA1_ID,
                  "FW_V2_DESCRICAO"     => $EA1_DESCRICAO,			
                  "FW_V2_DICA"          => "Clique aqui",
                  "FW_V2_CSSTITULO"     => $fonteSizeTitleAux,
                  "FW_V2_CSSDIVCONTENT" => $FW_V2_CSSDIVCONTENT,
                  "FW_V2_FUNCHIDDEN"    => "doSubmit('formGeral', 'estoqueIndexHidden.php', 'SELECT_TIPO_ARMACAO')",			
                  "FW_V2_CSS"           => "width: " . $EA1_DESCRICAO_WIDTH . "px; color: #3F5F8D; $fonteSizeAux",
                  "FW_V2_TITULO"        => "Tipo de arma&ccedil;&atilde;o"
                )	
              );?>
              
            </td><td valign="top" style="padding-left: 7px"><?php 
              $E01_TAMANHO_WIDTH = (((int) $DIV_TAB_WIDTH  * 14) / 100);
            
              FW_V2_componenteHtml(
                array(
                  "FW_V2_IDCOMP"    => "E01_TAMANHO",
                  "FW_V2_TIPOCOM"   => "INT",
                  "FW_V2_VALUE"     => $E01_TAMANHO,
                  "FW_V2_DICA"      => "clique aqui",
                  "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
                  "FW_V2_CSS"       => "width: " . $E01_TAMANHO_WIDTH . "px; color: #3F5F8D; text-align: left;  $fonteSizeAux",
                  "FW_V2_CSSRELAT"  => "width: " . $E01_TAMANHO_WIDTH . "px; color: #3F5F8D; text-align: right; $fonteSizeAux",
                  "FW_V2_TITULO"    => "Tamanho"
                )	
              );?>
          
            </td></tr>
            <tr><td valign="top" nowrap style="padding-top: 7px"><?php 
              $FW_V2_OPTIONLIST = "<option value='NULL'></option>";
              
              $SQL_QUERY_GEN = "
              SELECT E.EA0_ID, E.EA0_DESCRICAO
              FROM EA0_GENERO AS E";
                        
              $CONECTAR_DB  = FW_conctarDB();
              $SQL_QUERY    = $SQL_QUERY_GEN;
              $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
              $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
              $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
              
              if($NUM_LINES_DB > 0) {
                while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
                  $FW_V2_OPTIONLIST = "$FW_V2_OPTIONLIST <option value='$DADOS_ROW[0]' title='$DADOS_ROW[1]'>$DADOS_ROW[1]</option>";
                }
              }
              
              FW_desconctarDB($CONECTAR_DB);
              
              $FW_V2_OPTIONLIST = urlencode(trim($FW_V2_OPTIONLIST));
              $EA0_ID_WIDTH = (((int) $DIV_TAB_WIDTH  * 29.3) / 100);
              
              FW_V2_componenteHtml(
                array(
                  "FW_V2_IDCOMP"     => "EA0_ID",
                  "FW_V2_TIPOCOM"    => "SELECT",
                  "FW_V2_DICA"       => "clique aqui",
                  "FW_V2_VALUE"      => $EA0_ID,
                  "FW_V2_DESCRICAO"  => $EA0_DESCRICAO,
                  "FW_V2_OPTIONLIST" => $FW_V2_OPTIONLIST,
                  "FW_V2_CSSTITULO"  => $fonteSizeTitleAux,
                  "FW_V2_CSS"        => "color: #3F5F8D; $fonteSizeAux",
                  "FW_V2_CSSRELAT"   => "width: " . $EA0_ID_WIDTH . "px; color: #3F5F8D; $fonteSizeAux",
                  "FW_V2_TITULO"     => "G&ecirc;nero"
                )	
              );?>
            </td><td valign="top"  style="padding-top: 7px; padding-left: 7px"><?php 
              $E01_LOCAL_ARM_WIDTH = (((int) $DIV_TAB_WIDTH  * 41) / 100);
              
              FW_V2_componenteHtml(
                array(
                  "FW_V2_IDCOMP"    => "E01_LOCAL_ARM",
                  "FW_V2_TIPOCOM"   => "TEXT",
                  "FW_V2_VALUE"     => $E01_LOCAL_ARM,
                  "FW_V2_DICA"      => "clique aqui",
                  "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
                  "FW_V2_CSS"       => "width: " . $E01_LOCAL_ARM_WIDTH . "px; color: #3F5F8D; $fonteSizeAux",
                  "FW_V2_CSSRELAT"  => "width: " . $E01_LOCAL_ARM_WIDTH . "px; color: #3F5F8D; $fonteSizeAux",
									"FW_V2_MAXLENGTH" => 49,
                  "FW_V2_TITULO"    => "Local armazenamento"
                )	
              );?>
            
            </td><td valign="top" style="padding-top: 7px; padding-left: 7px;">
							<div id="DIV_E01_QTD_READ"><?php 
								$E01_QTD_WIDTH = (((int) $DIV_TAB_WIDTH  * 14) / 100);
				
								FW_V2_componenteHtml(
									array(
										"FW_V2_IDCOMP"    => "E01_QTD_READ",
										"FW_V2_TIPOCOM"   => "READ",
										"FW_V2_VALUE"     => FW_numeroEspacoMilhar($E01_QTD),
										"FW_V2_CSSTITULO" => $fonteSizeTitleAux,
										"FW_V2_CSS"       => "width: " . $E01_QTD_WIDTH . "px; color: #000; text-align: right; $fonteSizeAux",
										"FW_V2_TITULO"    => "Quantidade"
									)	
								);?>
							</div>              
            </td></tr>
            <tr><td valign="top" style="padding-top: 7px;" nowrap colspan="3"><?php 
              FW_V2_componenteHtml(
                array(
                  "FW_V2_IDCOMP"    => "EMISSOR",
                  "FW_V2_TIPOCOM"   => "READ",
                  "FW_V2_VALUE"     => $P01_DESCRICAO,
                  "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
                  "FW_V2_CSS"       => "color: #000; $fonteSizeAux",
                  "FW_V2_TITULO"    => "Emissor"
                )	
              );?>
            
            </td></tr>
            </table>
          </div>
          <div class="DIV_BUTTONS" align="center">
            <input                
                 type = "button" 
                class = "bttClass" 
                style = "margin: 0; font-size: 14px; width: 100px" 
                value = " Salvar " 
              onclick = "DIV_AGUARDE_MODAL.dialog('open'); doSubmit('formGeral', 'estoqueIndexHidden.php', 'SALVAR');"  />
              &nbsp;&nbsp;
            <input                
                 type = "button" 
                class = "bttClass" 
                style = "margin: 0; font-size: 14px; width: 110px" 
                value = " Cancelar " 
              onclick = "DIV_AGUARDE_MODAL.dialog('open'); reloadPage('<?php echo $E01_ID;?>');"  />  
              &nbsp;&nbsp;
            <input                
                 type = "button" 
                class = "bttClass" 
                style = "margin: 0; font-size: 14px; width: 100px" 
                value = " Novo " 
              onclick = "DIV_AGUARDE_MODAL.dialog('open'); reloadPage('');"  />
              &nbsp;&nbsp;              
            <input 
                 type = "button" 
                class = "bttClass" 
                style = "margin: 0; font-size: 14px; width: 100px" 
                value = " Sair " 
               onblur = "$('#FW_V2_TAG_A_E01_MODELO').focus();"
              onclick = "parent.fecharFormModal()"  />  

          </div>
        </div><?php
					
				if(strlen(trim($E01_ID)) > 0) {?>
          <div id="DIV_TABS-2" class="semMargPadd" 
          style="height: <?php echo $DIV_TAB_HEIGHT;?>px; ">
            <div id="DIV_FORM_MOV" style="height: <?php echo $DIV_TAB_FORM_HEIGHT;?>px"><?php
							getFormMov($GEN_DOC_WIDTH, $DIV_TAB_FORM_HEIGHT, $E01_QTD);?>
            </div>
            <div class="DIV_BUTTONS" align="center">
              <input                
                   type = "button" 
                  class = "bttClass" 
                  style = "margin: 0; font-size: 14px; width: 100px" 
                  value = " Salvar " 
                onclick = "DIV_AGUARDE_MODAL.dialog('open'); doSubmit('formGeral', 'estoqueIndexHidden.php', 'SALVAR_MOV');"  />
                &nbsp;&nbsp;
              <input                
                   type = "button" 
                  class = "bttClass" 
                  style = "margin: 0; font-size: 14px; width: 100px" 
                  value = " Novo " 
                onclick = "DIV_AGUARDE_MODAL.dialog('open'); doSubmit('formGeral', 'estoqueIndexHidden.php', 'SELECT_FORM_MOV');"  />
                &nbsp;&nbsp;              
              <input 
                   type = "button" 
                  class = "bttClass" 
                  style = "margin: 0; font-size: 14px; width: 100px" 
                  value = " Sair " 
                 onblur = "$('#FW_V2_TAG_A_E01_MODELO').focus();"
                onclick = "parent.fecharFormModal();"  />
            
            </div>           
          </div>
          <div id="DIV_TABS-3" class="semMargPadd" 
          style="height: <?php echo $DIV_TAB_HEIGHT;?>px; ">
          <div style="padding-bottom: 5px; padding-top: 3px; margin-bottom: 5px" align="center">
              <input 
                     type = "button" 
                    class = "bttClass" 
                    style = "margin: 0; font-size: 14px; width: 100px" 
                    value = "  Atualizar  " 
                  onclick = "$('#DIV_GRID_HIST_MOV').html(DIV_IMG_LOADING); 
                             doSubmit('formGeral', 'estoqueIndexHidden.php', 'HIST_MOV_GRID')" />
              &nbsp;&nbsp;
              <input 
                     type = "button" 
                    class = "bttClass" 
                    style = "margin: 0; font-size: 14px; width: 100px" 
                    value = "  Filtro  " 
                  onclick = "FW_gridAtivarFiltro('GRID_HIST_MOV');" />
              &nbsp;&nbsp;
              <input 
                   type = "button"
                  class = "bttClass" 
                  style = "margin: 0; font-size: 14px; width: 120px" 
                  value = "Impress&atilde;o" 
                onclick = "$('#GRID_SQL_QUERY').val($('#GRID_SQL_QUERY_GRID_HIST_MOV').val());
                           $('#formReportHistMov').submit();" />
                  
            </div>
            <div id="DIV_GRID_HIST_MOV" 
            style="height: <?php echo $DIV_TAB_FORM_HEIGHT;?>px;" align="center">&nbsp;</div>                
          </div><?php
				}?>
 
      </div>
    </td></tr>
    </table><?php 
		
		if($_SESSION["SS_IN_MANUT"] == true) {
			echo "
			<div style='font-family: Courier New, Courier, monospace; color: #000; font-size: 20px'>
							&nbsp;E01_ID...............: $E01_ID
				<br />&nbsp;EA1_DESCRICAO_WIDTH..: $EA1_DESCRICAO_WIDTH
				<br />&nbsp;DIV_TAB_FORM_HEIGHT..: $DIV_TAB_FORM_HEIGHT
				<br />&nbsp;DIV_TAB_HEIGHT.......: $DIV_TAB_HEIGHT
				<br />&nbsp;DIV_TAB_WIDTH........: $DIV_TAB_WIDTH
				<br />&nbsp;GEN_ID...............: $GEN_ID
				<br />&nbsp;GEN_NOME.............: $GEN_NOME
				<br />&nbsp;GEN_USER_STATUS......: $GEN_USER_STATUS
				<br />&nbsp;GEN_DOC_WIDTH........: $GEN_DOC_WIDTH
				<br />&nbsp;GEN_DOC_HEIGHT.......: $GEN_DOC_HEIGHT
			</div>";
		}?>
  
    <input type="hidden" name="GEN_ID"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="E01_ID"          value="<?php echo $E01_ID;?>"   />
    <input type="hidden" name="GEN_NOME"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS" value="<?php echo $GEN_USER_STATUS;?>"/>
    <input type="hidden" name="GEN_DOC_WIDTH"   value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT"  value="<?php echo $GEN_DOC_HEIGHT;?>" />
    <input type="hidden" name="GEN_ACAO_GERAL"  id="GEN_ACAO_GERAL"   />  

		<input type="hidden" name="EA1_DESCRICAO_WIDTH" value="<?php echo $EA1_DESCRICAO_WIDTH;?>" />
    <input type="hidden" name="DIV_TAB_WIDTH"       value="<?php echo $DIV_TAB_WIDTH;?>" />
    <input type="hidden" name="DIV_TAB_HEIGHT"      value="<?php echo $DIV_TAB_HEIGHT;?>" />    
    <input type="hidden" name="DIV_TAB_FORM_HEIGHT" value="<?php echo $DIV_TAB_FORM_HEIGHT;?>" />
   	<input type="hidden" name="E01_QTD_ATUAL" id="E01_QTD_ATUAL" value="<?php echo $E01_QTD;?>" />
    
  </form>
  
	<form id="formReportHistMov" name="formReportHistMov" action="estoqueReportHistMov.php" method="post" target="_blank">
    <input type="hidden" id="GRID_SQL_QUERY" name="GRID_SQL_QUERY" />  
  </form>
  
  <form id="formReload" name="formReload" method="post">
    <input type="hidden" name="GEN_ID_"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="GEN_NOME_"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS_" value="<?php echo $GEN_USER_STATUS;?>"/>
    <input type="hidden" name="GEN_DOC_WIDTH_"   value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT_"  value="<?php echo $GEN_DOC_HEIGHT;?>" />
    <input type="hidden" name="GEN_ACAO_GERAL_"  id="GEN_ACAO_GERAL_"   />
  </form><?php 

	$DISPLAY_AUX = "none";
	if($_SESSION["SS_IN_MANUT"] == true) $DISPLAY_AUX = "block";?>
	
	<div style="background-color:#FFF; width: 100%; display: <?php echo $DISPLAY_AUX;?>">
		<iframe id="iframeGeral" name="iframeGeral" style="width: 100%; height: 300px;"></iframe>
	</div>
  
</body></html>