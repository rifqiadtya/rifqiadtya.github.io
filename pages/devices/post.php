<?php
include "koneksi.php";
if(isset($_POST["post_id"]))
{
 $output = '';
 $query = "SELECT * FROM devices WHERE id_devices = '".$_POST["post_id"]."'";
 $result = mysql_query($query);
 while($row = mysql_fetch_array($result))
 {

  $output .= '<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">ID : '.$row['id_devices'].'</h4>
        </div>
        <div class="modal-body">
        <label>Data</label>
        <table class="table table-bordered">
        <tbody>
        <tr>
        <td width="30%">NIS</td><td width="50px">:</td><td>'.$row['id_devices'].'</td>
        </tr>
        <tr>
        <td>ipaddress</td><td>:</td><td>'.$row['ipaddress'].'</td>
        </tr>
        <tr>
        <td>Group</td><td>:</td><td>'.$row['group_id'].'</td>
        </tr>

        <tr>
        <td>Lastping</td><td>:</td><td>'.$row['lastping'].'></td>
        </tr>
        </tbody>
        </table>
        ';
  $query_1 = "SELECT id_devices FROM devices WHERE id_devices < '".$_POST['post_id']."' ORDER BY id_devices DESC LIMIT 1";
  $result_1 = mysql_query($query_1);
  $data_1 = mysql_fetch_array($result_1);
  $query_2 = "SELECT id_devices FROM devices WHERE id_devices > '".$_POST['post_id']."' ORDER BY id_devices ASC LIMIT 1";
  $result_2 = mysql_query($query_2);
  $data_2 = mysql_fetch_array($result_2);
  $if_previous_disable = '';
  $if_next_disable = '';
  if($data_1["id_devices"] == "")
  {
   $if_previous_disable = 'disabled';
  }
  if($data_2["id_devices"] == "")
  {
   $if_next_disable = 'disabled';
  }
  $output .= '
  <div align="center">
   <button type="button" name="previous" class="btn btn-default btn-sm previous" style="float:left;" id="'.$data_1['id_devices'].'" '.$if_previous_disable.'><i class="ti ti-arrow-left"></i> Sebelumnya</button>
   <button type="button" name="next" class="btn btn-default btn-sm next" style="float:right;" id="'.$data_2['id_devices'].'" '.$if_next_disable.'>Selanjutnya <i class="ti ti-arrow-right"></i></button>
  </div>
  <br /><br /></div>
  ';
 }
 echo $output;
}

?>
