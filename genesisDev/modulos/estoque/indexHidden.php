<html><head><?php
	include "../../includes/library/myLibrary.inc";
	include "estoqueInc.inc";
	//ini_set("display_errors", 0); 
	
	$erro      			 = "";
	$TIPO_ACAO 			  = "";
	$MENSAGEM_RETORNO = "Registro salvo com sucesso!!";
	
	if(isset($_POST["GEN_ACAO_GERAL"])) $GEN_ACAO_GERAL = $_POST["GEN_ACAO_GERAL"];?>
  
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css"><?php

	switch($GEN_ACAO_GERAL) {
		case "SELECT_ARMACAO_LST"://___[
			break;
		//]
		case "SELECT_GENERO_LST"://____[
			break;
		//]
		case "SELECT_GRID_ESTOQUE"://__[
			break;
		//]
		case "SELECT_LISTAS"://________[
			break;
		//]
		case "SELECT_RELAT_MOV"://_____[
			$E02_DATA_ANO_FILTRO = $_POST["E02_DATA_ANO_FILTRO"];
			$E02_DATA_MES_FILTRO = $_POST["E02_DATA_MES_FILTRO"];
			
			if(strlen(trim($E02_DATA_ANO_FILTRO)) == 0) $E02_DATA_ANO_FILTRO = date("Y");
			$E02_DATA_MES_FILTRO = implode(",", $_POST["E02_DATA_MES_FILTRO"]);
		
			break;
		//]
	}
	
	if($erro == "") {
		switch($GEN_ACAO_GERAL) {
			case "SELECT_ARMACAO_LST"://___[
			break;
		//]
			case "SELECT_GENERO_LST"://____[
				break;
			//]
			case "SELECT_GRID_ESTOQUE"://__[
				break;
			//]
			case "SELECT_LISTAS"://________[
				break;
			//]
			case "SELECT_RELAT_MOV"://_____[
				break;
			//]
		}
	}?>
  
	<script type="text/javascript" charset="utf-8">
    function start() {<?php
      if($erro <> "") {?>
        parent.newAlert("<span style='font-size: 18px'><?php echo $erro?></span>", "error", "");<?php
        echo "\r";
  
        switch($GEN_ACAO_GERAL) {
          case "SELECT_ARMACAO_LST"://___[
            break;
          //]
					case "SELECT_GENERO_LST"://____[
						break;
					//]
					case "SELECT_GRID_ESTOQUE"://__[
						break;
					//]
					case "SELECT_RELAT_MOV"://_____[
						break;
					//]
        }
        
      } else { 
        switch($GEN_ACAO_GERAL) {
          case "SELECT_ARMACAO_LST"://___[?>
            parent.document.getElementById("DIV_CONTENT_LEFT_TPM").innerHTML = 
                   document.getElementById("DIV_CONTENT_LEFT_TPM").innerHTML; <?php
									 
            break;
          //]
					case "SELECT_GENERO_LST"://____[?>
            parent.document.getElementById("DIV_CONTENT_LEFT_GEN").innerHTML = 
                   document.getElementById("DIV_CONTENT_LEFT_GEN").innerHTML; <?php
									 
            break;
          //]
					case "SELECT_GRID_ESTOQUE"://__[?>
            parent.document.getElementById("DIV_CONTENT_RIGHT_GRID").innerHTML = 
                   document.getElementById("DIV_CONTENT_RIGHT_GRID").innerHTML; <?php
						
						$E01_ID_SEL = $_POST["E01_ID_SEL"];
						if(strlen(trim($E01_ID_SEL)) > 0) {?>
							parent.FW_setFonteStyleDado("<?php echo $E01_ID_SEL;?>"); <?php
						}
									 
            break;
          //]
					case "SELECT_LISTAS"://________[?>
            parent.document.getElementById("DIV_CONTENT_LEFT_TPM").innerHTML =
                   document.getElementById("DIV_CONTENT_LEFT_TPM").innerHTML;
									 
						parent.document.getElementById("DIV_CONTENT_LEFT_GEN").innerHTML =
                   document.getElementById("DIV_CONTENT_LEFT_GEN").innerHTML;

						parent.document.getElementById("DIV_CONTENT_RIGHT_GRID").innerHTML =
                   document.getElementById("DIV_CONTENT_RIGHT_GRID").innerHTML; 
									 
						parent.document.getElementById("DIV_CONTENT_LEFT_M_FILTRO").innerHTML =
                   document.getElementById("DIV_CONTENT_LEFT_M_FILTRO").innerHTML; <?php
									 
            break;
          //]
					case "SELECT_RELAT_MOV"://_____[?>
						parent.document.getElementById("REPORT_MOV_CONTENT").value =
								   document.getElementById("DIV_CONTENT_RIGHT_M_RELATORIO").innerHTML;
									 
						parent.document.getElementById("DIV_CONTENT_RIGHT_M_RELATORIO").innerHTML =
									 document.getElementById("DIV_CONTENT_RIGHT_M_RELATORIO").innerHTML; <?php
									 
            break;
          //]
        }
        
      }?>
    }
  </script>
  
</head><body onLoad="start();" style="font-family:'Courier New', Courier, monospace; background-color: #FFF;"><?php
	echo "DATA E HORA.....: indexHidden.php " . date("d/m/Y H:i:s ") . "<BR />
				GEN_ACAO_GERAL..: $GEN_ACAO_GERAL<BR />";
				
	if($erro == "") {
		switch($GEN_ACAO_GERAL) {
			case "SELECT_ARMACAO_LST"://___[?>
				<div id="DIV_CONTENT_LEFT_TPM"><?php filtroTipoModelo();?></div><?php 
			//]
			case "SELECT_GENERO_LST"://____[?>
				<div id="DIV_CONTENT_LEFT_GEN"><?php filtroGenero();?></div><?php 
			//]
			case "SELECT_GRID_ESTOQUE"://__[?>
				<div id="DIV_CONTENT_RIGHT_GRID"><?php
					$DIV_CONTENT_LEFT_WIDTH = $_POST["DIV_CONTENT_LEFT_WIDTH"];
					estoqueGrid($DIV_CONTENT_LEFT_WIDTH);?>
					
        </div><?php
				
				break;
			//]
			case "SELECT_LISTAS"://________[
				$DIV_CONTENT_LEFT_WIDTH = $_POST["DIV_CONTENT_LEFT_WIDTH"];?>
				
        <div id="DIV_CONTENT_LEFT_GEN"><?php filtroGenero();?></div>
        <div id="DIV_CONTENT_LEFT_TPM"><?php filtroTipoModelo();?></div>
				<div id="DIV_CONTENT_RIGHT_GRID"><?php estoqueGrid($DIV_CONTENT_LEFT_WIDTH);?></div>
				
				<div id="DIV_CONTENT_LEFT_M_FILTRO">
					<div style="padding: 4px">
            <table border="0" cellspacing="0" cellpadding="0">
            <tr><th valign="top">
	            &nbsp;Ano:&nbsp;&nbsp;
            </th><td><?php
							$FW_V2_OPTIONLIST = ""; 
							
							$SQL_QUERY_GEN_AUX = "
							SELECT X.E02_DATA_ANO 
							FROM E02_OCULOS_MOV AS X
							GROUP BY X.E02_DATA_ANO 
							ORDER BY X.E02_DATA_ANO DESC";
							
							$CONECTAR_DB  = FW_conctarDB();
							$SQL_QUERY    = $SQL_QUERY_GEN_AUX;
							$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
							$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
							$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
							
							if($NUM_LINES_DB > 0) {
								while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
									$FW_V2_OPTIONLIST = "$FW_V2_OPTIONLIST <option value='" . $DADOS_ROW[0] . "'>" . $DADOS_ROW[0] . "</option>";
								}
							}
							$FW_V2_OPTIONLIST = urlencode(trim($FW_V2_OPTIONLIST));
							 
							FW_desconctarDB($CONECTAR_DB);
							
							FW_V2_componenteHtml(
								array(
									"FW_V2_IDCOMP"     => "E02_DATA_ANO_FILTRO",
									"FW_V2_NOMECOMP"   => "E02_DATA_ANO_FILTRO",
									"FW_V2_TIPOCOM"    => "SELECT",
									"FW_V2_VALUE"      => date("Y"),
									"FW_V2_DESCRICAO"  => date("Y"),
									"FW_V2_OPTIONLIST" => $FW_V2_OPTIONLIST,
									"FW_V2_CSS"        => "",
									"FW_V2_TITULO"     => "",
									"FW_V2_FUNCBLUR"   => "relatorioMovimento()",
								)	
							);?>
            </td></tr>
            </table><br />
            <table border="0" cellspacing="0" cellpadding="0" align="center" style="width: 100%">
            <tr><td width="20px">
              <input type="checkbox" checked onClick="setFiltroCheck('checkIdFiltroMesClass'); this.checked=true;" />
            
            </td><th align="left">
              <table border="0" cellspacing="0" cellpadding="0">
              <tr><th valign="bottom">Meses</th>
              <td style="padding-left: 10px">
                <img src = "../../imagens/nodes/lupa.gif" 
                   style = "cursor: pointer" 
                   title = "Clique aqui para selecionar"
                 onclick = "relatorioMovimento()" />
              </td></tr>
              </table>          
                          
            </th><td>&nbsp;
              
            </td></tr>
             
            <tr><td colspan="3" valign="top">
              <div style="overflow-y: auto; overflow-x: hidden;">
                <table border="0" cellspacing="0" cellpadding="0" align="center" style="width: 100%"><?php 
                  $MESES_ARR = array("NULL", 
                                     "Janeiro", "Fevereiro", "Março"   , "Abril"  , "Maio"    , "Junho",
                                     "Julho"  , "Agosto"   , "Setembro","Outubro" , "Novembro", "Dezembro");
                  
                  $efeitoZebra = "";
                  for($i = 1; $i < count($MESES_ARR); $i++) {?>
                    <tr<?php
                    if($efeitoZebra == "tdGridAuto") {
                      $efeitoZebra = "";
                      
                    } elseif($efeitoZebra == "") {
                      $efeitoZebra = "tdGridAuto";
                      
                    }?>
                    
                    class="<?php echo $efeitoZebra;?>">
                    <td width="20px" valign="top">
                      <input type="checkbox"                     
                      id="E02_DATA_MES_FILTRO_<?php echo $i;?>" 
                      name="E02_DATA_MES_FILTRO[]" 
                      
                      style="cursor: pointer" 
                      class="checkIdFiltroMesClass"
                      value="<?php echo $i;?>" />
                    </td>
                    <td>
                      <label for="E02_DATA_MES_FILTRO_<?php echo $i;?>" style="cursor: pointer;">
                        <?php echo $MESES_ARR[$i];?>
                      </label>
                    </td>
                  </tr><?php
                  }?>
                </table>
              </div>
            </td></tr>
            </table>
         
            <div style="padding-top: 10px;" align="center">
              <input 
                   type = "button" 
                  class = "bttGridClass" 
                  style = "margin: 0; font-size: 14px; width: 100px" 
                  value = "  Imprimir  " 
                onclick = "$('#formReportMov').submit();" />
            </div>
            						              
        	</div>  
        </div><?php
				
				break;
			//]
			case "SELECT_RELAT_MOV"://_____[?>
				<div id="DIV_CONTENT_RIGHT_M_RELATORIO"><?php
					relatorioOculosMov($E02_DATA_ANO_FILTRO, $E02_DATA_MES_FILTRO);?>
        </div><?php
				
				break;
			//]
		}
	}?>
</body></html>