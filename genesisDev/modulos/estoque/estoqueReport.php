<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
	include "../../includes/library/myLibrary.inc";
	include "estoqueInc.inc";
	
	$_SESSION["SS_IN_MANUT"] = false;
	
	if($_SESSION["SS_IN_MANUT"] == false) {
		ini_set("display_errors", 0); 
	}?>

  <title>....::: Genesis :::....</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../../includes/css/gen_style.css">

	<link rel="stylesheet" type="text/css" href="../../includes/jquery-ui-1.11.4.custom/jquery-ui.css">
	<script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/external/jquery/jquery.js" charset="utf-8"></script>
  <script type="text/javascript" src="../../includes/jquery-ui-1.11.4.custom/jquery-ui.js" charset="utf-8"></script>
  
	<script type="text/javascript" src="../../includes/js/FW_v2.js"    charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/makeGrid.js" charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/notice.js"   charset="utf-8"></script>
  
  <style type="text/css">
		body {
					margin-left: 0px; 
					 margin-top: 0px; 
				 margin-right: 0px; 
				margin-bottom: 0px;
		 background-color: #FFF;
		}
		
	</style>
  
</head><body><br /> <?php 
	$GRID_SET_IDS = $_POST["GRID_SET_IDS"];
	if(strlen(trim($GRID_SET_IDS)) == 0) $GRID_SET_IDS = -1;
	//echo $GRID_SET_IDS;?>
  
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
        <div style="border-bottom: 1px solid #EEE; margin-bottom: 5px;">&nbsp;</div>
      </th></tr><?php
			$STYLE_AUX = "color: #000; font-size: 14px";?>
      
      <tr><td align="center" style=" <?php echo $STYLE_AUX;?>">
        Modelo
        
      </td><td align="center" style=" <?php echo $STYLE_AUX;?>">
        Tamanho
        
      </td><td align="center" style=" <?php echo $STYLE_AUX;?>">
        G&ecirc;nero
        
      </td><td align="center" style=" <?php echo $STYLE_AUX;?>">
        Qtd
        
      </td></tr>
      <tr><th colspan="6">
        <div style="border-bottom: 1px solid #EEE; margin-top: 5px"></div>
      </th></tr>
      </thead><?php 
      
      $CONECTAR_DB  = FW_conctarDB();
      $E01_ID_F_AUX = $_REQUEST["E01_ID_F_AUX"];

      $SQL_QUERY    = "
			SELECT O.E01_MODELO 	 AS E01_GRID_ESTOQUE_MODELO, 
						 O.E01_TAMANHO 	 AS E01_GRID_ESTOQUE_TAMANHO, 
						 T.EA1_DESCRICAO AS E01_GRID_ESTOQUE_TIPO, 
						 G.EA0_DESCRICAO AS E01_GRID_ESTOQUE_GENERO, 
						 O.E01_QTD       AS E01_GRID_ESTOQUE_QTD
								 
			FROM E01_OCULOS O 
					 INNER JOIN EA1_TIPO_ARMACAO AS T ON O.EA1_ID = T.EA1_ID 
					 INNER JOIN EA0_GENERO       AS G ON O.EA0_ID = G.EA0_ID 
			
			WHERE O.E01_ID IN ($GRID_SET_IDS)
			
			ORDER BY E01_GRID_ESTOQUE_TIPO, 
							 E01_GRID_ESTOQUE_GENERO ";
      
      //echo $SQL_QUERY;
              
      $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
      $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
      $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
      
      if($NUM_LINES_DB > 0) {
        $FIRST_TIME_AUX   = true;
				$ESTOQUE_TIPO_AUX = NULL;
        $ESTOQUE_MODELO   = NULL;
        $ESTOQUE_TAMANHO  = NULL;
        $ESTOQUE_TIPO     = NULL;
        $ESTOQUE_GENERO   = NULL;
        $ESTOQUE_QTD      = NULL;
        $QTD_SUM_TOTAL    = 0;
        
        while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){
          $ESTOQUE_MODELO  = $DADOS_ROW[0];
          $ESTOQUE_TAMANHO = $DADOS_ROW[1];
          $ESTOQUE_TIPO    = $DADOS_ROW[2];
          $ESTOQUE_GENERO  = $DADOS_ROW[3];
          $ESTOQUE_QTD     = $DADOS_ROW[4];
					//--------------------------------------------------------------------------------------------------------
          
					if($ESTOQUE_TIPO_AUX != $ESTOQUE_TIPO) {
						if($FIRST_TIME_AUX == true) {
							$FIRST_TIME_AUX = false;
							
						} else {?>
              <tr><td colspan="5">
                <div align="right" style="color: #F90; font-size: 14px; margin: 4px; margin-right: 0px"><?php 
                  echo Total . ":&nbsp;&nbsp;&nbsp;" . FW_numeroEspacoMilhar($QTD_SUM_TOTAL);?>&nbsp;&nbsp;
                </div>
              </td></tr><?php
						}
						
						$QTD_SUM_TOTAL = 0;?>
            
            <tr><td colspan="5">
              <div style="color: #F90; font-size: 14px; margin: 4px; margin-right: 0px; ">
                <?php echo $ESTOQUE_TIPO;?>
              </div>
            </td></tr><?php
										
					}
					
					$ESTOQUE_TIPO_AUX = $ESTOQUE_TIPO;
					$QTD_SUM_TOTAL = $QTD_SUM_TOTAL + $ESTOQUE_QTD;
          //--------------------------------------------------------------------------------------------------------?>
          
         	<tr onmousemove="this.className = 'tdNoticia'" onmouseout="this.className = ''">
            <td valign="top" style=" padding-left: 20px;">
              <div style="border-bottom: 1px solid #EEE; font-size:14px">
                <?php echo $ESTOQUE_MODELO;?>&nbsp;
              </div>
            </td>
            <td valign="top">
              <div align="right" style="border-bottom: 1px solid #EEE; font-size: 14px">
                <?php echo str_replace(".", ",", $ESTOQUE_TAMANHO);?>&nbsp;&nbsp;
              </div>
            </td>
            <td valign="top">
              <div style="border-bottom: 1px solid #EEE; font-size:14px">
                <?php echo "&nbsp;&nbsp;" . $ESTOQUE_GENERO;?>
              </div>
            </td>
            <td valign="top" style=" padding-right: 10px;">
              <div align="right" style="border-bottom: 1px solid #EEE; font-size: 14px">
                <?php echo FW_numeroEspacoMilhar($ESTOQUE_QTD);?>
              </div>
            </td>
          </tr><?php
          
        }?>
        
        <tr><td colspan="5" style=" padding-right: 10px;">
          <div align="right" style="color: #F90; font-size: 14px; margin: 4px; margin-right: 0px"><?php 
            echo Total . ":&nbsp;&nbsp;&nbsp;" . FW_numeroEspacoMilhar($QTD_SUM_TOTAL);?>
          </div>
        </td></tr><?php

      }
      
      FW_desconctarDB($CONECTAR_DB);?>
      </table>
      <br /><br />
    </div>
  </div>
  
</body></html>