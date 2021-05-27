<!DOCTYPE html>
<html>
  
<head>
    <title>Insert Users Page</title>
</head>
  
<body>
    <center>
        <?php
  
        // servername => localhost
        // username => root
        // password => empty
        // database name => staff
        $conn = mysqli_connect("localhost", "budiluhur", "nU6tKz_NWH5", "device_monitoring");
          
        // Check connection
        if($conn === false){
            die("ERROR: Could not connect. " 
                . mysqli_connect_error());
        }
          
        
        $id_devices =  $_REQUEST['id_devices'];
        $ipaddress = $_REQUEST['ipaddress'];
        $group_id =  $_REQUEST['group_id'];
        $lastping = $_REQUEST(['lastping']);
          
        // Insert
        $sql = "INSERT INTO devices (`id_devices`, `ipaddress`, `group_id`, `lastping`) VALUES ('$id_devices', 
            '$ipaddress','$group_id','$lastping')";
          
        if(mysqli_query($conn, $sql)){
            echo "<h3>Berhasil menyimpan data!</h3>"; 
  
            echo nl2br("\n$id_devices\n $ipaddress\n "
                . "$group_id\n $lastping\n");
        } else{
            echo "ERROR: Oops! Terjadi kesalahan $sql. " 
                . mysqli_error($conn);
        }

        mysqli_close($conn);
        ?>
    </center>
</body>
  
</html>