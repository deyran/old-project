<html><head><?php
	include "../../includes/library/myLibrary.inc";
	//ini_set("display_errors", 0); 
	
	$erro      			 = "";
	$TIPO_ACAO 			  = "";
	$MENSAGEM_RETORNO = "Registro salvo com sucesso!!";
	
	$P01_ID        = "";
	$P01_DESCRICAO = "";
	$P01_NICK_NAME = "";
	$PA0_ID        = "";
	$SQL_COMMANDS  = "";
	
	$senhaAtual = "";
	$senhaNova  = "";
	
	if(isset($_POST["P01_ID"]))         $P01_ID         = $_POST["P01_ID"];
	if(isset($_POST["GEN_ACAO_GERAL"])) $GEN_ACAO_GERAL = $_POST["GEN_ACAO_GERAL"];?>
  
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css"><?php

	switch($GEN_ACAO_GERAL) {
		case "SELECT_USUARIOS"://__[
			break;
		//]
		case "SALVAR_USUARIOS"://__[
			if(isset($_POST["P01_ID"]))            $P01_ID            = $_POST["P01_ID"];
			if(isset($_POST["P01_DESCRICAO"]))     $P01_DESCRICAO     = $_POST["P01_DESCRICAO"];
			if(isset($_POST["PA0_ID"]))            $PA0_ID            = $_POST["PA0_ID"];
			if(isset($_POST["P01_NICK_NAME"]))     $P01_NICK_NAME     = $_POST["P01_NICK_NAME"];			
			if(isset($_POST["P01_NICK_NAME_OLD"])) $P01_NICK_NAME_OLD = $_POST["P01_NICK_NAME_OLD"];
			
			if(trim($P01_DESCRICAO) == $FW_V2_null) $P01_DESCRICAO = "";
			if(trim($P01_NICK_NAME) == $FW_V2_null) $P01_NICK_NAME = "";
			
			if(strlen(trim($P01_DESCRICAO)) == 0) $erro = "Você deve informar o <strong>Nome da pessoa</strong>!!";
			if((strlen(trim($P01_NICK_NAME)) == 0) && (strlen(trim($erro)) == 0)) $erro = "Você deve informar o <strong>Usuário</strong>!!";
			
			if($erro == "") {
				$VERIFICAR_NICK_NAME = false;
				
				if(strlen(trim($P01_ID)) == 0) {
					$VERIFICAR_NICK_NAME = true;
					
				} elseif(strlen(trim($P01_ID)) > 0) {
					if(trim($P01_NICK_NAME) != trim($P01_NICK_NAME_OLD)) $VERIFICAR_NICK_NAME = true;
					
				}
				
				if($VERIFICAR_NICK_NAME == true) {
					$NICK_QT = 0;
					
					$SQL_QUERY_GEN_AUX = "
					SELECT COUNT(*) NICK_QT
					FROM P01_PESSOA_USUARIO AS P
					WHERE P.P01_NICK_NAME = '$P01_NICK_NAME'";
					
					$CONECTAR_DB  = FW_conctarDB();
					$SQL_QUERY    = $SQL_QUERY_GEN_AUX;
					$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
					$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
					$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
					
					if($NUM_LINES_DB > 0) {
						while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
							$NICK_QT = $DADOS_ROW[0];
						}
					}
					
					if(((int)$NICK_QT) > 0) $erro = "O nome de usuário  <strong>$P01_NICK_NAME</strong> já existe!";
					
					FW_desconctarDB($CONECTAR_DB);				
				}
				
			}
			
			break;
		//]
		case "UPDATE_SENHA"://_____[
			if(isset($_POST["senhaAtual"]))$senhaAtual = $_POST["senhaAtual"];
			if(isset($_POST["senhaNova"])) $senhaNova  = $_POST["senhaNova"];
			
			if(strlen(trim($senhaAtual)) == 0) 
				$erro = "Você deve informar a <strong>Senha atual</strong>!!";
				
			if((strlen(trim($senhaNova)) == 0) && (strlen(trim($erro)) == 0)) 
				$erro = "Você deve informar a <strong>Senha nova</strong>!!";
			
			if((trim($senhaAtual) != trim($senhaNova)) && (strlen(trim($erro)) == 0)) 
				$erro = "A <strong>Senha atual</strong> deve ser igual a <strong>Senha nova</strong>!!";
				
			if((strlen(trim($senhaAtual)) < 6) && (strlen(trim($erro)) == 0)) 
				$erro = "A <strong>Senha</strong> deve ter <strong>6 caracteres</strong> no mínimo!";

		
			break;
		//]
	}
	
	if($erro == "") {
		switch($GEN_ACAO_GERAL) {
			case "SELECT_USUARIOS"://__[
			break;
		//]
			case "SALVAR_USUARIOS"://__[
				$CONECTAR_DB  = FW_conctarDB();
				
				if(strlen(trim($P01_ID)) == 0) {
					$TIPO_ACAO = "INSERT";
					
					$SQL_QUERY    = "SELECT (MAX(E.P01_ID) + 1) AS ID FROM P01_PESSOA AS E";
					$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
					$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
					$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
					
					if($NUM_LINES_DB > 0) {
						while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
							$P01_ID = $DADOS_ROW[0];
						}
					}
					
					$SQL_COMMANDS = "
					INSERT INTO P01_PESSOA (P01_ID, P01_DESCRICAO, P01_EMISSOR)
					VALUES (" . FW_trataCaractere($P01_ID , "N")        . ",".
											FW_trataCaractere($P01_DESCRICAO , "T") . ",".
											FW_trataCaractere($GEN_ID , "N")        . ")";
					
					FW_sqlExec($SQL_COMMANDS, $CONECTAR_DB);
					//----------------------------------------------------------------------------------------------------
					
					$P01_USER_PASS = "123456";
					
					$SQL_COMMANDS  = "
					INSERT INTO P01_PESSOA_USUARIO (
						P01_ID, P01_NICK_NAME, 
						PA0_ID, P01_USER_PASS, xxxx)
						
					VALUES (" . FW_trataCaractere($P01_ID       , "N") . ", " . 
											FW_trataCaractere($P01_NICK_NAME, "T") . ", " . 
											FW_trataCaractere($PA0_ID       , "N") . ", " . 
											FW_trataCaractere($P01_USER_PASS, "P") . ", " . 
											FW_trataCaractere($P01_USER_PASS, "T") . ") ";
											
					//echo "<br />" . $SQL_COMMANDS . "<br /><br />";
											
					FW_sqlExec($SQL_COMMANDS, $CONECTAR_DB);
				}
				else {
					$TIPO_ACAO = "UPDATE";
					
					$SQL_COMMANDS  = "
					UPDATE P01_PESSOA SET 
						P01_DESCRICAO = " . FW_trataCaractere($P01_DESCRICAO , "T") . " 
					WHERE P01_ID = $P01_ID";
					
					FW_sqlExec($SQL_COMMANDS, $CONECTAR_DB);
					//----------------------------------------------------------------------------------------------------				
					
					$SQL_COMMANDS  = "
					UPDATE P01_PESSOA_USUARIO SET
						P01_NICK_NAME = " . FW_trataCaractere($P01_NICK_NAME, "T") . ",
						PA0_ID  = "       . FW_trataCaractere($PA0_ID       , "N") . "
					WHERE	P01_ID = $P01_ID ";
											
					FW_sqlExec($SQL_COMMANDS, $CONECTAR_DB);
					
				}
				
				FW_desconctarDB($CONECTAR_DB);
				
				break;
			//]
			case "UPDATE_SENHA"://_____[
				$CONECTAR_DB  = FW_conctarDB();
				
				$SQL_COMMANDS = "
				UPDATE P01_PESSOA_USUARIO AS P SET
					P.P01_USER_PASS = " . FW_trataCaractere($senhaNova, "P") . ",
					P.xxxx          = " . FW_trataCaractere($senhaNova, "T") . "
				WHERE P.P01_ID = $P01_ID ";
				
				echo $SQL_COMMANDS;
				
				FW_sqlExec($SQL_COMMANDS, $CONECTAR_DB);
				FW_desconctarDB($CONECTAR_DB);
				
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
          case "SELECT_USUARIOS"://__[
            break;
          //]
          case "SALVAR_USUARIOS"://__[?>
            parent.toggleEditButtons();<?php
            
            break;
          //]
          case "UPDATE_SENHA"://_____[?>
            parent.toggleEditButtons();<?php
            
            break;
          //]
        }
        
      } else { 
        switch($GEN_ACAO_GERAL) {
          case "SELECT_USUARIOS"://__[?>
            parent.document.getElementById("DIV_CONTEUDO_GRID").innerHTML = 
                   document.getElementById("DIV_CONTEUDO_GRID").innerHTML; <?php
						
						$GRID_USER_SELECTED = "";
						if(isset($_POST["GRID_USER_SELECTED"])) $GRID_USER_SELECTED = $_POST["GRID_USER_SELECTED"];
						
						if(strlen(trim($GRID_USER_SELECTED)) > 0) {?>
							try {
								parent.FW_setFonteStyleDado("<?php echo $GRID_USER_SELECTED;?>");
							} catch(e){}<?php
						}
									 
            break;
          //]
          case "SALVAR_USUARIOS"://__[?>
            parent.setReloadListOut();<?php
            
            if($TIPO_ACAO == "INSERT")       {?>
              parent.relaodPage("<?php echo $P01_ID;?>", "<?php echo $MENSAGEM_RETORNO;?>");<?php
              
            } elseif($TIPO_ACAO == "UPDATE") {?>
							parent.toggleEditButtons();						
              parent.document.getElementById("P01_NICK_NAME_OLD").value = "<?php echo $P01_NICK_NAME;?>";
              parent.newAlert("<span style='font-size: 18px'><?php echo $MENSAGEM_RETORNO?></span>", "", "");<?php
              
            }
            
            break;
          //]
          case "UPDATE_SENHA"://_____[?>
            parent.newAlert("<span style='font-size: 18px'><?php echo $MENSAGEM_RETORNO?></span>", "", "");
            parent.toggleEditButtons();<?php
            
            break;
          //]
        }
        
      }?>
    }
  </script>
  
</head><body onLoad="start();" style="font-family:'Courier New', Courier, monospace; background-color: #FFF;"><?php
	echo "DATA E HORA.....: usuariosHidden.php " . date("d/m/Y H:i:s ") . "<BR />
				GEN_ACAO_GERAL..: $GEN_ACAO_GERAL<BR />
				P01_ID..........: $P01_ID<BR />
				GEN_ID..........: $GEN_ID<BR />";
				
	if($erro == "") {
		switch($GEN_ACAO_GERAL) {
			case "SELECT_USUARIOS"://__[?>
				<div id="DIV_CONTEUDO_GRID"><div align="center"><?php
					$GRID_ID = "P01_GRID_USUARIOS";
					
					$FATOR_WIDTH = 25;
					$GRID_WIDTH  = $GEN_DOC_WIDTH - 70;
					$USER_WIDTH  = (($GRID_WIDTH * $FATOR_WIDTH) / 100);
					$NICK_WIDTH  = (($GRID_WIDTH * $FATOR_WIDTH) / 100);
					$STAT_WIDTH  = (($GRID_WIDTH * $FATOR_WIDTH) / 100);
					$EMIS_WIDTH  = (($GRID_WIDTH * $FATOR_WIDTH) / 100);
					
					$SQL_QUERY = "
					SELECT 
						 P.P01_ID        AS GEN_GRID_ID,
						 D.P01_DESCRICAO AS GEN_GRID_NOME,
						 P.P01_NICK_NAME AS GEN_GRID_NICK,
						 U.PA0_DESCRICAO AS GEN_GRID_TIPO,
						 E.P01_DESCRICAO AS GEN_GRID_EMISSOR
						 
					FROM P01_PESSOA_USUARIO AS P 
							 INNER JOIN P01_PESSOA 		   AS D ON P.P01_ID = D.P01_ID
							 INNER JOIN P01_PESSOA 		   AS E ON E.P01_ID = D.P01_EMISSOR
							 INNER JOIN PA0_USUARIO_STATUS AS U ON P.PA0_ID = U.PA0_ID
							 
					ORDER BY GEN_GRID_NOME ";
					
					//echo $SQL_QUERY;
					
					$camposGrid = "
					<strong>Nome</strong>-$USER_WIDTH-GEN_GRID_NOME-left|
					<strong>Usu&aacute;rio</strong>-$NICK_WIDTH-GEN_GRID_NICK-left|
					<strong>Situa&ccedil;&atilde;o</strong>-$STAT_WIDTH-GEN_GRID_TIPO-center|
					<strong>Emissor</strong>-$EMIS_WIDTH-GEN_GRID_EMISSOR-left";
					
					$acaoGrid = "
					ativarFormModal('[FW_ID_VALUE]')-../../imagens/nodes/edit.gif-Clique para editar registro|";	
					
					$GRID_HEIGHT = (((int)$GEN_DOC_HEIGHT * 75) / 100);
					
					$GRID_PARAM["GRID_CHECKBOX"]    = false;
					$GRID_PARAM["GRID_ID"]          = $GRID_ID;
					$GRID_PARAM["GRID_FUNCTIONS"]   = $acaoGrid;
					$GRID_PARAM["GRID_CAMPOS"]      = $camposGrid;
					$GRID_PARAM["GRID_HEIGHT"]      = $GRID_HEIGHT;
					$GRID_PARAM["GRID_FORM_ID"]     = "formGrid";
					$GRID_PARAM["GRID_PAGE_HIDDEN"] = "usuariosHidden.php";
					$GRID_PARAM["GRID_NUM_LINES"]   = "30";
					$GRID_PARAM["GRID_PRINT_QUERY"] = "PRINT";
	
					FW_makeGrid($SQL_QUERY, $GRID_PARAM);?>
            
				</div></div><?php
				
				break;
			//]
		}
	}?>
</body></html>