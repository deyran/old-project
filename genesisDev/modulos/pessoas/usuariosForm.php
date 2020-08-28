<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
  include "../../includes/library/myLibrary.inc";
	
	session_start();
	$_SESSION["SS_IN_MANUT"] = false;
	
	$P01_ID                = "";
	$P01_DESCRICAO         = "";
	$P01_NICK_NAME         = "";
	$PA0_ID                = "";
	$P01_DESCRICAO_EMISSOR = "";
	$P01_ID_EMISSOR        = -1;
	$MENSAGEM_RETORNO      = "";
	
	if(isset($_REQUEST["P01_ID"]))           $P01_ID           = $_REQUEST["P01_ID"];
	if(isset($_REQUEST["MENSAGEM_RETORNO"])) $MENSAGEM_RETORNO = $_REQUEST["MENSAGEM_RETORNO"];
	
	if($_SESSION["SS_IN_MANUT"] == false) ini_set("display_errors", 0);
	
	$CONECTAR_DB  = FW_conctarDB();
	
	//COLETA DE DADOS___________[
		if(strlen(trim($P01_ID)) > 0) {
			$SQL_QUERY = "
			SELECT P.P01_ID, 
						 D.P01_DESCRICAO,
						 P.P01_NICK_NAME,
						 P.PA0_ID,
						 U.PA0_DESCRICAO,
						 E.P01_DESCRICAO AS P01_DESCRICAO_EMISSOR,
						 E.P01_ID AS P01_ID_EMISSOR
							
			FROM P01_PESSOA_USUARIO AS P 
				 INNER JOIN P01_PESSOA         AS D ON P.P01_ID = D.P01_ID
				 INNER JOIN PA0_USUARIO_STATUS AS U ON U.PA0_ID = P.PA0_ID
				 INNER JOIN P01_PESSOA         AS E ON E.P01_ID = D.P01_EMISSOR
					 
			WHERE P.P01_ID = $P01_ID";
			
			//echo $SQL_QUERY;
			
			$SQL_QUERY    = $SQL_QUERY;
			$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
			$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
			$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
			
			if($NUM_LINES_DB > 0) {
				while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
					$P01_ID                = $DADOS_ROW[0];
					$P01_DESCRICAO         = $DADOS_ROW[1];
					$P01_NICK_NAME         = $DADOS_ROW[2];
					$PA0_ID                = $DADOS_ROW[3];
					$PA0_DESCRICAO         = $DADOS_ROW[4];
					$P01_DESCRICAO_EMISSOR = $DADOS_ROW[5];
					$P01_ID_EMISSOR        = $DADOS_ROW[6];
	
				}
			}
		}
		else {
			$SQL_QUERY_GEN_AUX = "
			SELECT P.P01_DESCRICAO AS P01_DESCRICAO_EMISSOR
			FROM P01_PESSOA AS P
			WHERE P.P01_ID = $GEN_ID";
			
			$SQL_QUERY    = $SQL_QUERY_GEN_AUX;
			$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
			$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
			$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
			
			if($NUM_LINES_DB > 0) {
				while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
					$P01_DESCRICAO_EMISSOR = $DADOS_ROW[0];
				}
			}
			
		}
	//]
	//QUATIDADE DE WEB MASTER___[
		$GEN_QT_WM = 0;
		if($GEN_WEB_MASTER == true) {
			$SQL_QUERY_GEN_AUX = "
			SELECT COUNT(U.PA0_ID) AS GEN_QT_WM
			FROM P01_PESSOA_USUARIO AS U 
			WHERE U.PA0_ID = " . $USE_STATUS["WEB_MASTER"];
			
			$SQL_QUERY    = $SQL_QUERY_GEN_AUX;
			$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
			$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
			$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
			
			if($NUM_LINES_DB > 0) {
				while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
					$GEN_QT_WM = $DADOS_ROW[0];
				}
			}
		}
		
	//]
	//RESTRINÇÕES DE SEGURANÇA__[
		//SE PA0_ID == WEB_MASTER ENTÃO
		//	1 - OK - PODE ALTERAR O CAMPO SITUAÇÃO;
		//  2 - OK - PODER ALTERAR A SENHA PRÓPRIA OU DE OUTROS;
		//  3 - OK - PODE INCLUIR E ATUALIZAR QUALQUER REGISTRO;
		//  4 - OK - SÓ PODE DEIXAR DE SER WEB MASTER SE O NÚMERO DE WEB MASTAR FOR MAIOR QUE 1
		 
		//SENAO SE PA0_ID != WEB_MASTER ENTÃO
		//	1 - NÃO PODE ALTERAR O CAMPO SITUAÇÃO;
		// 	2 - PODE ALTERAR SOMENETE ALTERAR A PRÓPRIA SENHA; 
		//  3 - PODE INCLUIR E ATUALIZAR SOMENTE O PROPRIO REGISTRO E OS REGISTRO POR ELE EMITIDO;
		
		//FIM SE
	
		$ALTERAR_SENHA      = false;
		$SOMENTE_LEITURA    = false;
		$ALTERAR_SITUACAO   = false;
		$ALTERAR_WEB_MASTER = true;
		
		if($GEN_WEB_MASTER == true) {
			$ALTERAR_SITUACAO = true;
			$ALTERAR_SENHA    = true;
			
			if(strlen(trim($P01_ID)) == 0) {
				$SOMENTE_LEITURA = false;
				$ALTERAR_SENHA   = false;					
				
			} elseif((intVal($GEN_QT_WM) < 2) && (intVal($GEN_ID) == intVal($P01_ID))) {
				$ALTERAR_WEB_MASTER = false;
			}
		}	
		else {
			$SOMENTE_LEITURA = true;
			$ALTERAR_SENHA   = true;
			
			if(strlen(trim($P01_ID)) == 0) {
				$SOMENTE_LEITURA = false;
				$ALTERAR_SENHA   = false;	
				
			} elseif(intVal($GEN_ID) == intVal($P01_ID)) {
				$SOMENTE_LEITURA = false;
				$ALTERAR_SENHA   = true;
				
			} elseif(intVal($GEN_ID) == intVal($P01_ID_EMISSOR)) {
				$SOMENTE_LEITURA = false;
				$ALTERAR_SENHA   = false;
				
			} else {
				$SOMENTE_LEITURA = true;
				$ALTERAR_SENHA   = false;

			}

		}
	//]
	
	FW_desconctarDB($CONECTAR_DB);	?>
  
  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css">

	<link rel="stylesheet" type="text/css" href="../../includes/jquery-ui-1.11.4.custom/jquery-ui.css">
	<script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
  <script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/jquery-ui.js" charset="utf-8"></script>
  
	<script type="text/javascript" src="../../includes/js/FW_v2.js"    charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/makeGrid.js" charset="utf-8"></script>
 	<script type="text/javascript" src="../../includes/js/notice.js"   charset="utf-8"></script>
  
  <script type="text/javascript">
		var aguarde_azul   = "<img src=\"../../imagens/aguarde_azul.gif\" />", 
		    GEN_DOC_HEIGHT = <?php echo $GEN_DOC_HEIGHT;?>,
				GEN_DOC_WIDTH  = <?php echo $GEN_DOC_WIDTH;?>,
				DIV_FORM_MODAL = null;
				
		function doSubmit(pIdForm, pPath, pAcao) {
			if(pAcao != "") $("#GEN_ACAO_GERAL").val(pAcao);
			$("#" + pIdForm).attr("action", pPath).submit();
		}
		function ativarFormModal(pIdUser) 	      {
			if(DIV_FORM_MODAL == null) {
				DIV_FORM_MODAL = $("#DIV_FORM_MODAL").dialog({
					autoOpen: false,
						height: (GEN_DOC_HEIGHT - 100),
						 width: (GEN_DOC_WIDTH  - 400),
						 modal: false
				});
			}
			
			DIV_FORM_MODAL.dialog("open");
		}
		function toggleEditButtons()             {
			$(".DIV_USER_BUTTONS").toggle();
		}
		
		function setReloadListOut() {
			parent.document.getElementById("formGrid").submit();
		}
		
		function relaodPage(pId, pMensagem) {
			var pagina = "usuariosForm.php?" +
			             "MENSAGEM_RETORNO=" + pMensagem + "&" +
									 "P01_ID=" + pId;

			$("#tabUsuario").html(
				"<div align=\"center\"><br />" + 
				"		<img src=\"../../imagens/loading_img.gif\" width=\"150\" />" + 
				"</div>"
			);

			doSubmit("formReload", pagina, "");

		}
	
		function newAlert(text, tipe, posit) {
			if(tipe == "")  tipe  = "info";
			if(posit == "") posit = "top";
			
			$.notice(text, {
				container: "body",
					 height: 30,
					timeout: 2500,
						level: tipe,
					 anchor: posit
			});
		}
		
		$(function(){<?php
			if($FW_DADOS_OK == true) {?>
				$("#tabUsuario").tabs();
				$(".bttUserClass").button(); 
				
				try {parent.formModalShow();} catch(e){}<?php
				
				if(trim($MENSAGEM_RETORNO) != "") {?>
					setReloadListOut();
					newAlert("<span style='font-size: 18px'><?php echo $MENSAGEM_RETORNO?></span>", "", "");<?php
				}
				
			} elseif($FW_DADOS_OK == false) {
				$MENSAGEM_RETORNO = "<strong>Ausência de dados importantes!!!</strong>";
				echo "parent.window.location = '../../index.php?MENSAGEM_RETORNO=" . $MENSAGEM_RETORNO . "';";
				
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
  <form id="formGrid" name="formGrid" method="post" target="iframeGeral"><?php
    $DIV_TAB_WIDTH  = (((int)$GEN_DOC_WIDTH  * 40.27) / 100);
		$DIV_TAB_HEIGHT = (((int)$GEN_DOC_HEIGHT * 31.20) / 100);
		
		if($DIV_TAB_WIDTH  < 500) $DIV_TAB_WIDTH  = 500;
		if($DIV_TAB_HEIGHT < 180) $DIV_TAB_HEIGHT = 180;?>
		<div align="center">
      <div id="tabUsuario" class="semMargPadd" style="width: <?php echo $DIV_TAB_WIDTH;?>px; border: 0px solid">
        <ul>
          <li><a href="#tabUsuario-1">Registro</a></li><?php 
          
          $TAB_DISPLAY = "";
          if($ALTERAR_SENHA == false) $TAB_DISPLAY = " style='display: none;' ";?>
          <li <?php echo $TAB_DISPLAY;?>><a href="#tabUsuario-2" onclick="$('#senhaAtual').focus();">Senha</a></li>
          
        </ul><?php
        
        $fonteSizeAux      = " font-size: 16px; ";
        $fonteSizeTitleAux = " font-size: 16px; ";?>
          
        <div id="tabUsuario-1" style="height: <?php echo $DIV_TAB_HEIGHT;?>px">
          <table border="0" cellpadding="5" cellspacing="0" align="center">
          <tr><td valign="top"><?php 
            $FW_V2_WIDTH = (((int)$DIV_TAB_WIDTH * 55) / 100);
            
            /*echo "
            <br />DIV_TAB_WIDTH..: $DIV_TAB_WIDTH
            <br />FW_V2_WIDTH....: $FW_V2_WIDTH ";*/
            
            $TIPO_AUX = "TEXT";
            $FW_V2_CSS_AUX = "width: " . $FW_V2_WIDTH . "px; color: #3F5F8D; $fonteSizeAux";
            
            if($SOMENTE_LEITURA == true) {
              $TIPO_AUX = "READ";
              $FW_V2_CSS_AUX = "width: " . $FW_V2_WIDTH . "px; $fonteSizeAux";
            }
            
            FW_V2_componenteHtml(
              array(
                "FW_V2_IDCOMP"    => "P01_DESCRICAO",
                "FW_V2_TIPOCOM"   => $TIPO_AUX,
                "FW_V2_VALUE"     => $P01_DESCRICAO,
                "FW_V2_DICA"      => "clique aqui",
                "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
                "FW_V2_CSS"       => $FW_V2_CSS_AUX, 
                "FW_V2_TITULO"    => "Nome da pessoa"
              )	
            );	?>
          </td><td valign="top" nowrap><?php 
            $TIPO_AUX = "TEXT";
            $FW_V2_WIDTH_AUX = (($FW_V2_WIDTH * 50) / 100);
            
            $FW_V2_CSS_AUX = "width: " . $FW_V2_WIDTH_AUX . "px; color: #3F5F8D; $fonteSizeAux";
            
            if($SOMENTE_LEITURA == true) {
              $TIPO_AUX = "READ";
              $FW_V2_CSS_AUX = "width: " . $FW_V2_WIDTH_AUX . "px; $fonteSizeAux";
            }
          
            FW_V2_componenteHtml(
              array(
                "FW_V2_IDCOMP"    => "P01_NICK_NAME",
                "FW_V2_MAXLENGTH" => "15",
                "FW_V2_TIPOCOM"   => $TIPO_AUX,
                "FW_V2_VALUE"     => $P01_NICK_NAME,
                "FW_V2_DICA"      => "clique aqui",
                "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
                "FW_V2_CSS"       => $FW_V2_CSS_AUX,
                "FW_V2_TITULO"    => "Usuário"
              )	
            );	?>
            
            <input type="hidden" id="P01_NICK_NAME_OLD" name="P01_NICK_NAME_OLD" value="<?php echo $P01_NICK_NAME;?>" />
            
          </td></tr>
          </table>
          <table border="0" cellpadding="5" cellspacing="0" align="center" style="padding-top: 0px;">
          <tr><td valign="top"><?php
            $FW_V2_WIDTH_AUX = (($FW_V2_WIDTH * 50) / 100);
            
            if($ALTERAR_SITUACAO == true) {
              $FW_V2_OPTIONLIST = "";
          
              $SQL_QUERY_STATUS = "
              SELECT U.PA0_ID        AS SEL_ID,
                     U.PA0_DESCRICAO AS SEL_DESCRICAO
              FROM PA0_USUARIO_STATUS AS U ";
              
              if($ALTERAR_WEB_MASTER == false) {
                $SQL_QUERY_STATUS = "
                $SQL_QUERY_STATUS
                WHERE U.PA0_ID IN(" . $USE_STATUS["WEB_MASTER"] . ") ";
              }
              
              $CONECTAR_DB  = FW_conctarDB();
              $SQL_QUERY    = $SQL_QUERY_STATUS;
              $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
              $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
              $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
              
              if($NUM_LINES_DB > 0) {
                while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
                  $SEL_ID        = $DADOS_ROW[0];
                  $SEL_DESCRICAO = $DADOS_ROW[1];
                  
                  $FW_V2_OPTIONLIST = $FW_V2_OPTIONLIST . 
                  "<option value='$SEL_ID' title='$SEL_DESCRICAO'>$SEL_DESCRICAO</option>";
                  
                }
              }
              
              FW_desconctarDB($CONECTAR_DB);					
              
              $FW_V2_OPTIONLIST = urlencode(trim($FW_V2_OPTIONLIST));
              
              
              FW_V2_componenteHtml(
                array(
                  "FW_V2_IDCOMP"     => "PA0_ID",
                  "FW_V2_TIPOCOM"    => "SELECT",
                  "FW_V2_VALUE"      => $PA0_ID,
                  "FW_V2_DESCRICAO"  => $PA0_DESCRICAO,
                  "FW_V2_OPTIONLIST" => $FW_V2_OPTIONLIST,								
                  "FW_V2_DICA"       => "clique aqui",
                  "FW_V2_CSSTITULO"  => $fonteSizeTitleAux,
                  "FW_V2_CSS"        => "width: " . $FW_V2_WIDTH_AUX . "px; color: #3F5F8D; $fonteSizeAux",
                  "FW_V2_TITULO"     => "Situa&ccedil;&atilde;o",
                  "FW_V2_FUNCBLUR"   => "$('#senhaAtual').focus()"
                )	 
              );
            
            } 
            else {
              if(strlen(trim($PA0_ID)) == 0)        $PA0_ID = $USE_STATUS["ATIVO"];
              if(strlen(trim($P01_DESCRICAO)) == 0) $PA0_DESCRICAO = "Ativo";
              
              FW_V2_componenteHtml(
                array(
                  "FW_V2_IDCOMP"     => "PA0_ID",
                  "FW_V2_TIPOCOM"    => "READ",
                  "FW_V2_VALUE"      => $PA0_ID,
                  "FW_V2_DESCRICAO"  => $PA0_DESCRICAO,
                  "FW_V2_CSSTITULO"  => $fonteSizeTitleAux,
                  "FW_V2_CSS"        => "width: " . $FW_V2_WIDTH_AUX . "px; $fonteSizeAux",
                  "FW_V2_TITULO"     => "Situa&ccedil;&atilde;o"
                )	 
              );?>
              
              <input type="hidden" name="PA0_ID" value="<?php echo $PA0_ID;?>" /><?php
            }?>
          </td><td valign="top"><?php 
            $FW_V2_WIDTH = (((int)$DIV_TAB_WIDTH * 55) / 100);
            
            FW_V2_componenteHtml(
              array(
                "FW_V2_IDCOMP"    => "P01_DESCRICAO_EMISSOR",
                "FW_V2_TIPOCOM"   => "READ",
                "FW_V2_VALUE"     => trim($P01_DESCRICAO_EMISSOR), //substr(, 1000),
                "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
                "FW_V2_CSS"       => "width: " . $FW_V2_WIDTH . "px; $fonteSizeAux",
                "FW_V2_TITULO"    => "Emissor"
              )	
            );	?>
            
          </td></tr>
          <tr><td colspan="2">
            <div class="DIV_USER_BUTTONS" 
            style="padding-bottom: 5px; padding-top: 25px; margin-bottom: 5px; display: block" 
            align="center">
              <input <?php 
              if($SOMENTE_LEITURA == true) echo "disabled ";?>
                
                   type = "button" 
                     id = "bttUserSalvar" 
                  class = "bttUserClass" 
                  style = "margin: 0; font-size: 14px; width: 100px" 
                  value = " Salvar " 
                onclick = "
                toggleEditButtons();
                doSubmit('formGrid', 'usuariosHidden.php', 'SALVAR_USUARIOS');" 
                
              />&nbsp;&nbsp;<input 
              
                   type = "button" 
                  class = "bttUserClass" 
                  style = "margin: 0; font-size: 14px; width: 100px" 
                  value = "Novo" 
                onclick = "relaodPage('', '');" 
              
              />&nbsp;&nbsp;<input 
              type = "button" 
              class="bttUserClass" style="margin: 0; font-size: 14px; width: 100px" 
              value="Sair" onclick="parent.fecharFormModal();" />
            </div>          
            <div class="DIV_USER_BUTTONS" align="center" style="display: none">
              <img src="../../imagens/aguarde_azul.gif" width="100" height="25" />
            </div>
          </td></tr>
          </table>        
        </div>
        <div id="tabUsuario-2" style="height: <?php echo $DIV_TAB_HEIGHT;?>px">
          <table border="0" cellpadding="5" cellspacing="0" width="80%" align="center">
          <tr><td valign="top"><?php 
            FW_V2_drawTitle("Senha atual", $fonteSizeTitleAux);?>
            <div style="padding-left: 7px">
              <input 
                      type = "password" 
                        id = "senhaAtual" 
                      name = "senhaAtual" 
              autocomplete = "off" 
                 maxlength = "15" 
                     style = "width: 99%; <?php echo $fonteSizeAux;?>" 
                     class = "textbox" />
            </div>
          </td><td valign="top"><?php 
            FW_V2_drawTitle("Senha Nova", $fonteSizeTitleAux);?>
            <div style="padding-left: 7px">
              <input 
                      type = "password" 
                        id = "senhaNova" 
                      name = "senhaNova" 
              autocomplete = "off" 
                 maxlength = "15" 
                     style = "width: 99%; <?php echo $fonteSizeAux;?>" 
                     class = "textbox" />
            </div>
          </td></td>
          <tr><td valign="top" colspan="2" align="center"><br />
            <div class="DIV_USER_BUTTONS" 
            style="padding-bottom: 5px; padding-top: 3px; margin-bottom: 5px; display: block" 
            align="center">          
              <input type="button" 
              class="bttUserClass" 
              style="margin: 0; font-size: 14px; width: 100px" 
              value="Salvar"
              onclick="
              toggleEditButtons();
              doSubmit('formGrid', 'usuariosHidden.php', 'UPDATE_SENHA');" />
            </div>
            <div class="DIV_USER_BUTTONS" align="center" style="display: none">
              <img src="../../imagens/aguarde_azul.gif" width="100" height="25" />
            </div>            
          </td></tr>
          </table>
  
        </div>
      </div>
		</div>
	
  
    <input type="hidden" id="P01_ID" name="P01_ID" value="<?php echo $P01_ID;?>"   />
      
    <input type="hidden" name="GEN_ACAO_GERAL" id="GEN_ACAO_GERAL"   />
    <input type="hidden" name="GEN_ID"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="GEN_NOME"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS" value="<?php echo $GEN_USER_STATUS;?>" />    
    <input type="hidden" name="GEN_DOC_WIDTH"   value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT"  value="<?php echo $GEN_DOC_HEIGHT;?>" />
    
  </form>
	
  <form id="formReload" name="formReload" method="post">
    <input type="hidden" name="GEN_ACAO_GERAL_" id="GEN_ACAO_GERAL_"   />
    <input type="hidden" name="GEN_ID_"          value="<?php echo $GEN_ID;?>"   />
    <input type="hidden" name="GEN_NOME_"        value="<?php echo $GEN_NOME;?>" />
    <input type="hidden" name="GEN_USER_STATUS_" value="<?php echo $GEN_USER_STATUS;?>" />    
    <input type="hidden" name="GEN_DOC_WIDTH_"   value="<?php echo $GEN_DOC_WIDTH;?>"  />
    <input type="hidden" name="GEN_DOC_HEIGHT_"  value="<?php echo $GEN_DOC_HEIGHT;?>" />
  
  </form><?php 

	$DISPLAY_AUX = "none";
	if($_SESSION["SS_IN_MANUT"] == true) $DISPLAY_AUX = "block";?>
	
	<div style="background-color:#FFF; width: 100%; display: <?php echo $DISPLAY_AUX;?>">
		<iframe id="iframeGeral" name="iframeGeral" style="width: 100%; height: 300px;"></iframe>
	</div>
  
</body></html>