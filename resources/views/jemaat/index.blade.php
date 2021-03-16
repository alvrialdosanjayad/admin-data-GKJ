@extends('layouts.appUtama')

@section('tambahanCSS')
<!-- Custom styles for this page -->
<link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<style>
    #jemaat_filter {
        display: none;
    }
</style>
@endsection

@section('jemaat','active')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-start mb-2">
        <a href="{{ url('/jemaat/create')}}" class="col-xl-2 col-lg-3 col-md-4 btn btn-primary">
            <span class="text">Tambah Jemaat</span>
        </a>
        <a href="{{ route('cetak.viewCetak')}}" class="col-xl-2 col-lg-3 col-md-4 btn btn-primary ml-2">
            <span class="text">Cetak Data</span>
        </a>
    </div>

    <div class="card shadow mb-4 ">
        <div class="card-header py-3">
            <span class="h4 m-0 font-weight-bold text-primary">Daftar
                Jemaat</span>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label for="filter" class="d-inline">Filter Berdasarkan</label>
                <select class="form-control w-25 d-inline" id="filter">
                    <option value="" selected>Semua</option>
                    <option value="0">No KK</option>
                    <option value="1">Nama Lengkap</option>
                    <option value="2">No. Telp</option>
                    <option value="3">Alamat</option>
                    <option value="5">Wilayah</option>
                    <option value="6">Jenis Kelamin</option>
                    <option value="7">Baptis</option>
                    <option value="8">Pendidikan</option>
                </select>
                <select class="form-control w-25" id="hasilFilter"></select>
                <input type="text" class="form-control w-25" id="input-search" placeholder="Pencarian...">

            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="jemaat" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th width="15%">No KK</th>
                            <th width="20%">Nama Lengkap</th>
                            <th width="15%">No. Telp</th>
                            <th width="30%">Alamat</th>
                            <th width="15%">Tanggal Lahir</th>
                            <th width="15%">Wilayah</th>
                            <th width="15%">Jenis Kelamin</th>
                            <th width="15%">Baptis</th>
                            <th width="15%">Pendidikan</th>
                            <th width="5%">Action</th>
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
<div class="modal fade" id="tambah-edit-modal" data-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Excel</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success alert-dismissible fade show" id="alert-tambah-edit" role="alert"></div>
                <form id="form-tambah-edit" name="form-import" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="importExcel">
                        <p class="alert-message text-danger" id="importExcelError"></p>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-block" id="tombol-import" value="">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- AKHIR MODAL -->

<!-- MULAI MODAL KONFIRMASI DELETE-->
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
                <p><b>Data Jemaat akan dihapus, apakah anda yakin?</b></p>
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
    $('#hasilFilter').css('display', 'none');
    $('#input-search').css('display', 'none');
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#jemaat').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [1, "asc"]
            ],
            ajax: {
                url: "{{ route('jemaat.datatabel') }}",
                type: 'POST'
            },
            columns: [{
                    data: 'no_kk',
                    name: 'no_kk'
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                },
                {
                    data: 'wilayah',
                    name: 'wilayah'
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin'
                },
                {
                    data: 'baptis',
                    name: 'baptis'
                },
                {
                    data: 'pendidikan',
                    name: 'pendidikan'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
        // Toggle the visibility
        table.column(5).visible(false);
        table.column(6).visible(false);
        table.column(7).visible(false);
        table.column(8).visible(false);

        $('#filter').on('change', function(e) {
            $('#hasilFilter').css('display', 'none');
            $('#input-search').css('display', 'inline-block');
            $('#hasilFilter').empty();
            $('#input-search').empty();
            table.column(5).visible(false);
            table.column(6).visible(false);
            table.column(7).visible(false);
            table.column(8).visible(false);

            table.columns().search('').draw();
            if ($('#filter').val() == '') {
                $('#input-search').css('display', 'none');
            }
            if ($('#filter').val() == '5') {
                $('#hasilFilter').css('display', 'inline-block');
                $.get('jemaat/ambilData/' + $('#filter').val(), function(data) {
                    table.column(5).visible(true);
                    $('#hasilFilter').append('<option value=""> -- Pilih Wilayah --</option>');
                    $.each(data, function(index, subcatObj) {
                        $('#hasilFilter').append('<option value="' + subcatObj.wilayah + '">' + subcatObj.wilayah + '</option>');
                    });
                })
            } else if ($('#filter').val() == '6') {
                $('#hasilFilter').css('display', 'inline-block');
                $.get('jemaat/ambilData/' + $('#filter').val(), function(data) {
                    table.column(6).visible(true);
                    $('#hasilFilter').append('<option value=""> -- Pilih Jenis Kelamin --</option>');
                    $.each(data, function(index, subcatObj) {
                        $('#hasilFilter').append('<option value="' + subcatObj.jenis_kelamin + '">' + subcatObj.jenis_kelamin + '</option>');
                    });
                })
            } else if ($('#filter').val() == '7') {
                $('#hasilFilter').css('display', 'inline-block');
                $('#hasilFilter').append('<option value=""> -- Pilih Data --</option>');
                $('#hasilFilter').append('<option value="sudah"> Sudah </option>');
                $('#hasilFilter').append('<option value="belum"> Belum </option>');
            } else if ($('#filter').val() == '8') {
                $('#hasilFilter').css('display', 'inline-block');
                $.get('jemaat/ambilData/' + $('#filter').val(), function(data) {
                    table.column(8).visible(true);
                    $('#hasilFilter').append('<option value=""> -- Pilih Pendidikan --</option>');
                    $.each(data, function(index, subcatObj) {
                        $('#hasilFilter').append('<option value="' + subcatObj.pendidikan + '">' + subcatObj.pendidikan + '</option>');
                    });
                })

            }

        });

        $('#hasilFilter').on('change', function(e) {
            var inputFilter = $('#filter').val();
            table.column(inputFilter)
                .search($('#hasilFilter').val())
                .draw();
        });

        $('#input-search').on('keyup change clear', function(e) {
            var inputFilter = $('#filter').val();
            if (inputFilter == '5' || inputFilter == '6' || inputFilter == '7' || inputFilter == '8') {
                table
                    .search($('#input-search').val())
                    .draw();
            } else {
                table.column(inputFilter)
                    .search($('#input-search').val())
                    .draw();
            }

        });

    });

    $(document).on('click', '.delete', function() {
        dataId = $(this).attr('id');
        $('#konfirmasi-modal').modal('show');
    });

    $('#tombol-hapus').click(function() {

        $.ajax({
            url: "jemaat/" + dataId, //eksekusi ajax ke url ini
            type: 'delete',
            beforeSend: function() {
                $('#tombol-hapus').text('Proses..');
            },
            success: function(data) { //jika sukses
                setTimeout(function() {
                    $('#konfirmasi-modal').modal('hide'); //sembunyikan konfirmasi modal
                    $('#tombol-hapus').text('Hapus Data'); //set text untuk tombol hapus
                    var oTable = $('#jemaat').dataTable();
                    oTable.fnDraw(false); //reset datatable
                });
            }
        })
    });
</script>
@endsection