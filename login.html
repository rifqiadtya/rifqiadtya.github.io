<?php
    session_start();

    if(isset($_SESSION['username'])) {
        header("location: index.php?act=home"); 
    }
  ?>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="pages/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <title>DevMon Login</title>
  <body>
  <div class="login-wrapper">
    <form action="" class="form" id="loginform" autocomplete="off">
      <h2>DEVICE MONITOR</h2>
      <div class="input-group">
        <input type="text" id="uname" required>
        <label for="user">Username</label>
      </div>
      <div class="input-group" id="passw">
        <input type="password" class="form-control" id="pass" required>
        <label for="password">Password</label>
        <a class="matalihat" href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
    </div>
	 	 <button class="btn submit-btn" type="submit">Login</button>
    </form>
  </div>
<script>


    $("#loginform").submit(function (e){
    e.preventDefault();
    var username  = $('#uname').val();
		var password  = $('#pass').val();
		if(username!="" && password!="" ){
			$.ajax({
                url: "controller/ajax/devices/login.php",
				type: "POST",
				data: {
          type:1,
					username,
					password		
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
  })

    function cobaLogin(){
		
  }


  $(document).ready(function() {
    $("#passw a").on('click', function(event) {
        event.preventDefault();
        if($('#passw input').attr("type") == "text"){
            $('#passw input').attr('type', 'password');
            $('#passw i').addClass( "fa-eye-slash" );
            $('#passw i').removeClass( "fa-eye" );
        }else if($('#passw input').attr("type") == "password"){
            $('#passw input').attr('type', 'text');
            $('#passw i').removeClass( "fa-eye-slash" );
            $('#passw i').addClass( "fa-eye" );
        }
    });
});
</script>
</body>
</html>
