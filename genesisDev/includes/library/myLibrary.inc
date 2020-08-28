<?php 
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");              // Date in the past
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
	header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache"); // HTTP/1.0

	error_reporting (E_ALL ^ E_NOTICE); 
	
	if (!isset($_POST['action'])) {
		//If not isset -> set with dumy value 
		$_POST['action'] = "undefine"; 
	}
	//====================================================================================================================
	
	$FW_PASSWORD   = "";
	$FW_USER_NAME  = "root";	
	$FW_HOST_NAME  = "localhost";	
	$FW_DATABASE   = "genesisdb"; 
	$FW_PATH_IMAGE = "http://" . $_SERVER["SERVER_NAME"] . "/genesisDev/imagens/";	
	
	function FW_conctarDB() 											 {
		global $FW_HOST_NAME, $FW_USER_NAME, $FW_PASSWORD, $FW_DATABASE;
	
		$conexao = new mysqli($FW_HOST_NAME, $FW_USER_NAME, $FW_PASSWORD, $FW_DATABASE);
		$conexao->set_charset("utf8");
	
		if($conexao->connect_error) {
			$conectarDB = false;
			die("Connect Error (" . $conexao->connect_errno . ") "
					. $conexao->connect_error);
		}
	
		return $conexao;
	}
	function FW_converterData($strData) 					 {
		// Recebemos a data no formato: dd/mm/aaaa
		// Convertemos a data para o formato: aaaa-mm-dd
		
		if ( preg_match("#/#",$strData) == 1 ) {
				$strDataFinal = "'";
				$strDataFinal .= implode('-', array_reverse(explode('/',$strData)));
				$strDataFinal .= "'";
		}
		return $strDataFinal;
	}
	function FW_numeroEspacoMilhar($pNumber)      {
    $pNumber = number_format($pNumber,0,","," ");
    return str_replace(" ", "&nbsp;", $pNumber);
	}
	function FW_desconctarDB($pConexao) 					 {
		$pConexao->close();
	}
	function FW_sqlExec($pSqlCommands, $pConctar) {
		$FW_ERRO = "";
		//----------------------------------------------------------
		
		$result = $pConctar->query($pSqlCommands);
		
		if(!$result) {
			$FW_ERRO = "Erro ao salvar! Avisar equipe de suporte!";
			
			echo "<br />Insertion Error " . mysql_error() .
					 "<br /><br />$pSqlCommands<br /><br />";
		
		}
		//----------------------------------------------------------		
		
		return $FW_ERRO;
	}
	function FW_trataCaractere($pTexto, $tipoDado){
		global $FW_V2_null;
		
		if((strlen($pTexto) == 0) || ($pTexto == $FW_V2_null)) {
			$pTexto = "NULL";
			
		} elseif(strlen($pTexto) > 0) {
			switch($tipoDado) {
				case "T"://__[
					$pTexto = "'" . str_replace("'", "´", trim($pTexto)) . "'";
					break;
				//]
				case "N"://__[
					$pTexto = str_replace(",", ".", trim($pTexto));
					break;
				//]
				case "P"://__[
					$pTexto = "'" . md5(trim($pTexto)) . "'";
					break;
				//]
			}
			
			
			/*echo "<br />FW_trataCaractere
						  <br />pTexto....: $pTexto
						  <br />tipoDado..: $tipoDado<br /><br />";*/
			
		/*	switch($tipoDado) {
				case 0://__[
					$pTexto = "'" . str_replace("'", "´", $pTexto) . "'";
					break;
				//]
				case 1://__[
					break;
				//]
				case 2://__[
					$indexValue  = 0; 
					$dataHora    = $pTexto;
					$dataHoraArr = explode(" ", $dataHora);
					$indexValue  = (sizeof($dataHoraArr) - 1); 
					$dataValue   = $dataHoraArr[0];
					$horaValue   = "";
				
					if($indexValue > 0) $horaValue = $dataHoraArr[1]; 
						
					$DIA = "";
					$MES = "";
					$ANO = "";
					$TEXT_ARR = explode("/", $dataValue);
					
					if((sizeof($TEXT_ARR) - 1) > 0) {
						$DIA = $TEXT_ARR[0];
						$MES = $TEXT_ARR[1];
						$ANO = $TEXT_ARR[2];
				
						$dataValue = "$ANO-$MES-$DIA";
						if($horaValue != "") $dataValue = "$dataValue $horaValue";
						$dataValue = "'$dataValue'";
					}
					
					$pTexto = $dataValue;
					//$TEXT_ARR = explode("/", $pTexto);
					//
					//$DIA = $TEXT_ARR[0];
					//$MES = $TEXT_ARR[1];
					//$ANO = $TEXT_ARR[2];
					//
					//$pTexto = "'$ANO-$MES-$DIA'";
					
					break;
				//]
				case 3://__[
					$pTexto = str_replace(".",  "", $pTexto);
					$pTexto = str_replace(",", ".", $pTexto);
					
					break;
				//]
				case 4://__[
					$pTexto = number_format($pTexto, 2, ",", ".");
					
					break;
				//]
			}*/
		}
		
		return trim($pTexto);
	}
	
	function FW_makeGrid($P_GRID_SQL_QUERY, $P_GRID_PARAM) {
		$GRID_TITULO_PRINT = "";
		$GRID_SET_IDS      = "";
		$GRID_SQL_QUERY    = $P_GRID_SQL_QUERY;
				
		$GRID_CHECKBOX     = $P_GRID_PARAM["GRID_CHECKBOX"];
		$GRID_ID           = $P_GRID_PARAM["GRID_ID"];
		$GRID_FUNCTIONS    = $P_GRID_PARAM["GRID_FUNCTIONS"];
		$GRID_CAMPOS       = $P_GRID_PARAM["GRID_CAMPOS"];
		$GRID_HEIGHT       = $P_GRID_PARAM["GRID_HEIGHT"];
		$GRID_FORM_ID      = $P_GRID_PARAM["GRID_FORM_ID"];
		$GRID_PAGE_HIDDEN  = $P_GRID_PARAM["GRID_PAGE_HIDDEN"];
		$GRID_NUM_LINES    = $P_GRID_PARAM["GRID_NUM_LINES"];
		$GRID_PRINT_QUERY  = $P_GRID_PARAM["GRID_PRINT_QUERY"];
		
		/*echo "
		<div style='font-family: Courier New, Courier, monospace' align='left'>
			GRID_CHECKBOX.....: $GRID_CHECKBOX    <BR />
			GRID_ID...........: $GRID_ID	        <BR />
			GRID_FUNCTIONS....: $GRID_FUNCTIONS	  <BR />
			GRID_CAMPOS.......: $GRID_CAMPOS		  <BR />
			GRID_HEIGHT.......: $GRID_HEIGHT      <BR />
			GRID_FORM_ID......: $GRID_FORM_ID     <BR />
			GRID_PAGE_HIDDEN..: $GRID_PAGE_HIDDEN <BR />
			GRID_NUM_LINES....: $GRID_NUM_LINES   <BR />
			GRID_PRINT_QUERY..: $GRID_PRINT_QUERY
		</div>";*/		
		
		$HIDDEN_ACOES = "";
		if($GRID_SQL_QUERY == "") $HIDDEN_ACOES = "visibility: hidden";	
		
		global $FW_PATH_IMAGE;
		
		$HDD_ORDEM  = "";
		$HDD_CAMPO  = "";
		$HDD_FILTRO = "close";
	
		if(isset($_POST["HDD_" . $GRID_ID . "_ORDEM"]))  $HDD_ORDEM  = $_POST["HDD_" . $GRID_ID . "_ORDEM"];
		if(isset($_POST["HDD_" . $GRID_ID . "_CAMPO"]))  $HDD_CAMPO  = $_POST["HDD_" . $GRID_ID . "_CAMPO"];
		if(isset($_POST["HDD_" . $GRID_ID . "_FILTRO"])) $HDD_FILTRO = $_POST["HDD_" . $GRID_ID . "_FILTRO"];?>
		
		<input type="hidden" id="HDD_<?php echo $GRID_ID;?>_FORM_NAME" value="<?php echo $GRID_FORM_ID;?>" /><?php
		
		if($GRID_SQL_QUERY == "") $HDD_FILTRO = "open";?>
		<input type="hidden" id="HDD_<?php echo $GRID_ID;?>_ORDEM" 
		name="HDD_<?php echo $GRID_ID . "_ORDEM";?>" value="<?php echo $HDD_ORDEM;?>" />
		
		<input type="hidden" id="HDD_<?php echo $GRID_ID;?>_CAMPO" 
		name="HDD_<?php echo $GRID_ID . "_CAMPO";?>" value="<?php echo $HDD_CAMPO;?>" />
		
		<input type="hidden" id="HDD_<?php echo $GRID_ID;?>_PATH"  
		name="HDD_<?php echo $GRID_ID . "_PATH";?>"  value="<?php echo $GRID_PAGE_HIDDEN;?>" />
		
		<input type="hidden" id="HDD_<?php echo $GRID_ID;?>_FILTRO"  
		name="HDD_<?php echo $GRID_ID . "_FILTRO";?>"  value="<?php echo $HDD_FILTRO;?>" />

		<input type="hidden" id="HDD_<?php echo $GRID_ID;?>_FILTRO_UPDATE" <?php
		if($HDD_FILTRO == "open") {?> value="true" <?php }?> />
		
		<div id="DIV_GRID_<?php echo $GRID_ID;?>">
    	<table border="0" cellspacing="0" cellpadding="0" class="FW_CSS_GRID">
			<tr><td valign="top" align="left">
        <div style="border-bottom: 1px solid #CCC;">
          <table border="0" cellspacing="0" cellpadding="0" class="FW_CSS_GRID">
          <tr><?php
            if($GRID_CHECKBOX == true) {?>
              <td valign="baseline">
                <div style="margin-top: 5px;">
                  <input type="checkbox" 
                  id="checkSel_<?php echo $GRID_ID;?>" style="<?php echo $HIDDEN_ACOES;?>"
                  class="checkIdGridClass_<?php echo $GRID_ID;?>" checked="checked" 
                  onclick="FW_gridCheck('<?php echo $GRID_ID;?>'); this.checked=true;" />
                </div>  
                <input type="hidden" class="checkSelVal_<?php echo $GRID_ID;?>" value="false" />
              
            </td><?php
            }
            //AÇÕES TÍTULOS__[
            if($GRID_FUNCTIONS != "") {
              $gridAcao = explode("|", $GRID_FUNCTIONS);
              
              for($i = 0; $i < count($gridAcao) - 1; $i++) {
                $funcImg = explode("-", $gridAcao[$i]);
                $funcImg[0] = str_replace("[FW_ID_VALUE]", "", $funcImg[0]);?>
                
                <th nowrap="nowrap" valign="baseline"  align="center" style="position: relative; width: 25px">
                  <a href="javascript: void(0)" <?php if($funcImg[2] <> "") {echo "title='$funcImg[2]'";}?>
                  onclick="<?php echo $funcImg[0];?>" style="text-decoration: none; <?php echo $HIDDEN_ACOES;?>">
                    <img src="<?php echo $funcImg[1];?>" width="18" />
                  </a><?php
                  
                  if($i == 0) {?>
                    <div id="DIV_AGUARDE_<?php echo $GRID_ID;?>"
                    style="position: absolute; top: 2%; left: 100%; display: none">
                      <img src="<?php echo $FW_PATH_IMAGE . "wait16.gif";?>" />
                    </div><?php
                  }?>
                  
                </th><?php
              }
            }
            //]
            //TÍTULOS________[
              $WHERE_AUX = "";
              
              $primairoFiltro = "PRI_" . $GRID_ID . "_GRID_FILTRO";
              $camposGrid = explode("|", $GRID_CAMPOS);
              for($i = 0; $i < count($camposGrid); $i++) {
                if($i > 0) $primairoFiltro = "";
                $descSize = explode("-", $camposGrid[$i]);	?>
                
                <th nowrap="nowrap" style="width: <?php echo $descSize[1] . "px";?>"><?php
                  $ID_DISABLE_FILTRO = "FILTRO_DISABLE_" . $i;?>
                  <div style="cursor: pointer;">
                    <table border="0" cellspacing="0" cellpadding="0" align="center" 
                    style="font-family:Arial, Helvetica, sans-serif; padding-top: 5px">
                    <tr><td>
                      <div id="<?php echo $ID_DISABLE_FILTRO;?>" style="positionZ:absoluteZ; display: NONE;">
                        <a href="javascript: void(0)" onclick="FW_gridAtivarFiltro('<?php echo $GRID_ID;?>')" 
                        title="Clique aqui para remover o filtro">
                          <img id="IMG_<?php echo $ID_DISABLE_FILTRO;?>" 
                          src="<?php echo $FW_PATH_IMAGE . "removefiltro.gif";?>" />
                        </a>                    
                      </div>
                      
                    </td><td>
                      <div class="FW_CSS_TITULO" 
                      onclick="FW_gridOrdem('<?php echo $GRID_ID;?>', '<?php echo $descSize[2]?>')">
												<span style="font-size: 15px"><?php 
                        	echo trim($descSize[0]);
													
													if($GRID_PRINT_QUERY == "PRINT") {
														if($GRID_TITULO_PRINT != "") $GRID_TITULO_PRINT = $GRID_TITULO_PRINT . "|";
														$GRID_TITULO_PRINT = $GRID_TITULO_PRINT . trim($descSize[0]);
													}?>
                        </span>
                      </div>
                      
                    </td><td valign="middle">
                      <div style="padding-left: 5px; <?php 
                        if($descSize[2] != $HDD_CAMPO) { echo 'display: none';}?>"
                          id="DIV_<?php echo $descSize[2] . "_CAMPO";?>" 
                       class="DIV_<?php echo $GRID_ID   . "_CAMPO_CLASS";?>"><?php
                        $IMG_AUX = $FW_PATH_IMAGE . "downC.gif";
                        if($HDD_ORDEM == "ASC") $IMG_AUX = $FW_PATH_IMAGE . "upC.gif";?>
                        <img id="IMG_<?php echo $descSize[2] . "_CAMPO";?>" src="<?php echo $IMG_AUX;?>" />		
                      </div>
                    </td></tr>
                    </table>
                  </div>
                  <div class="DIV_<?php echo $GRID_ID . "_FILTRO_CLASS";?>" 
                  style="padding: 3px; <?php
                    if($HDD_FILTRO == 'close'){
                      echo 'display: none;';
                    }?>">
                    
                    <input 
                            type = "text" 
                           class = "textbox TEXT_<?php echo $GRID_ID . "_FILTRO_CLASS ". $primairoFiltro;?> " 
                         onkeyup = "$('#HDD_<?php echo $GRID_ID;?>_FILTRO_UPDATE').val('true')"
                        onfocus  = "$('.buttonClass').button({disabled: true});"
                    autocomplete = "off" 
                       onkeydown = "FW_gridFiltrar(event, '<?php echo $GRID_ID;?>')"
                              id = "<?php echo $descSize[2];?>" 
                            name = "<?php echo $descSize[2];?>" style="width: 90%" <?php
                    
                    $fieldFiltro = "";
                    if(isset($_POST[$descSize[2]])) {
                      $fieldFiltro = $_POST[$descSize[2]];
                      
                      if($fieldFiltro != "") {
                        if($WHERE_AUX == "") {
                          $WHERE_AUX = " X." . $descSize[2] . " LIKE '%" . $fieldFiltro . "%' ";
                          
                        } else if($WHERE_AUX != "") {
                          $WHERE_AUX = $WHERE_AUX . " AND X." . $descSize[2] . " LIKE '%" . $fieldFiltro . "%' ";
                          
                        }
    
                      }
                      
                    }?>
                    value="<?php echo $fieldFiltro;?>"/>
                    
                  </div>
                </th><?php
              }				
            //]?>
          </tr>
          </table>
        </div>		
			</td><td style="width: 15px" class="FW_CSS_GRID" valign="top">
				<!--ESPAÇO DO SCROLL E FILTRO-->
				<div style="margin-top: 5px; display: none" align="right">
					<a href="javascript: void(0)" onclick="FW_gridAtivarFiltro('<?php echo $GRID_ID;?>')" title="Clique aqui para ativar filtro">
						<img id="IMG_FILTRO_<?php echo $GRID_ID;?>" src="<?php 
						if($HDD_FILTRO == "close") {
							echo $FW_PATH_IMAGE . "filtro.gif";
							
						} else {
							echo $FW_PATH_IMAGE . "removefiltro.gif";
							
						}?>" />
					</a>
				</div>
			</td></tr><?php
			
			if($GRID_SQL_QUERY != "") {
				$heightAux = "";
				if($GRID_HEIGHT != "") $heightAux = "height:" . $GRID_HEIGHT . "px;";?>
				<tr><td valign="top" colspan="2" align="left">
          <div style=" <?php echo $heightAux;?> overflow-x:hidden; overflow-y: auto;">
            <table border="0" cellspacing="0" cellpadding="0" class="FW_CSS_GRID"><?php 
              $HDD_ORDEM = "";
              $HDD_CAMPO = "";
              $LIMIT_AUX = "";
							$ORDER_AUX = "";
            
              if(isset($_POST["HDD_" . $GRID_ID . "_ORDEM"])) $HDD_ORDEM = $_POST["HDD_" . $GRID_ID . "_ORDEM"];
              if(isset($_POST["HDD_" . $GRID_ID . "_CAMPO"])) $HDD_CAMPO = $_POST["HDD_" . $GRID_ID . "_CAMPO"];
             
						  if(strlen(trim($HDD_CAMPO)) > 0) $ORDER_AUX = "ORDER BY X." . $HDD_CAMPO . " " . $HDD_ORDEM . " ";
							if(strlen(trim($WHERE_AUX)) > 0) $WHERE_AUX = "WHERE " . $WHERE_AUX . " ";
							if((strlen(trim($WHERE_AUX)) == 0) && (strlen(trim($GRID_NUM_LINES)) > 0)) $LIMIT_AUX = "LIMIT " . $GRID_NUM_LINES;
							
              $FW_conexao = FW_conctarDB();
							
              $GRID_SQL_QUERY = "SELECT X.* FROM ($GRID_SQL_QUERY) AS X " .	
              $WHERE_AUX. 
              $ORDER_AUX.
							$LIMIT_AUX;
              //echo $GRID_SQL_QUERY;
              
              $result      = mysqli_query($FW_conexao, $GRID_SQL_QUERY);
              $result      = $FW_conexao->query($GRID_SQL_QUERY);
              $num_lines   = mysqli_affected_rows($FW_conexao);
              $efeitoZebra = "";
              $GRID_INDEX  = -1;
              
              if($num_lines > 0) {
                while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
                  $GRID_INDEX++;
                  
                  if($efeitoZebra == "tdGridAuto") {
                    $efeitoZebra = "";
                    
                  } elseif($efeitoZebra == "") {
                    $efeitoZebra = "tdGridAuto";
                    
                  }
                  
                  $ID_ROW_GRID = $row[0];
									
									if($GRID_SET_IDS != "") $GRID_SET_IDS = $GRID_SET_IDS . ", ";
									$GRID_SET_IDS = $GRID_SET_IDS . $ID_ROW_GRID;?>
                  
                  <tbody id="TBODY_<?php echo $GRID_ID;?>_<?php echo $ID_ROW_GRID;?>">
                    <tr class="<?php echo $efeitoZebra;?>" 
                    onmousemove="this.className = 'tdGridAutoSel'" 
                    onmouseout="this.className = '<?php echo $efeitoZebra;?>'"><?php
                    if($GRID_CHECKBOX == true) {?>
                      <td valign="baseline" align="left">
                        <input type="checkbox" 
                        id="checkSel_<?php echo $GRID_ID . "_" . $row[0];?>" 
                        name="checkIdGrid_<?php echo $GRID_ID;?>[]" value="<?php echo $row[0];?>"
                        class="checkIdGridClass_<?php echo $GRID_ID;?> checkSelClass_<?php echo $GRID_ID;?>" />
                      </td><?php
                    }
                    //AÇÕES DADOS__[
                    if($GRID_FUNCTIONS != "") {
                      $gridAcao = explode("|", $GRID_FUNCTIONS);
                      
                      for($i = 0; $i < count($gridAcao) - 1; $i++) {
                        $funcImg    = explode("-", $gridAcao[$i]);
                        $funcImg[0] = str_replace("[FW_ID_VALUE]", $row[0], $funcImg[0]);?>
                        
                        <td nowrap="nowrap" valign="baseline" style="position: relative; width: 25px;"  align="center">
                          <a href="javascript: void(0)" <?php if($funcImg[2] <> "") {echo "title='$funcImg[2]'";}?>
                          onclick="<?php echo $funcImg[0];?>" style="text-decoration: none;">
                            <img src="<?php echo $funcImg[1];?>" width="18" />
                          </a>
                        </td><?php
                      }
                    }
                    //]
                    //DADOS________[
                    $firstVal = true;
                    $fieldIndex = 0;
                    $camposGrid = explode("|", $GRID_CAMPOS);
                    
                    for($i = 1; $i < count($row); $i++) {
                      $descSize = explode("-", $camposGrid[$fieldIndex]);
                      $FW_IMG_VIEW = false;
                      $FW_IMG_PATH = "";
                      
                      if(count($descSize) > 4) {
                        $FW_IMG_VIEW = true;
                        $FW_IMG_PATH = str_replace("[FW_ID_VALUE]", $row[0], $descSize[4]);
                      }?>
                      
                      <td style="position: relative; width: <?php echo $descSize[1] . "px";?>"><?php
                        if($i == 1) {?>
                          <!--<input id="<?php echo $GRID_ID;?>_INDEX_VAL_ID_<?php echo $GRID_INDEX;?>_<?php echo $row[0];?>" 
                          value="<?php echo $GRID_INDEX . " - " . $row[0];?>" />--><?php
                        }
                        
                        if($FW_IMG_VIEW == true) {?>
                          <div id="DIV_IMG_VIEW_<?php echo $GRID_ID;?>_<?php echo $row[0];?>"
                          style="position: absolute; top: 2%; left: 30px; display: none; z-index: 10" align="center">
                            <img src="<?php echo $FW_IMG_PATH;?>" onerror="FW_imgError(this);" style="height: 150px" />
                          </div><?php
                        }?>
                      
                        <div id="DIV_<?php echo $descSize[2];?>_<?php echo $ID_ROW_GRID;?>" align="<?php echo $descSize[3];?>" 
                        style="white-space: nowrap; cursor: pointer;
                               border-left: 1px solid #AAAAAA; overflow:hidden; height: 19px;
                               width: <?php echo ($descSize[1] - 2) . "px";?>"
                        onclick="FW_gridAplicarFiltro('<?php echo $GRID_ID;?>', '<?php echo $row[$i];?>', '<?php echo $descSize[2];?>')"><?php
                          if(count($descSize) < 5) {?>
                            <span class="FW_CSS_DADOS FW_CSS_DADOS_<?php echo $row[0];?>" style="font-size: 15px; "  title="<?php echo $row[$i];?>"><?php
                              echo "&nbsp;$row[$i]&nbsp;";?>
                            </span><?php
                            
                          } else {?>
                            <table border="0" cellpadding="0" cellspacing="0">
                            <tr><td style="padding-left: 5px">
                              <div
                              onmouseover="$('#DIV_IMG_VIEW_<?php echo $GRID_ID;?>_<?php echo $row[0];?>').show()"
                              onmouseout ="$('#DIV_IMG_VIEW_<?php echo $GRID_ID;?>_<?php echo $row[0];?>').hide()">
                                <img src="<?php echo $FW_IMG_PATH;?>" class="gridPerfilCircular"
                                onerror="FW_imgError(this);" />
                              </div>
                                                      
                            </td><td style="padding-left: 5px">
                              <div class="FW_CSS_DADOS" title="<?php echo $row[$i];?>">
                                <?php echo $row[$i];?>
                              </div>
                              
                            </td></tr>
                            </table><?PHP
                          }?>
                          
                        </div><?php
                        
                        if($i == 1) {?>
                          <div id="DIV_AGUARDE_<?php echo $GRID_ID;?>_<?php echo $row[0];?>"
                          style="position: absolute; top: 2%; display: none" align="center">
                            <img src="<?php echo $FW_PATH_IMAGE . "wait16.gif";?>" />
                          </div><?php
                        }
                        ?>
                      </td><?php
                      $fieldIndex++;
                    }                  
                    //]?>
                    </tr>
                    
                  </tbody><?php
                  
                }
              }
              
              if($result != NULL) $result->close();
              FW_desconctarDB($FW_conexao);?>
            </table>
      
          </div>
				</td></tr><?php
			}?>
			
			</table>
      
      <input type = "hidden" 
               id = "GRID_TITULO_PRINT_<?php echo $GRID_ID;?>"
             name = "GRID_TITULO_PRINT_<?php echo $GRID_ID;?>"
            value = "<?php echo $GRID_TITULO_PRINT;?>" />
  
      <input type = "hidden" 
               id = "GRID_SQL_QUERY_<?php echo $GRID_ID;?>" 
             name = "GRID_SQL_QUERY_<?php echo $GRID_ID;?>" 
            value = "<?php echo trim($GRID_SQL_QUERY);?>" />

      <input type = "hidden" 
               id = "GRID_SET_IDS_<?php echo $GRID_ID;?>" 
             name = "GRID_SET_IDS_<?php echo $GRID_ID;?>" 
            value = "<?php echo trim($GRID_SET_IDS);?>" />
            
		</div><?php
	}	
	//====================================================================================================================

	$FW_V2_null = "]|.NULL.|[";
	function FW_V2_drawTitle($pTitle, $pCss) 				{?>
		<div class="titleField semMargPadd" style=" <?php echo $pCss;?>"><?php 
			echo $pTitle;?></div><?php
	}
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
		
		$FW_V2_valueTextAux = "";		

		if(strlen(trim($FW_V2_parametros["FW_V2_NOMECOMP"])) == 0) {
			$FW_V2_nomeComp = $FW_V2_idComp;
		}
		if(strlen(trim($FW_V2_parametros["FW_V2_TIPOCOM"])) == 0)  {
			$FW_V2_tipoCom = "TEXT";
		}
		if(strlen(trim($FW_V2_parametros["FW_V2_CSSRELAT"])) == 0) {
			$FW_V2_cssRelat = $FW_V2_css;
		}
		
		if($FW_V2_tipoCom == "AUTO") {
			if(strlen(trim($FW_V2_parametros["FW_V2_STARTIN"])) == 0)    {
				$FW_V2_startIN = 3;
			}
			if(strlen(trim($FW_V2_parametros["FW_V2_DESCNOME"])) == 0)   {
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
		

		$FW_V2_CLASS_COMP = "FW_V2_containerMargin";
		if(strlen(trim($FW_V2_parametros["FW_V2_TITULO"])) == 0) $FW_V2_CLASS_COMP = "FW_V2_container";
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
		//=================================================================================================================?>
		
    <div id="FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>" style="padding: 0px; margin: 0px"><?php 
			if(strlen(trim($FW_V2_parametros["FW_V2_TITULO"])) > 0) {?>
				<div id="FW_V2_TITULO_<?php echo $FW_V2_idComp;?>" class="FW_V2_Titulo">
					<span style=" <?php echo $FW_V2_cssTitulo;?>"><?php echo $FW_V2_titulo;?></span>
        </div><?php
			}
						
			if($FW_V2_tipoCom == "READ")     {
				$FW_V2_valueTextAux = $FW_V2_value;
				if(strlen(trim($FW_V2_descricao)) > 0) $FW_V2_valueTextAux = $FW_V2_descricao;?>
        
        <div id="FW_V2_TEXT_<?php echo $FW_V2_idComp;?>" 
             style="color: #000000; <?php echo $FW_V2_cssRelat;?>" 
             class=" <?php echo $FW_V2_CLASS_COMP;?>"><?php 
					echo $FW_V2_valueTextAux;?>
        </div><?php
				
			} 
			elseif($FW_V2_tipoCom == "AUTO") {
				global $FW_PATH_IMAGE;
				$FW_V2_MYPATH_IMAGE = $FW_PATH_IMAGE;?>

        <div id="FW_V2_A_CONTENT_<?php echo $FW_V2_idComp;?>" class="FW_V2_content" style="display: block;" 
        onmouseover="$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').addClass('tdGridAuto');" 
        onmouseout ="$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').removeClass('tdGridAuto');">
          <table border="0" cellspacing="0" cellpadding="0">
          <tr><td valign="top">
            <a 
            	 id = "FW_V2_TAG_A_<?php echo $FW_V2_idComp;?>" 
             href = "#/editar" 
            class = "FW_V2_content" 
            style = "display: block;" 
            
            onmouseover = "$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').addClass('tdGridAuto');" 
            onmouseout  = "$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').removeClass('tdGridAuto');" 
            
                onclick = "FW_V2_apenasNada(); return false;"
              onmouseup = "FW_V2_apenasNada(); return false;"
            onmousedown = "FW_V2_apenasNada(); return false;"
            
            onfocus = "setTimeout(function(){FW_V2_componenteHtml('<?php echo $FW_V2_idComp;?>'); return false;}, 100)">
              <div id="FW_V2_TEXT_<?php echo $FW_V2_idComp;?>" 
                   style="display: block; <?php echo $FW_V2_cssRelat;?>;" 
                   class="<?php echo $FW_V2_CLASS_COMP;?>"
                   onclick="FW_V2_componenteHtml('<?php echo $FW_V2_idComp;?>'); return false;"><?php 
                echo $FW_V2_valueTextAux;?> 
              </div>
            </a>            
            
          </td><td style="padding-left: 4px" valign="top">
            <a href="/editar" class="FW_V2_content"
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
			else                             {?>
        <div id="FW_V2_A_CONTENT_<?php echo $FW_V2_idComp;?>" style="display: block;">
          <a 
             id = "FW_V2_TAG_A_<?php echo $FW_V2_idComp;?>" 
           href = "#/editar" 
          class = "FW_V2_content" 
          style = "display: block;" 
          
          onmouseover = "$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').addClass('tdGridAuto');" 
          onmouseout  = "$('#FW_V2_DIV_CONTAINER_<?php echo $FW_V2_idComp;?>').removeClass('tdGridAuto');" 
          
          onclick="FW_V2_apenasNada(); return false;"
          onmouseup="FW_V2_apenasNada(); return false;"
          onmousedown="FW_V2_apenasNada(); return false;"
          
  
          onfocus="setTimeout(function(){FW_V2_componenteHtml('<?php echo $FW_V2_idComp;?>'); return false;}, 100)">
            <div id="FW_V2_TEXT_<?php echo $FW_V2_idComp;?>" 
                 style="display: block; <?php echo $FW_V2_cssRelat;?>;" 
                 class="<?php echo $FW_V2_CLASS_COMP;?>"
                 onclick="FW_V2_componenteHtml('<?php echo $FW_V2_idComp;?>'); return false;"><?php 
							echo $FW_V2_valueTextAux;?> 
						</div>
          </a>
        </div>
        <div id="FW_V2_COMP_<?php echo $FW_V2_idComp;?>" class="<?php echo $FW_V2_CLASS_COMP;?>"></div>
        
        <input type="hidden" id="<?php echo $FW_V2_idComp;?>" name="<?php echo $FW_V2_nomeComp;?>" value="<?php echo $FW_V2_value;?>" />
        <input type="hidden" id="hdd_info_<?php echo $FW_V2_idComp;?>" value="<?php echo $FW_V2_varFunc;?>" /><?php
				
			}
		?>
    </div><?php
	}
	//====================================================================================================================
	
	$GEN_UF_ARR = array(
		0	=> array("AC",	"Acre"),
		1	=> array("AL",	"Alagoas"),
		2	=> array("AM", "Amazonas"),
		3	=> array("AP", "Amapá"),
		4	=> array("BA", "Bahia"),
		5	=> array("CE", "Ceará"),
		6	=> array("DF", "Distrito Federal"),
		7	=> array("ES", "Espírito Santo"),
		8	=> array("GO", "Goiás"),
		9	=> array("MA", "Maranhão"),
		10 => array("MG", "Minas Gerais"),
		11 => array("MS", "Mato Grosso do Sul"),
		12 => array("MT", "Mato Grosso"),
		13 => array("PA", "Pará"),
		14 => array("PB", "Paraíba"),
		15 => array("PE", "Pernambuco"),
		16 => array("PI", "Piauí"),
		17 => array("PR", "Paraná"),
		18 => array("RJ", "Rio de Janeiro"),
		19 => array("RN", "Rio Grande do Norte"),
		20 => array("RO", "Rondônia"),
		21 => array("RR", "Roraima"),
		22 => array("RS", "Rio Grande do Sul"),
		23 => array("SC", "Santa Catarina"),
		24 => array("SE", "Sergipe"),
		25 => array("SP", "São Paulo"),
		26 => array("TO", "Tocantins")
	);	
	
	$GEN_UF_ID       = 13; //PARÁ
	$GEN_ID          = "";
	$GEN_NOME        = "";
	$GEN_USER_STATUS = "";
	$GEN_DOC_WIDTH   = "";
	$GEN_DOC_HEIGHT  = ""; 
	$GEN_PARAMETROS  = "";
	
	if(isset($_POST["GEN_ID"]))          $GEN_ID          = $_POST["GEN_ID"];
	if(isset($_POST["GEN_NOME"]))        $GEN_NOME        = $_POST["GEN_NOME"];
	if(isset($_POST["GEN_USER_STATUS"])) $GEN_USER_STATUS = $_POST["GEN_USER_STATUS"];
	if(isset($_POST["GEN_DOC_WIDTH"]))   $GEN_DOC_WIDTH   = $_POST["GEN_DOC_WIDTH"];
	if(isset($_POST["GEN_DOC_HEIGHT"]))  $GEN_DOC_HEIGHT  = $_POST["GEN_DOC_HEIGHT"];
	
	if($GEN_ID          == "") if(isset($_POST["GEN_ID_"]))          $GEN_ID          = $_POST["GEN_ID_"];
	if($GEN_NOME        == "") if(isset($_POST["GEN_NOME_"]))        $GEN_NOME        = $_POST["GEN_NOME_"];
	if($GEN_USER_STATUS == "") if(isset($_POST["GEN_USER_STATUS_"])) $GEN_USER_STATUS = $_POST["GEN_USER_STATUS_"];
	if($GEN_DOC_WIDTH   == "") if(isset($_POST["GEN_DOC_WIDTH_"]))   $GEN_DOC_WIDTH   = $_POST["GEN_DOC_WIDTH_"];
	if($GEN_DOC_HEIGHT  == "") if(isset($_POST["GEN_DOC_HEIGHT_"]))  $GEN_DOC_HEIGHT  = $_POST["GEN_DOC_HEIGHT_"];

	if($GEN_ID          == "") if(isset($_GET["GEN_ID"]))          $GEN_ID          = $_GET["GEN_ID"];
	if($GEN_NOME        == "") if(isset($_GET["GEN_NOME"]))        $GEN_NOME        = $_GET["GEN_NOME"];
	if($GEN_USER_STATUS == "") if(isset($_GET["GEN_USER_STATUS"])) $GEN_USER_STATUS = $_GET["GEN_USER_STATUS"];
	if($GEN_DOC_WIDTH   == "") if(isset($_GET["GEN_DOC_WIDTH"]))   $GEN_DOC_WIDTH   = $_GET["GEN_DOC_WIDTH"];
	if($GEN_DOC_HEIGHT  == "") if(isset($_GET["GEN_DOC_HEIGHT"]))  $GEN_DOC_HEIGHT  = $_GET["GEN_DOC_HEIGHT"];
	
	$FW_DADOS_OK = true;
	if($GEN_ID == "") $TUDO_OK = false;
	if(($FW_DADOS_OK == true) && ($GEN_NOME        == "")) $FW_DADOS_OK = false;
	if(($FW_DADOS_OK == true) && ($GEN_USER_STATUS == "")) $FW_DADOS_OK = false;
	if(($FW_DADOS_OK == true) && ($GEN_DOC_WIDTH   == "")) $FW_DADOS_OK = false;
	if(($FW_DADOS_OK == true) && ($GEN_DOC_HEIGHT  == "")) $FW_DADOS_OK = false;
	//====================================================================================================================
	
	$USE_STATUS["ATIVO"]      = 0;
	$USE_STATUS["INATIVO"]    = 1;
	$USE_STATUS["WEB_MASTER"] = 2;

	$GEN_PA0_ID = -1;
	$GEN_WEB_MASTER = false;

	if($FW_DADOS_OK == true) {
		$SQL_QUERY_GEN_AUX = "
		SELECT U.PA0_ID
		FROM P01_PESSOA_USUARIO AS U 
		WHERE U.P01_ID = $GEN_ID";
		
		$CONECTAR_DB  = FW_conctarDB();
		$SQL_QUERY    = $SQL_QUERY_GEN_AUX;
		$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
		$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
		$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
		
		if($NUM_LINES_DB > 0) {
			while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
				$GEN_PA0_ID = $DADOS_ROW[0];
			}
		}
		
		$GEN_WEB_MASTER = (intVal($GEN_PA0_ID) == intVal($USE_STATUS["WEB_MASTER"]));
		
		FW_desconctarDB($CONECTAR_DB);	
	
	}
	
//	$FW_DADOS_OK     = false;
//	$GEN_ID          = 0;
//	$GEN_NOME        = "Deyvid Rannyere Moraes Costa";
//	$GEN_USER_STATUS = 2;
//	$GEN_DOC_WIDTH   = 1366; 
//	$GEN_DOC_HEIGHT  = 673;
//	$FW_DADOS_OK     = 1; 
//	$GEN_WEB_MASTER  = true;
	
//	echo "
//	<div style='font-family: Courier New, Courier, monospace'>
//					GEN_ID...........: $GEN_ID
//		<br />GEN_NOME.........: $GEN_NOME
//		<br />GEN_USER_STATUS..: $GEN_USER_STATUS
//		<br />GEN_DOC_WIDTH....: $GEN_DOC_WIDTH
//		<br />GEN_DOC_HEIGHT...: $GEN_DOC_HEIGHT
//		<br />FW_DADOS_OK......: $FW_DADOS_OK
//		<br />GEN_WEB_MASTER...: $GEN_WEB_MASTER
//	</div>";

	$GEN_PARAMETROS = 
	"GEN_ID=$GEN_ID&"                   . 
  "GEN_NOME=$GEN_NOME&"               .
	"GEN_USER_STATUS=$GEN_USER_STATUS&" .
  "GEN_DOC_WIDTH=$GEN_DOC_WIDTH&"     .
	"GEN_DOC_HEIGHT=$GEN_DOC_HEIGHT";
//	echo $GEN_PARAMETROS;

	//====================================================================================================================

	$lista_navegadores = array("MSIE", "Firefox", "Chrome", "Safari");
	$navegador_usado = $_SERVER['HTTP_USER_AGENT'];
	$GEN_FATOR     = 86;
	$GEN_NAVEGADOR = "";
	
	foreach($lista_navegadores as $valor_verificar) 	{
		if(strrpos($navegador_usado, $valor_verificar)) {
			$navegador = $valor_verificar;
		}
	}
	
	$GEN_NAVEGADOR = strtoupper(trim($navegador));
	//echo "O navegador usado é " . $GEN_NAVEGADOR;?>