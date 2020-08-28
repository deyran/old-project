<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
  include "../../includes/library/myLibrary.inc";
	
	session_start();
	$_SESSION["SS_IN_MANUT"] = false;

	$SWITCH_FORM     = "";
	$SWITCH_FORM_IDS = "";
	$SWITCH_FORM_TBL = "";
	
	if(isset($_REQUEST["SWITCH_FORM"]))      $SWITCH_FORM      = $_REQUEST["SWITCH_FORM"];
	if(isset($_REQUEST["MENSAGEM_RETORNO"])) $MENSAGEM_RETORNO = $_REQUEST["MENSAGEM_RETORNO"];
	
	if($SWITCH_FORM == "SWITCH_FORM_ARMACAO")    {
		$SWITCH_FORM_IDS = "EA1";
		$SWITCH_FORM_TBL = "EA1_TIPO_ARMACAO";
		
	}
	elseif($SWITCH_FORM == "SWITCH_FORM_GENERO") {
		$SWITCH_FORM_IDS = "EA0";
		$SWITCH_FORM_TBL = "EA0_GENERO";
		
	}?>
  
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

  <script type="text/javascript">
		var aguarde_azul      = "<img src=\"../../imagens/aguarde_azul.gif\" />", 
		    GEN_DOC_HEIGHT    = <?php echo $GEN_DOC_HEIGHT;?>,
				GEN_DOC_WIDTH     = <?php echo $GEN_DOC_WIDTH;?>,
				DIV_AGUARDE_MODAL = null;
		
		function fecharAguardeModal() {
			DIV_AGUARDE_MODAL.dialog("close");
		}
		
		$(function(){<?php
			if($FW_DADOS_OK == true) {?>
				$("#tabTabelasAux").tabs();
				$("#<?php echo $SWITCH_FORM_IDS;?>_DESCRICAO").focus();
				
				parent.formModalTblAuxShow();
				
				DIV_AGUARDE_MODAL = $("#DIV_AGUARDE_MODAL").dialog({
					autoOpen: false,
						height: 180,
						 width: 300,
						 modal: true,
          position: {my: "top", at: "top"},
						  open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog | ui).hide(); }
						 
				});<?php
				
				if(strlen(trim($MENSAGEM_RETORNO)) > 0) {?>
					newAlert("<span style='font-size: 18px'><?php echo $MENSAGEM_RETORNO?></span>", "", "");<?php
					
					if($SWITCH_FORM == "SWITCH_FORM_ARMACAO")    {
						echo "parent.formModalArmacaoReload();";
						
					}
					elseif($SWITCH_FORM == "SWITCH_FORM_GENERO") {
						echo "parent.formModalGeneroReload();";
						
					}
					
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
   </style>
  
</head><body>
	<div id="DIV_AGUARDE_MODAL" title="GÊNESIS - AGUARDE ...">
  	<div align="center">
	  	<img src="../../imagens/loading_img.gif" width="100" />
    </div>
  </div>
  
  <form id="formGrid" name="formGrid" method="post" target="iframeGeral" class="semMargPadd"><?php
		if($GEN_DOC_WIDTH  < 1100) $GEN_DOC_WIDTH  = 1100;
		if($GEN_DOC_HEIGHT < 500 ) $GEN_DOC_HEIGHT = 500;
		
    $DIV_TAB_HEIGHT = (((int)$GEN_DOC_HEIGHT * 50) / 100);
		$DIV_TAB_WIDTH  = (((int)$GEN_DOC_WIDTH  * 30) / 100);
		
		$DIV_TAB_HEIGHT_CONTENT = (((int)$DIV_TAB_HEIGHT * 83) / 100);
		$DIV_TAB_WIDTH_CONTENT  = (((int)$DIV_TAB_WIDTH  * 93) / 100);
		
		$fonteSizeAux      = " font-size: 16px; ";
		$fonteSizeTitleAux = " font-size: 16px; ";?>

		<table border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td align="right" nowrap="nowrap" valign="baseline" style="width: 25px;" colspan="2">
				<a href="javascript: void(0)" 
						title = "Clique para atualizar lista" 
					onclick = " DIV_AGUARDE_MODAL.dialog('open');$('#formReload').submit();" 
						style = "text-decoration: none;">
					<img src="../../imagens/nodes/bpRefresh.gif" width="18" />
				</a>            
			</td>
			<td valign="top" style="padding-left: 5px">
        <table border="0" cellspacing="0" cellpadding="0" width="95%">
        <tr><td valign="top" width=" width: 80%">
          <span style="font-size: 18px"><?php
            if($SWITCH_FORM == "SWITCH_FORM_ARMACAO") {
              echo "Tipo de arma&ccedil;&atilde;o";
              
            } else {
              echo "G&ecirc;nero";
              
            }?>
          </span>        
        
        </td><td valign="middle" align="right" style="padding-left: 14px;">
        	<img src = "../../imagens/nodes/setaEntrando.gif" 
           onclick = "parent.fecharFormModalTblAux()" 
             title = "Clique aqui para sair"
             style = "cursor: pointer" />
          
        </td></tr>
        </table>
      
      
      
				
			</td>
		</tr>
		<tr>
			<td nowrap="nowrap" valign="baseline" style="width: 25px;" align="center">
			 &nbsp;&nbsp;
			</td>
			<td nowrap="nowrap" valign="baseline" style="width: 25px;" align="center"><?php 
				$ONCLICK_SALVAR = "
				$('#" . $SWITCH_FORM_IDS . "_ID').val('');
				DIV_AGUARDE_MODAL.dialog('open');
				doSubmit('formGrid', 'tabelasAuxIndexHidden.php', 'SALVAR');"; // ?>
				
				<a href="javascript: void(0)" 
						title = "Clique para salvar" 
					onclick = "<?php echo $ONCLICK_SALVAR;?>" 
						style = "text-decoration: none;">
					<img src="../../imagens/icons/disk.gif" width="18" />
				</a>
			</td>
			<td style="position: relative; border-left: 1px solid #AAAAAA; padding-left: 5px;">
				<input type = "text" 
								 id = "<?php echo $SWITCH_FORM_IDS;?>_DESCRICAO" 
							 name = "<?php echo $SWITCH_FORM_IDS;?>_DESCRICAO" 
							class = "textbox" 
			 autocomplete = "off"                  
							style = "width: 95%" />
			</td>
		</tr>
		<tr><td colspan="3" valign="top">
			<div style="
			overflow-x: hidden; 
			overflow-y: auto; 
					height: <?php echo $DIV_TAB_HEIGHT_CONTENT;?>px;
					 width: <?php echo $DIV_TAB_WIDTH_CONTENT;?>px; 
					border: 0px solid red">
				<table border="0" cellspacing="0" cellpadding="0"><?php
					if($SWITCH_FORM == "SWITCH_FORM_ARMACAO")    {
						$SQL_QUERY_GEN_AUX = "
						SELECT T.EA1_ID, T.EA1_DESCRICAO, O.EA1_ID_AUX
						FROM EA1_TIPO_ARMACAO AS T LEFT JOIN (
							
							SELECT O.EA1_ID AS EA1_ID_AUX
							FROM E01_OCULOS AS O
							GROUP BY O.EA1_ID
							
						) AS O ON T.EA1_ID = O.EA1_ID_AUX 
						ORDER BY T.EA1_DESCRICAO";
						
					} 
					elseif($SWITCH_FORM == "SWITCH_FORM_GENERO") {
						$SQL_QUERY_GEN_AUX = "
						SELECT E.EA0_ID, E.EA0_DESCRICAO, O.EA0_ID_AUX
						FROM EA0_GENERO AS E LEFT JOIN (
								 SELECT O.EA0_ID AS EA0_ID_AUX
								 FROM E01_OCULOS AS O
								 GROUP BY O.EA0_ID
								 HAVING O.EA0_ID IS NOT NULL
								 
						) AS O ON E.EA0_ID = O.EA0_ID_AUX
						ORDER BY E.EA0_DESCRICAO";
						
					}
					
					$CONECTAR_DB  = FW_conctarDB();
					
					$SQL_QUERY    = $SQL_QUERY_GEN_AUX;
					$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
					$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
					$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
					
					if($NUM_LINES_DB > 0) {
						while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
							$EA_ID        = $DADOS_ROW[0];
							$EA_DESCRICAO = $DADOS_ROW[1];
							$EA_ID_AUX    = $DADOS_ROW[2];
							
							$ONCLICK_DEL = "
							$('#" . $SWITCH_FORM_IDS . "_ID').val($EA_ID);
							doSubmit('formGrid', 'tabelasAuxIndexHidden.php', 'DELETE');
							DIV_AGUARDE_MODAL.dialog('open');";

							$ONCLICK_SALVAR = "
							$('#" . $SWITCH_FORM_IDS . "_ID').val($EA_ID);
							DIV_AGUARDE_MODAL.dialog('open');
							doSubmit('formGrid', 'tabelasAuxIndexHidden.php', 'SALVAR');";
							
							$STYLE_AUX = "; visibility: hidden";
							if(strlen(trim($EA_ID_AUX)) == 0) $STYLE_AUX = "";?>
							
							<tr onmousemove="this.className = 'tdGridAuto'" onmouseout="this.className = ''">
								<td nowrap="nowrap" valign="baseline" style="width: 25px;" align="center">
									<a href="javascript: void(0)" 
									title="Clique para excluir '<?php echo $EA_DESCRICAO;?>'" 
									 onclick="<?php echo $ONCLICK_DEL;?>"
									 style="text-decoration: none <?php echo $STYLE_AUX;?>">
										<img src="../../imagens/excluir.png" width="18" />
									</a>
								</td>
								<td nowrap="nowrap" valign="baseline" style="width: 25px;" align="center">
									<a href = "javascript: void(0)" 
										title = "Clique para salvar '<?php echo $EA_DESCRICAO;?>'" 
									onclick = "<?php echo $ONCLICK_SALVAR;?>" 
										style = "text-decoration: none;">
										<img src="../../imagens/icons/disk.gif" width="18" />
									</a>
								</td>
								<td style="width: <?php echo ($DIV_TAB_WIDTH_CONTENT - 70);?>px;">
									<div align="left" title="<?php echo $EA_DESCRICAO;?>"
									style="white-space: nowrap;
															cursor: pointer;
												 border-left: 1px solid #AAAAAA;
												padding-left: 5px;
														overflow: hidden; height: 20px;
															 width: <?php echo ($DIV_TAB_WIDTH_CONTENT - 75);?>px;"><?php
										FW_V2_componenteHtml(
											array(
												"FW_V2_IDCOMP"   => $SWITCH_FORM_IDS . "_DESCRICAO_" . $EA_ID,
												"FW_V2_NOMECOMP" => $SWITCH_FORM_IDS . "_DESCRICAO_" . $EA_ID,
												"FW_V2_TIPOCOM"  => "TEXT",
												"FW_V2_VALUE"    => $EA_DESCRICAO,
												"FW_V2_CSSRELAT" => "fonte-size: 16px; width: " . ($DIV_TAB_WIDTH_CONTENT - 72) . "px; color: #3F5F8D;",
												"FW_V2_CSS"      => "fonte-size: 17px; width: " . ($DIV_TAB_WIDTH_CONTENT - 72) . "px;"
											)	
										);?>
									
									</div>                          
								</td>
								
							<tr><?php
							
						}
						
					}?>
				</table>
			</div><?php
			
			FW_desconctarDB($CONECTAR_DB);?>
		</td></tr>
		</table><?php 
		
		$GEN_typeAux = "hidden";
		if($_SESSION["SS_IN_MANUT"] == true) {
			$GEN_typeAux = "text";
			
		}?>
  	
    <input type = "<?php echo $GEN_typeAux;?>"
           name = "<?php echo $SWITCH_FORM_IDS;?>_ID" 
             id = "<?php echo $SWITCH_FORM_IDS;?>_ID" /><br />
             
    <input type = "<?php echo $GEN_typeAux;?>"
           name = "SWITCH_FORM" 
             id = "SWITCH_FORM" 
		      value = "<?php echo $SWITCH_FORM;?>"/><br />

    <input type = "<?php echo $GEN_typeAux;?>"
           name = "SWITCH_FORM_TBL" 
             id = "SWITCH_FORM_TBL" 
		      value = "<?php echo $SWITCH_FORM_TBL;?>"/><br />

    <input type = "<?php echo $GEN_typeAux;?>"
           name = "SWITCH_FORM_IDS"
             id = "SWITCH_FORM_IDS"
		      value = "<?php echo $SWITCH_FORM_IDS;?>"/><br />
    
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_ACAO_GERAL" id="GEN_ACAO_GERAL"   /><br />
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_ID"          value="<?php echo $GEN_ID;?>"   /><br />
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_NOME"        value="<?php echo $GEN_NOME;?>" /><br />
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_USER_STATUS" value="<?php echo $GEN_USER_STATUS;?>"/><br />    
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_DOC_WIDTH"   value="<?php echo $GEN_DOC_WIDTH;?>"  /><br />
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_DOC_HEIGHT"  value="<?php echo $GEN_DOC_HEIGHT;?>" />
    
  </form>
	
  <form id="formReload" name="formReload" action="tabelasAuxIndex.php?SWITCH_FORM=<?php echo $SWITCH_FORM;?>" method="post">
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_ACAO_GERAL_" id="GEN_ACAO_GERAL_"   /><br />
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_ID_"          value="<?php echo $GEN_ID;?>"   /><br />
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_NOME_"        value="<?php echo $GEN_NOME;?>" /><br />
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_USER_STATUS_" value="<?php echo $GEN_USER_STATUS;?>"/><br />    
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_DOC_WIDTH_"   value="<?php echo $GEN_DOC_WIDTH;?>"  /><br />
    <input type="<?php echo $GEN_typeAux;?>" name="GEN_DOC_HEIGHT_"  value="<?php echo $GEN_DOC_HEIGHT;?>" />
  
  </form><?php 

	$DISPLAY_AUX = "none";
	if($_SESSION["SS_IN_MANUT"] == true) $DISPLAY_AUX = "block";?>
	
	<div style="background-color:#FFF; width: 100%; display: <?php echo $DISPLAY_AUX;?>">
		<iframe id="iframeGeral" name="iframeGeral" style="width: 100%; height: 300px;"></iframe>
	</div>
  
</body></html>