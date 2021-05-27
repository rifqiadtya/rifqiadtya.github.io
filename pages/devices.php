<head>
    <link rel="stylesheet" href="pages/css/table.css">
</head>
<table>
    <tr>
        <h2 class="mt-4"><strong>Devices</strong></h2>
    </tr>

    <div class="row">
    <div class="col-sm-4">
        <button class="btn btn-primary btn-sm float-left mb-3 mt-1" onclick="addNew()" title="Add New Users">
                <i class="fas fa-plus fa-fw"></i> Add New 
        </button>
    </div>
    <div class="form-group ml-5">
        <div class="col-sm-1 float-right ml-5">
            <input type="text" id="Cari" placeholder=" Search" title="Search">
        </div>
    </div>
  </div>
</table>

<!-- Menampilkan list data -->
<body>
<div class="table-responsive">
    <table class="table table-borderless table-hover table-striped table-sm text-center">
        <thead>
            <tr>
                <th onclick="sortIng('devices.name')">Device Name</th>
                <th>IP Address</th>
                <th>Status</th>
                <th>Lastping</th>
                <th>Device Group</th>
               
                <th class="text-center" style="width:14%">
                    <i class="fas fa-cogs fa-fw"></i>
                </th>
            </tr>
        </thead>

        <tbody id="listdata"></tbody>
    </table>
</div>

<div class="d-flex flex-row justify-content-between mt-3">
    <div><p align="center ml-1 mt-3"> <?php $trn_date = date("d-m-y H:i:s");
                        echo "Date : $trn_date";?> </p>
</div>
<div id="pagination" class=""></div>
</div>


<!-- Modal Form -->
<div class="modal fade" id="modalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Devices</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                
                <input type="hidden" id="id_devices" value="0">

                <div class="form-group mb-3">
                    <label for="name">Devices Name</label>
                    <input type="text" id="name" class="form-control shadow-none">
                </div>

                <div class="form-group mb-3">
                    <label for="name">IP Address</label>
                    <input type="text" id="ipaddress" class="form-control shadow-none">
                </div>

                <div class="form-group mb-3">
                    <label for="name">Device Group</label>
                    <select name="text" id="group_id" class="form-control">
                                           <option value='0'>--Select Group--</option>

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
</body>


<script>

     // function get group name
   function getGroup() {
	$.ajax({
		type: "GET",
		url: "controller/ajax/devices.php?act=list",
		dataType: "json",
		success: function(res) {
			var dataList = "";

			res.map((item, index) => {
				dataList += `<option value="${item.group_id}" data-index="data-ke-${index}">${item.group_id}</option>`;
			});

			$("#group_id").html(dataList);
		
		}
	});
   }

    // Function dapatakan data
    var curPage = 1;
    var itemsOnPage = 6;
    var cari='';
    function getList() {
        $.ajax({
            type: "GET",
            url: "controller/ajax/devices.php",
            data : {
                act: 'list',
                search: cari,
                curPage,
                itemsOnPage
            },
            dataType: "json",
            success: function(hasil) {
                var dataList = "";

                for (var x = 0;x < hasil['record'].length;x++) {
                    dataList += `
                        <tr>
                            <td>${hasil['record'][x].name}</td>
                            <td>${hasil['record'][x].ipadr}</td>
                            <td>${(hasil['record'][x].status == '0' || !hasil['record'][x].status) 
                                ? '<span class="badge badge-danger">offline</span>' 
                                : '<span class="badge badge-success">online</span>'}</td>
                            <td>${hasil['record'][x].lastping}</td>
                            <td>${hasil['record'][x].group_id}</td>
                           
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm" onclick="hapusData(${hasil['record'][x].id_devices})">
                                    <i class="fas fa-trash fa-fw"></i>
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="editData(${hasil['record'][x].id_devices})">
                                <i class="fas fa-edit fa-fw"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                }              

                $("#listdata").html(dataList)
                $('#pagination').pagination({
        items: hasil['total'],
        itemsOnPage: itemsOnPage,
        currentPage: curPage,
        onPageClick: function(current){
            curPage = current;
            getList();
        },
        cssStyle: 'light-theme',
        
    });
            }
        });
    }

    // panggil dapatakan data saat halaman dimuat
    getList();

    // Function memunculkan form untuk tambah baru
    function addNew() {
        $("#modalForm").modal()
        clearForm()
        getGroup();
    }

    // Function untuk menghapus data
    function hapusData(id_devices) {
        var konfirmasi = confirm("Delete data ?")
        if (konfirmasi) {
            
             $.ajax({
                type: "POST",
                url: "controller/ajax/devices.php",
                dataType: "json",
                data: {
                    act: 'delete',
                    id_devices: id_devices
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
        var id_devices  = $("#id_devices").val()
        var name        = $("#name").val()
        var ipaddress   = $("#ipaddress").val()
        var group_id    = $("#group_id").val()
        var action      = parseInt(id_devices) ? 'update' : 'insert';
            
        $.ajax({
                type: "POST",
                url: `controller/ajax/devices.php`,
                dataType: "json",
                data: {
                    act: action,
                    id_devices: id_devices,
                    name: name,
                    ipaddress: ipaddress,
                    group_id: group_id
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

function save()
    {
      var tampung_nm = document.getElementById('name').value;
      if(tampung_nm == ""){
        alert("Nama Jangan Kosong Donk!");
      } else {
        alert("Nama anda : " + tampung_nm);
      }
    
    }

    //Function edit data
    function editData(id_devices) {
        $.ajax({
                type: "GET",
                url: "controller/ajax/devices.php",
                dataType: "json",
                data: {
                    act: 'getRow',
                    id_devices: id_devices
                },  
                success: function(hasil) {
                    getGroup();
                    $("#modalForm").modal()
                    $("#id_devices").val(hasil.id_devices)
                    $("#name").val(hasil.name)
                    $("#ipaddress").val(hasil.ipadr)
                    $("#status").val(hasil.status)
                    $("#lastping").val(hasil.lastping)
                    $("#group_id").val(hasil.group_id)

                }
            })
    }

    //Function clear form
    function clearForm() {
        $("#ipaddress").val("")
        $("#name").val("")
        $("#id_devices").val(0)
        $("#group_id").val(0)
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


    //fungsi sort
    function sortIng(col) {
        sortby  = col;
        sortdir = sortdir === 'desc' ? 'asc' : 'desc';
        getList();
    }


</script>