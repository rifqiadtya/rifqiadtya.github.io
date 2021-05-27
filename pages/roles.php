    <head>
        <link rel="stylesheet" href="pages/css/table.css">
    </head>
    <h2 class="mt-4"><strong>Roles List</strong></h2>


    <div class="row">
        <div class="col-sm-4">
            <button class="btn btn-primary btn-sm float-left mb-3 mt-1" onclick="addNew()" title="Add New Roles">
                <i class="fas fa-plus fa-fw"></i> Add New Roles
            </button>
        </div>
    </div>




    <!-- Menampilkan list data -->
    <div class="table-responsive">
        <table class="table table-borderless table-hover table-striped table-sm text-center">
            <thead>
                <tr>
                    <th>Role Name</th>
                    <th class="text-center" style="width:14%">
                        <i class="fas fa-cogs fa-fw"></i>
                    </th>
                </tr>
            </thead>

            <tbody id="listdata"></tbody>
        </table>
    </div>

    <br>
    <p align="center ml-1 mt-3"> <?php $trn_date = date("d-m-y H:i:s");
                                    echo "Date : $trn_date"; ?> </p>




    <!-- Modal Form -->
    <div class="modal fade" id="modalFormRole">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="roles_id" value="0">

                    <div class="form-group mb-3">
                        <label for="name">Role Name</label>
                        <input type="text" name="role_name" id="role_name" class="form-control shadow-none">
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
        // Function dapatkan data
        function getList() {
            $.ajax({
                type: "GET",
                url: "controller/ajax/roles.php",
                dataType: "json",
                data: {
                    act: 'list'
                },
                success: function(hasil) {
                    var dataList = "";

                    for (var x = 0; x < hasil.length; x++) {
                        dataList += `
                            <tr>
                                <td>${hasil[x].role_name}</td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm" onclick="hapusData(${hasil[x].roles_id})">
                                        <i class="fas fa-trash fa-fw"></i>
                                    </button>
                                    <button class="btn btn-primary btn-sm" onclick="editData(${hasil[x].roles_id})">
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

        // panggil dapatkan data saat halaman dimuat
        getList();

        // Function memunculkan form untuk tambah baru
        function addNew() {
            $("#modalFormRole").modal()
            clearForm()
        }

        // Function untuk menghapus data
        function hapusData(roles_id) {
            var konfirmasi = confirm("Confirmation delete (OK/Cancel) ?")
            if (konfirmasi) {

                $.ajax({
                    type: "POST",
                    url: "controller/ajax/roles.php",
                    dataType: "json",
                    data: {
                        act: 'delete',
                        roles_id: roles_id
                    },
                    success: function(hasil) {
                        if (hasil.status) {
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
            var roles_id = $("#roles_id").val()
            var role_name = $("#role_name").val()
            var action = parseInt(roles_id) ? 'update' : 'insert';
            if (role_name != "") {
                $.ajax({
                    type: "POST",
                    url: `controller/ajax/roles.php`,
                    dataType: "json",
                    data: {
                        act: action,
                        roles_id: roles_id,
                        role_name: role_name
                    },
                    success: function(hasil) {
                        if (hasil.status) {
                            getList();
                            $("#modalFormRole").modal('hide')
                        } else {
                            alert('Gagal menyimpan data');
                        }
                    }
                })
            } else {
                alert('Harap masukan value');
            }

        }

        //Function edit data
        function editData(roles_id) {
            $.ajax({
                type: "GET",
                url: "controller/ajax/roles.php",
                dataType: "json",
                data: {
                    act: 'getRow',
                    roles_id: roles_id
                },
                success: function(hasil) {
                    $("#modalFormRole").modal()
                    $("#roles_id").val(hasil.roles_id)
                    $("#role_name").val(hasil.role_name)

                }
            })
        }



        //Function clear form
        function clearForm() {
            $("#roles_id").val(0)
            $("#role_name").val("")
        }
    </script>