<?php
	function numberfix($number) {
		$number = number_format($number,0,","," ");
		return str_replace(" ", "&nbsp;", $number);
		
	}
	function gridReload()       {		
		$E01_ID_F = $_POST["E01_ID_F"];
		if($E01_ID_F != "") $E01_ID_F = implode(",", $_POST["E01_ID_F"]);
		
		echo "E01_ID_F........: $E01_ID_F <BR />"?>
		
		<div id="DIV_CONTEUDO_GRID_TBL">
			<table border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top: 5px">
			<tr><td valign="top">
				<div style="padding-bottom: 5px; padding-top: 3px; margin-bottom: 5px">
					<input type="button" id="bttFiltrarGrid" class="bttGridClass" style="margin: 0; font-size: 14px; width: 150px" 
          value="Habilitar filtro" onclick="habilitaFiltroGrid()" />&nbsp;&nbsp;<input type="button" id="bttNovoGrid" 
          class="bttGridClass" style="margin: 0; font-size: 14px; width: 150px" 
          value="Novo modelo" onclick="editarEstoque('')" />
				</div>
			</td></tr>
			<tr><td valign="top"><?php
				$sqlQuery = "
				SELECT O.E01_ID        AS E01_GRID_ESTOQUE_ID,
				       O.E01_MODELO    AS E01_GRID_ESTOQUE_MODELO,
				       O.E01_TAMANHO   AS E01_GRID_ESTOQUE_TAMANHO,
							 O.E01_TIPO      AS E01_GRID_ESTOQUE_TIPO,
							 G.EA0_DESCRICAO AS E01_GRID_ESTOQUE_GENERO,
							 O.E01_QTD       AS E01_GRID_ESTOQUE_QTD
							 
				FROM E01_OCULOS AS O LEFT JOIN EA0_GENERO AS G ON O.EA0_ID = G.EA0_ID";
				
				if($E01_ID_F != "") $sqlQuery = "$sqlQuery WHERE O.E01_ID IN ($E01_ID_F)";
				
				$camposGrid = "
				<strong>Modelo</strong>-200-E01_GRID_ESTOQUE_MODELO-left|
				<strong>Tamanho</strong>-100-E01_GRID_ESTOQUE_TAMANHO-right|
				<strong>Tipo arma&ccedil;&atilde;o</strong>-150-E01_GRID_ESTOQUE_TIPO-left|
				<strong>G&ecirc;nero</strong>-200-E01_GRID_ESTOQUE_GENERO-left|
				<strong>Qtd</strong>-80-E01_GRID_ESTOQUE_QTD-right";
										 
				$acaoGrid = "editarEstoque('[FW_ID_VALUE]')-../../imagens/nodes/edit.gif-Clique para editar registro|". 
										"excluiItemEstoque('[FW_ID_VALUE]')-../../imagens/icons/excluir.gif-Clique para excluir registro|". 
										"visualizarRelatorio('[FW_ID_VALUE]')-../../imagens/nodes/print.gif-Clique para visualizar relatório|";	
				
				$PATH_GRID = "formGrid|indexFiltroHidden.php";
				
				FW_makeGrid(true, $acaoGrid, "E01_GRID_ESTOQUE", $camposGrid, $sqlQuery, ($GEN_DOC_HEIGHT - 170), $PATH_GRID);	?>
			</td></tr>
			</table>
		</div><?php
	}

	function relatorioOculos()  				             {?>
		<h3 align="center" class="semMargPadd">
			R&nbsp;E&nbsp;L&nbsp;A&nbsp;T&nbsp;&Oacute;&nbsp;R&nbsp;I&nbsp;O
			&nbsp;&nbsp;&nbsp;D&nbsp;E&nbsp;&nbsp;&nbsp;
			E&nbsp;S&nbsp;T&nbsp;O&nbsp;Q&nbsp;U&nbsp;E
		</h3>
		<div align="center">
    	<div style="width: 210mm; font-family:'Courier New', Courier, monospace">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <thead>
        <tr><th colspan="6">
          <div style="border-bottom: 1px solid; margin-bottom: 5px;">&nbsp;</div>
        </th></tr>
        <tr><th style="font-size: 14px">
          Modelo
        </th><th style="font-size: 14px">
          Tamanho
        </th><th style="font-size: 14px">
          G&ecirc;nero
        </th><th style="font-size: 14px">
          Qtd
        </th></tr>
        <tr><th colspan="6">
          <div style="border-top: 1px solid; margin-top: 5px"></div>
        </th></tr>
        </thead><?php 
				
				$CONECTAR_DB  = FW_conctarDB();
				$E01_ID_F_AUX = $_REQUEST["E01_ID_F_AUX"];
				$efeitoZebra  = "";
				$SQL_QUERY    = "
				SELECT O.E01_MODELO 	 AS E01_GRID_ESTOQUE_MODELO, 
							 O.E01_TAMANHO 	 AS E01_GRID_ESTOQUE_TAMANHO, 
							 T.EA1_DESCRICAO AS E01_GRID_ESTOQUE_TIPO, 
							 G.EA0_DESCRICAO AS E01_GRID_ESTOQUE_GENERO, 
							 O.E01_QTD       AS E01_GRID_ESTOQUE_QTD, 
							 S.E01_QTD_SUM   AS E01_GRID_ESTOQUE_QTD_SUM
							 
				FROM E01_OCULOS O 
						 INNER JOIN EA1_TIPO_ARMACAO AS T ON O.EA1_ID = T.EA1_ID 
						 INNER JOIN EA0_GENERO AS G ON O.EA0_ID = G.EA0_ID 
						 LEFT JOIN ( 
									SELECT O.EA1_ID, SUM(O.E01_QTD) AS E01_QTD_SUM
									FROM E01_OCULOS O 
									GROUP BY O.EA1_ID 
									
						 ) AS S ON S.EA1_ID = O.EA1_ID ";
				
				if($E01_ID_F_AUX != "") {
					$SQL_QUERY = " $SQL_QUERY WHERE O.E01_ID IN ($E01_ID_F_AUX) ";
				}
				
				$SQL_QUERY = " $SQL_QUERY 

				ORDER BY E01_GRID_ESTOQUE_TIPO, 
								 E01_GRID_ESTOQUE_GENERO ";
				
				//echo $SQL_QUERY;
								
				$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
				$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
				$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
				
				if($NUM_LINES_DB > 0) {
					$FIRST_TIME_AUX      = true;
					$ESTOQUE_TIPO_AUX    = "";
					$ESTOQUE_QTD_SUM_AUX = 0;
					
					
					$ESTOQUE_MODELO  = NULL;
					$ESTOQUE_TAMANHO = NULL;
					$ESTOQUE_TIPO    = NULL;
					$ESTOQUE_GENERO  = NULL;
					$ESTOQUE_QTD     = NULL;
					$ESTOQUE_QTD_SUM = NULL;
					
					
					$DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM);
					$ESTOQUE_TIPO_BEFORE    = $DADOS_ROW[2];
					$ESTOQUE_QTD_SUM_BEFORE = $DADOS_ROW[5];?>
              
          <tr><td colspan="5">
            <div style="color: #F90; font-size: 14px; margin: 4px; margin-right: 0px">
              <?php echo $ESTOQUE_TIPO_BEFORE;?>
            </div>
          </td></tr><?php
					
					while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
						$ESTOQUE_MODELO  = $DADOS_ROW[0];
						$ESTOQUE_TAMANHO = $DADOS_ROW[1];
						$ESTOQUE_TIPO    = $DADOS_ROW[2];
						$ESTOQUE_GENERO  = $DADOS_ROW[3];
						$ESTOQUE_QTD     = $DADOS_ROW[4];
						$ESTOQUE_QTD_SUM = $DADOS_ROW[5];
						
						if($ESTOQUE_TIPO_BEFORE != $ESTOQUE_TIPO) {
							$efeitoZebra = "";
							$ESTOQUE_QTD_SUM_AUX = $ESTOQUE_QTD_SUM;?>
              
              <tr><td colspan="5">
              	<div style="border-top: 1px solid #CCC;">
                  <div align="right" style="color: #F90; font-size: 14px; margin: 4px; margin-right: 0px"><?php 
                    echo Total . ":&nbsp;&nbsp;&nbsp;" . FW_numeroEspacoMilhar($ESTOQUE_QTD_SUM_BEFORE);
                    $ESTOQUE_QTD_SUM_BEFORE = $ESTOQUE_QTD_SUM;?>&nbsp;&nbsp;
                  </div>
                </div>
              </td></tr>
              
              <tr><td colspan="5">
                <div style="color: #F90; font-size: 14px; margin: 4px; margin-right: 0px">
                  <?php echo $ESTOQUE_TIPO;?>
                </div>
              </td></tr><?php
							
						}
						$ESTOQUE_TIPO_BEFORE = $ESTOQUE_TIPO;
						//--------------------------------------------------------------------------------------------------------
						
						if($efeitoZebra == "tdGridAuto") {
							$efeitoZebra = "";
							
						} elseif($efeitoZebra == "") {
							$efeitoZebra = "tdGridAuto";
							
						}						
						//--------------------------------------------------------------------------------------------------------?>
            
            <tr class="<?php echo $efeitoZebra;?>">
              <td valign="top">
                <div style="padding-left: 20px; border-right: 1px solid #CCC; font-size:14px">
                  <?php echo $ESTOQUE_MODELO;?>&nbsp;
                </div>
              </td>
              <td valign="top">
                <div align="right" style="border-right: 1px solid #CCC; font-size:14px">
                  <?php echo str_replace(".", ",", $ESTOQUE_TAMANHO);?>&nbsp;&nbsp;
                </div>
              </td>
              <td valign="top">
                <div style="border-right: 1px solid #CCC; font-size:14px">
                  <?php echo "&nbsp;&nbsp;" . $ESTOQUE_GENERO;?>
                </div>
              </td>
              <td valign="top">
                <div align="right" style="border-right: 1px solid #CCC; font-size:14px">
                  <?php echo FW_numeroEspacoMilhar($ESTOQUE_QTD);?>&nbsp;&nbsp;
                </div>
              </td>
            </tr><?php
						
					}?>
          
          <tr><td colspan="5">
          	<div style="border-top: 1px solid #CCC">
              <div align="right" style="color: #F90; font-size: 14px; margin: 4px; margin-right: 0px">
                <?php echo Total . ":&nbsp;" . FW_numeroEspacoMilhar($ESTOQUE_QTD_SUM_BEFORE);
                $ESTOQUE_QTD_SUM_BEFORE = $ESTOQUE_QTD_SUM;
                ?>&nbsp;&nbsp;
              </div>
            </div>
					</td></tr><?php

				}
				
				FW_desconctarDB($CONECTAR_DB);?>
        </table>
        <br /><br />
			</div>
    </div><?php
   }
	 
	function estoqueGrid($P_LEFT_WIDTH)              {
		global $GEN_DOC_WIDTH, $GEN_DOC_HEIGHT, $GEN_NAVEGADOR;
		
		$E01_ID_F = "";
		$EAO_ID_F = "";
		$DIV_CONTEUDO_HEIGHT = 300;
		
		if(isset($_POST["E01_ID_F"])) $E01_ID_F = implode(",", $_POST["E01_ID_F"]);
		if(isset($_POST["EAO_ID_F"])) $EAO_ID_F = implode(",", $_POST["EAO_ID_F"]);
		if(isset($_POST["DIV_CONTEUDO_HEIGHT"])) $DIV_CONTEUDO_HEIGHT = $_POST["DIV_CONTEUDO_HEIGHT"]
		//--------------------------------------------------------------------------------------------?>
		
		<div align="center"><?php
			$WHERE_AUX = "";
			
			$SQL_QUERY = "
			SELECT O.E01_ID         AS EST_GRID_ID,
						 O.E01_MODELO     AS EST_GRID_MODELO,
						 E1.EA1_DESCRICAO AS EST_GRID_ARMACAO,
						 O.E01_TAMANHO    AS EST_GRID_TAMANHO,
						 E0.EA0_DESCRICAO AS EST_GRID_GENERO,
						 E01_QTD          AS EST_GRID_QTD
			
			FROM E01_OCULOS AS O LEFT JOIN EA0_GENERO       AS E0 ON O.EA0_ID = E0.EA0_ID
													 LEFT JOIN EA1_TIPO_ARMACAO AS E1 ON O.EA1_ID = E1.EA1_ID ";
													 
			if(strlen(trim($E01_ID_F)) > 0) $WHERE_AUX  = " WHERE O.EA1_ID IN ($E01_ID_F) ";

			if(strlen(trim($EAO_ID_F)) > 0) {
				if(strlen(trim($WHERE_AUX)) > 0) {
					$WHERE_AUX  = " $WHERE_AUX AND O.EA0_ID IN ($EAO_ID_F) ";
					
				} else {
					$WHERE_AUX  = " WHERE O.EA0_ID IN ($EAO_ID_F) ";
					
				}
			}
		
			$SQL_QUERY = "$SQL_QUERY $WHERE_AUX ";
			//--------------------------------------------------------------------------------------------

			$FATOR_WIDTH = 20;
			
			if($GEN_NAVEGADOR == "FIREFOX") {
				$FATOR_WIDTH = 20;
				
			} elseif($GEN_NAVEGADOR == "SAFARI") {
				$FATOR_WIDTH = 20;
				
			} else {
				$FATOR_WIDTH = 20.5;
				
			}
			
			$GRID_WIDTH  = $GEN_DOC_WIDTH - ($P_LEFT_WIDTH + 120);
			
			$EST_GRID_MODELO_WIDTH  = (($GRID_WIDTH * ($FATOR_WIDTH - 2)) / 100);
			$EST_GRID_ARMACAO_WIDTH = (($GRID_WIDTH * $FATOR_WIDTH) / 100);
			$EST_GRID_TAMANHO_WIDTH = (($GRID_WIDTH * ($FATOR_WIDTH - 2)) / 100);
			$EST_GRID_GENERO_WIDTH  = (($GRID_WIDTH * $FATOR_WIDTH) / 100);
			$EST_GRID_QTD_WIDTH     = (($GRID_WIDTH * ($FATOR_WIDTH + 4)) / 100);
			//--------------------------------------------------------------------------------------------
			
			$camposGrid = "
			<strong>Modelo</strong>-$EST_GRID_MODELO_WIDTH-EST_GRID_MODELO-left|
			<strong>Arma&ccedil;&atilde;o</strong>-$EST_GRID_ARMACAO_WIDTH-EST_GRID_ARMACAO-left|
			<strong>Tamanho</strong>-$EST_GRID_TAMANHO_WIDTH-EST_GRID_TAMANHO-right|
			<strong>G&ecirc;nero</strong>-$EST_GRID_GENERO_WIDTH-EST_GRID_GENERO-left|
			<strong>Quantidade</strong>-$EST_GRID_QTD_WIDTH-EST_GRID_QTD-right";
			//--------------------------------------------------------------------------------------------
			
			$acaoGrid = "
			ativarFormModal('[FW_ID_VALUE]')-../../imagens/nodes/edit.gif-Clique para editar registro|";	
			//--------------------------------------------------------------------------------------------
			
			$GRID_HEIGHT = (($DIV_CONTEUDO_HEIGHT * 80) / 100);
			
			if($GEN_NAVEGADOR == "FIREFOX") {
				$GRID_HEIGHT = (($DIV_CONTEUDO_HEIGHT * 80) / 100);

				if($GRID_HEIGHT < 309) $GRID_HEIGHT = 290;

			} elseif($GEN_NAVEGADOR == "SAFARI") {
				$GRID_HEIGHT = (($DIV_CONTEUDO_HEIGHT * 83) / 100);
				
				if($GRID_HEIGHT < 312) $GRID_HEIGHT = 285;
			}
			
			$GRID_PARAM["GRID_CHECKBOX"]    = false;
			$GRID_PARAM["GRID_ID"]          = "EST_GRID";
			$GRID_PARAM["GRID_FUNCTIONS"]   = $acaoGrid;
			$GRID_PARAM["GRID_CAMPOS"]      = $camposGrid;
			$GRID_PARAM["GRID_HEIGHT"]      = $GRID_HEIGHT;
			$GRID_PARAM["GRID_FORM_ID"]     = "formGrid";
			$GRID_PARAM["GRID_PAGE_HIDDEN"] = "indexHidden.php";
			$GRID_PARAM["GRID_NUM_LINES"]   = "";
			$GRID_PARAM["GRID_PRINT_QUERY"] = "PRINT";
			//--------------------------------------------------------------------------------------------
			
			FW_makeGrid($SQL_QUERY, $GRID_PARAM);?>
			
		</div><?php
	}
	function filtroTipoModelo()                      {
		global $GEN_DOC_HEIGHT, $GEN_DOC_WIDTH, $GEN_NAVEGADOR;

		$DIV_WIDTH  = (((int) $GEN_DOC_WIDTH  * 21) / 100);
		$DIV_HEIGHT = (((int) $GEN_DOC_HEIGHT * 35) / 100);
				
		$DIV_WIDTH_TD = $DIV_WIDTH - 20;

		if($GEN_NAVEGADOR == "FIREFOX") {
			if($DIV_WIDTH < 170) {
				$DIV_WIDTH    = 205;
				$DIV_WIDTH_TD = 175;
			}
			
		} elseif($GEN_NAVEGADOR == "SAFARI") {
			if($DIV_WIDTH < 170) {
				$DIV_WIDTH    = 200;
				$DIV_WIDTH_TD = 170;
			}

		} else {
			if($DIV_WIDTH < 200) {
				$DIV_WIDTH    = 200;
				$DIV_WIDTH_TD = 178;
			}
		}
	
		if(isset($_POST["E01_ID_F"])) $E01_ID_F_AUX = implode(",", $_POST["E01_ID_F"]);?>
		
    <div style="padding: 4px">
      <table border="0" cellspacing="0" cellpadding="0" align="center">
        <tr>
          <td width="20px">
            <input type="checkbox" checked onclick="setFiltroCheck('checkIdFiltroClass'); this.checked=true;" />
          </td>
          <td align="left">
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="bottom">Tipo arma&ccedil;&atilde;o</th>
                <td style="padding-left: 10px">
                  <img src = "../../imagens/nodes/lupa.gif" 
                     style = "cursor: pointer" 
                     title = "Clique aqui para selecionar"
                   onclick = "selectGridEstoque();" />
                       
                </td><td style="padding-left: 10px">
                  <img id = "imgPrintRelat" 
                      src = "../../imagens/nodes/edit.gif" 
                    style = "cursor: pointer;" 
                    title = "Clique aqui para editar dados"
                  onclick = "formModalTblAux('SWITCH_FORM_ARMACAO');" />
                       
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr><td colspan="2" valign="top">
          <div id="DIV_CONTEUDO_MODELO_FILTRO" 
          style="    height: <?php echo $DIV_HEIGHT;?>px; 
                 overflow-y: auto; 
                 overflow-x: hidden;">
            <table border="0" cellspacing="0" cellpadding="0"><?php
              $CONECTAR_DB  = FW_conctarDB();
              
              $SQL_QUERY = "";
              if($E01_ID_F_AUX == "")     {
                $SQL_QUERY    = "
                SELECT E.EA1_ID, E.EA1_DESCRICAO, -1 AS E01_ID_A
                FROM EA1_TIPO_ARMACAO AS E
                ORDER BY E.EA1_DESCRICAO";
                
              } 
							elseif($E01_ID_F_AUX != "") {
                $SQL_QUERY    = "
                SELECT E.EA1_ID, E.EA1_DESCRICAO,  E01.E01_ID_A
                FROM EA1_TIPO_ARMACAO AS E LEFT JOIN (
                  SELECT E.EA1_ID AS E01_ID_A
                  FROM E01_OCULOS E
                  GROUP BY E.EA1_ID
                  HAVING E01_ID_A IN($E01_ID_F_AUX) 
                
                ) AS E01 ON E.EA1_ID = E01.E01_ID_A
                ORDER BY E.EA1_DESCRICAO";
                
              }
              
              $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
              $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
              $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
              
              if($NUM_LINES_DB > 0) {
                $efeitoZebra = "";
                while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){?>
                  <tr<?php
										if($efeitoZebra == "tdGridAuto") {
											$efeitoZebra = "";
											
										} elseif($efeitoZebra == "") {
											$efeitoZebra = "tdGridAuto";
											
										}?>
                    
                    class="<?php echo $efeitoZebra;?>">
                    <td width="20px" valign="top">
                      <input type="checkbox" <?php 
                      if($DADOS_ROW[0] == $DADOS_ROW[2]) {
                        echo " checked ";
                      }?>
                      
                      id="E01_ID_F_<?php echo $DADOS_ROW[0];?>" 
                      name="E01_ID_F[]" 
                      
                      style="cursor: pointer" 
                      class="checkIdFiltroClass"
                      value="<?php echo $DADOS_ROW[0];?>" />
                    </td>
                    <td valign="top" width="<?php echo ($DIV_WIDTH_TD);?>px" title="<?php echo $DADOS_ROW[1];?>">
                      <div style="white-space: nowrap; cursor: pointer;
                                     overflow: hidden; height: 19px;
                                        width: <?php echo ($DIV_WIDTH_TD - 3);?>px">
                        <label for="E01_ID_F_<?php echo $DADOS_ROW[0];?>" 
                        style="cursor: pointer">
                          <?php echo $DADOS_ROW[1];?>
                        </label>
                      </div>                    
                      
                    </td>
                  </tr> <?php
                }
              }
              
              FW_desconctarDB($CONECTAR_DB);?>
            </table>
          </div>
        </td></tr>
      </table>
    </div><?php
	}
	function filtroGenero()                          {
		global $GEN_DOC_HEIGHT, $GEN_DOC_WIDTH, $GEN_NAVEGADOR;

		$DIV_WIDTH    = (((int)$GEN_DOC_WIDTH  * 21) / 100);
		$DIV_HEIGHT   = (((int)$GEN_DOC_HEIGHT * 34) / 100);
		$DIV_WIDTH_TD = $DIV_WIDTH - 20;
		
		if($GEN_NAVEGADOR == "FIREFOX") {
			if($DIV_WIDTH < 170) {
				$DIV_WIDTH    = 200;
				$DIV_WIDTH_TD = 170;
				$FATOR        = 25;
				$DIV_HEIGHT   = (((int)$GEN_DOC_HEIGHT * 25) / 100);
				
			}
			
		} elseif($GEN_NAVEGADOR == "SAFARI") {
			if($DIV_WIDTH < 170) {
				$DIV_WIDTH    = 200;
				$DIV_WIDTH_TD = 170;
				$DIV_HEIGHT   = (((int)$GEN_DOC_HEIGHT * 25) / 100);
				
			}
		}  else {
			if($DIV_WIDTH < 200) {
				$DIV_WIDTH    = 200;
				$DIV_WIDTH_TD = 178;
			}
		}

		$EAO_ID_F_AUX = "";
		if(isset($_POST["EAO_ID_F"])) $EAO_ID_F_AUX = implode(",", $_POST["EAO_ID_F"]);?>
		
    <div style="padding: 4px;">
      <table border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top" width="20px">
            <input type="checkbox" checked onclick="setFiltroCheck('checkGeneroClass'); this.checked=true;" />
          </td>
          <td valign="top">
            <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th valign="bottom">G&ecirc;nero</th>
                <td style="padding-left: 10px" valign="top">
                  <img src = "../../imagens/nodes/lupa.gif" 
                     style = "cursor: pointer" 
                     title = "Clique aqui para selecionar"
                   onclick = "selectGridEstoque();" />
                       
                </td><td style="padding-left: 10px" valign="top">
                  <img id = "imgPrintRelat" 
                      src = "../../imagens/nodes/edit.gif" 
                    style = "cursor: pointer;" 
                    title = "Clique aqui para editar dados"
                  onclick = "formModalTblAux('SWITCH_FORM_GENERO');" />
                       
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr><td colspan="2" valign="top">
          <div id="DIV_CONTEUDO_GENERO_MODELO_FILTRO" 
          style="height: <?php echo $DIV_HEIGHT;?>px; 
                 border: 0px solid red;
             overflow-y: auto; 
             overflow-x: hidden;">
            <table border="0" cellspacing="0" cellpadding="0"><?php
              $CONECTAR_DB  = FW_conctarDB();
              
              $SQL_QUERY = "";
							
							if(strlen(trim($EAO_ID_F_AUX)) == 0)    {
                $SQL_QUERY    = "
                SELECT E.EA0_ID, E.EA0_DESCRICAO, -1 AS EA0_ID_A
                FROM EA0_GENERO AS E
                ORDER BY E.EA0_DESCRICAO";
                
              } 
							elseif(strlen(trim($EAO_ID_F_AUX)) > 0) {
                $SQL_QUERY    = "
                SELECT E.EA0_ID, E.EA0_DESCRICAO,  EA0.EA0_ID_A
                FROM EA0_GENERO AS E LEFT JOIN (
                  SELECT E.EA0_ID AS EA0_ID_A
                  FROM E01_OCULOS E
                  GROUP BY E.EA0_ID
                  HAVING EA0_ID_A IN($EAO_ID_F_AUX) 
                
                ) AS EA0 ON E.EA0_ID = EA0.EA0_ID_A
                ORDER BY E.EA0_DESCRICAO";
                
              }

              $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
              $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
              $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
              
              if($NUM_LINES_DB > 0) {
                $efeitoZebra = "";
                while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){?>
                  <tr<?php
                    if($efeitoZebra == "tdGridAuto") {
                      $efeitoZebra = "";
                      
                    } elseif($efeitoZebra == "") {
                      $efeitoZebra = "tdGridAuto";
                      
                    }?>
                    
                    class="<?php echo $efeitoZebra;?>">
                    <td width="20px" valign="top">
                      <input<?php 
                      if($DADOS_ROW[0] == $DADOS_ROW[2]) {
                        echo " checked ";
                      }?>

											type = "checkbox" 
                        id = "EAO_ID_F_<?php echo $DADOS_ROW[0];?>" 
                      name = "EAO_ID_F[]" 
                     style = "cursor: pointer" 
                     class = "checkGeneroClass"
                     value = "<?php echo $DADOS_ROW[0];?>" />
                     
                    </td><td valign="top" 
                    width="<?php echo ($DIV_WIDTH_TD);?>px"
                    title="<?php echo $DADOS_ROW[1];?>">
                      <div style="white-space: nowrap; cursor: pointer;
                                     overflow: hidden; height: 19px;
                                        width: <?php echo ($DIV_WIDTH_TD - 3);?>px">
                        <label for="EAO_ID_F_<?php echo $DADOS_ROW[0];?>" 
                        style="cursor: pointer">
                          <?php echo $DADOS_ROW[1];?>
                        </label>
                      </div>
                    </td>
                  </tr> <?php
                }
              }
              
              FW_desconctarDB($CONECTAR_DB);?>
            </table>
          </div>
        </td></tr>
      </table>
    </div><?php
	}
	function historicoMovGrid($P_WIDTH, $P_HEIGHT)   {
		$FATOR_WIDTH         = 15;
		$MOV_ID_WIDTH        = (($P_WIDTH * $FATOR_WIDTH) / 100);
		$MOV_TIPO_WIDTH      = (($P_WIDTH * ($FATOR_WIDTH - 5)) / 100);
		$MOV_DATA_WIDTH      = (($P_WIDTH * ($FATOR_WIDTH + 1)) / 100);
		$MOV_DE_WIDTH        = (($P_WIDTH * ($FATOR_WIDTH - 5)) / 100);
		$MOV_PARA_WIDTH      = (($P_WIDTH * ($FATOR_WIDTH - 5)) / 100);
		$MOV_DIFERENCA_WIDTH = (($P_WIDTH * ($FATOR_WIDTH - 5)) / 100);
		$MOV_EMISSOR_WIDTH   = (($P_WIDTH * ($FATOR_WIDTH + 4)) / 100);
		$MOV_EMISSAO_WIDTH   = (($P_WIDTH * ($FATOR_WIDTH + 3)) / 100);
		
		if(isset($_POST["E01_ID"])) $E01_ID = $_POST["E01_ID"];
		
		$SQL_QUERY = "
		SELECT 
				E.E02_ID AS GRID_HIST_MOV_ID,
		
				CASE E.E02_TIPO_MOV
					 WHEN 0 THEN 'Entrada'
					 WHEN 1 THEN 'Saída'
					 WHEN 2 THEN 'Perda'
					 WHEN 3 THEN 'Quebra'
				END AS GRID_HIST_MOV_TIPO,
				
				DATE_FORMAT(E.E02_DATA, '%d/%m/%Y') AS GRID_HIST_MOV_DATA,
				
				E.E02_QTD_DE   AS GRID_HIST_MOV_DE,
				E.E02_QTD_PARA AS GRID_HIST_MOV_PARA,
				(E.E02_QTD_PARA - E.E02_QTD_DE) AS GRID_HIST_MOV_DIFERENCA,
				
				P.P01_DESCRICAO AS GRID_HIST_MOV_EMISSOR,
				DATE_FORMAT(E.E02_DATA_EMISSAO, '%d/%m/%Y') AS GRID_HIST_MOV_EMISSAO
				
		FROM E02_OCULOS_MOV AS E INNER JOIN P01_PESSOA AS P ON P.P01_ID = E.P01_ID 
		
		WHERE E.E01_ID = $E01_ID
		
		ORDER BY GRID_HIST_MOV_EMISSAO DESC";
		
		$camposGrid = "
		<span>Natur.</span>-$MOV_TIPO_WIDTH-GRID_HIST_MOV_TIPO-left|
		<span>Data</span>-$MOV_DATA_WIDTH-GRID_HIST_MOV_DATA-left|
		<span>De</span>-$MOV_DE_WIDTH-GRID_HIST_MOV_DE-right|
		<span>Para</span>-$MOV_PARA_WIDTH-GRID_HIST_MOV_PARA-right|
		<span>Dif.</span>-$MOV_DIFERENCA_WIDTH-GRID_HIST_MOV_DIFERENCA-right|
		<span>Emissor</span>-$MOV_EMISSOR_WIDTH-GRID_HIST_MOV_EMISSOR-left|
		<span>Emiss&atilde;o</span>-$MOV_EMISSAO_WIDTH-GRID_HIST_MOV_EMISSAO-left";
		
		$acaoGrid = "";	
		
		$GRID_PARAM["GRID_CHECKBOX"]    = false;
		$GRID_PARAM["GRID_ID"]          = "GRID_HIST_MOV";
		$GRID_PARAM["GRID_FUNCTIONS"]   = $acaoGrid;
		$GRID_PARAM["GRID_CAMPOS"]      = $camposGrid;
		$GRID_PARAM["GRID_HEIGHT"]      = ($P_HEIGHT - 90);
		$GRID_PARAM["GRID_FORM_ID"]     = "formGeral";
		$GRID_PARAM["GRID_PAGE_HIDDEN"] = "estoqueIndexHidden.php?GEN_ACAO_GERAL_GRID=HIST_MOV_GRID";
		$GRID_PARAM["GRID_NUM_LINES"]   = "30";
		$GRID_PARAM["GRID_PRINT_QUERY"] = "PRINT";
	
		FW_makeGrid($SQL_QUERY, $GRID_PARAM);	
	}
	function getFormMov($P_WIDTH, $P_HEIGHT, $P_QTD) {
		$fonteSizeAux      = " font-size: 16px; ";
		$fonteSizeTitleAux = " font-size: 16px; ";
		$DIV_COMP_WIDTH    = (((((int) $P_WIDTH * 40) / 100) / 4) - 5);?>
    
    <table border="0" cellspacing="0" cellpadding="5" align="center" style="margin-top: 0px; padding-top: 0px; width: 95%">
    <tr><td valign="top"><?php 
      FW_V2_componenteHtml(
        array(
          "FW_V2_IDCOMP"    => "E02_DATA",
          "FW_V2_TIPOCOM"   => "DATE",
          "FW_V2_VALUE"     => $E02_DATA,
          "FW_V2_DICA"      => "clique aqui",
					"FW_V2_CSSRELAT"  => "width: 110px; color: #3F5F8D; $fonteSizeAux",
          "FW_V2_CSS"       => "width: 90px; color: #3F5F8D; $fonteSizeAux",
          "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
          "FW_V2_TITULO"    => "Data mov."
        )	
      );?>
    </td><td valign="top"><?php 
      $FW_V2_OPTIONLIST = "
      <option value='0'>Entrada</option>
      <option value='1'>Saída</option>
      <option value='2'>Perda</option>
      <option value='3'>Quebra</option>";
      
      $FW_V2_OPTIONLIST = urlencode(trim($FW_V2_OPTIONLIST));				
      
      FW_V2_componenteHtml(
        array(
          "FW_V2_IDCOMP"     => "E02_TIPO_MOV",
          "FW_V2_TIPOCOM"    => "SELECT",
          "FW_V2_VALUE"      => 0,
          "FW_V2_DESCRICAO"  => "Entrada",
          "FW_V2_OPTIONLIST" => $FW_V2_OPTIONLIST,
          "FW_V2_CSS"        => "width: " . $DIV_COMP_WIDTH . "px; color: #3F5F8D; $fonteSizeAux",
          "FW_V2_CSSTITULO"  => $fonteSizeTitleAux,
          "FW_V2_TITULO"     => "Natureza"
        )	
      );?>
    </td><td valign="top"><?php 
      FW_V2_componenteHtml(
        array(
          "FW_V2_IDCOMP"    => "E01_QTD",
          "FW_V2_TIPOCOM"   => "INT",
          "FW_V2_VALUE"     => 0,
          "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
          "FW_V2_CSSRELAT"  => "width: 90px; color: #3F5F8D; $fonteSizeAux text-align: right",										
          "FW_V2_CSS"       => "width: " . $DIV_COMP_WIDTH . "px; $fonteSizeAux",
          "FW_V2_TITULO"    => "Quantidade"
        )	
      );?>
    </td><td valign="top" style=""><?php 
      FW_V2_componenteHtml(
        array(
          "FW_V2_IDCOMP"    => "E01_QTD_2",
          "FW_V2_TIPOCOM"   => "READ",
          "FW_V2_VALUE"     => FW_numeroEspacoMilhar($P_QTD),
          "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
          "FW_V2_CSS"       => "width: 130px;color: #000; $fonteSizeAux text-align: right",
          "FW_V2_TITULO"    => "Quantidade atual"
        )	
      );?>
    </td></tr>
    <tr><td valign="top" colspan="4">
      <div style="padding-top: 7px"><?php 
        $DIV_TAB_OBS_HEIGHT = (((int)$P_HEIGHT * 60) /100);
        FW_V2_componenteHtml(
          array(
            "FW_V2_IDCOMP"    => "E02_OBSERVACAO",
            "FW_V2_TIPOCOM"   => "TEXT_AREA",
            "FW_V2_VALUE"     => "",
            "FW_V2_DICA"      => "clique aqui",
            "FW_V2_CSS"       => "border: 1px solid #EFEFEF; height:" . 
                                 $DIV_TAB_OBS_HEIGHT . "px; width: 99%; color: #3F5F8D; $fonteSizeAux",
            "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
            "FW_V2_TITULO"    => "Observa&ccedil;&atilde;o"
          )	
        );?>
      </div>
    </td></tr>
    </table><?php
	}
	function relatorioOculosMov($P_ANO, $P_MES)      {?>
  	<br />
    <h3 align="center" class="semMargPadd">
      M&nbsp;O&nbsp;V&nbsp;I&nbsp;M&nbsp;E&nbsp;N&nbsp;T&nbsp;A&nbsp;&Ccedil;&nbsp;&Atilde;&nbsp;O
      &nbsp;&nbsp;&nbsp;D&nbsp;E&nbsp;&nbsp;&nbsp;
      E&nbsp;S&nbsp;T&nbsp;O&nbsp;Q&nbsp;U&nbsp;E
    </h3>
    <h3 align="center" class="semMargPadd">
      A&nbsp;N&nbsp;O&nbsp;&nbsp;&nbsp;<?php
      
      $ANO_ARR = str_split($P_ANO);
      
      for ($ANO_INDEX = 0; $ANO_INDEX <= count($ANO_ARR); $ANO_INDEX++) {
        echo $ANO_ARR[$ANO_INDEX] . "&nbsp;";
      }?>
                  
    </h3>
  <div align="center">
    <div style="width: 210mm; font-family:'Courier New', Courier, monospace"><?php
      $TIPO_ARR_ACC = array(-1      , 0        , 0      , 0      , 0);
      $TIPO_ARR     = array("&nbsp;", "Entrada", "Saída", "Perda", "Quebra");
      
      $MESES_ARR = array("NULL", 
                         "Janeiro", "Fevereiro", "Março"   , "Abril"  , "Maio"    , "Junho",
                         "Julho"  , "Agosto"   , "Setembro","Outubro" , "Novembro", "Dezembro");
      
			$SQL_AUX = "";
			if(strlen(trim($P_MES)) > 0) $SQL_AUX = " AND M.E02_DATA_MES IN ($P_MES) ";

			$SQL_QUERY_AUX = "
      SELECT
            E.E02_DATA_MES, 
            E.E01_TIPO,
      
            COUNT(IF(E.E02_TIPO_MOV = 0, 1, NULL)) AS '0',
            COUNT(IF(E.E02_TIPO_MOV = 1, 1, NULL)) AS '1',
            COUNT(IF(E.E02_TIPO_MOV = 2, 1, NULL)) AS '2',
            COUNT(IF(E.E02_TIPO_MOV = 3, 1, NULL)) AS '3'
          
      FROM (
				SELECT T.EA1_DESCRICAO AS E01_TIPO, 
				       M.E02_DATA_MES, 
							 M.E02_TIPO_MOV
							 
				FROM E02_OCULOS_MOV AS M INNER JOIN E01_OCULOS       AS O ON M.E01_ID = O.E01_ID
																 INNER JOIN EA1_TIPO_ARMACAO AS T ON T.EA1_ID = O.EA1_ID
																 
				WHERE M.E02_DATA_ANO IN ($P_ANO) $SQL_AUX					
      
      ) AS E
      
      GROUP BY E.E02_DATA_MES, E.E01_TIPO ";
      
      //echo $SQL_QUERY_AUX;
      
      $CONECTAR_DB  = FW_conctarDB();
      $SQL_QUERY    = $SQL_QUERY_AUX;
      $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
      $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
      $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);?>
      
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
      <thead>
      <tr><th colspan="6">
        <div style="border-bottom: 1px solid #EEE; margin-bottom: 5px;">&nbsp;</div>
      </th></tr><?php
			$STYLE_AUX = "color: #000; font-size: 14px";?>
      
      <tr><td align="center" style=" <?php echo $STYLE_AUX;?>">
        Tipo armação
        
      </td><td align="center" style=" <?php echo $STYLE_AUX;?>">
        Entrada
        
      </td><td align="center" style=" <?php echo $STYLE_AUX;?>">
        Saída 
        
      </td><td align="center" style=" <?php echo $STYLE_AUX;?>">
        Perda
        
      </td><td align="center" style=" <?php echo $STYLE_AUX;?>">
        Quebra
        
      </td></tr>
      <tr><th colspan="6">
        <div style="border-bottom: 1px solid #EEE; margin-top: 5px"></div>
      </th></tr>
      </thead>

      <tbody><?php 
      if($NUM_LINES_DB > 0) {
        $mesCurrentAux = NULL;
        while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
          if($mesCurrentAux != $DADOS_ROW[0]) {?>
            <tr><td colspan="6">
              <div style="font-size: 14px; color: #F90; margin: 5px; ">
                <?php echo $MESES_ARR[$DADOS_ROW[0]];?>
              </div>
            </td></tr><?php
          }
          $mesCurrentAux = $DADOS_ROW[0];?>
          
          <tr onmousemove="this.className = 'tdNoticia'" onmouseout="this.className = ''">
          <td style="padding-left: 20px">
          	<div style="border-bottom: 1px solid #EEE; font-size:14px">
            	<?php echo $DADOS_ROW[1];?>
            </div>
          </td><?php
					
					for($k = 2; $k < 6; $k++) {?>
            <td><div align="right" style="border-bottom: 1px solid #EEE; font-size: 14px">
              <?php echo str_replace(".", ",", $DADOS_ROW[$k]);?>&nbsp;&nbsp;
            </div></td><?php 
					}?>
          </tr><?php
          
          $TIPO_ARR_ACC[2] = $TIPO_ARR_ACC[2] + $DADOS_ROW[2];
          $TIPO_ARR_ACC[3] = $TIPO_ARR_ACC[3] + $DADOS_ROW[3];
          $TIPO_ARR_ACC[4] = $TIPO_ARR_ACC[4] + $DADOS_ROW[4];
          $TIPO_ARR_ACC[5] = $TIPO_ARR_ACC[5] + $DADOS_ROW[5];
          
        }
      }
      
      FW_desconctarDB($CONECTAR_DB);?>
      
      <tr><td colspan="6">&nbsp;</td></tr>
      
      <tr><td align="right">
        <div style="font-size: 14px; color: #F90;" class="semMargPadd">
          Total
        </div>
      </td><td align="right">
        <div style="font-size: 14px; color: #F90;" class="semMargPadd">
          <?php echo $TIPO_ARR_ACC[2];?>&nbsp;&nbsp;
        </div>
      </td><td align="right">
        <div style="font-size: 14px; color: #F90;" class="semMargPadd">
          <?php echo $TIPO_ARR_ACC[3];?>&nbsp;&nbsp;
        </div>
      </td><td align="right">
        <div style="font-size: 14px; color: #F90;" class="semMargPadd">
          <?php echo $TIPO_ARR_ACC[4];?>&nbsp;&nbsp;
        </div>
      </td><td align="right">
        <div style="font-size: 14px; color: #F90;" class="semMargPadd">
          <?php echo $TIPO_ARR_ACC[5];?>&nbsp;&nbsp;
        </div>
      </td></tr>
      
      </tbody>
      </table>
      
    </div><?php
	}
?>