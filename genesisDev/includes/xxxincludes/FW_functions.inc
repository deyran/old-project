<?php
	function FW_createAutoComplete($pNomeAC, $pIdAC, $pValue, $pValTxt, $pWidth, $pPath, $pCase) {
	?><div style="position: relative; <?php echo $pWidth;?>">
			<input type="text" onkeyup="FW_autoComplete('<?php echo $pNomeAC;?>', event)" 
			autocomplete="off"
			style="<?php echo $pWidth;?>" id="<?php echo $pNomeAC;?>" name="<?php echo $pNomeAC;?>" 
			value="<?php echo $pValTxt;?>" />
			
			<table border="0" cellspacing="0" cellpadding="0" 
			style="background-color:#CCC; position: absolute; margin-top: 3px; ">
			<tr><td>
				<div id="div_<?php echo $pNomeAC;?>" 
				style="background-color:#FFF; display: none; <?php echo $pWidth;?>"></div>
			</td></tr>
			</table>
			
			<input type="hidden" id="hdd_path_<?php echo $pNomeAC;?>" 
			name="hdd_path_<?php echo $pNomeAC;?>" value="<?php echo $pPath;?>" />
			
			<input type="hidden" id="hdd_id_<?php echo $pNomeAC;?>" 
			name="hdd_id_<?php echo $pNomeAC;?>" value="<?php echo $pIdAC;?>" />
	
			<input type="hidden" id="<?php echo $pIdAC;?>" 
			name="<?php echo $pIdAC;?>" value="<?php echo $pValue;?>" />
			
			<input type="hidden" id="hdd_case_<?php echo $pNomeAC;?>" 
			name="hdd_case_<?php echo $pNomeAC;?>" value="<?php echo $pCase;?>" />
		</div><?php
		}
	
	function FW_mensagemRetorno($pIdContent, $pIdDivMsg, $pTxtMsg) {?>
		<div id="<?php echo $pIdContent;?>" class="ui-widget" style="display: none">
			<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
				<p>
					<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
					<div id="<?php echo $pIdDivMsg;?>" style="font-size: 22px; color: #F00" align="center"><?php 
					echo $pTxtMsg;?></div>
				</p>
			</div>
		</div><?php 
		}
	
	function FW_printTitle($pTitle) {?>
		 <div style="color: #999"><?php echo $pTitle;?></div><?php
		}

	function FW_trataCaractere($pTexto, $tipoDado) {
		if(strlen($pTexto) == 0) {
			$pTexto = "NULL";
			
		} elseif(strlen($pTexto) > 0) {
			/*echo "<br />FW_trataCaractere
						<br />pTexto....: $pTexto
						<br />tipoDado..: $tipoDado<br /><br />";*/
			
			switch($tipoDado) {
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
			}
		}
		
		return trim($pTexto);
	}
		
	function FW_sqlExec($pSqlCommands, $pConctar) {
		$FW_ERRO = "";
		//----------------------------------------------------------
		
		$result = $pConctar->query($pSqlCommands);
		
		if(!$result) {
			$FW_ERRO = "Erro ao salvar! Avisar equipe de suporte!";
			
			echo "<br />Insertion Error " . mysql_error() .
					 "<br /><br />$pSqlCommands<br /><br />";
		
		} else {
			echo "--> Sucessfully";
		
		}
		//----------------------------------------------------------		
		
		return $FW_ERRO;
	}
	
	//FW GRID
	function FW_makeGrid($checkSel, $pAcaoGrid, $pNomeGrid, $pCamposGrid, $pSqlQuery, $pHeight, $pPath) {
		$HIDDEN_ACOES = "";
		if($pSqlQuery == "") $HIDDEN_ACOES = "visibility: hidden";	
		
		$HDD_ORDEM  = "";
		$HDD_CAMPO  = "";
		$HDD_FILTRO = "close";
		$PATH_IMAGE = "http://" . $_SERVER["SERVER_NAME"] . "/s_r_comercio/images/";	
		
		if(($_SERVER["SERVER_NAME"] == "127.0.0.1") or ($_SERVER["SERVER_NAME"] == "localhost")) {
			$PATH_IMAGE = "http://" . $_SERVER["SERVER_NAME"] . ":70/exodoweb/images/";	
		}
	
		if(isset($_POST["HDD_" . $pNomeGrid . "_ORDEM"]))  $HDD_ORDEM  = $_POST["HDD_" . $pNomeGrid . "_ORDEM"];
		if(isset($_POST["HDD_" . $pNomeGrid . "_CAMPO"]))  $HDD_CAMPO  = $_POST["HDD_" . $pNomeGrid . "_CAMPO"];
		if(isset($_POST["HDD_" . $pNomeGrid . "_FILTRO"])) $HDD_FILTRO = $_POST["HDD_" . $pNomeGrid . "_FILTRO"];
		
		if($pSqlQuery == "") $HDD_FILTRO = "open";?>
		<input type="hidden" id="HDD_<?php echo $pNomeGrid;?>_ORDEM" 
		name="HDD_<?php echo $pNomeGrid . "_ORDEM";?>" value="<?php echo $HDD_ORDEM;?>" />
		
		<input type="hidden" id="HDD_<?php echo $pNomeGrid;?>_CAMPO" 
		name="HDD_<?php echo $pNomeGrid . "_CAMPO";?>" value="<?php echo $HDD_CAMPO;?>" />
		
		<input type="hidden" id="HDD_<?php echo $pNomeGrid;?>_PATH"  
		name="HDD_<?php echo $pNomeGrid . "_PATH";?>"  value="<?php echo $pPath;?>" />
		
		<input type="hidden" id="HDD_<?php echo $pNomeGrid;?>_FILTRO"  
		name="HDD_<?php echo $pNomeGrid . "_FILTRO";?>"  value="<?php echo $HDD_FILTRO;?>" />
		
		<div id="DIV_GRID_<?php echo $pNomeGrid;?>" style="padding: 10px; ">
			<table border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2"><!--ATIVAR FILTRO-->
				<div style="border-bottom: 1px solid #CCC;" align="right">
					<a href="javascript: void(0)" onclick="FW_gridAtivarFiltro('<?php echo $pNomeGrid;?>')" 
					title="Clique aqui para ativar filtro">
						<img id="IMG_FILTRO_<?php echo $pNomeGrid;?>" src="<?php 
						if($HDD_FILTRO == "close") {
							echo $PATH_IMAGE . "filtro.gif";
							
						} else {
							echo $PATH_IMAGE . "removefiltro.gif";
							
						}?>" />
					</a>
				</div>
			</td></tr>
			<tr><td valign="top" align="left">
				<table border="0" cellspacing="0" cellpadding="0">
				<tr><?php
					if($checkSel == true) {?>
						<td valign="baseline" align="left">
							<input type="checkbox" 
							id="checkSel_<?php echo $pNomeGrid;?>" style="<?php echo $HIDDEN_ACOES;?>"
							class="checkIdGridClass_<?php echo $pNomeGrid;?>" checked="checked" 
              onclick="FW_gridCheck('<?php echo $pNomeGrid;?>'); this.checked=true;" />
								
							<input type="hidden" class="checkSelVal_<?php echo $pNomeGrid;?>" value="false" />
						
					</td><?php
					}
					//AÇÕES TÍTULOS__[
					if($pAcaoGrid != "") {
						$gridAcao = explode("|", $pAcaoGrid);
						
						for($i = 0; $i < count($gridAcao); $i++) {
							$funcImg = explode("-", $gridAcao[$i]);
							$funcImg[0] = str_replace("[ID]", "", $funcImg[0]);?>
							
							<th nowrap="nowrap" valign="baseline"  align="center" style="position: relative">
								<a href="javascript: void(0)" <?php if($funcImg[2] <> "") {echo "title='$funcImg[2]'";}?>
								onclick="<?php echo $funcImg[0];?>" style="text-decoration: none; padding-left: 7px; <?php echo $HIDDEN_ACOES;?>">
									<img src="<?php echo $PATH_IMAGE . $funcImg[1];?>" width="16" height="16" />
								</a><?php
								
								if($i == 0) {?>
									<div id="DIV_AGUARDE_<?php echo $pNomeGrid;?>"
									style="position: absolute; top: 2%; left: 100%; display: none">
										<img src="<?php echo $PATH_IMAGE . "wait16.gif";?>" />
									</div><?php
								}?>
								
							</th><?php
						}
					}
					//]
					//TÍTULOS________[
						$WHERE_AUX = "";
						
						$primairoFiltro = "PRI_GRID_FILTRO";
						$camposGrid = explode("|", $pCamposGrid);
						for($i = 0; $i < count($camposGrid); $i++) {
							if($i > 0) $primairoFiltro = "";
							
							$descSize = explode("-", $camposGrid[$i]);	?>
              <!--
                onmouseover="$('#<?php echo $ID_DISABLE_FILTRO;?>').show();"
             		onmouseout="$('#<?php echo $ID_DISABLE_FILTRO;?>').hide();"-->
							<th nowrap="nowrap" style="width: <?php echo $descSize[1] . "px";?>"><?php
								$ID_DISABLE_FILTRO = "FILTRO_DISABLE_" . $i;?>
								<div style="cursor: pointer;"> 
									<table border="0" cellspacing="0" cellpadding="0" align="center">
									<tr><td>
                  	<div id="<?php echo $ID_DISABLE_FILTRO;?>" style="positionZ:absoluteZ; display: NONE;">
                      <a href="javascript: void(0)" onclick="FW_gridAtivarFiltro('<?php echo $pNomeGrid;?>')" 
                      title="Clique aqui para remover o filtro">
                        <img id="IMG_<?php echo $ID_DISABLE_FILTRO;?>" 
                        src="<?php echo $PATH_IMAGE . "removefiltro.gif";?>" />
                      </a>                    
                    </div>
                    
                  </td><td>
										<div onclick="FW_gridOrdem('<?php echo $pNomeGrid;?>', '<?php echo $descSize[2]?>')"><?php 
											echo $descSize[0];?>
                    </div>
										
									</td><td valign="middle">
										<div style="padding-left: 5px; <?php 
											if($descSize[2] != $HDD_CAMPO) { echo 'display: none';}?>"
												id="DIV_<?php echo $descSize[2] . "_CAMPO";?>" 
										 class="DIV_<?php echo $pNomeGrid   . "_CAMPO_CLASS";?>"><?php
											$IMG_AUX = $PATH_IMAGE . "downC.gif";
											if($HDD_ORDEM == "ASC") $IMG_AUX = $PATH_IMAGE . "upC.gif";?>
											<img id="IMG_<?php echo $descSize[2] . "_CAMPO";?>" src="<?php echo $IMG_AUX;?>" />		
										</div>
									</td></tr>
									</table>
								</div>
								<div class="DIV_<?php echo $pNomeGrid . "_FILTRO_CLASS";?>" 
								style="padding: 3px; <?php
									if($HDD_FILTRO == 'close'){
										echo 'display: none;';
									}?>">
                  
									<input type="text" class="TEXT_<?php echo $pNomeGrid . "_FILTRO_CLASS ". $primairoFiltro;?> " 
                  onfocus="$('.buttonClass').button({disabled: true});"
                  autocomplete="off" onkeyup="FW_gridFiltrar(event, '<?php echo $pNomeGrid;?>')"
										id="<?php echo $descSize[2];?>" 
									name="<?php echo $descSize[2];?>" style="width: 90%" <?php
									
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
					
			</td><td style="width: 15px">
				<!--ESPAÇO DO SCROLL-->
				&nbsp;
			</td></tr><?php
			
			if($pSqlQuery != "") {
				$heightAux = "";
				if($pHeight != "") $heightAux = "height:" . $pHeight . "px;";?>
				<tr><td valign="top" colspan="2" align="left">
				<div style="<?php echo $heightAux;?> overflow-x:hidden; overflow-y: auto;">
					<table border="0" cellspacing="0" cellpadding="0"><?php 
						$HDD_ORDEM = "";
						$HDD_CAMPO = "";
						$ORDER_AUX = "";
					
						if(isset($_POST["HDD_" .$pNomeGrid . "_ORDEM"])) $HDD_ORDEM = $_POST["HDD_" .$pNomeGrid . "_ORDEM"];
						if(isset($_POST["HDD_" .$pNomeGrid . "_CAMPO"])) $HDD_CAMPO = $_POST["HDD_" .$pNomeGrid . "_CAMPO"];
						
						if($HDD_CAMPO != "") $ORDER_AUX = "ORDER BY X." . $HDD_CAMPO . " " . $HDD_ORDEM;
						if($WHERE_AUX != "") $WHERE_AUX = " WHERE " . $WHERE_AUX;
						
						$FW_conexao = conctarDB();
						
						$pSqlQuery = "SELECT X.* FROM ($pSqlQuery) AS X " .	$WHERE_AUX . $ORDER_AUX;
						//echo $pSqlQuery;
						
						$result = mysqli_query($FW_conexao, $pSqlQuery);
						$result = $FW_conexao->query($pSqlQuery);
						$num_lines = mysqli_affected_rows($FW_conexao);
						$efeitoZebra = "par";
						
						if($num_lines > 0) {
							while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
								if($efeitoZebra == "par") {
									$efeitoZebra = "impar";
									
								} elseif($efeitoZebra == "impar") {
									$efeitoZebra = "par";
									
								}
								
								$ID_ROW_GRID = $row[0];?>
								
								<tbody id="TBODY_<?php echo $pNomeGrid;?>_<?php echo $ID_ROW_GRID;?>">
									<tr class="<?php echo $efeitoZebra;?>" 
									onmousemove="this.className = 'trSelecionado'" 
									onmouseout="this.className = '<?php echo $efeitoZebra;?>'"><?php
									if($checkSel == true) {?>
										<td valign="baseline" align="left">
											<input type="checkbox" id="checkSel_<?php echo $pNomeGrid . "_" . $row[0];?>" 
											name="checkIdGrid_<?php echo $pNomeGrid;?>[]" value="<?php echo $row[0];?>"
											class="checkIdGridClass_<?php echo $pNomeGrid;?>" />
										</td><?php
									}
									//AÇÕES DADOS__[
									if($pAcaoGrid != "") {
										$gridAcao = explode("|", $pAcaoGrid);
										
										for($i = 0; $i < count($gridAcao); $i++) {
											$funcImg    = explode("-", $gridAcao[$i]);
											$funcImg[0] = str_replace("[ID]", $row[0], $funcImg[0]);?>
											
											<td nowrap="nowrap" valign="baseline" style="width: 25px;"  align="center">
												<a href="javascript: void(0)" <?php if($funcImg[2] <> "") {echo "title='$funcImg[2]'";}?>
												onclick="<?php echo $funcImg[0];?>" style="text-decoration: none;  padding-left: 5px;">
													<img src="<?php echo $PATH_IMAGE . $funcImg[1];?>" width="17" />
												</a>
											</td><?php
										}
									}
									//]
									//DADOS________[
									$firstVal = true;
									$fieldIndex = 0;
									$camposGrid = explode("|", $pCamposGrid); 
									for($i = 1; $i < count($row); $i++) {
										$descSize = explode("-", $camposGrid[$fieldIndex]);?>
										<td style="position: relative; width: <?php echo $descSize[1] . "px";?>" 
										title="<?php echo $row[$i];?>" >
											<div id="DIV_<?php echo $descSize[2];?>_<?php echo $ID_ROW_GRID;?>" align="<?php echo $descSize[3];?>" 
											style="white-space: nowrap; color: #000; cursor: pointer;
														 border-left: 1px solid #AAAAAA; overflow:hidden; height: 16px; 
														 width: <?php echo ($descSize[1] - 2) . "px";?>"
											onclick="FW_gridAplicarFiltro('<?php echo $pNomeGrid;?>', '<?php echo $row[$i];?>', '<?php echo $descSize[2];?>')">
											<?php
											echo "&nbsp;" . $row[$i] . "&nbsp;";?></div><?php
											
											if($i == 1) {?>
												<div id="DIV_AGUARDE_<?php echo $pNomeGrid;?>_<?php echo $row[0];?>"
												style="position: absolute; top: 2%; display: none" align="center">
													<img src="<?php echo $PATH_IMAGE . "wait16.gif";?>" />
												</div><?php
											}?>
										</td><?php
										$fieldIndex++;
									}					
									//]?>
									</tr>
								</tbody>
							 <?php
								
							}
						}
						
						if($result != NULL) $result->close();
						desconctarDB($FW_conexao);?>
					</table>
		
				</div>
				</td></tr><?php
			}?>
			
			</table>
		</div><?php
	}
?>