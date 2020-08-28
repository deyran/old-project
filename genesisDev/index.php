<?php 
if(isset($_POST["GEN_USER_NAME"])) {
	include "includes/library/myLibrary.inc";
	
	$ERROR = "";
	$GEN_USER_NAME = $_POST["GEN_USER_NAME"];
	$GEN_PASSWORD  = $_POST["GEN_PASSWORD"];
	
	if((strlen(trim($GEN_USER_NAME)) == 0)) $ERROR = "Você deve informar o usuário!!";
	if((strlen(trim($GEN_PASSWORD)) == 0) && ($ERROR == "")) $ERROR = "Você deve informar a senha!!";

	$GEN_ID   = "";
	$GEN_NOME = "";
	$GEN_PAGE = "index.php";
	
	if(strlen(trim($ERROR)) == 0) {
		$SQL_QUERY_USER = "
		SELECT P.P01_ID        AS GEN_ID,
					 D.P01_DESCRICAO AS GEN_NOME,
					 P.PA0_ID        AS GEN_USER_STATUS
					 
		FROM P01_PESSOA_USUARIO AS P INNER JOIN P01_PESSOA AS D ON P.P01_ID = D.P01_ID
				 
		WHERE P.P01_NICK_NAME = " . FW_trataCaractere($GEN_USER_NAME, "T") . " AND
					P.P01_USER_PASS = " . FW_trataCaractere($GEN_PASSWORD , "P");
					
		//echo $SQL_QUERY_USER;	
	
		$CONECTAR_DB  = FW_conctarDB();
		$SQL_QUERY    = $SQL_QUERY_USER;
		$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
		$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
		$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
		
		if($NUM_LINES_DB > 0) {
			while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
				$GEN_ID          = $DADOS_ROW[0];
				$GEN_NOME        = $DADOS_ROW[1];
				$GEN_USER_STATUS = $DADOS_ROW[2];
				$GEN_PAGE        = "modulos/index.php";
				
			}
		}
		
		if((strlen(trim($GEN_ID)) == 0)) $ERROR = "Usuário ou senha estão incorretos!!!";

	}?>
	
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
  
  <html><head>
    <title>....::: Genesis :::....</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	  <script type="text/javascript" src="includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
		
		<script type="text/javascript">
			$(function(){<?php
	      if(strlen(trim($ERROR)) == 0) {?>
					$("#GEN_DOC_WIDTH").val($(document).width());
					$("#GEN_DOC_HEIGHT").val($(document).height());	<?php
					
				}?>
			
				$("#formGrid").submit();
				
			});
    </script>
    
  </head><body>
		<div align="center"><br /><img src="imagens/loading_img.gif" width="300" /></div>
    
    <form id="formGrid" name="formGrid" method="post" action="<?php echo $GEN_PAGE;?>"><?php
      if(strlen(trim($ERROR)) > 0) {?>
        <input type="hidden" name="MENSAGEM_RETORNO" value="<?php echo $ERROR;?>" /><?php 
        
      } else {?>
        <input type="hidden" name="GEN_ID"          value="<?php echo $GEN_ID;?>" />
				<input type="hidden" name="GEN_NOME"        value="<?php echo $GEN_NOME;?>" />
        <input type="hidden" name="GEN_USER_STATUS" value="<?php echo $GEN_USER_STATUS;?>" />
        
        <input type="hidden" id="GEN_DOC_WIDTH"  name="GEN_DOC_WIDTH" />
        <input type="hidden" id="GEN_DOC_HEIGHT" name="GEN_DOC_HEIGHT" /><?php 
        
      }?>
    </form>
    
	</body></html><?php
	
} else {?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
  include "includes/library/myLibrary.inc";
	if(isset($_REQUEST["MENSAGEM_RETORNO"])) $MENSAGEM_RETORNO = $_REQUEST["MENSAGEM_RETORNO"];?>
  
  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="includes/css/gen_style.css">
  
  <link rel="stylesheet" type="text/css" href="includes/jquery-ui-1.11.4.custom/jquery-ui.css">
  
  <script type="text/javascript" src="includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
  <script type="text/javascript" src="includes/jquery-ui-1.11.4.custom/jquery-ui.js"              charset="utf-8"></script>
 	<script type="text/javascript" src="includes/js/notice.js"                                      charset="utf-8"></script>

  <script type="text/javascript">
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
			
    $(function(){
      $("#GEN_USER_NAME").focus();<?php

			if($MENSAGEM_RETORNO != "") {?>
				newAlert("<span style='font-size: 18px'><?php echo $MENSAGEM_RETORNO;?></span>", "error", "");<?php
			}?>
    });
  </script>
   
  <style type="text/css">
		body {
			overflow: hidden;
		}
  </style>
  
</head><body>
<form id="formGrid" name="formGrid" method="post">
  <div id="DIV_PRINC_USUARIO" style="background-color: #004080; height: 50px">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr><td valign="top" width="30%" align="center">
      <div style="color:#FFF; padding: 10px; font-size: 25px; ">
        G&nbsp;&Ecirc;&nbsp;N&nbsp;E&nbsp;S&nbsp;I&nbsp;S&nbsp;&nbsp;&nbsp;1&nbsp;.&nbsp;0
      </div>
    
    </td><td valign="middle" width="70%">
      <table border="0" cellpadding="0" cellspacing="0" align="center">
      <tr><td valign="top">
        <div style="color: #FFF">Usu&aacute;rio</div>
        <input 
         autocomplete = "off"        
            maxlength = "20"
                 type = "text" 
                   id = "GEN_USER_NAME" 
                 name = "GEN_USER_NAME" 
                style = "width: 170px" />
        
      </td><td valign="top" style="padding-left: 10px">
        <div style="color: #FFF">Senha</div>
        <input 
          maxlength = "15"
               type = "password" 
               name = "GEN_PASSWORD" 
              style = "width: 100px" />
        
      </td><td valign="bottom" style="padding-left: 10px">
        <input type="submit" value="Entrar" class="textboxBtn" style="color:#FFF" />
        
      </td></tr>
      </table>
  
    </td></tr>
    </table>
  </div>

  <br /><br /><br />
  <br /><br /><br />
  <table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr><td valign="top" style="color:  #000"><?php 
    $STYLE_AUX_0 = "font-size: 15px; TEXT-TRANSFORM: uppercase; ";?>
    
    <div style=" <?php echo $STYLE_AUX_0;?>">
      Excelência Operacional
    </div>
    <div style="padding-left: 10px">
      &raquo;&nbsp;Otimização do fluxo de informa&ccedil;&atilde;o<br />
      &raquo;&nbsp;Agilidade e organiza&ccedil;&atilde;o<br />
      &raquo;&nbsp;Redu&ccedil;&atilde;o de custos operacional<br />
    </div>
    
    
    <div style=" <?php echo $STYLE_AUX_0;?> margin-top: 15px">
      Serviços
    </div>
    <div style="padding-left: 10px">
      &raquo;&nbsp;Mapeamento do perfil de pessoas<br />
      &raquo;&nbsp;Presta&ccedil;&atilde;o de servi&ccedil;os baseado no perfil<br />
      &raquo;&nbsp;Novos servi&ccedil;os<br />
    </div>
    
    
    <div style=" <?php echo $STYLE_AUX_0;?> margin-top: 15px">
      Relacionamento mais estreito com pessoas
    </div>
    <div style="padding-left: 10px">
      &raquo;&nbsp;Tratamento baseado no perfil das pessoas<br />
      &raquo;&nbsp;Concretização da confiança como ativo político<br />
      &raquo;&nbsp;Consolidação da imagem para com as pessoas<br />
      &raquo;&nbsp;Estabelecimento de vínculos duradouros<br />
    </div>
    
  </td><td valign="top" style="color:  #000; padding-left: 30px">
    <div style=" <?php echo $STYLE_AUX_0;?>">
      Melhor tomada de decisões
    </div>
    <div style="padding-left: 10px">
      &raquo;&nbsp;Identifica&ccedil;&atilde;o de problemas<br />
      &raquo;&nbsp;An&aacute;lise de alternativas<br />
      &raquo;&nbsp;Identifica&ccedil;&atilde;o de crit&eacute;rios de decis&atilde;o<br />
      &raquo;&nbsp;Classifica&ccedil;&atilde;o de import&acirc;ncia<br />
    </div>
    
    
    <div style=" <?php echo $STYLE_AUX_0;?> margin-top: 15px">
      Vantagem competitiva
    </div>
    <div style="padding-left: 10px">
      &raquo;&nbsp;Alvo estrat&eacute;gico<br />
      &raquo;&nbsp;Diferencia&ccedil;&atilde;o<br />
      &raquo;&nbsp;Baixo custo<br />
      &raquo;&nbsp;Foco<br />
    </div>


    <div style=" <?php echo $STYLE_AUX_0;?> margin-top: 15px">
      Sobreviv&ecirc;ncia
    </div>
    <div style="padding-left: 10px">
      &raquo;&nbsp;Excel&ecirc;ncia operacional<br />
      &raquo;&nbsp;Servi&ccedil;os<br />
      &raquo;&nbsp;Relacionamento mais estreitos com pessoas<br />
      &raquo;&nbsp;Melhor tomada de decis&otilde;es<br />
      &raquo;&nbsp;Vantagem competitiva<br />
    </div>
  </td></tr>
  </table>
  
</form>

</body></html><?php 
}?>