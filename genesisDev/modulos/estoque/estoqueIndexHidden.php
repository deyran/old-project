<html><head><?php
	include "../../includes/library/myLibrary.inc";
	include "estoqueInc.inc";
	//ini_set("display_errors", 0); 
	
	$erro      			 = "";
	$TIPO_ACAO 			  = "";
	$GEN_ACAO_GERAL   = "";
	$GEN_ACAO_GERAL_  = "";
	$MENSAGEM_RETORNO = "Registro salvo com sucesso!!";
	
	$SQL_COMMANDS  = "";
	$E01_ID        = "";
	$EA1_ID        = "";
	$EA0_ID        = "";
	$E01_MODELO    = "";
	$E01_TAMANHO   = "";
	$E01_QTD       = "";
	$E01_LOCAL_ARM = "";
	
	$E02_DATA       = "";
	$E02_DATA_MES   = "";
	$E02_DATA_ANO   = "";
	$E02_TIPO_MOV   = "";
	$E01_QTD        = "";
	$E01_QTD_ATUAL  = "";
	$E01_QTD_NEW    = "";
	$E02_OBSERVACAO = "";
	$P01_ID         = "";
	
	if(isset($_POST["E01_ID"]))                 $E01_ID         = $_POST["E01_ID"];
	if(isset($_POST["GEN_ACAO_GERAL"]))         $GEN_ACAO_GERAL = $_POST["GEN_ACAO_GERAL"];
	if(isset($_REQUEST["GEN_ACAO_GERAL_GRID"])) $GEN_ACAO_GERAL = $_REQUEST["GEN_ACAO_GERAL_GRID"];?>
  
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css"><?php

	switch($GEN_ACAO_GERAL) {
		case "SALVAR"://_______________[
			if(isset($_POST["EA1_ID"]))        $EA1_ID        = $_POST["EA1_ID"];
			if(isset($_POST["EA0_ID"]))        $EA0_ID        = $_POST["EA0_ID"];
			if(isset($_POST["E01_MODELO"]))    $E01_MODELO    = $_POST["E01_MODELO"];
			if(isset($_POST["E01_TAMANHO"]))   $E01_TAMANHO   = $_POST["E01_TAMANHO"];
			if(isset($_POST["E01_LOCAL_ARM"])) $E01_LOCAL_ARM = $_POST["E01_LOCAL_ARM"];

			if($EA1_ID        == $FW_V2_null) $EA1_ID        = "";
			if($EA0_ID        == $FW_V2_null) $EA0_ID        = "";
			if($E01_MODELO    == $FW_V2_null) $E01_MODELO    = "";
			if($E01_TAMANHO   == $FW_V2_null) $E01_TAMANHO   = "";
			if($E01_LOCAL_ARM == $FW_V2_null) $E01_LOCAL_ARM = "";
			
			if(strlen(trim($E01_MODELO))   == 0) $erro = "Você deve informar o '<strong>Modelo</strong>'!!";
			if((strlen(trim($EA1_ID))      == 0) && (strlen(trim($erro)) == 0)) $erro = "Você deve informar o '<strong>Tipo de armação</strong>'!!";
			if((strlen(trim($E01_TAMANHO)) == 0) && (strlen(trim($erro)) == 0)) $erro = "Você deve informar o '<strong>Tamanho</strong>'!!";
			if((strlen(trim($EA0_ID))      == 0) && (strlen(trim($erro)) == 0)) $erro = "Você deve informar o '<strong>G&ecirc;nero</strong>'!!";
			
			if(strlen(trim($erro)) == 0) {
				if(strlen(trim($E01_ID)) == 0)    {
					$TIPO_ACAO 		= "INSERT";
					$CONECTAR_DB  = FW_conctarDB();
					$SQL_QUERY    = "SELECT (MAX(E.E01_ID) + 1) AS ID FROM E01_OCULOS AS E";
					$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
					$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
					$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
					
					if($NUM_LINES_DB > 0) {
						while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
							$E01_ID = $DADOS_ROW[0];
						}
					}
					FW_desconctarDB($CONECTAR_DB);
					//----------------------------------------------------------------------				
					
					$SQL_COMMANDS = "
					INSERT INTO E01_OCULOS (
						E01_ID     , E01_MODELO, EA1_ID, 
						E01_TAMANHO, EA0_ID    , E01_LOCAL_ARM,
						E01_EMISSOR, E01_QTD)
						
					VALUES (" . 
						FW_trataCaractere($E01_ID        , "N") . ",  " .
						FW_trataCaractere($E01_MODELO    , "T") . ",  " .
						FW_trataCaractere($EA1_ID        , "N") . ",  " .
						FW_trataCaractere($E01_TAMANHO   , "N") . ",  " .
						FW_trataCaractere($EA0_ID        , "N") . ",  " .
						FW_trataCaractere($E01_LOCAL_ARM , "T") . ",  " .
						FW_trataCaractere($GEN_ID        , "N") . ",0)";
					
				} 
				elseif(strlen(trim($E01_ID)) > 0) {
					$TIPO_ACAO = "UPDATE";
					
					$SQL_COMMANDS = "
					UPDATE E01_OCULOS AS O SET
						O.E01_MODELO    = " . FW_trataCaractere($E01_MODELO   , "T") . ",
						O.EA1_ID        = " . FW_trataCaractere($EA1_ID       , "N") . ",
						O.E01_TAMANHO   = " . FW_trataCaractere($E01_TAMANHO  , "N") . ",
						O.EA0_ID        = " . FW_trataCaractere($EA0_ID       , "N") . ",
						O.E01_LOCAL_ARM = " . FW_trataCaractere($E01_LOCAL_ARM, "T") . "
						
					WHERE O.E01_ID = $E01_ID";
				}
			}
			
			$GEN_ACAO_GERAL_ = $GEN_ACAO_GERAL;
			$GEN_ACAO_GERAL  = "SQL_EXECUTE";
			
			//echo $SQL_COMMANDS . "<br /><br />";
			break;
		//]
		case "SELECT_TIPO_ARMACAO"://__[
			break;
		//]
		case "SELECT_FORM_MOV"://______[
			break;
		//]
		case "HIST_MOV_GRID"://________[
			break;
		//]
		case "SALVAR_MOV"://___________[
			if(isset($_POST["E02_DATA"]))       $E02_DATA       = $_POST["E02_DATA"];
			if(isset($_POST["E02_TIPO_MOV"]))   $E02_TIPO_MOV   = $_POST["E02_TIPO_MOV"];
			if(isset($_POST["E01_QTD"]))        $E01_QTD        = $_POST["E01_QTD"];
			if(isset($_POST["E01_QTD_ATUAL"]))  $E01_QTD_ATUAL  = $_POST["E01_QTD_ATUAL"];
			if(isset($_POST["E02_OBSERVACAO"])) $E02_OBSERVACAO = $_POST["E02_OBSERVACAO"];
			if(isset($_POST["GEN_ID"]))         $P01_ID         = $_POST["GEN_ID"];			
			//============================================================================================================================
			
			if($E02_DATA       == $FW_V2_null) $E02_DATA       = "";
			if($E01_QTD        == $FW_V2_null) $E01_QTD        = "";
			if($E01_QTD_ATUAL  == $FW_V2_null) $E01_QTD_ATUAL  = "";
			if($E02_OBSERVACAO == $FW_V2_null) $E02_OBSERVACAO = "";

			if(strlen(trim($E02_DATA)) == 0) $erro = "Informe a '<strong>Data de movimenta&ccedil;&atilde;o</strong>'!!";
			if((strlen(trim($E01_QTD)) == 0) && (strlen(trim($erro)) == 0)) $erro = "Informe a '<strong>Quantidade</strong>'!!";
			if((((int)$E01_QTD == 0)) && (strlen(trim($erro)) == 0)) $erro = "Quantidade deve ser maior que '<strong>zero</strong>'!!";
			//============================================================================================================================
						
			if(strlen(trim($erro)) == 0) {
				$E02_DATA_ARR = explode("/", $E02_DATA);
				$E02_DATA_MES = $E02_DATA_ARR[1];
				$E02_DATA_ANO = $E02_DATA_ARR[2];
				
				$E02_TIPO_MOV_AUX = (int) $E02_TIPO_MOV;
				$E01_QTD_NEW = 0;
				
				if($E02_TIPO_MOV_AUX == 0)    {
					$E01_QTD_NEW = (int)$E01_QTD_ATUAL + (int)$E01_QTD;
					
				} 
				elseif($E02_TIPO_MOV_AUX > 0) {
					$E01_QTD_NEW = (int)$E01_QTD_ATUAL - (int)$E01_QTD;
					
				}
		
				if($E01_QTD_NEW < 0) $erro = "Quantidade atual não pode ficar negativa!!!";
				
			}
			//============================================================================================================================
			
			if(strlen(trim($erro)) == 0) {
				$SQL_COMMANDS = "
				UPDATE E01_OCULOS AS O SET 
					O.E01_QTD = $E01_QTD_NEW
				WHERE O.E01_ID = $E01_ID";
				
				$CONECTAR_DB = FW_conctarDB();
				FW_sqlExec($SQL_COMMANDS, $CONECTAR_DB);
				FW_desconctarDB($CONECTAR_DB);
				
				$SQL_COMMANDS = "
				INSERT INTO E02_OCULOS_MOV (
					E02_TIPO_MOV , E01_ID        , E02_DATA  , 
					E02_DATA_MES , E02_DATA_ANO  , E02_QTD_DE, 
					E02_QTD_PARA , E02_OBSERVACAO, P01_ID
					
				) VALUES (" . 
					FW_trataCaractere($E02_TIPO_MOV  , "N") . ",".
					FW_trataCaractere($E01_ID        , "N") . ",".
					FW_converterData($E02_DATA)             . ",".
					FW_trataCaractere($E02_DATA_MES  , "T") . ",".
					FW_trataCaractere($E02_DATA_ANO  , "T") . ",".
					FW_trataCaractere($E01_QTD_ATUAL , "N") . ",".
					FW_trataCaractere($E01_QTD_NEW   , "N") . ",".
					FW_trataCaractere($E02_OBSERVACAO, "T") . ",".
					FW_trataCaractere($P01_ID        , "N") . ")";
				
			}

			$GEN_ACAO_GERAL_ = $GEN_ACAO_GERAL;
			$GEN_ACAO_GERAL  = "SQL_EXECUTE";
			
			echo "
			<div style='font-family: Courier New, Courier, monospace; padding: 10px'>
							E02_DATA........: $E02_DATA
				<br />E02_DATA_MES....: $E02_DATA_MES
				<br />E02_DATA_ANO....: $E02_DATA_ANO
				<br />E02_TIPO_MOV....: $E02_TIPO_MOV
				<br />E01_QTD.........: $E01_QTD
				<br />E01_QTD_ATUAL...: $E01_QTD_ATUAL
				<br />E01_QTD_NEW.....: $E01_QTD_NEW
				<br />E02_OBSERVACAO..: $E02_OBSERVACAO
				<br />P01_ID..........: $P01_ID
			</div><br /><br />";
						
	
			break;
		//]
	}
	
	if($erro == "") {
		switch($GEN_ACAO_GERAL) {
			case "SQL_EXECUTE"://__________[
				$CONECTAR_DB    = FW_conctarDB();
				FW_sqlExec($SQL_COMMANDS, $CONECTAR_DB);
				FW_desconctarDB($CONECTAR_DB);
				
				$GEN_ACAO_GERAL = $GEN_ACAO_GERAL_;
				
				break;
			//]
			case "SELECT_TIPO_ARMACAO"://__[
				break;
			//]
			case "SELECT_FORM_MOV"://______[
				break;
			//]
			case "HIST_MOV_GRID"://________[
				break;
			//]
		}
	}?>
  
	<script type="text/javascript" charset="utf-8">
    function start() {<?php
      if(strlen(trim($erro)) > 0) {?>
        parent.newAlert("<span style='font-size: 18px'><?php echo $erro?></span>", "error", "");<?php
        echo "\r";
  
        switch($GEN_ACAO_GERAL) {
					case "SALVAR"://_______________[
						break;
					//]
          case "SELECT_TIPO_ARMACAO"://__[
            break;
          //]
					case "SELECT_FORM_MOV"://______[
						break;
					//]
					case "HIST_MOV_GRID"://________[
						break;
					//]
        }
        
      } 
			else { 
        switch($GEN_ACAO_GERAL) {
					case "SALVAR"://_______________[?>
						parent.parent.doSubmit("formGrid", "indexHidden.php", "SELECT_GRID_ESTOQUE");<?php
						
						if($TIPO_ACAO == "INSERT")     {
							$MENSAGEM_RETORNO = $E01_ID . "&MENSAGEM_RETORNO=$MENSAGEM_RETORNO";?>
							parent.reloadPage("<?php echo $MENSAGEM_RETORNO;?>"); <?php
							
						} 
						elseif($TIPO_ACAO == "UPDATE") {?>
							parent.newAlert("<span style='font-size: 18px'><?php echo $MENSAGEM_RETORNO;?></span>", "", "");<?php
							
						}
						
						break;
					//]
          case "SELECT_TIPO_ARMACAO"://__[?>
						parent.FW_V2_autoAddContent("EA1_ID", document.getElementById("DIV_SELECT_TIPO_ARMACAO").innerHTML);	<?php
						break;
					//]
					case "SELECT_FORM_MOV"://______[?>
						parent.document.getElementById("DIV_FORM_MOV").innerHTML =
						       document.getElementById("DIV_FORM_MOV").innerHTML;	<?php
						break;
					//]
					case "SALVAR_MOV"://___________[?>
						parent.parent.doSubmit("formGrid", "indexHidden.php", "SELECT_GRID_ESTOQUE");
						parent.newAlert("<span style='font-size: 18px'><?php echo $MENSAGEM_RETORNO;?></span>", "", "");
						
						parent.document.getElementById("DIV_E01_QTD_READ").innerHTML =
						       document.getElementById("DIV_E01_QTD_READ").innerHTML;	
									 
						parent.document.getElementById("DIV_FORM_MOV").innerHTML =
						       document.getElementById("DIV_FORM_MOV").innerHTML;	
									 
						parent.document.getElementById("E01_QTD_ATUAL").value = "<?php echo $E01_QTD_NEW;?>";<?php
									 
						break;
					//]
					case "HIST_MOV_GRID"://________[?>
						parent.document.getElementById("DIV_GRID_HIST_MOV").innerHTML =
						       document.getElementById("DIV_GRID_HIST_MOV").innerHTML;	<?php
						break;
					//]
        }
        
      }?>
			
			parent.fecharAguardeModal();
    }
  </script>
  
</head><body onLoad="start();" style="font-family:'Courier New', Courier, monospace; background-color: #FFF;"><?php
	echo "DATA E HORA.....: estoqueIndexHidden.php " . date("d/m/Y H:i:s ") . "<BR />
				GEN_ID..........: $GEN_ID<BR />
				E01_ID..........: $E01_ID<BR />
				GEN_ACAO_GERAL..: $GEN_ACAO_GERAL<BR />";
				
	if($erro == "") {
		switch($GEN_ACAO_GERAL) {
			case "SELECT_TIPO_ARMACAO"://__[
				$EA1_DESCRICAO = "";
				$EA1_DESCRICAO_WIDTH = 250;
				
				if(isset($_POST["EA1_DESCRICAO"]))       $EA1_DESCRICAO       = $_POST["EA1_DESCRICAO"];
				if(isset($_POST["EA1_DESCRICAO_WIDTH"])) $EA1_DESCRICAO_WIDTH = $_POST["EA1_DESCRICAO_WIDTH"];
				
				echo $EA1_DESCRICAO . " - " . $EA1_DESCRICAO_WIDTH;?>
        
        <div id="DIV_SELECT_TIPO_ARMACAO"><?php
          $SQL_QUERY_GEN_AUX = "
          SELECT E.EA1_ID, E.EA1_DESCRICAO
          FROM EA1_TIPO_ARMACAO AS E 
          WHERE E.EA1_DESCRICAO LIKE '%" . str_replace(" ", "%", $EA1_DESCRICAO) . "%'";
          
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
            
						$EA1_DESCRICAO_WIDTH_AUX = (((int) $EA1_DESCRICAO_WIDTH) - 20);
						
            while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
              $EA1_ID            = $DADOS_ROW[0]; 
              $EA1_DESCRICAO     = $DADOS_ROW[1];
							$EA1_DESCRICAO_AUX = substr(trim($EA1_DESCRICAO), 0, 43);?>
            
              <tr 
              onmouseover="javascript: this.className = 'thGridAuto';"
              onmouseout ="javascript: this.className = '';"
              onmousemove="this.style.cursor = 'hand'; this.style.cursor = 'pointer';">
              <td valign="top" style="width: <?php echo $EA1_DESCRICAO_WIDTH_AUX;?>px">
                <div style="width: <?php echo ($EA1_DESCRICAO_WIDTH_AUX - 2);?>px; height: 16px; overflow: hidden; white-space: nowrap;">
                  <a href="javascript: void(0)" 
                  onmouseout ="$('#hdd_auto_mouseOver_EA1_ID').val('false')"
                  onmouseover="$('#hdd_auto_mouseOver_EA1_ID').val('true')"
                  
                  style="color:#000000; margin-left: 15px" title="<?php echo $EA1_DESCRICAO;?>"
                  onclick="FW_V2_aplicarAutoValores('EA1_ID', '<?php echo $EA1_ID;?>' , '<?php echo $EA1_DESCRICAO_AUX;?>');">
                    <?php echo $EA1_DESCRICAO_AUX;?>
                  </a>
                </div>
              </td></tr><?php
              
            }
						
          } else {?>
            <tr><td valign="top">
              <div class="grandeInclinado" style="margin-top: 5px;" align="center">
                &nbsp;Nenhum registro encontrado
              </div>
            </td></tr><?php
					}?>
					</table><?php
          
          FW_desconctarDB($CONECTAR_DB);	?>
          
        </div><?php
				
				break;
			//]
			case "SELECT_FORM_MOV"://______[
				if(isset($_POST["E01_QTD_ATUAL"]))       $E01_QTD_ATUAL       = $_POST["E01_QTD_ATUAL"];
				if(isset($_POST["GEN_DOC_WIDTH"]))       $GEN_DOC_WIDTH       = $_POST["GEN_DOC_WIDTH"];
				if(isset($_POST["DIV_TAB_FORM_HEIGHT"])) $DIV_TAB_FORM_HEIGHT = $_POST["DIV_TAB_FORM_HEIGHT"];
				
				echo "E01_QTD..: $E01_QTD";?>
        
        <div id="DIV_FORM_MOV"><?php getFormMov($GEN_DOC_WIDTH, $DIV_TAB_FORM_HEIGHT, $E01_QTD_ATUAL);?></div><?php
				
				break;
			//]
			case "SALVAR_MOV"://___________[
				$DIV_TAB_WIDTH       = 0;
				$GEN_DOC_WIDTH       = 0;
				$DIV_TAB_FORM_HEIGHT = 0;
				$fonteSizeAux        = " font-size: 16px; ";
				$fonteSizeTitleAux   = " font-size: 16px; ";
				
				if(isset($_POST["GEN_DOC_WIDTH"]))       $GEN_DOC_WIDTH       = $_POST["GEN_DOC_WIDTH"];
				if(isset($_POST["DIV_TAB_WIDTH"]))       $DIV_TAB_WIDTH       = $_POST["DIV_TAB_WIDTH"];
				if(isset($_POST["DIV_TAB_FORM_HEIGHT"])) $DIV_TAB_FORM_HEIGHT = $_POST["DIV_TAB_FORM_HEIGHT"];?>
				
        <div id="DIV_E01_QTD_READ"><?php 
          $E01_QTD_WIDTH = (((int) $DIV_TAB_WIDTH  * 14) / 100);
  
          FW_V2_componenteHtml(
            array(
              "FW_V2_IDCOMP"    => "E01_QTD_READ",
              "FW_V2_TIPOCOM"   => "READ",
              "FW_V2_VALUE"     => FW_numeroEspacoMilhar($E01_QTD_NEW),
              "FW_V2_CSSTITULO" => $fonteSizeTitleAux,
              "FW_V2_CSS"       => "width: " . $E01_QTD_WIDTH . "px; color: #000; text-align: right; $fonteSizeAux",
              "FW_V2_TITULO"    => "Quantidade"
            )	
          );?>
        </div> 
				
        <div id="DIV_FORM_MOV"><?php
          getFormMov($GEN_DOC_WIDTH, $DIV_TAB_FORM_HEIGHT, $E01_QTD_NEW);?>
        </div> <?php

				break;
			//]
			case "HIST_MOV_GRID"://________[?>
        <div id="DIV_GRID_HIST_MOV"><?php
					if(isset($_POST["DIV_TAB_WIDTH"]))  $DIV_TAB_WIDTH  = $_POST["DIV_TAB_WIDTH"];
					if(isset($_POST["DIV_TAB_HEIGHT"])) $DIV_TAB_HEIGHT = $_POST["DIV_TAB_HEIGHT"];
				
					/*echo "
					<br />DIV_TAB_WIDTH...: $DIV_TAB_WIDTH
					<br />DIV_TAB_HEIGHT..: $DIV_TAB_HEIGHT	";*/
				
        	historicoMovGrid($DIV_TAB_WIDTH, $DIV_TAB_HEIGHT);?>
        </div><?php
				
				break;
			//]			
		}
	}?>
</body></html>