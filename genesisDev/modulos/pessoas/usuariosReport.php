<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html><head><?php
  include "../../includes/library/myLibrary.inc";
	
	session_start();
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
  
	<script type="text/javascript" src="../../includes/js/FW_v2.js" charset="utf-8"></script>
	<script type="text/javascript" src="../../includes/js/makeGrid.js" charset="utf-8"></script>
  

  <style type="text/css">
		body {
			background-color: #FFF;
		}
	</style>
  
</head><body><br />   
  <h3 align="center" class="semMargPadd">
    L&nbsp;I&nbsp;S&nbsp;T&nbsp;A&nbsp;&nbsp;
    D&nbsp;E&nbsp;&nbsp;
    U&nbsp;S&nbsp;U&nbsp;&Aacute;&nbsp;R&nbsp;I&nbsp;O&nbsp;S
  </h3>
  <div align="center">
    <div style="width: 210mm; font-family:'Courier New', Courier, monospace">
      <table border="0" cellspacing="0" cellpadding="0" width="100%">
        <tbody>
        <tr><td valign="top"><?php
          $TITULO_PRINT     = $_POST["GRID_TITULO_PRINT_REPORT"];
          $SQL_QUERY_REPORT = $_POST["GRID_SQL_QUERY_REPORT"];?>
          
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr><td colspan="7">
              <div style="border-bottom: 1px solid #EEE; margin-bottom: 5px;">&nbsp;</div>
            </td></tr><?php
            
            $TITULO_PRINT_ARRAY = explode("|", $TITULO_PRINT);?>
            
            <tr><?php
            $STYLE_AUX = "color: #000; font-size: 14px";
            for($i = 0; $i < count($TITULO_PRINT_ARRAY); $i++) {?>
              <td style=" <?php echo $STYLE_AUX;?>" align="center"><?php 
                $TITULO_PRINT = str_replace("<strong>" , "", $TITULO_PRINT_ARRAY[$i]);
                $TITULO_PRINT = str_replace("</strong>", "", $TITULO_PRINT);
                
                echo $TITULO_PRINT;?>
              </td><?php
            }?>
            </tr>
            <tr><td colspan="7">
              <div style="border-top: 1px solid #EEE; margin-top: 5px"></div>
            </td></tr><?php 
            
            $CONECTAR_DB  = FW_conctarDB();
            $SQL_QUERY    = $SQL_QUERY_REPORT;
            $RESULT_DB    = mysqli_query($CONECTAR_DB, $SQL_QUERY);
            $RESULT_DB    = $CONECTAR_DB->query($SQL_QUERY);
            $NUM_LINES_DB = mysqli_affected_rows($CONECTAR_DB);
            
            if($NUM_LINES_DB > 0) {
              $styleAux = " style='font-size: 14px'";	
              while($DADOS_ROW = mysqli_fetch_array($RESULT_DB, MYSQLI_NUM)){?>
                <tr onmousemove="this.className = 'tdNoticia'" onmouseout="this.className = ''"><?php
                  $BORDER_RIGHT = "border-right: 1px solid #EEE; ";
                  
                  for($i = 1; $i < 5; $i++) {
                    if($i > 3) $BORDER_RIGHT = "";?>
                    
                    <td valign="top" style="padding-left: 5px;">
                      <div style=" <?php echo $BORDER_RIGHT;?> font-size: 14px; text-align: justify">
                       <?php echo $DADOS_ROW[$i];?>
                      </div>            
                    </td><?php
                    
                  }?>
                  
                </tr><?php
              }
            }?>
            
            <tfoot>
              <tr><td colspan="7">
                <div style="border-top: 1px solid #EEE;"></div>
              </td></tr>
            
              <tr><td valign="top" colspan="7">
                <div align="right" style="color: #000; margin-top: 7px; font-size: 12px">G&ecirc;nesis 1.0&nbsp;</div>
              </td></tr>
            </tfoot><?php
            
            FW_desconctarDB($CONECTAR_DB);?>
          </table>
        </td></tr>
        </tbody>
      </table>
      <br /><br />
    </div>
  </div>      
  
</body></html>