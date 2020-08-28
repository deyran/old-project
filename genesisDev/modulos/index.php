<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
	include "../includes/library/myLibrary.inc";?>
  
  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../includes/css/gen_style.css">
  
  <link rel="stylesheet" type="text/css" href="../includes/jquery-ui-1.11.4.custom/jquery-ui.css">
  
  <script type="text/javascript" src="../includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
  <script type="text/javascript" src="../includes/jquery-ui-1.11.4.custom/jquery-ui.js"              charset="utf-8"></script>
 	<script type="text/javascript" src="../includes/js/notice.js"                                      charset="utf-8"></script>

  <script type="text/javascript"><?php
		if($FW_DADOS_OK == false) {?>
			$(function() {
				window.location = "../index.php";
			});<?php
		}?>
		
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
		
		function direcionador(pPath) {
			$("#formGrid").attr("action", pPath).submit();
		}
	</script>
   
  <style type="text/css">
		body {
			overflow: hidden;
		}
  </style>
  
</head><body>
  <div id="DIV_PRINC_USUARIO" style="background-color: #004080; height: 50px">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr><td valign="top" width="20%" align="center">
      <div style="color:#FFF; padding: 10px; font-size: 25px; ">
        G&nbsp;&Ecirc;&nbsp;N&nbsp;E&nbsp;S&nbsp;I&nbsp;S&nbsp;&nbsp;&nbsp;1&nbsp;.&nbsp;0
      </div>
    
    </td><td valign="middle" width="70%">
      <div align="center" style="color: #FFF; font-size: 20px;" class="semMargPadd">
				M&nbsp&Oacute;&nbspD&nbspU&nbspL&nbspO&nbspS
        
      </div><div align="center" 
      style="color: #CC6; font-style: italic; font-size: 15px;" class="semMargPadd"><?php 
				echo $GEN_NOME;?>
        
      </div>
      
    </td><td valign="middle" align="center">
      <a href="../" style="color: #FFF; font-style: normal">SAIR&nbsp;</a>
      
    </td></tr>
    </table>
  </div>
	
	<form id="formGrid" name="formGrid" method="post"><?php
		$DIV_CONTEUDO_GRID_HEIGHT = ((int)$GEN_DOC_HEIGHT - 73);?>
		<div id="DIV_CONTEUDO_GRID" 
		style="height: <?php echo $DIV_CONTEUDO_GRID_HEIGHT;?>px; overflow-x: auto;" class="DIV_CONTEUDO">
			<br /><br /><?php
	
			$CELL_STYLE = "
								 width: 200px; 
								height: 50px; 
			background-color: #ECECFF;";?>
								 
			<table border="0" cellpadding="0" cellspacing="10" align="center">
			<tr><td valign="middle" align="center" style=" <?php echo $CELL_STYLE;?>">
      	<a    href = "GESTAO_USUARIOS"
             title = "Edição de usuário do sistema" 
             style = "font-style: normal; color: #000" 
           onclick = "direcionador('pessoas/usuarios.php'); return false;">
					USU&Aacute;RIOS
        </a>
				
			</td><td valign="middle" align="center" style=" <?php echo $CELL_STYLE;?>">
      	<a    href = "GESTAO_USUARIOS"
             title = "Edição de usuário do sistema" 
             style = "font-style: normal; color: #000" 
           onclick = "direcionador('estoque/index.php'); return false;">
					CONTROLE DE ESTOQUE
        </a>
      
			</td><!--
<td valign="middle" align="center" style=" <?php echo $CELL_STYLE;?>">
      	<a    href = "GESTAO_ELEITORES"
             title = "Gestão de usuário" 
             style = "font-style: normal; color: #000" 
           onclick = "direcionador('pessoas/eleitores/index.php'); return false;">
					ELEITORES
        </a> 
      
			</td>

-->	
</tr>

			</table>

      <input type="hidden" name="GEN_ID"          value="<?php echo $GEN_ID;?>" />
      <input type="hidden" name="GEN_NOME"        value="<?php echo $GEN_NOME;?>" />
      <input type="hidden" name="GEN_USER_STATUS" value="<?php echo $GEN_USER_STATUS;?>" />
      
      <input type="hidden" id="GEN_DOC_WIDTH"  name="GEN_DOC_WIDTH"  value="<?php echo $GEN_DOC_WIDTH;?>"  />
      <input type="hidden" id="GEN_DOC_HEIGHT" name="GEN_DOC_HEIGHT" value="<?php echo $GEN_DOC_HEIGHT;?>" />
			
		</div>
    
	</form>
  
</body></html>