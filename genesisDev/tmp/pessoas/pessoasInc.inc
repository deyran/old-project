<?php
	function makeFiltroGrupo() {?>
    <div id="DIV_CONTEUDO_FILTRO_GRUPO" class="DIV_CONTEUDO_FORM" style="display: block;"><?php 
      $sqlAux = "";
      $A05_ID_FILTRO = $_POST["A05_ID_FILTRO"];
      
      if($A05_ID_FILTRO != "") {
        $A05_ID_FILTRO = implode(",", $A05_ID_FILTRO);
        $sqlAux = "WHERE G.A05_ID NOT IN ($A05_ID_FILTRO) ";
      }
              
      $OPTIONS = "<option></option>";
      
      $CONECTAR_DB  = FW_conctarDB();
      $SQL_QUERY    = "
      SELECT G.* 
      FROM A05_GRUPO AS G 
      $sqlAux
      ORDER BY G.A05_DESCRICAO";
        
      $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
      $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
      $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
      
      if($NUM_LINES_DB > 0) {
        while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
          $OPTIONS = "$OPTIONS <option value='$DADOS_ROW[0]'>$DADOS_ROW[1]</option>";
        }
      }
      
      FW_desconctarDB($CONECTAR_DB);
      
      FW_V2_componenteHtml(
        array(
          "FW_V2_CSSTITULO"  => "font-size: 15px;",
          "FW_V2_TITULO"     => "Grupo de pessoas",
          "FW_V2_IDCOMP"     => "A05_ID_FILTRO",
          "FW_V2_NOMECOMP"   => "A05_ID_FILTRO[]",
          "FW_V2_TIPOCOM"    => "SELECT",
          "FW_V2_CSS"        => "width: 100%",
          "FW_V2_FUNCBLUR"   => "selectFiltroGrupo()",
          "FW_V2_OPTIONLIST" => rawurlencode($OPTIONS),
          "FW_V2_DICA"       => "&raquo;CLIQUE AQUI PARA SELECIONAR",
        )
      );?>
      
      <div id="DIV_CONTEUDO_FILTRO_GRUPO_AGUARDE"></div><br />
    </div><?php	
	}
?>