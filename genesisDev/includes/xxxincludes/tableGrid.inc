<?php
//$sqlQuery = "SELECT * FROM a01_uf";
//$camposGrid = "Sigla-70|Descri&ccedil;&atilde;o-170";
//$acaoGrid = "functionA('[ID]')-edit.gif-Clique para editar|functionB('[ID]')-excluir.png-Clique para excluir";
//makeGrid($acaoGrid, $camposGrid, $sqlQuery)

function makeGrid($pAcaoGrid, $pCamposGrid, $pSqlQuery) {
	include "dataBase.inc";
	
	$pCon = conctarDB();?>
  <div style="padding: 10px">
    <table border="0" cellspacing="0" cellpadding="0">
    <tbody>
    <tr><td><?php
      if($pAcaoGrid <> "") {?>
        <table border="0" cellspacing="0" cellpadding="0">
        <tr><td valign="baseline">
          <input type="checkbox" id="checkSel" name="checkIdGrid" 
          class="checkIdGridClass" checked="checked" onclick="grid_check(); this.checked=true;" />
          
        </td><?php
          $gridAcao = explode("|", $pAcaoGrid);
          
          for($i = 0; $i < count($gridAcao); $i++) {
            $funcImg = explode("-", $gridAcao[$i]);
            $funcImg[0] = str_replace("[ID]", "", $funcImg[0]);?>
            
            <td nowrap="nowrap" valign="baseline" style="padding-left: 7px">
              <a href="javascript: void(0)" <?php if($funcImg[2] <> "") {echo "title='$funcImg[2]'";}?>
              onclick="<?php echo $funcImg[0];?>" style="text-decoration: none;">
                <img src="<?php $_SERVER["SERVER_NAME"];?>/images/<?php echo $funcImg[1];?>" width="16" height="16" />
              </a>
            </td><?php
          }
          
        ?></tr>
        </table><?php
        
      } elseif($pAcaoGrid == "") {?>
        <input type="checkbox" id="checkSel" name="checkIdGrid" 
        class="checkIdGridClass" checked="checked" onclick="grid_check(); this.checked=true;" /> <?php
        
      }?>
    
      <input type="hidden" class="checkSelVal" value="false" />
      
    </td><?php 
    
    $camposGrid = explode("|", $pCamposGrid);
    for($i = 0; $i < count($camposGrid); $i++) {
      $descSize = explode("-", $camposGrid[$i]);	?>
      <th nowrap="nowrap" style="width: <?php echo $descSize[1] . "px";?>"><?php 
        echo $descSize[0]?>
      </th><?php
    }?></tr>
    </tbody>
    
    <tr><td colspan="20"><div style="border-bottom: 1px solid #EFEFEF"></div></td></tr>
    
    <tbody><?php
      $result = mysqli_query($pCon, $pSqlQuery);
      $result = $pCon->query($pSqlQuery);
      
      $efeitoZebra = "par";
  
      while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        if($efeitoZebra == "par") {
          $efeitoZebra = "impar";
          
        } elseif($efeitoZebra == "impar") {
          $efeitoZebra = "par";
          
        }?>
        <tr class="<?php echo $efeitoZebra;?>" 
        onmousemove="this.className = 'trSelecionado'" 
        onmouseout="this.className = '<?php echo $efeitoZebra;?>'">
        <td><div style="border-right: 1px solid #EFEFEF; padding-right: 5px"><?php 
          //AÇÕES___[
          if($pAcaoGrid <> "") {?>
            <table border="0" cellspacing="0" cellpadding="0">
            <tr><td valign="baseline">
              <input type="checkbox" id="checkSel_<?php echo $row[0];?>" name="checkIdGrid" 
              class="checkIdGridClass" />
              
            </td><?php
              $gridAcao = explode("|", $pAcaoGrid);
              
              for($i = 0; $i < count($gridAcao); $i++) {
                $funcImg = explode("-", $gridAcao[$i]);
                $funcImg[0] = str_replace("[ID]", $row[0], $funcImg[0]);?>
                
                <td nowrap="nowrap" valign="baseline" style="padding-left: 7px">
                  <a href="javascript: void(0)" <?php if($funcImg[2] <> "") {echo "title='$funcImg[2]'";}?>
                  onclick="<?php echo $funcImg[0];?>" style="text-decoration: none;">
                    <img src="<?php $_SERVER["SERVER_NAME"];?>/images/<?php echo $funcImg[1];?>" width="17" />
                  </a>
                </td><?php
              }
              
            ?></tr>
            </table><?php
            
          } elseif($pAcaoGrid == "") {?>
            <input type="checkbox" id="checkSel_<?php echo $row[0];?>" name="checkIdGrid" 
            class="checkIdGridClass" /> <?php
            
          }//]?>
          
        </div></td><?php 
          //CAMPOS__[
          for($i = 1; $i < count($row); $i++) {?>
            <td nowrap="nowrap" style="padding-left: 5px;">
              <div style="border-right: 1px solid #EFEFEF"><?php echo $row[$i] . "&nbsp;&nbsp;";?></div>
            </td><?php
          }
          //]?>
          
        </tr><?php
        
      }?>
    </tbody>
    
    <tr><td colspan="20"><div style="border-bottom: 1px solid #EFEFEF"></div></td></tr>
    </table>
  </div><?php
	
	$result->close();
	desconctarDB();
	
}?>
