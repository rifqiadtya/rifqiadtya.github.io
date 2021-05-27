<!-- <!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./pages/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  </head>
  <body>
  <?
    session_start();

    if(isset($_SESSION['username'])) {
        header("location: ?act=home.php"); 
    }
  ?>
    <div class="center">
      <input type="checkbox" id="show">
      <label for="show" class="show-btn">Login Device Monitor</label>
      <div class="container">
        <label for="show" class="close-btn fas fa-times" title="close"></label>
        <div class="text">
Login</div>
<form action="#">
          <div class="data">
            <label>Username</label>
            <input type="text" id="uname" required>
          </div>
<div class="data">
            <label>Password</label>
            <input type="password" id="pass" required>
          </div>
<div class="btn">
            <div class="inner">
</div>
<button type="button" onclick="cobaLogin()">login</button>
          </div>
</form>
</div>
</div>
<script>
    function cobaLogin(){
		var username = $('#uname').val();
		var password = $('#pass').val();
		if(username!="" && password!="" ){
			$.ajax({
                url: "controller/ajax/devices/login.php",
				type: "POST",
				data: {
					type:2,
					username: username,
					password: password						
				},
				cache: false,
                dataType: "json",
				success: function(dataResult){
					if(dataResult.statusCode == 200){
						location.href = "index.php?act=home";
                        					
					}
					else if(dataResult.statusCode == 201){
                        alert("Username atau Password salah.");
					}
				}
			});
		}
    }
</script>
</body>
</html> -->
