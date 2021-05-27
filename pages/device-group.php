<head>
    <link rel="stylesheet" href="pages/css/table.css">
</head>
<h2 class="mt-4"><strong>Device Group</strong></h2>
    <button class="btn btn-primary btn-sm float-left mb-3 mt-1" onclick="addNew()">
        <i class="fas fa-plus fa-fw"></i> Add New DevGroup
</button>

<!-- Menampilkan list data -->
<div class="table-responsive">
    <table class="table table-borderless table-hover table-sm table-striped">
        <thead class="text-center">
            <tr>
                <th>Device Group</th>
                <th class="text-center" style="width:14%">
                    <i class="fas fa-cogs fa-fw"></i>
                </th>
            </tr>
        </thead>

        <tbody id="listdata" class="text-center"></tbody>
    </table>
</div>

<!-- Modal Form -->
<div class="modal fade" id="modalForm">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Device Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                
                <input type="hidden" id="group_id" value="0">

                <div class="form-group mb-3">
                    <label for="name">Group Name</label>
                    <input type="text" id="group_name" class="form-control shadow-none">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="save()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>

    // Function dapatakan data
    function getList() {
        $.ajax({
            type: "GET",
            url: "controller/ajax/device-group/list.php",
            dataType: "json",
            success: function(hasil) {
                var dataList = "";

                for (var x = 0;x < hasil.length;x++) {
                    dataList += `
                        <tr>
                            <td>${hasil[x].group_name}</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm" onclick="hapusData(${hasil[x].group_id})">
                                    <i class="fas fa-trash fa-fw"></i>
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="editData(${hasil[x].group_id})">
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
    }

    // Function untuk menghapus data
    function hapusData(group_id) {
        var konfirmasi = confirm("Beneran nih?")
        if (konfirmasi) {
            
             $.ajax({
                type: "POST",
                url: "controller/ajax/device-group/delete.php",
                dataType: "json",
                data: {
                    group_id: group_id
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
        var group_name = $("#group_name").val()
        var group_id = $("#group_id").val()
        var action = parseInt(group_id) ? 'update' : 'insert';
            
        $.ajax({
                type: "POST",
                url: `controller/ajax/device-group/${action}.php`,
                dataType: "json",
                data: {
                    group_id: group_id,
                    group_name:group_name
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
    function editData(group_id) {
        $.ajax({
                type: "GET",
                url: "controller/ajax/device-group/get.php",
                dataType: "json",
                data: {
                    group_id: group_id
                },  
                success: function(hasil) {
                    $("#modalForm").modal()
                    $("#group_name").val(hasil.group_name)
                    $("#group_id").val(hasil.group_id)
                }
            })
    }

    //Function clear form
    function clearForm() {
        $("#grouo_name").val("")
        $("#group_id").val(0)
    }

</script>