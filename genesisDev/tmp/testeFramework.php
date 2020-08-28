<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"><head><?php 
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache"); // HTTP/1.0

	error_reporting (E_ALL ^ E_NOTICE); 
	
	if (!isset($_POST['action'])) {
		//If not isset -> set with dumy value 
		$_POST['action'] = "undefine"; 
	}
	
	$GEN_acaoGeral    = $_POST["GEN_acaoGeral"];
	$GEN_P01_ID       = 1;//$_POST["GEN_P01_ID"];
	$GEN_windowHeight = $_POST["GEN_windowHeight"];
	$GEN_windowWidth  = $_POST["GEN_windowWidth"];		

	include "../includes/F_PHP_functions.inc";?>

	<script type="text/javascript" src="../includes/jquery-1.11.3.min.js" charset="utf-8"></script>
 	<script type="text/javascript" src="../includes/F_JS_functions.js"    charset="utf-8"></script>
 	<script type="text/javascript" src="../includes/FW_v2.js"    charset="utf-8"></script>  
 	
  
  <link rel="stylesheet" type="text/css" href="../includes/styleGeral.css"/>
  <link rel="stylesheet" type="text/css" href="../includes/css/FW_V2.css"/>

      
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>....::: Genesis :::....</title>
  
  <script type="text/javascript">
		var windowWidth  = $(window).width();
		var windowHeight = ($(window).height() - 50);
		
  </script>

</head><body>
  <div id="DIV_PRINC_USUARIO" style="background-color: #2F4F4F; color: #CCC; height: 45px">
    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%; font-family:Arial, Helvetica, sans-serif">
    <tr><td valign="middle" align="left"  nowrap="nowrap">
      <table border="0" cellspacing="0" cellpadding="7" style="font-size: 12px">
      <tr><td>
      	<img src="../../imagens/pessoas/<?php echo $GEN_P01_ID . ".jpg";?>" class="perfilCircular" onerror="FW_imgError(this);" />        
          
      </td><td valign="top">
        Deyvid Rannyere de Moraes Costa<br />
        <span style="font-style:italic">Secret&aacute;rio administrativos</span>
          
      </td></tr>
      </table>
        
    </td><td valign="middle" style="width: 70%" align="center">
      <span style="font-size: 20px; color: #FFF"><?php 
				if($GEN_acaoGeral == "GESTAO_CIDADAOS") {
					echo "G E S T &Atilde; O&nbsp;&nbsp;&nbsp;&nbsp;D E&nbsp;&nbsp;&nbsp;&nbsp;C I D A D &Atilde; O S";
					
				} elseif($GEN_acaoGeral == "GESTAO_JURIDICAS") {
					echo "G E S T &Atilde; O&nbsp;&nbsp;&nbsp;&nbsp;D E&nbsp;&nbsp;&nbsp;&nbsp;P E S S O A S&nbsp;&nbsp;&nbsp;&nbsp;J U R &Iacute; D I C A S";
					
				} elseif($GEN_acaoGeral == "GESTAO_N_GENTE") {
					echo "N O S S A&nbsp;&nbsp;&nbsp;&nbsp;G E N T E";
					
				}?>
	     
      </span>
    
    </td><td valign="middle" align="center" width="150px">
    	<a href="../index.php" style="color: #CCC; text-decoration: none">RETORNAR</a>
      
    </td></tr>
    </table>
  </div><?php

	$GEN_PRINC_CONTEUDO_CSS = "
	background-color: #FFF; 
	margin: 7px;";?>
		
	<div id="DIV_PRINC_CONTEUDO" style=" <?php echo $GEN_PRINC_CONTEUDO_CSS;?>"><?php 
	$FW_V2_null = "]|.NULL.|[";
	
	function drawTitle($pTitle, $pCss) {
		if($pCss == "") $pCss = " color: #999999; font-size: 11px; padding: 0; margin: 0; "?>
		<div  style=" <?php echo $pCss; ?>" align="left"><?php echo $pTitle;?></div><?php
	}

	FW_V2_componenteHtml(
		array(
			"FW_V2_IDCOMP"        => "MEU_NOME",
			"FW_V2_NOMECOMP"      => "",
			"FW_V2_TIPOCOM"       => "TEXT",
			"FW_V2_TITULO"        => "Nome do cidadão",
			"FW_V2_VALUE"         => "Deyvid Rannyere Moraes Costa",
			"FW_V2_DESCRICAO"     => "",
			"FW_V2_OPTIONLIST"    => "",
			"FW_V2_DICA"          => "",
			"FW_V2_CSSTITULO"     => "",
			"FW_V2_CSS"           => "",
			"FW_V2_CSSRELAT"      => "fonte-size: 18px",
			"FW_V2_FUNCBLUR"      => "",
			"FW_V2_FUNCHIDDEN"    => "FW_V2_FUNCHIDDEN",
			"FW_V2_MASCARA"       => "",
			"FW_V2_MAXLENGTH"     => "",
			"FW_V2_DESCNOME"      => "FW_V2_DESCNOME",
			"FW_V2_STARTIN"       => "",
			"FW_V2_SELECTNOME"    => "",
			"FW_V2_CSSDIVCONTENT" => ""
		)	
	);

	function FW_V2_componenteHtml($FW_V2_parametros){
		if(strlen(trim($FW_V2_parametros["FW_V2_IDCOMP"])) == 0) {
			echo "O campo <strong>'FW_V2_IDCOMP'</strong> é obrigatório!!";
			return;
		}
		//====================================================================================================
		
		$FW_V2_idComp        = trim($FW_V2_parametros["FW_V2_IDCOMP"]);
		$FW_V2_nomeComp      = trim($FW_V2_parametros["FW_V2_NOMECOMP"]);
		$FW_V2_tipoCom       = trim($FW_V2_parametros["FW_V2_TIPOCOM"]);
		$FW_V2_titulo        = trim($FW_V2_parametros["FW_V2_TITULO"]);
		$FW_V2_value         = trim($FW_V2_parametros["FW_V2_VALUE"]);
		$FW_V2_descricao     = trim($FW_V2_parametros["FW_V2_DESCRICAO"]);
		$FW_V2_optionList    = trim($FW_V2_parametros["FW_V2_OPTIONLIST"]);
		$FW_V2_dica          = trim($FW_V2_parametros["FW_V2_DICA"]);
		$FW_V2_cssTitulo     = trim($FW_V2_parametros["FW_V2_CSSTITULO"]);
		$FW_V2_css           = trim($FW_V2_parametros["FW_V2_CSS"]);
		$FW_V2_cssRelat      = trim($FW_V2_parametros["FW_V2_CSSRELAT"]);
		$FW_V2_funcBlur      = trim($FW_V2_parametros["FW_V2_FUNCBLUR"]);
		$FW_V2_funcHidden    = trim($FW_V2_parametros["FW_V2_FUNCHIDDEN"]);
		$FW_V2_mascara       = trim($FW_V2_parametros["FW_V2_MASCARA"]);
		$FW_V2_maxLength     = trim($FW_V2_parametros["FW_V2_MAXLENGTH"]);
		$FW_V2_descNome      = trim($FW_V2_parametros["FW_V2_DESCNOME"]);
		$FW_V2_startIN       = trim($FW_V2_parametros["FW_V2_STARTIN"]);
		$FW_V2_selectNome    = trim($FW_V2_parametros["FW_V2_SELECTNOME"]);
		$FW_V2_cssDivContent = trim($FW_V2_parametros["FW_V2_CSSDIVCONTENT"]);
		//=================================================================================================================
		
		$FW_V2_content         = " cursor: pointer; text-decoration: none; color: #000; ";
		$FW_V2_cssTitutloAux   = " color: #999999; font-size: 13px; padding: 0; margin: 0; font-style: normal;"; 
		$FW_V2_container       = " padding: 0px; margin: 0px; font-style: normal; font-size: 14px; ";
		$FW_V2_containerMargin = " $FW_V2_container margin-left: 7px; ";


		$FW_V2_CLASS_COMP      = $FW_V2_containerMargin;
		if(strlen(trim($FW_V2_parametros["FW_V2_TITULO"])) == 0) $FW_V2_CLASS_COMP = $FW_V2_container;

		//=================================================================================================================
		
		$FW_V2_valueTextAux = "";		

		if(strlen(trim($FW_V2_parametros["FW_V2_NOMECOMP"])) == 0) {
			$FW_V2_nomeComp = $FW_V2_idComp;
		}
		
		if(strlen(trim($FW_V2_parametros["FW_V2_TIPOCOM"])) == 0) {
			$FW_V2_tipoCom = "TEXT";
		}

		if(strlen(trim($FW_V2_parametros["FW_V2_CSSRELAT"])) == 0) {
			$FW_V2_cssRelat = $FW_V2_css;
		}
		
		if($FW_V2_tipoCom == "AUTO") {
			if(strlen(trim($FW_V2_parametros["FW_V2_STARTIN"])) == 0) {
				$FW_V2_startIN = 3;
			}
			
			if(strlen(trim($FW_V2_parametros["FW_V2_DESCNOME"])) == 0) {
				echo "O campo <strong>'FW_V2_DESCNOME'</strong> é obrigatório!!";
				return;
			}
			
			if(strlen(trim($FW_V2_parametros["FW_V2_FUNCHIDDEN"])) == 0) {
				echo "O campo <strong>'FW_V2_FUNCHIDDEN'</strong> é obrigatório!!";
				return;
			}
			
		}
		

		if($FW_V2_value != "") {
			if($FW_V2_tipoCom == "TEXT_AREA") {
				$FW_V2_valueTextAux = str_replace("  ", "&nbsp;&nbsp;", trim($FW_V2_value));
				$FW_V2_valueTextAux = str_replace("\n", "<br />", trim($FW_V2_valueTextAux));
				
			}	else if($FW_V2_tipoCom == "SELECT") {
				$FW_V2_valueTextAux = $FW_V2_descricao;
				
			}	else if($FW_V2_tipoCom == "AUTO") {
				$FW_V2_valueTextAux = $FW_V2_descricao;
				if($FW_V2_descricao == "") $FW_V2_valueTextAux = "<span class='FW_V2_content_dica'>" & $FW_V2_dica & "</span>";
								
			} else if($FW_V2_tipoCom == "FLOAT") {
				$FW_V2_valueTextAux = $FW_V2_value;
				if($FW_V2_value != "") $FW_V2_value = str_replace(",", ".", trim($FW_V2_value));

			} else {
				$FW_V2_valueTextAux = $FW_V2_value;
				
			}
				
		} else {
			if($FW_V2_dica != "") {
				$FW_V2_valueTextAux = "<span class='FW_V2_content_dica'>" . $FW_V2_dica . "</span>";
				
			} else {
				$FW_V2_valueTextAux = "<div>&nbsp;<br /></div>";
			}

		}
		
		if($FW_V2_valueTextAux == "") {
			if($FW_V2_dica != "") {
				$FW_V2_valueTextAux = "<span class='FW_V2_content_dica'>" . $FW_V2_dica . "</span>";
				
			}
		}
		//=================================================================================================================

		$FW_V2_varFunc = 
		"FW_V2_idComp="        . $FW_V2_idComp     . "|" .
		"FW_V2_nomeComp="      . $FW_V2_nomeComp   . "|" .
		"FW_V2_tipoCom="       . $FW_V2_tipoCom    . "|" .
		"FW_V2_value="         . $FW_V2_value      . "|" .
		"FW_V2_descricao="     . $FW_V2_descricao  . "|" .
		"FW_V2_optionList="    . $FW_V2_optionList . "|" .
		"FW_V2_dica="          . $FW_V2_dica       . "|" .
		"FW_V2_cssTitulo="     . $FW_V2_cssTitulo  . "|" .
		"FW_V2_css="           . $FW_V2_css        . "|" .
		"FW_V2_cssRelat="      . $FW_V2_cssRelat   . "|" .
		"FW_V2_funcBlur="      . $FW_V2_funcBlur   . "|" .
		"FW_V2_funcHidden="    . $FW_V2_funcHidden . "|" .
		"FW_V2_mascara="       . $FW_V2_mascara    . "|" .
		"FW_V2_maxLength="     . $FW_V2_maxLength  . "|" .
		"FW_V2_descNome="      . $FW_V2_descNome   . "|" .
		"FW_V2_startIN="       . $FW_V2_startIN    . "|" .
		"FW_V2_selectNome="    . $FW_V2_selectNome . "|" .
		"FW_V2_cssDivContent=" . $FW_V2_cssDivContent;
		
		//echo str_replace("|", "<BR />", $FW_V2_varFunc) . "<br /><br />";
		//====================================================================================================?>
    
   	<div id="FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>" style="padding: 0px; margin: 0px; font-family:Arial, Helvetica, sans-serif"><?php
			if($FW_V2_titulo != "") {
				$printCssAux = $FW_V2_cssTitulo;
				if($printCssAux == "") $printCssAux = $FW_V2_cssTitutloAux; ?>
				<div id="FW_V2_TITULO_<?php echo $FW_V2_idComp;?>" style=" <?php echo $printCssAux;?>"><?php 
					echo $FW_V2_titulo;?>
        </div><?php
			}

			if($FW_V2_tipoCom == "READ")     {
				$FW_V2_valueTextAux	= $FW_V2_value;
				if($FW_V2_descricao != "") $FW_V2_valueTextAux = $FW_V2_descricao;
				
				$cssAux = $FW_V2_CLASS_COMP;
				
				echo $FW_V2_CLASS_COMP;?>
        
        <div id="FW_V2_TEXT_<?php echo $FW_V2_idComp;?>"
        style="color: #000000; <?php echo $FW_V2_cssRelat . " " . $FW_V2_CLASS_COMP;?>" ><?php 
					echo $FW_V2_valueTextAux;?>
        </div><?php
			}
			elseif($FW_V2_tipoCom == "AUTO") {
				$FW_V2_MYPATH_IMAGE = "http://" . $_SERVER["SERVER_NAME"] . "/genesis/imagens/";?>

        <div id="FW_V2_A_CONTENT_<?php echo $FW_V2_idComp;?>" style="display: block; <?php echo $FW_V2_content;?>" 
        onmouseover="$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').addClass('tdGridAuto');" 
        onmouseout ="$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').removeClass('tdGridAuto');">
          <table border="0" cellspacing="0" cellpadding="0">
          <tr><td>
            <div id="FW_V2_TEXT_<?php echo $FW_V2_idComp;?>" 
                 style="cursor:auto; <?php echo $FW_V2_cssRelat;?>;" 
                 class="<?php echo $FW_V2_CLASS_COMP;?>"><?php 
							echo $FW_V2_valueTextAux; ?>
            </div>
            
          </td><td style="padding-left: 4px">
            <a href="/editar" style=" <?php echo $FW_V2_content;?>"
              onfocus="FW_V2_apenasNada(); return false;"
              onmouseup="FW_V2_apenasNada(); return false;"
              onmousedown="FW_V2_apenasNada(); return false;"
              onclick="FW_V2_componenteHtml('<?php echo $FW_V2_idComp;?>'); return false;">
              <img src="<?php echo $FW_V2_MYPATH_IMAGE;?>nodes/lupa.gif" border="0" />
            </a>
          </td></tr>
          </table>
          
        </div>
        <div id="FW_V2_COMP_<?php echo $FW_V2_idComp;?>" class="<?php echo $FW_V2_CLASS_COMP;?>"></div>
        
        <input type="hidden" id="<?php echo $FW_V2_idComp;?>" name="<?php echo $FW_V2_nomeComp;?>" value="<?php echo $FW_V2_value;?>" />
        <input type="hidden" id="hdd_info_<?php echo $FW_V2_idComp;?>" value="<?php echo $FW_V2_varFunc;?>" /><?php

			}
			else {?>
        <div id="FW_V2_A_CONTENT_<?php echo $FW_V2_idComp;?>" style="display: block;">
          <a href="editar" style="display: block; <?php echo $FW_V2_content . " " . $FW_V2_CLASS_COMP;?>" 
          
          onmouseover="$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').addClass('tdGridAuto');" 
          onmouseout ="$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').removeClass('tdGridAuto');" 
          
          onclick="FW_V2_apenasNada(); return false;"
          onmouseup="FW_V2_apenasNada(); return false;"
          onmousedown="FW_V2_apenasNada(); return false;"
          
  
          onfocus="setTimeout(function(){FW_V2_componenteHtml('<?php echo $FW_V2_idComp;?>'); return false;}, 100)">
            <div id="FW_V2_TEXT_<?php echo $FW_V2_idComp;?>" 
                 style="display: block; <?php echo $FW_V2_cssRelat;?>;" 
                 class="<?php echo $FW_V2_CLASS_COMP;?>" 
                 onclick="FW_V2_componenteHtml('<?php echo $FW_V2_idComp;?>'); return false;">
              <?php echo $FW_V2_valueTextAux;?>
            </div>
          </a>
        </div>

        <div id="FW_V2_COMP_<?php echo $FW_V2_idComp;?>" style=" <?php echo $FW_V2_CLASS_COMP;?>"></div>
        
        <input type="hidden" id="<?php echo $FW_V2_idComp;?>" name="<?php echo $FW_V2_nomeComp;?>" value="<?php echo $FW_V2_value;?>" />
        <input type="hidden" id="hdd_info_<?php echo $FW_V2_idComp;?>" value="<?php echo $FW_V2_varFunc;?>" /><?php

			}
		
		?>
    </div><?php
	}

	
	
	
?></div>
    
</body></html>
