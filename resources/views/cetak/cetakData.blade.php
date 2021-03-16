@extends('layouts.appUtama')

@section('tambahanCSS')
<style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endsection

@section('jemaat','active')

@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session('status') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            Pilih Data
        </div>
        <div class="card-body">
            <form action="{{route('cetak.cetakData')}}" method="POST">
                @csrf
                <table class="table table-md table-borderless" cellspacing="0" width="100%">
                    <tr>
                        <td width="20%"><label for="filter">Filter Berdasarkan</label></td>
                        <td width="80%">
                            <select class="form-control w-50" id="filter" name="filterCetak">
                                <option value="semua">Semua</option>
                                <option value="pendidikan">Pendidikan</option>
                                <option value="jenis_kelamin">Jenis Kelamin</option>
                                <option value="umur">Umur</option>
                                <option value="wilayah">Wilayah</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="80%">
                            <select class="form-control w-25" id="kategori-filter" name="kategoriCetak"></select>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"></td>
                        <td width="80%" id="filterumur">
                            <input type="number" class="form-control kurang-lebih" style="width: 10%; display: inline;" name="umur1">
                            <p class="diantara" style="display: inline;"> - </p>
                            <input type="number" class="form-control diantara" style="width: 10%; display: inline;" name="umur2">
                        </td>
                    </tr>
                    <tr>
                        <td><button type="submit" class="btn btn-primary" id="button-cetak">Cetak</button></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

@endsection

@section('tambahanJS')
<!-- Page level plugins -->
<script>
    $('#filterumur').css('display', 'none');
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#filter').on('change', function(e) {
            $('#kategori-filter').empty();
            if ($('#filter').val() == 'umur') {
                $('#filterumur').css('display', '');
                $('.diantara').css('display', 'none')
                $('#kategori-filter').append('<option value="kurangdari" selected>Kurang dari</option>');
                $('#kategori-filter').append('<option value="diantara">diantara</option>');
                $('#kategori-filter').append('<option value="lebihdari">Lebih dari</option>');
            } else {
                $.get('/cetak/ambilDataFilter/' + $('#filter').val(), function(data) {

                    $.each(data, function(index, subcatObj) {
                        $('#kategori-filter').append('<option value="' + subcatObj.id + '">' + subcatObj.data + '</option>');
                    });
                })

                $('#filterumur').css('display', 'none');
            }

        });
        $('#kategori-filter').on('change', function(e) {
            if ($('#kategori-filter').val() == 'kurangdari' || $('#kategori-filter').val() == 'lebihdari') {
                $('.diantara').css('display', 'none')
            } else {
                $('.diantara').css('display', 'inline')
            }

        });
        
         $('#button-cetak').on('click', function(e) {
           $(".close").click();

        });

    });
</script>

@endsection