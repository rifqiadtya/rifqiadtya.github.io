<?php
$current_url = $_GET['act'];
?>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./pages/css/topnav.css">
</head>
<nav class="navbar navbar-expand-sm shadow-sm sticky-top">
   <div class="container">
   <a class="navbar-brand" href="?act=home"><img src="./pages/res/img/devmon.png" class="img-fluid" alt=""></a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
        aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars fa-fw"></i>
    </button>

    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0 nav-pills">
            <li class="nav-item ">
                <a class="nav-link <?= $current_url == 'home' ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="top" title="Home" href="?act=home">
                    <i class="fas  fa-home fa-fw"></i>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?= $current_url == 'devices' ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="top" title="Devices" href="?act=devices" >
                    <i class="fas  fa-inbox fa-fw"></i>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?= $current_url == 'device-group' ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="top" title="Device Group" href="?act=device-group">
                    <i class="fas fa-layer-group fa-fw"></i>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?= $current_url == 'devices_pms' ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="top" title="Device Permissions" href="?act=devices_pms">
                    <i class="fas fa-key fa-fw"></i>
	        	</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?= $current_url == 'users' ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="top" title="Users" href="?act=users">
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link <?= $current_url == 'roles' ? 'active' : ''; ?>" data-toggle="tooltip" data-placement="top" title="Roles" href="?act=roles">
                    <i class="fas fa-briefcase fa-fw"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto mt-2 mt-lg-0 nav-pills">
            <li class="nav-item logout">
                <a class="nav-link" href="logout.php">
                    <i class="fas  fa-sign-out-alt fa-fw"></i>    
                    </a>
            </li>
        </ul>
    </div>
   </div>
</nav>

