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
 	
  <link rel="stylesheet" type="text/css" href="../includes/cssmenu/styles.css"/>
  <link rel="stylesheet" type="text/css" href="../includes/styleGeral.css"/>
      
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>....::: Genesis :::....</title>
  
  <script type="text/javascript"><?php		
		if($GEN_acaoGeral == "") {
		//	echo "window.location = '../index.php'";
		}?>
		
		var windowWidth  = $(window).width();
		var windowHeight = ($(window).height() - 50);
		
		$(document).ready(function(e)    {
		/*	$("#DIV_PRINC_CONTEUDO")
			.attr("style", "height: " + windowHeight + "px; overflow: auto;");
			*/
		});
		
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
  </div>
  
  <form id="frmGeral" name="frmGeral" method="post"><?php
		$GEN_PRINC_CONTEUDO_CSS = "
		background-color: #FFF; 
		height: " . ($GEN_windowHeight - 10) . "px; 
		margin: 7px;";?>
      
    <div id="DIV_PRINC_CONTEUDO" style="<?php echo $GEN_PRINC_CONTEUDO_CSS;?>"><?php
	$FW_V2_TITULO_CSS = "text-align: center; font-weight: bold; color: #2F4F4F; padding: 5px;";
	
	$FW_V2_colecao = array(
			"FW_V2_SQL_QUERY" => "
				SELECT P.IDPESSOA  	AS P01_ID, 
							 P.NOME 			AS P01_NOME, 
							 P.MUNICIPIO	AS P01_MUNICIPIO, 
							 P.BAIRRO 		AS P01_BAIRRO
				FROM PESSOAS AS P
				WHERE P.IDPESSOA < 50
				ORDER BY P.NOME, P.MUNICIPIO, P.BAIRRO ",
	
			      "FW_V2_NOME_GRID" => "GRID_LISTA_PESSOAS",
			       "FW_V2_CHECKBOX" => true,
			"FW_V2_SQL_QUERY_COUNT" => "SELECT COUNT(P.IDPESSOA) FROM PESSOAS AS P",			 

			"FW_V2_ACOES" => array(
					array("alert('[FW_V2_ID_VALUE]')", $GEN_PATH_IMAGE . "edit.gif"   , "Clique para editar registro"),
					array("alert('[FW_V2_ID_VALUE]')", $GEN_PATH_IMAGE . "excluir.png", "Clique para editar registro")
			),
				
			"FW_V2_TITULO" => array(
				array("P01_ID"       , "Nome"            , "width: 500px; $FW_V2_TITULO_CSS"),
				array("P01_MUNICIPIO", "Munic&iacute;pio", "width: 150px; $FW_V2_TITULO_CSS"),
				array("P01_BAIRRO"   , "Bairro"          , "width: 150px; $FW_V2_TITULO_CSS")
			)
	);
	
	FW_V2_makeGrid($FW_V2_colecao);
	function FW_V2_makeGrid($FW_V2_colecao) {
		global $GEN_PATH_IMAGE;

		$FW_V2_TITULO_ID   	 = 0;
		$FW_V2_TITULO_DESC 	 = 1;
		$FW_V2_TITULO_CSS  	 = 2;

		$FW_V2_ACOES_FUNC    = 0;
		$FW_V2_ACOES_IMG     = 1;
		$FW_V2_ACOES_TITLE   = 2;
		$FW_V2_ACOES         = $FW_V2_colecao["FW_V2_ACOES"];		
		$FW_V2_ACOES_BUTTONS = "FW_V2_ACOES_BUTTONS_" . $FW_V2_NOME_GRID;		
		
		$FW_V2_TITULO      		 = $FW_V2_colecao["FW_V2_TITULO"];		
		$FW_V2_NOME_GRID   		 = $FW_V2_colecao["FW_V2_NOME_GRID"];
		
		$FW_V2_SQL_QUERY_COUNT_MX = 0; // MÁXIM
		$FW_V2_SQL_QUERY_COUNT_MM = 0; // MINIMO
		$FW_V2_SQL_QUERY_COUNT    = $FW_V2_colecao["FW_V2_SQL_QUERY_COUNT"];
		//-------------------------------------------------------------------------------------------------------
		
		if($FW_V2_SQL_QUERY_COUNT  != "") {
			$FW_V2_CONECTAR						= FW_conctarDB();
			$FW_V2_RESULT  						= mysqli_query($FW_V2_CONECTAR, $FW_V2_SQL_QUERY_COUNT);
			$FW_V2_RESULT   					= $FW_V2_CONECTAR->query($FW_V2_SQL_QUERY_COUNT);
			$FW_V2_NUM_LINE 					= mysqli_affected_rows($FW_V2_CONECTAR);
			$FW_V2_ROW      					= mysqli_fetch_array($FW_V2_RESULT, MYSQLI_NUM);
			$FW_V2_SQL_QUERY_COUNT_MX = $FW_V2_ROW[0];
			
			FW_desconctarDB($FW_V2_CONECTAR);
		}
		//-------------------------------------------------------------------------------------------------------?>
    
    <div id="FW_V2_DIV_GRID<?php echo "_" . $FW_V2_NOME_GRID;?>">
    <table border="1" cellspacing="0" cellpadding="0" 
    class="FW_V2_CSS_GRID FW_V2_CSS_GRID<?php echo "_" . $FW_V2_NOME_GRID;?>"><?php 
		//TÍTULO___[
			echo "<tr>";?>
			<td valign="top">
        <table border="0" cellspacing="0" cellpadding="0">
        <tr><td valign="top"><?php
          if($FW_V2_colecao["FW_V2_CHECKBOX"]) {?>
            <input type="checkbox"  style="margin-top: 5px"
                 id = "FW_V2_CHECK<?php echo "_" . $FW_V2_NOME_GRID;?>"
              class = "FW_V2_CHECK<?php echo "_" . $FW_V2_NOME_GRID;?>_CLASS"
            onclick = "this.checked=true;" /><?php
          }?>
        </td><?php
				
        if(count($FW_V2_ACOES) > 0) {?>
          <td valign="top" style="padding-left: 5px;">
            <a href="/OPÇÕES" 
            onclick="
            $('#<?php echo $FW_V2_ACOES_BUTTONS;?>').toggle('slow'); 
            $('.FW_V2_RANGE<?php echo "_" . $FW_V2_NOME_GRID;?>').toggle('fast');
            return false;"
            
            title="Clique aqui para ver opções">
              <img   style="margin-top: 5px" src="<?php echo $GEN_PATH_IMAGE . "FW_ACAO.png"?>" width="16" height="14" border="0" />
            </a>
            
          </td><td valign="top">
          <div style="position: relative">
          <div id="<?php echo $FW_V2_ACOES_BUTTONS;?>" 
          style="display: none; position: absolute; padding-left: 5px; z-index: 1000; background-color: #FFF">
            <table border="0" cellspacing="0" cellpadding="5">
            <tr><?php
							for($i = 0; $i < count($FW_V2_ACOES); $i++) {?>
								<td valign="middle">
                  <a href="/OPÇÕES" onclick="<?php echo $FW_V2_ACOES[$i][$FW_V2_ACOES_FUNC];?>; return false;"
                  title="<?php echo $FW_V2_ACOES[$i][$FW_V2_ACOES_TITLE];?>">
                    <img src="<?php echo $FW_V2_ACOES[$i][$FW_V2_ACOES_IMG];?>" border="0" />
                  </a>
                </td><?php
							}?>
            </tr>
            </table>
          </div></div>
          </td><?php
				}?>
        </tr>
        </table>
      </td><?php

			if(count($FW_V2_TITULO) > 0) {
				for($i = 0; $i < count($FW_V2_TITULO); $i++) {?>
          <td valign="top" style="position: relative"><?php 
						if(($i == 0) && ($FW_V2_SQL_QUERY_COUNT  != "")) {?>
							<div style="position: absolute; padding: 5px; font-size: 14px" 
              class="FW_V2_CSS_GRID_RANGE FW_V2_RANGE<?php echo "_" . $FW_V2_NOME_GRID;?>">
              	<?php echo $FW_V2_SQL_QUERY_COUNT_MM . "&nbsp;&nbsp;de&nbsp;&nbsp;" . $FW_V2_SQL_QUERY_COUNT_MX;?>
              </div><?php
						}?>
            
            <div style=" <?php echo $FW_V2_TITULO[$i][$FW_V2_TITULO_CSS];?>">
              <?php echo $FW_V2_TITULO[$i][$FW_V2_TITULO_DESC];?>
            </div>
          </td><?php
				}
			}
			echo "</tr>";
		//]	?>
    </table>
    </div><?php
	}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	//====================================================================================================================		
      $sqlQuery = "
      SELECT P.IDPESSOA  	AS P01_ID, 
             P.NOME 			AS P01_NOME, 
             P.MUNICIPIO	AS P01_MUNICIPIO, 
             P.BAIRRO 		AS P01_BAIRRO
      FROM PESSOAS AS P
      WHERE P.IDPESSOA < 50
      ORDER BY P.NOME, P.MUNICIPIO, P.BAIRRO";

      $camposGrid = "
      Nome-500-P01_NOME-left-" . $FW_PATH_IMAGE . "pessoas/[FW_ID_VALUE].jpg|
      Município-150-P01_MUNICIPIO-left|
      Bairro-150-P01_BAIRRO-left";
      
      //$acaoGrid  = "";
			$acaoGrid = "
			alert('[FW_ID_VALUE]')-edit.gif-Clique para editar registro";
			
      $PATH_GRID = "index.php";
      
    	//FW_makeGrid(true, $acaoGrid, "V1_GRID_LISTA_PESSOAS", $camposGrid, $sqlQuery, ($GEN_windowHeight - 70), $PATH_GRID);

	
	?>
    </div>
    
    
    <input type="hidden" id="GEN_acaoGeral" name="GEN_acaoGeral" value="<?php echo $GEN_acaoGeral;?>" />
    <input type="hidden" id="GEN_P01_ID"    name="GEN_P01_ID"    value="<?php echo $GEN_P01_ID;?>" />

    <input type="hidden" id="GEN_windowHeight" name="GEN_windowHeight" value="<?php echo $GEN_windowHeight;?>" />
    <input type="hidden" id="GEN_windowWidth"  name="GEN_windowWidth"  value="<?php echo $GEN_windowWidth;?>" />
    
  </form>
  
  <div style="top:70%; position: absolute; width: 100%; display: none">
  	<iframe id="iframeGeral" name="iframeGeral" style="width: 95%; height: 150px;"></iframe>
  </div>
    
</body></html>
