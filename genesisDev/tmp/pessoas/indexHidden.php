<html><head><?php
include "../../includes/library/myLibrary.inc";?>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" /><?php

switch($GEN_ACAO_GERAL) {
	case "MAKE_FILTRO"://__[
		$A05_ID_FILTRO = $_REQUEST["A05_ID_FILTRO"];//implode(",", $_POST["A05_ID_FILTRO"]);
		break;
	//]
}?>
  
<script type="text/javascript" charset="utf-8">
	function start() {<?php
		if($erro <> "") {?>
			alert("<?php echo $erro?>");<?php
			
		} else {
			switch($GEN_ACAO_GERAL) {
				case "MAKE_FILTRO"://__[
					break;
				//]
			}
			
		}?>
	}
</script>
  
</head><body onload="start();" style="font-family:'Courier New', Courier, monospace"><?php
echo "GEN_ACAO_GERAL..: $GEN_ACAO_GERAL<BR />";
echo "A05_ID_FILTRO...: $A05_ID_FILTRO<BR />";

if($erro == "") {
	switch($GEN_ACAO_GERAL) {
		case "MAKE_FILTRO"://__[
			break;
		//]
	}
}?>
</body></html>