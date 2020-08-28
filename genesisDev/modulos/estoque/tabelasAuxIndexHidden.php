<html><head><?php
	include "../../includes/library/myLibrary.inc";
	//ini_set("display_errors", 0); 
	
//$SWITCH_FORM = "SWITCH_FORM_ARMACAO"
//$SWITCH_FORM     = "SWITCH_FORM_GENERO";
//$SWITCH_FORM_TBL = "EA0_GENERO";
//$SWITCH_FORM_IDS = "EA0";						
	
	$erro      			 = "";
	$TIPO_ACAO 			  = "";
	$EA_ID 			      = "";
	$EA_DESCRICAO		 = "";
	$GEN_ACAO_GERAL_  = "";
	$SWITCH_FORM      = "";
	$SWITCH_FORM_TBL  = "";
	$SWITCH_FORM_IDS  = "";						
	$MENSAGEM_RETORNO = "Registro salvo com sucesso!!";
	
	if(isset($_POST["SWITCH_FORM"]))     $SWITCH_FORM     = $_POST["SWITCH_FORM"];
	if(isset($_POST["SWITCH_FORM_TBL"])) $SWITCH_FORM_TBL = $_POST["SWITCH_FORM_TBL"];
	if(isset($_POST["SWITCH_FORM_IDS"])) $SWITCH_FORM_IDS = $_POST["SWITCH_FORM_IDS"];

	if(isset($_POST[$SWITCH_FORM_IDS. "_ID"])) $EA_ID          = $_POST[$SWITCH_FORM_IDS. "_ID"];
	if(isset($_POST["GEN_ACAO_GERAL"]))        $GEN_ACAO_GERAL = $_POST["GEN_ACAO_GERAL"];?>
  
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css"><?php
	
	$GEN_ACAO_GERAL_ = $GEN_ACAO_GERAL;
	
	switch($GEN_ACAO_GERAL) {
		case "SALVAR"://__[
			$ERRO_MSG = "";
			
			if($SWITCH_FORM == "SWITCH_FORM_ARMACAO")    {
				$ERRO_MSG = "Você deve <strong>descrever</strong> o tipo de armação!!";
				
			}
			elseif($SWITCH_FORM == "SWITCH_FORM_GENERO") {
				$ERRO_MSG = "Você deve <strong>descrever</strong> o gênero!!";
				
			}

			if(isset($_POST[$SWITCH_FORM_IDS . "_DESCRICAO"])) $EA_DESCRICAO = $_POST[$SWITCH_FORM_IDS . "_DESCRICAO"];
			if(strlen(trim($EA_ID)) > 0) $EA_DESCRICAO = $_POST[$SWITCH_FORM_IDS . "_DESCRICAO_" . $EA_ID];
			
			if($EA_DESCRICAO == $FW_V2_null)     $EA_DESCRICAO = "";
			if(strlen(trim($EA_DESCRICAO)) == 0) $erro = $ERRO_MSG;
			
			$SQL_COMMANDS = "";
			
			if(strlen(trim($erro)) == 0) {
				if(strlen(trim($EA_ID)) == 0) {
					$CONECTAR_DB  = FW_conctarDB();
					
					$SQL_QUERY    = "SELECT (MAX(E." . $SWITCH_FORM_IDS . "_ID) + 1) AS ID FROM $SWITCH_FORM_TBL AS E";
					$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
					$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
					$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
					
					if($NUM_LINES_DB > 0) {
						while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
							$EA_ID = $DADOS_ROW[0];
						}
					}
					
					FW_desconctarDB($CONECTAR_DB);
					
					$SQL_COMMANDS = "
					INSERT INTO $SWITCH_FORM_TBL (" . $SWITCH_FORM_IDS . "_ID, " . $SWITCH_FORM_IDS . "_DESCRICAO) 
					VALUES (" . 
						FW_trataCaractere($EA_ID, "N") . ", " . 
						FW_trataCaractere($EA_DESCRICAO, "T") . ")";
					
				}
				elseif(strlen(trim($EA_ID)) > 0) {
					$SQL_COMMANDS = "
					UPDATE $SWITCH_FORM_TBL AS T SET 
						T." . $SWITCH_FORM_IDS . "_DESCRICAO = " . FW_trataCaractere($EA_DESCRICAO, "T") . " 
					WHERE T." . $SWITCH_FORM_IDS . "_ID = "    . FW_trataCaractere($EA_ID, "N");
					
				}
			}
			
			echo "<br /><br />$SQL_COMMANDS<br /><br />";
			
			$GEN_ACAO_GERAL  = "SQL_EXECUTE";
			
			break;
		//]
		case "DELETE"://__[
			$GEN_ACAO_GERAL  = "SQL_EXECUTE";
			
			$SQL_COMMANDS = "
			DELETE T.* 
			FROM $SWITCH_FORM_TBL AS T
			WHERE T." . $SWITCH_FORM_IDS . "_ID = " . FW_trataCaractere($EA_ID, "N");
			
			break;
		//]
	}
	
	if($erro == "") {
		switch($GEN_ACAO_GERAL) {
			case "SQL_EXECUTE"://__[
				$CONECTAR_DB    = FW_conctarDB();
				FW_sqlExec($SQL_COMMANDS, $CONECTAR_DB);
				FW_desconctarDB($CONECTAR_DB);
				
				$GEN_ACAO_GERAL = $GEN_ACAO_GERAL_;
				
				break;
			//]

		}
	}?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
	<script type="text/javascript">
    function start() {<?php
      if($erro <> "") {?>
        parent.newAlert("<span style='font-size: 18px'><?php echo $erro?></span>", "error", "");<?php
        echo "\r";
  
        switch($GEN_ACAO_GERAL) {
          case "SALVAR"://__[
						break;
					//]
					case "DELETE"://__[
						break;
					//]
        }
        
      } 
			else { 
        switch($GEN_ACAO_GERAL) {
          case "SALVAR"://__[
						$PAGINA = "tabelasAuxIndex.php?$GEN_PARAMETROS&MENSAGEM_RETORNO=" . $MENSAGEM_RETORNO;?>
						parent.window.location = "<?php echo trim($PAGINA);?>&SWITCH_FORM=<?php echo $SWITCH_FORM;?>";<?php
						
            break;
          //]
					case "DELETE"://__[
						$MENSAGEM_RETORNO = "Registro excluído com sucesso!!";
						$PAGINA = "tabelasAuxIndex.php?$GEN_PARAMETROS&MENSAGEM_RETORNO=" . $MENSAGEM_RETORNO;?>
						parent.window.location = "<?php echo trim($PAGINA);?>&SWITCH_FORM=<?php echo $SWITCH_FORM;?>";<?php
						
            break;
          //]
        }
        
      }?>
			
			parent.fecharAguardeModal();
    }
  </script>
  
</head><body onLoad="start();" style="font-family:'Courier New', Courier, monospace; background-color: #FFF;"><?php
	echo "DATA E HORA.....: tabelasAuxIndexHidden.php " . date("d/m/Y H:i:s ") . "<BR />
				EA_ID...........: $EA_ID <BR />
				GEN_ACAO_GERAL..: $GEN_ACAO_GERAL <BR />";
				
	if($erro == "") {
		switch($GEN_ACAO_GERAL) {
		}
	}?>
</body></html>