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
  
</head><body><br />   
  <h3 align="center" class="semMargPadd">
    M&nbsp;O&nbsp;V&nbsp;I&nbsp;M&nbsp;E&nbsp;N&nbsp;T&nbsp;A&nbsp;&Ccedil;&nbsp;&Atilde;&nbsp;O 
    &nbsp;&nbsp;D&nbsp;E&nbsp;&nbsp;
    E&nbsp;S&nbsp;T&nbsp;O&nbsp;Q&nbsp;U&nbsp;E

  </h3>
  <div align="center">
    <div style="width: 210mm; font-family:'Courier New', Courier, monospace">
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <thead>
        <tr><td colspan="7">
          <div style="border-bottom: 1px solid #EEE; margin-bottom: 5px;">&nbsp;</div>
        </td></tr><?php
				$STYLE_AUX = "color: #000; font-size: 14px";?>
        <tr><td style=" <?php echo $STYLE_AUX;?>" align="center">
          Opera&ccedil;&atilde;o
          
        </td><td style=" <?php echo $STYLE_AUX;?>" align="center">
          Data
          
        </td><td style=" <?php echo $STYLE_AUX;?>" align="center">
          De
          
        </td><td style=" <?php echo $STYLE_AUX;?>" align="center">
          Para
          
        </td><td style=" <?php echo $STYLE_AUX;?>" align="center">
          Diferen&ccedil;a
          
        </td><td style=" <?php echo $STYLE_AUX;?>" align="center">
          Emissor
          
        </td><td style=" <?php echo $STYLE_AUX;?>" align="center">
          Emiss&atilde;o
          
        </td></tr>
        <tr><td colspan="7">
          <div style="border-top: 1px solid #EEE; margin-top: 5px"></div>
        </td></tr>
        </thead><?php

				$GRID_SQL_QUERY = $_POST["GRID_SQL_QUERY"];
				
				$CONECTAR_DB  = FW_conctarDB();
				$SQL_QUERY    = $GRID_SQL_QUERY;
				$RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
				$RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
				$NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
				
				if($NUM_LINES_DB > 0) {
					$ALIGN_AUX = array("", "left", "right", "right", "right", "right", "left", "right");

					while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){?>
						<tr onmousemove="this.className = 'tdNoticia'" onmouseout="this.className = ''"><?php
							$BORDER_RIGHT = "border-right: 1px solid #EEE; ";
							
							for($i = 1; $i < 8; $i++) {
								if($i > 6) $BORDER_RIGHT = "";?>
                
								<td valign="top" align="<?php echo $ALIGN_AUX[$i];?>">
                  <div style=" <?php echo $BORDER_RIGHT;?> font-size: 14px"><?php
										if((($i == 3) || ($i == 4) || ($i == 5))) {
											echo "&nbsp;" . FW_numeroEspacoMilhar($DADOS_ROW[$i]) . "&nbsp;";
											
										} else {
											echo "&nbsp;" . $DADOS_ROW[$i] . "&nbsp;";
											
										}?>
                  </div>
								</td><?php
							}?>
            </tr><?php
						
					}
				}
				
				FW_desconctarDB($CONECTAR_DB);?>
        
        <tfoot>
          <tr><td colspan="7">
	          <div style="border-top: 1px solid #EEE;"></div>
          </td></tr>
        
          <tr><td valign="top" colspan="7">
	          <div align="right" style="color: #000; margin-top: 7px; font-size: 12px">G&ecirc;nesis 1.0&nbsp;</div>
          </td></tr>
        </tfoot>        
      </table>
      <br /><br />
    </div>
  </div>
  
</body></html>