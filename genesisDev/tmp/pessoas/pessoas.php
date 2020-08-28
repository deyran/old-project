<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
	include "../../includes/library/myLibrary.inc";
	include "pessoasInc.inc";	

	$GEN_DOC_HEIGHT = $_GET["GEN_DOC_HEIGHT"];
	$GEN_DOC_WIDTH  = $_GET["GEN_DOC_WIDTH"];	?>

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
		//===================================================================================================================
		
		$(function() {
			$("#DIV_FORM_PESSOAS").tabs();
		});				
  </script>
  
  <style type="text/css">
		body {
			margin-left: 0px; 
			margin-top: 0px; 
			margin-right: 0px; 
			margin-bottom: 0px; 
	
		}
		
		#DIV_FORM_PESSOAS {
			height: <?php echo ($GEN_DOC_HEIGHT - 50);?>px;
			overflow: auto;
			padding: 7px;
		}
		
		.DADOS_PESSOAS, .DADOS_PESSOAS_CLOSE {
			cursor: pointer;
		}
	</style>
  
</head><body>
<form id="formGrid" name="formGrid" method="post" target="iframeGeral">
  <div id="DIV_FORM_PESSOAS">
    <table border="0" cellspacing="0" cellpadding="10" width="99%">
    <tr><td valign="top"><?php 
      FW_V2_componenteHtml(
        array(
          "FW_V2_IDCOMP"   => "NOME",
          "FW_V2_NOMECOMP" => "NOME",
          "FW_V2_TIPOCOM"  => "TEXT",
          "FW_V2_VALUE"    => "",
          "FW_V2_DICA"     => "clique aqui",
          "FW_V2_CSS"      => "width: 100%;",
          "FW_V2_TITULO"   => "Nome da pessoa"
        )	
      );?>
    
    </td><td valign="top"><?php 
      FW_V2_componenteHtml(
        array(
          "FW_V2_IDCOMP"   => "NASCIMENTO",
          "FW_V2_NOMECOMP" => "NASCIMENTO",
          "FW_V2_TIPOCOM"  => "DATE",
          "FW_V2_VALUE"    => "",							
          "FW_V2_DICA"     => "dd/mm/aaaa",
          "FW_V2_CSS"      => "width: 100px;",
          "FW_V2_TITULO"   => "Nascimento"
        )	
      );?>
    
    </td><td valign="top"><?php 
      $FW_V2_OPTIONLIST = "
      <option value='NULL'></option>
      <option value='M'>Masculino</option>
      <option value='F'>Femenino</option>";
       
      $FW_V2_OPTIONLIST = urlencode(trim($FW_V2_OPTIONLIST));
      
      FW_V2_componenteHtml(
        array(
          "FW_V2_IDCOMP"     => "SEXO",
          "FW_V2_NOMECOMP"   => "SEXO",
          "FW_V2_TIPOCOM"    => "SELECT",
          "FW_V2_VALUE"      => "",
          "FW_V2_DESCRICAO"  => "",
          "FW_V2_OPTIONLIST" => $FW_V2_OPTIONLIST,
          "FW_V2_CSS"        => "width: 100px;",
          "FW_V2_TITULO"     => "Sexo"
        )	
      );?>
    
    </td><td valign="top"><?php 
      $CONECTAR_DB      = FW_conctarDB();
      $SQL_QUERY        = "SELECT G.* FROM A05_GRUPO AS G ORDER BY G.A05_DESCRICAO";
      $RESULT_DB        = mysqli_query($CONECTAR_DB, $SQL_QUERY);
      $RESULT_DB        = $CONECTAR_DB->query($SQL_QUERY);
      $NUM_LINES_DB     = mysqli_affected_rows($CONECTAR_DB);
      $FW_V2_OPTIONLIST = "<option value='NULL'></option>";
      
      if($NUM_LINES_DB > 0) {
        while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
          $FW_V2_OPTIONLIST = "$FW_V2_OPTIONLIST
          <option value='$DADOS_ROW[0]' title='$DADOS_ROW[1]'>$DADOS_ROW[1]</option>";
        }
      }
      
      $FW_V2_OPTIONLIST = urlencode(trim($FW_V2_OPTIONLIST));
      
      FW_V2_componenteHtml(
        array(
          "FW_V2_IDCOMP"     => "GRUPO",
          "FW_V2_NOMECOMP"   => "GRUPO",
          "FW_V2_TIPOCOM"    => "SELECT",
          "FW_V2_VALUE"      => "",
          "FW_V2_DESCRICAO"  => "",
          "FW_V2_OPTIONLIST" => $FW_V2_OPTIONLIST,
          "FW_V2_TITULO"     => "Grupo"
        )	
      );
      
      FW_desconctarDB($CONECTAR_DB);?>
    </td></tr>
    </table>
    <input type="hidden" id="P01_ID" name="P01_ID" />
  </div>  
  
  <input type="hidden" id="GEN_ACAO_GERAL" name="GEN_ACAO_GERAL" />
  <input type="hidden" id="GEN_DOC_HEIGHT" name="GEN_DOC_HEIGHT" value="<?php echo $GEN_DOC_HEIGHT;?>" />
  <input type="hidden" id="GEN_DOC_WIDTH"  name="GEN_DOC_WIDTH"  value="<?php echo $GEN_DOC_WIDTH;?>" />
  
</form>

<div style="top:70%; position: absolute; width: 100%; display: none">
  <iframe id="iframeGeral" name="iframeGeral" style="width: 95%; height: 150px;"></iframe>
</div>

</body></html>