<html><head><?php
include "../../includes/library/myLibrary.inc";
include "pessoasInc.inc";	?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><?php

$GEN_DOC_HEIGHT = $_POST["GEN_DOC_HEIGHT"];

switch($GEN_ACAO_GERAL) {
	case "FILTRO_FORM"://________[
		break;
	//]
	case "MAKE_GRID"://__________[
		break;
	//]	
	case "MAKE_FILTRO_GRUPO"://__[

		break;
	//]
}?>
  
<script type="text/javascript" charset="utf-8">
	function start() {<?php
		if($erro <> "") {?>
			alert("<?php echo $erro?>");<?php
			
		} else {
			switch($GEN_ACAO_GERAL) {
				case "FILTRO_FORM"://________[?>
					parent.setFiltroModal(document.getElementById("DIV_FORM_MODAL").innerHTML); <?php
					
					break;
				//]	
				case "MAKE_GRID"://__________[?>
					parent.document.getElementById("DIV_CONTEUDO_GRID").innerHTML = 
					       document.getElementById("DIV_CONTEUDO_GRID").innerHTML;<?php
								 
					break;
				//]	
				case "MAKE_FILTRO_GRUPO"://__[?>
					parent.document.getElementById("DIV_CONTEUDO_FILTRO_GRUPO").innerHTML = 
					       document.getElementById("DIV_CONTEUDO_FILTRO_GRUPO").innerHTML;

					parent.document.getElementById("DIV_CONTEUDO_ITENS").innerHTML = 
					       document.getElementById("DIV_CONTEUDO_ITENS").innerHTML;<?php
								 
					break;
				//]
			}
			
		}?>
	}
</script>
  
</head><body onLoad="start();" style="font-family:'Courier New', Courier, monospace"><?php
echo "GEN_ACAO_GERAL..: $GEN_ACAO_GERAL<BR />
      GEN_DOC_HEIGHT..: $GEN_DOC_HEIGHT<BR />";

if($erro == "") {
	switch($GEN_ACAO_GERAL) {
		case "FILTRO_FORM"://________[?>
			<div id="DIV_FORM_MODAL">
        <table border="0" cellspacing="0" cellpadding="5">
        <tr><td id="TD_FORM_MODAL_OPC_LEFT" valign="top">
          <div id="DIV_FORM_MODAL_OPC">
            <h3>Grupo de pessoas</h3>
            <div class="DIV_FORM_MODAL_OPC_CLASS">
            <div style="overflow: auto; height: <?php echo ($GEN_DOC_HEIGHT - 500);?>px"><?php 
							$CONECTAR_DB  = FW_conctarDB();
							$SQL_QUERY    = "
							SELECT G.* 
							FROM A05_GRUPO AS G 
							ORDER BY G.A05_DESCRICAO";
								
							$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
							$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
							$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
							
							if($NUM_LINES_DB > 0) {
								while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
									$ID_AUX = 
									"DIV_GRUPO_FILTRO_LABEL_" . $DADOS_ROW[0] . "|" . 
									"GEN_CELULA_FILTRO_01"    . "|" . 
									"A05_ID_FILTRO"           . "|" .									
									$DADOS_ROW[0]        		  . "|" . 
									$DADOS_ROW[1]        		  . "|" .
									"DIV_GRUPO_LABEL_"        . $DADOS_ROW[0];?>
                  
                	<div id="DIV_GRUPO_LABEL_<?php echo $DADOS_ROW[0];?>" class="GEN_CELULA_FILTRO_01" 
                  onclick="setFiltroContent('<?php echo $ID_AUX;?>');">
										<?php echo $DADOS_ROW[1];?>
                  </div><?php
								}
							}
							
							FW_desconctarDB($CONECTAR_DB);?>
            </div></div>
            
            <h3>Section 2</h3>
            <div class="DIV_FORM_MODAL_OPC_CLASS">Section 2</div>
            
            <h3>Section 3</h3>
            <div class="DIV_FORM_MODAL_OPC_CLASS">Section 3</div>
            
          </div>
        
        </td><td id="TD_FORM_MODAL_OPC_RIGHT" valign="top">
        	<div id="DIV_FORM_MODAL_OPC_CONTENT" style="padding-left: 10px"></div>
        </td></tr>
        </table>

        <div id="DIV_MODELO_LABEL" style="display: none; ">
          <div class="__CLASS__ __ID_FILTRO_LABEL__" style="float: left;">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr><td valign="top" style="color: #000">
              __DESCRICAO__
              <input type="hidden" name="__NAME__[]" value="__ID__" />
            
            </td><td width="5%" valign="top" style="padding-left: 2px">
              <div style="color: red; cursor: pointer" onClick="$('.__ID_FILTRO_LABEL__').remove(); $('#__ID_LABEL__').show();">
                X
              </div>
            
            </td></tr>
            </table>
          </div>
        </div>

      </div><?php
			
			break;
		//]			
		case "MAKE_GRID"://__________[
			$A05_ID_FILTRO = implode(",", $_POST["A05_ID_FILTRO"]);?>
      
			<div id="DIV_CONTEUDO_GRID" class="DIV_CONTEUDO"><?php
				echo "A05_ID_FILTRO...: $A05_ID_FILTRO";?>
      </div><?php
			
			break;
		//]	
		case "MAKE_FILTRO_GRUPO"://__[
			makeFiltroGrupo();?>
			
			<div id="DIV_CONTEUDO_ITENS"><?php
				$A05_ID_FILTRO = $_POST["A05_ID_FILTRO"];
				if($A05_ID_FILTRO != "") {
					$A05_ID_FILTRO = implode(",", $A05_ID_FILTRO);
					
					$CONECTAR_DB  = FW_conctarDB();
					$SQL_QUERY    = "
						SELECT G.* 
						FROM A05_GRUPO AS G 
						WHERE G.A05_ID IN($A05_ID_FILTRO)
						ORDER BY G.A05_DESCRICAO";
					$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
					$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
					$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
					
					if($NUM_LINES_DB > 0) {
						while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
							$A05_ID        = $DADOS_ROW[0];
							$A05_DESCRICAO = $DADOS_ROW[1];?>
							
							<div id="DIV_GRUPO_<?php echo $A05_ID;?>" style="padding: 2.5px; margin: 2.5px; color: #CCC; background-color: #C4E1FF">
								<table border="0" cellspacing="0" cellpadding="0" width="100%">
								<tr><td valign="top"><?php
									echo $A05_DESCRICAO;?>
									<input type="hidden" name="A05_ID_FILTRO[]" value="<?php echo $A05_ID;?>" />
								
								</td><td width="5%" valign="top">
									<div style="color: red; cursor: pointer" onClick="$('#DIV_GRUPO_<?php echo $A05_ID;?>').remove();">
										X
									</div>
									
								</td></tr>
								</table>
							</div><?php            
						}
					}
	
					FW_desconctarDB($CONECTAR_DB);
					
				}?>
			</div><?php
			
			break;
		//]
	}
}?>
</body></html>