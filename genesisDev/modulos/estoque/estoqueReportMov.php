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
  
</head><body><?php
	$REPORT_MOV_CONTENT = $_POST["REPORT_MOV_CONTENT"];
	echo $REPORT_MOV_CONTENT;?>
  
</body></html>