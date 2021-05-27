<?php include 'koneksi.php' ?>
 
<h1>Menampilkan Database devices</h1>
 
<p>Menampilkan isi database devices </p>
 
<a href="?act=devices">Input Data devices Baru</a><br>
 
<div class="table-responsive">

  <table class="table table-bordered table-striped table-hover">
  
  <tr>
    <th>ID Devices</th>
    <th>Nama</th>
    <th>IP Address</th>
    <th>Status</th>
    <th>Group</th>
    <th>Lastping</th>
  </tr>
    
  <?php
    
  
  $query ="select * from devices";
  $hasil = mysqli_query($koneksi, $query);
    
  while($data = mysqli_fetch_array($hasil))
  {
    
    echo "<tr>";
    echo "<td>$data[id_devices]</td>";
    echo "<td>$data[name]</td>";
    echo "<td>$data[ipaddress]</td>";
    echo "<td>$data[status]</td>";
    echo "<td>$data[group_id]</td>";
    echo "<td>$data[lastping]</td>";
    echo "</tr>";
  }
  ?>
    </table>

</div>