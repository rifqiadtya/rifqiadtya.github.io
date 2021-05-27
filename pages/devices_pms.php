<head>
    <link rel="stylesheet" href="pages/css/table.css">
</head>
<h2 class="mt-4"><strong>Devices Permission</strong></h2>

  <div class="row">
    <div class="col-sm-4">
        <button class="btn btn-primary btn-sm float-left mb-3 mt-1" onclick="addNew()" title="Add New">
                <i class="fas fa-plus fa-fw"></i> Add New 
        </button>
    </div>

    <div class="form-group ml-5">
        <div class="col-sm-1 float-right ml-5">
            <input type="text" id="Cari" placeholder=" Search" title="Search">
        </div>
    </div>

</div>


<!-- Menampilkan list data -->
<body>
<div class="table-responsive">
    <table class="table table-borderless table-hover table-striped table-sm text-center">
        <thead>
            <tr>
                <th>Username</th>
                <th>Device Name</th>
                <th>Devices</th>

                <th class="text-center" style="width:14%">
                    <i class="fas fa-cogs fa-fw"></i>
                </th>

            </tr>
        </thead>

        <tbody id="listdata"></tbody>
    </table>
</div>

<p align="left" class="ml-1 mt-3"> <?php $trn_date = date("d-m-y H:i:s");
                    echo "Date : $trn_date";?>

<!-- Modal Form -->
<div class="modal fade" id="modalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Permissions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                
                <input type="hidden" id="id_device_pms" value="0">

                <div class="form-group mb-3">
                    <label for="name">Users</label>
                    <select id="id_user" class="js-example-basic-multiple form-control" name="id_user">
                    <option value='0'>select</option>
                            
                    </select>
                </div>       

                <div class="form-group mb-3">
                    <label for="name">id Devices</label>
                    <select id="id_device" class="js-example-basic-multiple form control" name="id_device" multiple="multiple">
                    <option value='0'>select</option>
                            
                    </select>
                    
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="save()">Save</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modaldevices" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
            </div>
            <div class="modal-body">
            <table class="table table-borderless table-hover table-striped table-sm text-center">
        <thead>
            <tr>
                <th>Device Name</th>
                <th>IP Address</th>
                <th>status</th>
                <th>lastping</th>


            </tr>
        </thead>

        <tbody id="listdevices"></tbody>
    </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Edit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            
        </div>
    </div>
</div>
</body>

<script>

    // Function dapatakan data
    var cari = '';
    var data_list = [];
    function getList() {
        $.ajax({
            type: "POST",
            url: "controller/ajax/devices_pms/list.php",
            data: {
             search:cari,
            
            },
            dataType: "json",
            success: function(hasil) {
                var dataList = "";
                
                data_list = hasil;

                for (var x = 0;x < hasil.length;x++) {
                    dataList += `
                        <tr>
                            <td>${hasil[x].username}</td>
                            <td>${hasil[x].name}</td>
                            
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm" onclick="cariD(${hasil[x].id_device_pms})">
                                    ${hasil[x].devices.length}

                            <td class="text-center">
                                <button class="btn btn-danger btn-sm" onclick="hapusData(${hasil[x].id_device_pms})">
                                    <i class="fas fa-trash fa-fw"></i>

                                </button>
                                <button class="btn btn-primary btn-sm" onclick="editData(${hasil[x].id_device_pms})">
                                <i class="fas fa-edit fa-fw"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                }              

                $("#listdata").html(dataList)
            }
        });
    }


    // panggil dapatakan data saat halaman dimuat
    getList();

    // Function memunculkan form untuk tambah baru
    function addNew() {
        $("#modalForm").modal()
        clearForm()
        getUser()
        getDevice()
    }

    // Function untuk menghapus data
    function hapusData(id_device_pms) {
        var konfirmasi = confirm("Confirmation delete (OK/Cancel) ?")
        if (konfirmasi) {
            
             $.ajax({
                type: "POST",
                url: "controller/ajax/device_pms/delete.php",
                dataType: "json",
                data: {
                    id_device_pms: id_device_pms,
                },  
                success: function(hasil) {
                    if(hasil.status) {
                        getList();
                    } else {
                        alert('Gagal menghapus data');
                    }
                }
            })
        }
    }
    
    //Function save data
    function save() {
        var id_device_pms = $("#id_device_pms").val()
        var username      = $("#username").val()
        var name          = $("#name").val()
        var action = parseInt(id_device_pms) ? 'update' : 'insert';
            
        $.ajax({
                type: "POST",
                url: `controller/ajax/devices_pms/${action}.php`,
                dataType: "json",
                data: {
                    id_device_pms: id_device_pms,
                    username: username,
                    name: name,
                    
                },  
                success: function(hasil) {
                    if(hasil.status) {
                        getList();
                        $("#modalForm").modal('hide')
                    } else {
                        alert('Gagal menyimpan data');
                    }
                }
            })
    }

    //Function edit data
    function editData(id_device_pms) {
        $.ajax({
                type: "GET",
                url: "controller/ajax/devices_pms/get.php",
                dataType: "json",
                data: {
                    id_device_pms: id_device_pms
                },  
                success: function(hasil) {
                    $("#modalForm").modal()
                    $("#id_device_pms").val(hasil.id_device_pms)
                    $("#username").val(hasil.username)
                   
                    $("#name").val(hasil.name)
                }
            })
    }

    // function cari data
    function cariD(id_device_pms) {
           var devices = data_list.filter(function (ambil){
        
               return ambil.id_device_pms == id_device_pms
           })[0].devices

           if(devices){
               var devicelist = '';
               devices.map(function (tampil){
                devicelist += `
                        <tr>
                            <td>${tampil.name}</td>
                            <td>${tampil.ipadr}</td>
                            <td>
                            ${(tampil.status == '0' || !tampil.status) 
                                ? '<span class="badge badge-danger">offline</span>' 
                                : '<span class="badge badge-success">online</span>'}
                            </td>
                            <td>${tampil.lastping}</td>
                        </tr>
                    `;
               })
               $('#listdevices').html(devicelist)
               $("#modaldevices").modal()
    }
           }
           
           


    //Function clear form
    function clearForm() {
        $("#id_user").val("") 
        $("#id_device").val("")
      
    }

    //fungsi
    function cariData(e) {
        if (e.keyCode === 13) {
            getList();
        } else {
            cari    = e.target.value
        }

    }

    document.getElementById('Cari').addEventListener('keyup', cariData)

    function getUser() {
	$.ajax({
		type: "GET",
		url: "controller/ajax/users.php?act=list",
		dataType: "json",
		success: function(res) {
			var dataList = "";

			res.map((item, index) => {
				dataList += `<option value="${item.id_user}" data-index="data-ke-${index}">${item.username}</option>`;
			});

			$("#id_user").html(dataList);
            $("#id_user").select2();
		
		}
	});
   }

   function getDevice() {
	$.ajax({
		type: "GET",
		url: "controller/ajax/devices.php?act=list",
		dataType: "json",
		success: function(res) {
			var dataList = "";

			res.map((item, index) => {
				dataList += `<option value="${item.id_devices}" data-index="data-ke-${index}">${item.name}</option>`;
			});

			$("#id_device").html(dataList);
            $("#id_device").select2();
		
		}
	});
   }

    // fungsi sort
    // function sortIng(col) {
    //     sortby  = col;
    //     sortdir = sortdir === 'desc' ? 'asc' : 'desc';
    //     getList();
    // }

</script>

<script>
$('.js-example-basic-multiple').select2(); 

</script>