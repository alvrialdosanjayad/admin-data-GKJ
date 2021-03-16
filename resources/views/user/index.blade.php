@extends('layouts.appUtama')

@section('tambahanCSS')
<!-- Custom styles for this page -->
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('user','active')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-left mb-2">
        <button type="button" class="col-lg-3 col-sm-4 btn btn-primary mr-2" id="tombol-tambah">
            <span class="text">Tambah Admin</span>
        </button>
        <button type="button" class="col-lg-3 col-sm-4 btn btn-primary mr-2" id="import-user">
            <span class="text">Import Data</span>
        </button>
        <a href="{{url('/export/export-jemaat')}}" class="col-lg-3 col-sm-4 btn btn-primary mr-2">
            <span class="text">Export Data</span>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="h4 m-0 font-weight-bold text-primary">Daftar User</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="20%">Username</th>
                            <th width="20%">Role</th>
                            <th width="50%">Nama Lengkap</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>

                </table>

            </div>

        </div>

    </div>

</div>
<!-- /.container-fluid -->

@endsection

@section('tambahanModal')
<!-- MODAL TAMBAH USER BARU -->
<div class="modal fade" id="tambah-edit-modal" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-judul"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="alert-tambah-edit" role="alert"></div>
                <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="text" class="form-control" name="role" id="role" value="Admin" readonly>
                                <!-- <input type="text" class="form-control" name="role" id="role" value="admin" disabled> -->
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" id="username">
                                <div class="alert-message text-danger" id="usernameError"></div>
                            </div>
                            <div class="form-group">
                                <label for="passsword" id="lPassword"></label>
                                <input type="password" class="form-control" name="password" id="password" autocomplete="new-password">
                                <div class="alert-message text-danger" id="passwordError"></div>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" id="lnPassword"></label>
                                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" autocomplete="new-password">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="create">Simpan
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- AKHIR MODAL -->

<div class="modal fade" id="import-modal" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Excel</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="alert-import" role="alert"></div>
                <form id="form-import" name="form-import" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="importData">
                        <p class="alert-message text-danger" id="importUserError"></p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-block" id="tombol-import" value="">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL KONFIRMASI DELETE-->
<div class="modal fade" id="konfirmasi-modal" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PERHATIAN</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><b>User akan dihapus, apakah anda yakin?</b></p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" name="tombol-hapus" id="tombol-hapus">Hapus
                    Data</button>
            </div>
        </div>
    </div>
</div>
<!-- AKHIR MODAL -->
@endsection



@section('tambahanJS')
<!-- Page level plugins -->
<script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(document).ready(function() {

        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('user.index') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });

    $('#tombol-tambah').click(function() {
        $('#alert-tambah-edit').css('display', 'none')
        $('#tombol-simpan').val("create-post"); //valuenya menjadi create-post
        $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
        $('#modal-judul').html("Tambah Admin Baru"); //valuenya tambah pegawai baru
        $('#lPassword').html("Password");
        $('#lnPassword').html("Repeat Password");
        $('#usernameError').text('');
        $('#passwordError').text('');
        $('#tambah-edit-modal').modal('show'); //modal tampil
    });

    $("#tombol-simpan").click(function(e) {
        var data, data2, data3;
        $('#tombol-simpan').html('Proses');
        $('.alert').css('display', 'none');
        $("#tombol-simpan").prop("disabled", true);
        e.preventDefault();
        $.ajax({
            data: $('#form-tambah-edit').serialize(), //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
            url: "{{route('user.store')}}", //url simpan data
            type: "POST", //karena simpan kita pakai method POST
            dataType: 'json', //data tipe kita kirim berupa JSON
            success: function(data) { //jika berhasil 
                $('#usernameError').text('');
                $('#password').val('');
                $('#password-confirm').val('');
                $('#passwordError').text('');

                $('#alert-tambah-edit').text('Data berhasil di tambah')
                $('#alert-tambah-edit').css('display', '')
                $('#tombol-simpan').html('Simpan'); //tombol simpan
                $("#tombol-simpan").prop("disabled", false);
                var oTable = $('#dataTable').dataTable(); //inialisasi datatable
                oTable.fnDraw(false); //reset datatable
            },
            error: function(data) {
                $('#tombol-simpan').html('Simpan'); //tombol simpan
                $("#tombol-simpan").prop("disabled", false);
                $('#usernameError').text('');
                $('#password').val('');
                $('#password-confirm').val('');
                $('#passwordError').text('');
                if (data.responseJSON.errors.username) {
                    $('#usernameError').text(data.responseJSON.errors.username);
                }
                if (data.responseJSON.errors.password) {
                    $('#passwordError').text(data.responseJSON.errors.password);
                }
            }
        });
    });

    $(document).on('click', '.delete', function() {
        dataId = $(this).attr('id');
        $('#konfirmasi-modal').modal('show');
    });

    $('#tombol-hapus').click(function() {
        $.ajax({
            url: "user/" + dataId, //eksekusi ajax ke url ini
            type: 'delete',
            beforeSend: function() {
                $('#tombol-hapus').text('Proses...'); //set text untuk tombol hapus
            },
            success: function(data) { //jika sukses
                setTimeout(function() {
                    $('#konfirmasi-modal').modal('hide'); //sembunyikan konfirmasi modal
                    $('#tombol-hapus').text('Hapus Data'); //set text untuk tombol hapus
                    var oTable = $('#dataTable').dataTable();
                    oTable.fnDraw(false); //reset datatable
                });
            }
        })
    });

    $('#import-user').click(function() {
        $('#alert-import').css('display', 'none');
        $('#form-import').trigger("reset"); //mereset semua input dll didalamnya
        $('#import-modal').modal('show'); //modal tampil
    });

    $('#tombol-import').click(function() {
        $('#importUserError').html('');
        $('#tombol-import').html('Proses...'); //tombol simpan

        $('#alert-import').css('display', 'none')
    });

    $("#form-import").submit(function(e) {
        $("#tombol-import").prop("disabled", true);
        var formData = new FormData(this);
        e.preventDefault();
        $.ajax({
            data: formData, //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
            url: "{{url('/import/import-jemaat')}}", //url simpan data
            type: "POST", //karena simpan kita pakai method POST
            dataType: "json", //data tipe kita kirim berupa JSON
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) { //jika berhasil 

                $('#alert-import').css('display', '')
                $('#alert-import').text('Data Berhasil Di Import')
                $('#tombol-import').html('Simpan'); //tombol simpan
                $("#tombol-import").prop("disabled", false);
                var oTable = $('#dataTable').dataTable(); //inialisasi datatable
                oTable.fnDraw(false); //reset datatable
            },
            error: function(data) {
                $('#alert-import').css('display', 'none');
                $('#tombol-import').html('Simpan'); //tombol simpan
                $('#importUserError').html('');
                $("#tombol-import").prop("disabled", false);
                if (data.responseJSON.errors.importData) {
                    $('#importUserError').html(data.responseJSON.errors.importData);
                }
            }
        });
    });
</script>
@endsection