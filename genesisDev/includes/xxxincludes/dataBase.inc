<?php
function conctarDB() {
	$password = "";	
	$userName = "root";
	$dataBase = "exodowebdb";
	$hostName = "localhost";

	$conexao = new mysqli($hostName, $userName, $password, $dataBase);
	$conexao->set_charset("utf8");

	if($conexao->connect_error) {
		$conectarDB = false;
		die("Connect Error (" . $conexao->connect_errno . ") "
				. $conexao->connect_error);
	}

	return $conexao;
}

function desconctarDB($pConexao) {
	$pConexao->close();
}

//$result = $pCon->query($pSqlQuery);
//while($row = $result->fetch_assoc()){
//	echo $row[1] . '<br />';
//}

/**
 * Por Leandro Vieira Pinho
 * http://leandro.w3invent.com.br
 **/
function converterData($strData) {
	// Recebemos a data no formato: dd/mm/aaaa
	// Convertemos a data para o formato: aaaa-mm-dd
	if ( preg_match("#/#",$strData) == 1 ) {
			$strDataFinal = "'";
			$strDataFinal .= implode('-', array_reverse(explode('/',$strData)));
			$strDataFinal .= "'";
	}
	return $strDataFinal;
}	?>