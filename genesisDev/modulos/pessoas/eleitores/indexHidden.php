<html><head><?php
	include "../../../includes/library/myLibrary.inc";
	//ini_set("display_errors", 0); 
	
	$erro      			 = "";
	$TIPO_ACAO 			  = "";
	$GEN_ACAO_GERAL   = "";
	$MENSAGEM_RETORNO = "Registro salvo com sucesso!!";

	if(isset($_POST["GEN_ACAO_GERAL"]))   $GEN_ACAO_GERAL = $_POST["GEN_ACAO_GERAL"];
	if(isset($_POST["GEN_ACAO_GERAL_F"])) $GEN_ACAO_GERAL = $_POST["GEN_ACAO_GERAL_F"];?>
  
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../../../includes/css/gen_style.css"><?php

	switch($GEN_ACAO_GERAL) {
		case "SELECT_MUNICIPIO"://__[
			break;
		//]
		case "LST_MUNICIPIO"://_____[
			break;
		//]

		case "SELECT_BAIRRO"://__[
			break;
		//]
		case "LST_BAIRRO"://_____[
			break;
		//]

	}
	
	if($erro == "") {
		switch($GEN_ACAO_GERAL) {
			case "SELECT_BAIRRO"://__[
			break;
		//]
			case "LST_BAIRRO"://_____[
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
          case "SELECT_MUNICIPIO"://__[
						break;
					//]
					case "LST_MUNICIPIO"://_____[
						break;
					//]
					
          case "SELECT_BAIRRO"://__[
						break;
					//]
					case "LST_BAIRRO"://_____[
						break;
					//]
        }
        
      } else { 
        switch($GEN_ACAO_GERAL) {
          case "SELECT_MUNICIPIO"://__[?>
						parent.FW_V2_autoAddContent("GEN_MUN_ID", document.getElementById("DIV_SELECT_MUNICIPIO").innerHTML);	<?php
						
            break;
          //]
					case "LST_MUNICIPIO"://_____[?>
						parent.setLstLocalidade(document.getElementById("DIV_FILTRO_LST_MUNICIPIO").innerHTML, "MUNICIPIO");
						parent.document.getElementById("DIV_GEN_MUN").innerHTML = document.getElementById("DIV_GEN_MUN").innerHTML; 
						
						parent.FW_V2_componenteHtml("GEN_MUN_ID"); <?php
						
            break;
          //]					

          case "SELECT_BAIRRO"://__[?>
						parent.FW_V2_autoAddContent("GEN_BAI_ID", document.getElementById("DIV_SELECT_BAIRRO").innerHTML);	<?php
						
            break;
          //]
					case "LST_BAIRRO"://_____[?>
						parent.setLstLocalidade(document.getElementById("DIV_FILTRO_LST_BAIRRO").innerHTML, "BAIRRO");	
						parent.document.getElementById("DIV_GEN_BAI").innerHTML = document.getElementById("DIV_GEN_BAI").innerHTML; 
						
						parent.FW_V2_componenteHtml("GEN_BAI_ID"); <?php
						
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
			case "SELECT_MUNICIPIO"://__[
				$GEN_FILTRO_UF = $GEN_UF_ID;
				$GEN_MUN_DESCRICAO = "";
				
				if(isset($_POST["GEN_FILTRO_UF"]))     $GEN_FILTRO_UF     = $_POST["GEN_FILTRO_UF"];
				if(isset($_POST["GEN_MUN_DESCRICAO"])) $GEN_MUN_DESCRICAO = $_POST["GEN_MUN_DESCRICAO"];
				
				$SQL_QUERY_GEN_AUX = "
				SELECT M.A03_ID, M.A03_DESCRICAO_ABV, U.A04_SIGLA
							 
				FROM A04_UF AS U INNER JOIN A03_MUNICIPIO AS M ON M.A04_ID = U.A04_ID
												 INNER JOIN A02_BAIRRO    AS B ON M.A03_ID = B.A03_ID
												 
				WHERE U.A04_ID IN($GEN_FILTRO_UF) AND
							M.A03_DESCRICAO_ABV LIKE '%" . str_replace(" ", "%", $GEN_MUN_DESCRICAO) . "%'
							
				GROUP BY M.A03_ID, M.A03_DESCRICAO ";
				
				//echo $SQL_QUERY_GEN_AUX;?>
				
				<div id="DIV_SELECT_MUNICIPIO"><?php
          $CONECTAR_DB  = FW_conctarDB();
          $SQL_QUERY    = $SQL_QUERY_GEN_AUX;
          $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
          $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
          $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);?>
          
          <table border="0" cellpadding="0" cellspacing="0" width="99%"><?php
          if($NUM_LINES_DB > 0) {?>
            <tr><td valign="top">
              <div class="pequenoInclinado" style="margin-top: 5px;">
                &nbsp;Encontrado
              </div>
            </td></tr><?php
            
            while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
              $A03_ID        = $DADOS_ROW[0]; 
              $A03_DESCRICAO = $DADOS_ROW[1];
							$A04_SIGLA     = $DADOS_ROW[2];	?>
            
              <tr 
              onmouseover="javascript: this.className = 'thGridAuto';"
              onmouseout ="javascript: this.className = '';"
              onmousemove="this.style.cursor = 'hand'; this.style.cursor = 'pointer';">
              <td valign="top" style="width: 230px">
                <div style="width: 228px; height:16px; overflow:hidden; white-space: nowrap;">
                  <a href="javascript: void(0)" 
                  onmouseout ="$('#hdd_auto_mouseOver_GEN_MUN_ID').val('false')"
                  onmouseover="$('#hdd_auto_mouseOver_GEN_MUN_ID').val('true')"
                  
                  style="color:#000000; margin-left: 15px; text-transform: uppercase; font-size: 12px" 
                  title="<?php echo $A03_DESCRICAO;?>"
                  onclick="FW_V2_aplicarAutoValores('GEN_MUN_ID', '<?php echo $A03_ID;?>' , '<?php echo $A03_DESCRICAO;?>');
                           selectLstLocalidade('<?php echo $A03_ID;?>', 'MUNICIPIO');">
                    <?php echo $A04_SIGLA . " - " . $A03_DESCRICAO;?>
                  </a>
                </div>
              </td></tr><?php
              
            }
          } else {?>
            <tr><td valign="top">
              <div class="pequenoInclinado" style="margin-top: 5px; font-size: 14px" align="center">
                &nbsp;Nenhum registro encontrado
              </div>
            </td></tr><?php
					}?>
          </table><?php
          
          FW_desconctarDB($CONECTAR_DB);	?>
        </div><?php
				
				break;
			//]
			case "LST_MUNICIPIO"://_____[
				if(isset($_POST["GEN_FILTRO_UF"]))        $GEN_FILTRO_UF        = $_POST["GEN_FILTRO_UF"];
				if(isset($_POST["GEN_FILTRO_MUNICIPIO"])) $GEN_FILTRO_MUNICIPIO = $_POST["GEN_FILTRO_MUNICIPIO"];
				if(isset($_POST["GEN_F_MUN"]))            $GEN_F_MUN            = implode(",", $_POST["GEN_F_MUN"]);
				
				if(strlen(trim($GEN_F_MUN)) > 0) $GEN_FILTRO_MUNICIPIO = $GEN_FILTRO_MUNICIPIO . ", " . $GEN_F_MUN;
				
			/*echo "<BR />GEN_F_MUN.............: $GEN_F_MUN
							<BR />GEN_FILTRO_UF.........: $GEN_FILTRO_UF
							<BR />GEN_FILTRO_MUNICIPIO..: $GEN_FILTRO_MUNICIPIO";*/
				
				$SQL_QUERY = "
				SELECT M.A03_ID, 
				       M.A03_DESCRICAO_ABV, U.A04_SIGLA
				
				FROM A04_UF AS U INNER JOIN A03_MUNICIPIO AS M ON M.A04_ID = U.A04_ID
								         INNER JOIN A02_BAIRRO    AS B ON M.A03_ID = B.A03_ID
								 
				WHERE U.A04_ID IN($GEN_FILTRO_UF) AND 
				      M.A03_ID IN ($GEN_FILTRO_MUNICIPIO)
				
				GROUP BY M.A03_ID, M.A03_DESCRICAO_ABV 
				ORDER BY M.A03_DESCRICAO";
			
				$CONECTAR_DB  = FW_conctarDB();
				$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
				$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
				$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);?>
				
				<div id="DIV_FILTRO_LST_MUNICIPIO"><?php
					if($NUM_LINES_DB > 0) {
						while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
							$A03_ID            = $DADOS_ROW[0];
							$A03_DESCRICAO_ABV = $DADOS_ROW[1];
							$A04_SIGLA         = $DADOS_ROW[2];?>
							
							<div id="DIV_F_<?php echo $A03_ID;?>" class="FILTRO_CLASS" style="width: 90%">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                <tr onmouseover = "$('#IMG_F_<?php echo $A03_ID;?>').show()"
                     onmouseout = "$('#IMG_F_<?php echo $A03_ID;?>').hide()">
                <td valign="top" style="width: 90%; color: #000" title="<?php echo $A03_DESCRICAO_ABV;?>">
                  <?php echo $A04_SIGLA . " - " . $A03_DESCRICAO_ABV;?>
                  
                </td><td valign="top" align="right">
                	<img id = "IMG_F_<?php echo $A03_ID;?>" 
                    title = "Clique aqui para tirar '<?php echo $A04_SIGLA . " - " . $A03_DESCRICAO_ABV;?>' do filtro" 
                  onclick = "$('#DIV_F_<?php echo $A03_ID;?>').remove()"
                    style = "display: none; cursor: pointer" 
                      src = "<?php echo $FW_PATH_IMAGE . "pbIcons\cross.gif";?>" />
                  
                </td></tr>
                </table>
								
								<input type="hidden" name="GEN_F_MUN[]" value="<?php echo $A03_ID;?>" />
							</div><?php
								
						}
					}?>
        </div>
				
        <di id="DIV_GEN_MUN" style="padding-left: 7px"><?php
          $FW_V2_CSSDIVCONTENT = 
          "position: absolute; background-color: #FFFFFF; width: 250px;" 	.
          "height: 100px; overflow: auto; border: 1px solid #CCCCCC; $fonteSizeAux ";
          
          FW_V2_componenteHtml(
            array(
            "FW_V2_TIPOCOM"       => "AUTO",		
            "FW_V2_IDCOMP"        => "GEN_MUN_ID",
            "FW_V2_DESCNOME"      => "GEN_MUN_DESCRICAO",
            "FW_V2_VALUE"         => "",
            "FW_V2_DESCRICAO"     => "",			
            "FW_V2_DICA"          => "Clique aqui",
            "FW_V2_CSSDIVCONTENT" => $FW_V2_CSSDIVCONTENT,
            "FW_V2_FUNCHIDDEN"    => "selectLocalidade('SELECT_MUNICIPIO');",
            "FW_V2_CSS"           => "text-transform: uppercase; font-size: 12px; width: 250px; color: #3F5F8D; $fonteSizeAux",
            "FW_V2_TITULO"        => ""
            )	
          );?>
        </div><?php
        
        FW_desconctarDB($CONECTAR_DB);							
				
				break;
				
			//]

			case "SELECT_BAIRRO"://__[
			  $GEN_WHERE_AUX     = "";
				$GEN_F_MUN         = "";
				$GEN_BAI_DESCRICAO = "";
				$GEN_FILTRO_UF     = $GEN_UF_ID;
				
				if(isset($_POST["GEN_FILTRO_UF"]))     $GEN_FILTRO_UF     = $_POST["GEN_FILTRO_UF"];
				if(isset($_POST["GEN_BAI_DESCRICAO"])) $GEN_BAI_DESCRICAO = $_POST["GEN_BAI_DESCRICAO"];
				if(isset($_POST["GEN_F_MUN"]))         $GEN_F_MUN         = implode(",", $_POST["GEN_F_MUN"]);
				
				if(strlen(trim($GEN_F_MUN)) > 0) $GEN_WHERE_AUX = " M.A03_ID IN ($GEN_F_MUN) AND ";
				
				$SQL_QUERY_GEN_AUX = "
				SELECT U.A04_SIGLA, M.A03_ID, M.A03_DESCRICAO_ABV, B.A02_ID, B.A02_DESCRICAO 
				
				FROM A04_UF AS U INNER JOIN A03_MUNICIPIO AS M ON M.A04_ID = U.A04_ID 
												 INNER JOIN A02_BAIRRO AS B ON M.A03_ID = B.A03_ID 
												 
				WHERE U.A04_ID IN($GEN_FILTRO_UF) AND $GEN_WHERE_AUX
							B.A02_DESCRICAO LIKE '%" . str_replace(" ", "%", $GEN_BAI_DESCRICAO) . "%'
				
				ORDER BY U.A04_SIGLA, M.A03_DESCRICAO_ABV, B.A02_DESCRICAO ";
				
				echo $SQL_QUERY_GEN_AUX;?>
				
				<div id="DIV_SELECT_BAIRRO"><?php
          $CONECTAR_DB  = FW_conctarDB();
          $SQL_QUERY    = $SQL_QUERY_GEN_AUX;
          $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
          $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
          $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);?>
          
          <table border="0" cellpadding="0" cellspacing="0" width="99%"><?php
          if($NUM_LINES_DB > 0) {?>
            <tr><td valign="top">
              <div class="pequenoInclinado" style="margin-top: 5px;">
                &nbsp;Encontrado
              </div>
            </td></tr><?php
            
            while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
							$A04_SIGLA         = $DADOS_ROW[0];
							$A03_ID            = $DADOS_ROW[1];
							$A03_DESCRICAO_ABV = $DADOS_ROW[2];
							$A02_ID            = $DADOS_ROW[3]; 
							$A02_DESCRICAO     = $DADOS_ROW[4];
							
							$A02_DESCRICAO_AUX = $A02_DESCRICAO . 
							"&nbsp;<span class=pequenoInclinado>($A03_DESCRICAO_ABV)</span>"?>
            
              <tr 
              onmouseover="javascript: this.className = 'thGridAuto';"
              onmouseout ="javascript: this.className = '';"
              onmousemove="this.style.cursor = 'hand'; this.style.cursor = 'pointer';">
              <td valign="top" style="width: 230px">
                <div style="width: 228px; height:16px; overflow:hidden; white-space: nowrap;">
                  <a href="javascript: void(0)" 
                  onmouseout ="$('#hdd_auto_mouseOver_GEN_BAI_ID').val('false')"
                  onmouseover="$('#hdd_auto_mouseOver_GEN_BAI_ID').val('true')"
                  
                  style="color:#000000; margin-left: 15px; text-transform: uppercase; font-size: 12px" 
                  title="<?php echo $A02_DESCRICAO . " ($A03_DESCRICAO_ABV)";?>"
                  onclick="FW_V2_aplicarAutoValores('GEN_MUN_ID', '<?php echo $A02_ID;?>' , '<?php echo $A02_DESCRICAO_AUX;?>');
                           selectLstLocalidade('<?php echo $A02_ID;?>', 'BAIRRO');"><?php 
										echo $A02_DESCRICAO_AUX;?>
                  </a>
                </div>
              </td></tr><?php
              
            }
          } else {?>
            <tr><td valign="top">
              <div class="pequenoInclinado" style="margin-top: 5px; font-size: 14px" align="center">
                &nbsp;Nenhum registro encontrado
              </div>
            </td></tr><?php
					}?>
          </table><?php
          
          FW_desconctarDB($CONECTAR_DB);	?>
        </div><?php
				
				break;
			//]
			case "LST_BAIRRO"://_____[
				if(isset($_POST["GEN_FILTRO_BAIRRO"])) $GEN_FILTRO_BAIRRO = $_POST["GEN_FILTRO_BAIRRO"];
				if(isset($_POST["GEN_F_BAI"]))         $GEN_F_BAI         = implode(",", $_POST["GEN_F_BAI"]);
				if(strlen(trim($GEN_F_BAI)) > 0) $GEN_FILTRO_BAIRRO = $GEN_FILTRO_BAIRRO . ", " . $GEN_F_BAI;
				
				$SQL_QUERY = "
				SELECT B.A02_ID, 
				       B.A02_DESCRICAO, 
				       B.A03_DESCRICAO_ABV
				FROM A02_BAIRRO AS B
				WHERE B.A02_ID IN($GEN_FILTRO_BAIRRO)
				ORDER BY B.A02_DESCRICAO ";
			
				$CONECTAR_DB  = FW_conctarDB();
				$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
				$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
				$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);?>
				
				<div id="DIV_FILTRO_LST_BAIRRO"><?php
					if($NUM_LINES_DB > 0) {
						while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
							$A02_ID            = $DADOS_ROW[0];
							$A02_DESCRICAO     = $DADOS_ROW[1];
							$A03_DESCRICAO_ABV = $DADOS_ROW[2];?>
							
							<div id="DIV_F_<?php echo $A02_ID;?>" class="FILTRO_CLASS" style="width: 90%">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%">
                <tr onmouseover = "$('#IMG_F_<?php echo $A02_ID;?>').show()"
                     onmouseout = "$('#IMG_F_<?php echo $A02_ID;?>').hide()">
                <td valign="top" style="width: 90%; color: #000" title="<?php echo $A02_DESCRICAO;?>"><?php 
									echo $A02_DESCRICAO;?>
                  
                </td><td valign="top" align="right">
                	<img id = "IMG_F_<?php echo $A02_ID;?>" 
                    title = "Clique aqui para tirar '<?php echo $A02_DESCRICAO;?>' do filtro" 
                  onclick = "$('#DIV_F_<?php echo $A02_ID;?>').remove()"
                    style = "display: none; cursor: pointer" 
                      src = "<?php echo $FW_PATH_IMAGE . "pbIcons\cross.gif";?>" />
                  
                </td></tr>
                </table>
								
								<input type="hidden" name="GEN_F_BAI[]" value="<?php echo $A02_ID;?>" />
							</div><?php
								
						}
					}?>
        </div>
				
        <div id="DIV_GEN_BAI" style="padding-left: 7px"><?php
          $FW_V2_CSSDIVCONTENT = 
          "position: absolute; background-color: #FFFFFF; width: 250px;" 	.
          "height: 100px; overflow: auto; border: 1px solid #CCCCCC; $fonteSizeAux ";
          
          FW_V2_componenteHtml(
            array(
            "FW_V2_TIPOCOM"       => "AUTO",		
            "FW_V2_IDCOMP"        => "GEN_BAI_ID",
            "FW_V2_DESCNOME"      => "GEN_BAI_DESCRICAO",
            "FW_V2_VALUE"         => "",
            "FW_V2_DESCRICAO"     => "",			
            "FW_V2_DICA"          => "Clique aqui",
            "FW_V2_CSSDIVCONTENT" => $FW_V2_CSSDIVCONTENT,
            "FW_V2_FUNCHIDDEN"    => "selectLocalidade('SELECT_BAIRRO');",
            "FW_V2_CSS"           => "text-transform: uppercase; font-size: 12px; width: 250px; color: #3F5F8D; $fonteSizeAux",
            "FW_V2_TITULO"        => ""
            )	
          );?>
        </div><?php
        
        FW_desconctarDB($CONECTAR_DB);							
				
				break;
			//]

		}
	}?>
</body></html>