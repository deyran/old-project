<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
	include "../includes/library/myLibrary.inc";?>
  
  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="../includes/css/gen_style.css">
  <link rel="stylesheet" type="text/css" href="../includes/jquery-ui-1.11.4.custom/jquery-ui.min.css" />

	<script type="text/javascript" src="../includes/js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript" src="../includes/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>  
	<script type="text/javascript" src="../includes/js/FW_v2.js"></script>  

  <script type="text/javascript">
		function getDocHeight() {
			var D = document;
			return Math.max(
					D.body.scrollHeight, D.documentElement.scrollHeight,
					D.body.offsetHeight, D.documentElement.offsetHeight,
					D.body.clientHeight, D.documentElement.clientHeight
			);
		}
		
		$(function(){
			$(".DIV_CONTEUDO").css({"height": (getDocHeight() - 75) + "px"});
		});
		
  </script>
  
  <style type="text/css">
		body {
			  margin-left: 0px; 
			   margin-top: 0px; 
			 margin-right: 0px; 
			margin-bottom: 0px; 
			     overflow: hidden;
	 background-color: #DFDFFF
		}
	</style>
  
</head><body style=""><?php 
	$printHeadParam = "
	<table border='0' cellspacing='0' cellpadding='0' style='width: 100%; margin-top: 10px;'>
	<tr><td valign='top' width='90%'>
		<div class='semMargPadd' align='center' style='color: #FFF; font-size: 25px'>
    	G&nbsp;E&nbsp;S&nbsp;T&nbsp;&Atilde;&nbsp;O
			&nbsp;&nbsp;&nbsp;&nbsp;D&nbsp;E&nbsp;&nbsp;&nbsp;&nbsp;
			C&nbsp;I&nbsp;D&nbsp;A&nbsp;D&nbsp;&Atilde;&nbsp;O&nbsp;S
    </div>
		
	</td><td valign='middle' align='center'>
		<a href='../index.php' class='semMargPadd' style='font-style:normal; color:#FFF; font-size: 14px'>
			Retornar
		</a>
	</td></tr>
	</table>";
	
	imprimirCabecalho($printHeadParam);?>
  
  <table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
  <tr><td valign="top">
  	<div class="DIV_CONTEUDO"></div>
  </td><td valign="top">
		<div class="DIV_CONTEUDO"><?php
			$ARRAY_AUX = array(
				"FW_V2_IDCOMP"        => "MEU_NOME",
				"FW_V2_NOMECOMP"      => "",
				"FW_V2_TIPOCOM"       => "DATE",
				"FW_V2_TITULO"        => "Nome do cidadão",
				"FW_V2_VALUE"         => "",
				"FW_V2_DESCRICAO"     => "",
				"FW_V2_OPTIONLIST"    => "",
				"FW_V2_DICA"          => "",
				"FW_V2_CSSTITULO"     => "",
				"FW_V2_CSS"           => "",
				"FW_V2_CSSRELAT"      => "",
				"FW_V2_FUNCBLUR"      => "",
				"FW_V2_FUNCHIDDEN"    => "FW_V2_FUNCHIDDEN",
				"FW_V2_MASCARA"       => "",
				"FW_V2_MAXLENGTH"     => "",
				"FW_V2_DESCNOME"      => "FW_V2_DESCNOME",
				"FW_V2_STARTIN"       => "",
				"FW_V2_SELECTNOME"    => "",
				"FW_V2_CSSDIVCONTENT" => ""
			);
		
			FW_V2_componenteHtml($ARRAY_AUX);?>    
    </div>
  </td></tr>
  </table>

  
  
	


</body></html>