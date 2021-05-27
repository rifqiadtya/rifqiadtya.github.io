<head>
    <link rel="stylesheet" href="pages/css/table.css">
</head>
<h2 class="mt-4"><strong>Users List</strong></h2>

<?php
echo "You're an " . $_SESSION['rolename'];

//Connect to javascript
$session_value = (isset($_SESSION['rolename'])) ? $_SESSION['rolename'] : '';
?>

<div class="row">
    <div id="addNew" class="col-sm-4">
        <button class="btn btn-primary btn-sm float-left mb-3 mt-1" onclick="addNew()" title="Add New Users">
            <i class="fas fa-plus fa-fw"></i> Add New Users
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
                    <th onclick="sortIng('roles.role_name')">Roles</th>
                    <th onclick="sortIng('users.fullname')">Fullname</th>
                    <th onclick="sortIng('users.username')">Username</th>
                    <th class="text-center" style="width:14%">
                        <i class="fas fa-cogs fa-fw"></i>
                    </th>
                </tr>
            </thead>

            <tbody id="listdata"></tbody>
        </table>
    </div>
    <div class="d-flex flex-row justify-content-between mt-3">
        <div>
            <p align="center ml-1 mt-3"> <?php $trn_date = date("d-m-y H:i:s");
                                            echo "Date : $trn_date"; ?> </p>
        </div>
        <div id="pagination" class=""></div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalFormUsers" name="modalFOrmUsers">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="judulModal">Judul</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id_user" value="0">

                    <div class="form-group mb-3">
                        <label for="name">Roles</label>
                        <select name="roles_id" id="roles_id" class="form-control">
                            <option value='0'>--Select Roles--</option>
                        </select>
                        <br><label for="name">Fullname</label>
                        <input type="text" id="fullname" class="form-control shadow-none">
                        <br><label for="name">Username</label>
                        <input type="text" id="username" class="form-control shadow-none">
                        <div id="passbox">
                            <br><label for="name">Password</label>
                            <input type="password" id="password" class="form-control shadow-none">
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save()">Save</button>
                </div>
            </div>
        </div>
    </div>




    <!-- Modal Form Pass Change -->
    <div class="modal fade" id="modalFormPassChg">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="id_userpass" value="0">

                    <div class="form-group mb-3">
                        <br><label for="name">New Password</label>
                        <input type="password" id="newpass" class="form-control shadow-none">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="changePass()">Save</button>
                </div>
            </div>
        </div>
    </div>
</body>


<script>
    
    document.getElementById("fullname").onkeypress = function(e) {
        var chr = String.fromCharCode(e.which);
        if ("!@#$%^&*()_+=-,./;'[]|{}:?><1234567890".indexOf(chr) >= 0)
            return false;
    };
    document.getElementById("username").onkeypress = function(e) {
        var chr = String.fromCharCode(e.which);
        if ("!@#$%^&*()+=-,./;'[]|{}:?><".indexOf(chr) >= 0)
            return false;
    };

    // function get roles
    function getRoles() {
        $.ajax({
            type: "GET",
            url: "controller/ajax/roles.php?act=list",
            dataType: "json",
            success: function(res) {
                var dataList = "";

                res.map((item, index) => {
                    dataList += `<option value="${item.roles_id}" data-index="data-ke-${index}">${item.role_name}</option>`;
                });

                $("#roles_id").html(dataList);

            }
        });
    }

    // Function dapatkan data
    var cari = '';
    var sortby = 'users.fullname';
    var sortdir = 'asc';
    var curPage = 1;
    var itemsOnPage = 5;

    function getList() {
        $.ajax({
            type: "GET",
            url: "controller/ajax/users.php",
            data: {
                act: 'list',
                search: cari,
                sortby,
                sortdir,
                curPage,
                itemsOnPage
            },
            dataType: "json",
            success: function(hasil) {
                var dataList = "";

                for (var x = 0; x < hasil['record'].length; x++) {
                    dataList += `
                        <tr>
                            <td>${hasil['record'][x].role_name}</td>
                            <td>${hasil['record'][x].fullname}</td>
                            <td>${hasil['record'][x].username}</td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm" onclick="hapusData(${hasil['record'][x].id_user})">
                                    <i class="fas fa-trash fa-fw"></i>
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="editData(${hasil['record'][x].id_user})">
                                <i class="fas fa-edit fa-fw"></i>
                                </button>
                                <button class="btn btn-primary btn-sm" onclick="passChg(${hasil['record'][x].id_user})">
                                <i class="fas fa-key fa-fw"></i>
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
                    onPageClick: function(current) {
                        curPage = current;
                        getList();
                    },
                    cssStyle: 'light-theme',

                });
            }
        });
    }

    // panggil dapatkan data saat halaman dimuat
    getList();

    // Function memunculkan form untuk tambah baru
    function addNew() {
        var ruler = "<?= $_SESSION['rolename'] ?>";
        if (ruler == 'Admin' || ruler == 'User') {
            $("#modalFormUsers").modal()
            $("#judulModal").html('Add New User')
            $("#passbox").show()
            clearForm()
            getRoles();
        } else {
            alert("You don't have permission");
        }

    }


    // Function untuk menghapus data
    function hapusData(id_user) {

        var ruler = "<?= $_SESSION['rolename'] ?>";
        if (ruler == 'Admin') {
            var konfirmasi = confirm("Confirmation delete (OK/Cancel) ?")
            if (konfirmasi) {

                $.ajax({
                    type: "POST",
                    url: "controller/ajax/users.php",
                    dataType: "json",
                    data: {
                        act: 'delete',
                        id_user: id_user
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
        } else {
            alert("You don't have permission");
            // alert('Cek <?php echo $session_value; ?>');
        }



    }


    //Function save data
    function save() {
        var id_user = $("#id_user").val()
        var roles_id = $("#roles_id").val()
        var fullname = $("#fullname").val()
        var username = $("#username").val()
        var password = $("#password").val()
        var action = parseInt(id_user) ? 'update' : 'insert';

        $.ajax({
            type: "POST",
            url: `controller/ajax/users.php`,
            dataType: "json",
            data: {
                act: action,
                id_user: id_user,
                roles_id: roles_id,
                fullname: fullname,
                username: username,
                password: password
            },
            success: function(hasil) {
                if (hasil.status) {
                    getList();
                    $("#modalFormUsers").modal('hide')
                } else {
                    alert('Gagal menyimpan data');
                }
            }
        })

    }

    //Function edit data
    function editData(id_user) {
        var ruler = "<?= $_SESSION['rolename'] ?>";
        if (ruler == 'Admin' || ruler == 'User') {
            $.ajax({
                type: "GET",
                url: "controller/ajax/users.php",
                dataType: "json",
                data: {
                    act: 'getRow',
                    id_user: id_user
                },
                success: function(hasil) {
                    getRoles();
                    $("#modalFormUsers").modal()
                    $("#judulModal").html('Edit User')
                    $("#id_user").val(hasil.id_user)
                    $("#roles_id").val(hasil.roles_id)
                    $("#fullname").val(hasil.fullname)
                    $("#username").val(hasil.username).attr('disabled', true)
                    $("#passbox").hide()

                }
            })
        } else {
            alert("You don't have permission");
        }


    }



    //Function ubah password (Manggil Modal)
    function passChg(id_user) {
        var ruler = "<?= $_SESSION['rolename'] ?>";
        if (ruler == 'Admin') {
            $('#id_userpass').val(id_user);
            $('#modalFormPassChg').modal();
        } else {
            alert("You don't have permission");
        }
    }
    //Function Change Password
    function changePass() {
        var id_user = $("#id_userpass").val()
        var password = $("#newpass").val()
        var action = 'changePass'

        $.ajax({
            type: "POST",
            url: `controller/ajax/users.php`,
            dataType: "json",
            data: {
                act: action,
                id_user: id_user,
                password: password
            },
            success: function(hasil) {
                if (hasil.status) {
                    getList();
                    $("#modalFormPassChg").modal('hide')
                } else {
                    alert('Gagal menyimpan data');
                }
            }
        })
    }

    //Function clear form
    function clearForm() {
        $("#id_user").val(0)
        $("#roles_id").val(0)
        $("#fullname").val("")
        $("#username").val("")
        $("#password").val("")
    }

    //fungsi
    function cariData(e) {
        if (e.keyCode === 13) {
            getList();
        } else {
            cari = e.target.value
        }

    }

    document.getElementById('Cari').addEventListener('keyup', cariData)


    //fungsi sort
    function sortIng(col) {
        sortby = col;
        sortdir = sortdir === 'desc' ? 'asc' : 'desc';
        getList();
    }
</script>