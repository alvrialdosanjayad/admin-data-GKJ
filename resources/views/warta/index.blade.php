@extends('layouts.appUtama')

@section('tambahanCSS')
<!-- Custom styles for this page -->
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('wartaJemaat','active')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-left">
        <button type="button" class="btn btn-primary col-lg-3 col-sm-4 mb-2" id="tombol-tambah">
            <span class="text">Tambah Warta</span>
        </button>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="h4 m-0 font-weight-bold text-primary">Daftar Warta Jemaat</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="wartaJemaat" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="30%">Tanggal</th>
                            <th width="60%">Nama Warta</th>
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
<!-- MODAL TAMBAH WARTA -->
<div class="modal fade" id="tambah-edit-modal" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-judul"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="alert-tambah-edit" role="alert"></div>
                <form id="form-tambah-edit" name="form-tambah-edit" class="form-horizontal" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" class="form-control" name="status" id="status">
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" id="tanggal">
                                <p class="border p-2 rounded" id="tanggalHtml"></p>
                            </div>
                            <div class="namaWarta1">
                                <label for="namaWarta">Nama Warta</label>
                                <p class="border p-2 rounded" id="namaWartaHtml"></p>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Upload Warta</label>
                                <input type="file" class="form-control-file" name="fileWarta">
                                <p class="alert-message text-danger" id="fileWartaError"></p>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- AKHIR MODAL -->

<!-- MODAL KONFIRMASI DELETE -->
<div class="modal fade" id="konfirmasi-modal" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">PERHATIAN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b>Warta akan dihapus, apakah anda yakin?</b></p>
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
        $('#wartaJemaat').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('warta.index') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'tanggal',
                    name: 'tanggal',
                },
                {
                    data: 'nama_warta',
                    name: 'nama_warta'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],

        });
    });

    $('#tombol-tambah').click(function() {
        $('.alert').css('display', 'none')
        $('#tombol-simpan').val("tambah"); //valuenya menjadi create-post
        $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
        $('#modal-judul').html("Tambah Warta Baru"); //valuenya tambah pegawai baru
        $('.namaWarta1').css("display", "none");
        $('#tanggal').css("display", "");

        $("#tanggalHtml").removeClass("border p-2 rounded");
        $("#tanggalHtml").addClass("alert-message text-danger");

        $('#status').val("");

        $('#tanggalHtml').html('');
        $('#fileWartaError').html('');
        $('#tambah-edit-modal').modal('show'); //modal tampil
    });

    $('#tombol-simpan').click(function() {
        $('#fileWartaError').html('');
        $('#tombol-simpan').html('Proses...'); //tombol simpan
        $('.alert').css('display', 'none')
        if ($("#tanggalHtml").hasClass('border') == false) {
            $('#tanggalHtml').html('');
        }
    });

    $("#form-tambah-edit").submit(function(e) {
        $("#tombol-simpan").prop("disabled", true);
        var formData = new FormData(this);
        e.preventDefault();
        $.ajax({
            data: formData, //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
            url: "{{route('warta.store')}}", //url simpan data
            type: "POST", //karena simpan kita pakai method POST
            dataType: 'json', //data tipe kita kirim berupa JSON
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) { //jika berhasil 
                if ($('#tombol-simpan').val() == "tambah") {
                    $('#alert-tambah-edit').text('Data berhasil di tambah')

                } else {
                    $('#alert-tambah-edit').text('Data berhasil di ubah')
                }
                $('.alert').css('display', '')
                $("#tombol-simpan").prop("disabled", false);
                $('#tombol-simpan').html('Simpan'); //tombol simpan
                var oTable = $('#wartaJemaat').dataTable(); //inialisasi datatable
                oTable.fnDraw(false); //reset datatable
            },
            error: function(data) {
                $('.alert').css('display', 'none')
                $('#tombol-simpan').html('Simpan'); //tombol simpan
                $('#fileWartaError').html('');
                $("#tombol-simpan").prop("disabled", false);
                if ($("#tanggalHtml").hasClass('border') == false) {
                    $('#tanggalHtml').html('');
                }
                if (data.responseJSON.errors.fileWarta) {
                    $('#fileWartaError').html(data.responseJSON.errors.fileWarta);
                }
                if (data.responseJSON.errors.tanggal) {
                    $('#tanggalHtml').html(data.responseJSON.errors.tanggal);
                }
            }
        });
    });

    $('body').on('click', '.edit-post', function() {
        var data_id = $(this).data('id');
        $.get('warta/' + data_id + '/edit', function(data) {
            $('.alert').css('display', 'none');
            $('#tombol-simpan').val("ubah"); //valuenya menjadi create-post
            $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
            $('#modal-judul').html("Edit Warta"); //valuenya tambah pegawai baru
            $('.namaWarta1').css("display", "");
            $('#tanggal').css("display", "none");

            $("#tanggalHtml").addClass("border p-2 rounded");
            $("#tanggalHtml").removeClass("alert-message text-danger");

            $('#fileWartaError').html('');
            $('#tambah-edit-modal').modal('show'); //modal tampil

            //set value masing-masing id berdasarkan data yg diperoleh dari ajax get request diatas

            $('#status').val("update");
            $('#tanggal').val(data.tanggal);
            $('#tanggalHtml').html(data.tanggal);
            $('#namaWartaHtml').html(data.nama_warta);
        })
    });

    $(document).on('click', '.delete', function() {
        dataId = $(this).attr('id');
        $('#konfirmasi-modal').modal('show');
    });

    $('#tombol-hapus').click(function() {

        $.ajax({
            url: "warta/" + dataId, //eksekusi ajax ke url ini
            type: 'delete',
            beforeSend: function() {
                $('#tombol-hapus').text('Proses...'); //set text untuk tombol hapus
            },
            success: function(data) { //jika sukses
                setTimeout(function() {
                    $('#konfirmasi-modal').modal('hide'); //sembunyikan konfirmasi modal
                    $('#tombol-hapus').text('Hapus Data');
                    var oTable = $('#wartaJemaat').dataTable();
                    oTable.fnDraw(false); //reset datatable
                });
            }
        })
    });
</script>
@endsection