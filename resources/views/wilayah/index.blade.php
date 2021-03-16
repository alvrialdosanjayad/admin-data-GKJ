@extends('layouts.appUtama')

@section('tambahanCSS')
<!-- Custom styles for this page -->
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('wilayah','active')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-start">
        <button type="button" class="btn btn-primary col-xl-2 col-lg-3 col-md-4 mb-2" id="tombol-tambah">
            <span class="text">Tambah Wilayah</span>
        </button>
    </div>


    <div class="card shadow mb-4 t">
        <div class="card-header py-3">
            <span class="h4 m-0 font-weight-bold text-primary">Daftar
                Wilayah</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="wilayah" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="80%">Nama Wilayah</th>
                            <th width="20%">Action</th>
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
<!-- MODAL TAMBAH WILAYAH BARU -->
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
                            <input type="hidden" class="form-control" name="kodeWilayah" id="kodeWilayah">
                            <div class="form-group">
                                <label for="namaWilayah">Nama Wilayah</label>
                                <input type="text" class="form-control" name="wilayah" id="namaWilayah">
                                <div class="alert-message text-danger" id="namaWilayahError"></div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-block" id="tombol-simpan" value="create">Simpan</button>
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
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><b>Wilayah akan dihapus, apakah anda yakin?</b></p>
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

<!-- Page level custom scripts -->

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $(document).ready(function() {
        $('#wilayah').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('wilayah.index') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'wilayah',
                    name: 'wilayah'
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
        $('.alert').css('display', 'none')
        $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
        $('#modal-judul').html("Tambah Wilayah Baru"); //valuenya tambah pegawai baru
        $('#namaWilayahError').text('');
        $('#namaWilayah').attr('placeholder', '');
        $('#tombol-simpan').val('tambah'); //tombol simpan
        $('#tambah-edit-modal').modal('show'); //modal tampil

    });

    $("#tombol-simpan").click(function(e) {
        $('#tombol-simpan').html('Proses...'); //tombol simpan
        $('.alert').css('display', 'none');
        $("#tombol-simpan").prop("disabled", true);
        e.preventDefault();
        $.ajax({
            data: $('#form-tambah-edit').serialize(), //function yang dipakai agar value pada form-control seperti input, textarea, select dll dapat digunakan pada URL query string ketika melakukan ajax request
            url: "{{route('wilayah.store')}}", //url simpan data
            type: "POST", //karena simpan kita pakai method POST
            dataType: 'json', //data tipe kita kirim berupa JSON
            success: function(data) { //jika berhasil
                $('#namaWilayahError').text('');
                if ($('#tombol-simpan').val() == "tambah") {
                    $('#alert-tambah-edit').text('Data berhasil di tambah')

                } else {
                    $('#alert-tambah-edit').text('Data berhasil di ubah')
                }
                $('.alert').css('display', '')
                $("#tombol-simpan").prop("disabled", false);
                $('#tombol-simpan').html('Simpan'); //tombol simpan
                var oTable = $('#wilayah').dataTable(); //inialisasi datatable
                oTable.fnDraw(false); //reset datatable
            },
            error: function(data) {
                $('.alert').css('display', 'none')
                $("#tombol-simpan").prop("disabled", false);
                $('#tombol-simpan').html('Simpan'); //tombol simpan
                $('#namaWilayahError').text('');
                $('#namaWilayahError').text(data.responseJSON.errors.wilayah);

            }
        });
    });

    $('body').on('click', '.edit-post', function() {
        var data_id = $(this).data('id');
        $.get('wilayah/' + data_id + '/edit', function(data) {
            $('.alert').css('display', 'none');
            $('#tombol-simpan').val('ubah'); //tombol simpan
            $('#modal-judul').html("Edit Wilayah");
            $('#form-tambah-edit').trigger("reset"); //mereset semua input dll didalamnya
            $('#namaWilayahError').text('');
            $('#tambah-edit-modal').modal('show');

            //set value masing-masing id berdasarkan data yg diperoleh dari ajax get request diatas               
            $('#kodeWilayah').val(data.id);
            $('#namaWilayah').attr('placeholder', data.wilayah);
        })
    });

    $(document).on('click', '.delete', function() {
        dataId = $(this).attr('id');
        $('#konfirmasi-modal').modal('show');
    });

    $('#tombol-hapus').click(function() {
        $.ajax({
            url: "wilayah/" + dataId, //eksekusi ajax ke url ini
            type: 'delete',
            beforeSend: function() {
                $('#tombol-hapus').text('Proses...'); //set text untuk tombol hapus
            },
            success: function(data) { //jika sukses
                setTimeout(function() {
                    $('#konfirmasi-modal').modal('hide'); //sembunyikan konfirmasi modal
                    $('#tombol-hapus').text('Hapus Data'); //set text untuk tombol hapus
                    var oTable = $('#wilayah').dataTable();
                    oTable.fnDraw(false); //reset datatable
                });
            }
        })
    });
</script>
@endsection