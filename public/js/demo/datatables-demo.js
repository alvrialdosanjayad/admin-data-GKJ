$(document).ready(function() {
    $('.alert').css('display', 'none');
    $('#hasilFilter').css('display', 'none');
    $('#input-search').css('display', 'inline-block');
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
                data: 'tanggal_lahir',
                name: 'tanggal_lahir',
            },
            {
                data: 'wilayah_gereja',
                name: 'wilayah_gereja'
            },
            {
                data: 'jenis_kelamin',
                name: 'jenis_kelamin'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });
    var columnWilayah = table.column(5);
    var columnJenisKelamin = table.column(6);


    // Toggle the visibility
    columnWilayah.visible(false);
    columnJenisKelamin.visible(false);

    $('#filter').on('change', function(e) {
        if ($('#filter').val() == 'wilayah') {
            $('#hasilFilter').css('display', 'inline-block');
            $.get('jemaat/ambilData/' + $('#filter').val(), function(data) {
                $('#hasilFilter').empty();
                columnWilayah.visible(true);
                columnJenisKelamin.visible(false);
                table.columns().search('').draw();
                $('#hasilFilter').append('<option value=""> -- Pilih Wilayah --</option>');
                $.each(data, function(index, subcatObj) {
                    $('#hasilFilter').append('<option value="' + subcatObj.wilayah_gereja + '">' + subcatObj.wilayah_gereja + '</option>');
                });
            })
        } else if ($('#filter').val() == 'jns_kelamin') {
            $('#hasilFilter').css('display', 'inline-block');
            $.get('jemaat/ambilData/' + $('#filter').val(), function(data) {
                $('#hasilFilter').empty();
                columnWilayah.visible(false);
                columnJenisKelamin.visible(true);
                table.columns().search('').draw();
                $('#hasilFilter').append('<option value=""> -- Pilih Jenis Kelamin --</option>');
                $.each(data, function(index, subcatObj) {
                    $('#hasilFilter').append('<option value="' + subcatObj.jenis_kelamin + '">' + subcatObj.jenis_kelamin + '</option>');
                });
            })
        } else {
            $('#hasilFilter').css('display', 'none');
            $('#hasilFilter').empty();
            columnWilayah.visible(false);
            columnJenisKelamin.visible(false);
            table.columns().search('').draw();
        }
    });

    $('#hasilFilter').on('change', function(e) {
        if ($('#filter').val() == 'wilayah') {
            columnWilayah.search($('#hasilFilter').val()).draw();
        }
        if ($('#filter').val() == 'jns_kelamin') {
            columnJenisKelamin.search($('#hasilFilter').val()).draw();
        }
    });

    $('#input-search').on('keyup change clear', function(e) {
        if ($('#filter').val() == 'nokk') {
            table.column(0)
                .search($('#input-search').val())
                .draw();
        }
        if ($('#filter').val() == 'nama') {
            table.column(1)
                .search($('#input-search').val())
                .draw();
        }
        if ($('#filter').val() == 'notel') {
            table.column(2)
                .search($('#input-search').val())
                .draw();
        }
        if ($('#filter').val() == 'alamat') {
            table.column(3)
                .search($('#input-search').val())
                .draw();
        }
        if ($('#filter').val() == 'wilayah') {
            table
                .search($('#input-search').val())
                .draw();
        }
        if ($('#filter').val() == 'jns_kelamin') {
            table
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
            $('#tombol-hapus').text('Hapus Data'); //set text untuk tombol hapus
        },
        success: function(data) { //jika sukses
            setTimeout(function() {
                $('#konfirmasi-modal').modal('hide'); //sembunyikan konfirmasi modal
                $('.alert').css('display', '');
                var oTable = $('#jemaat').dataTable();
                oTable.fnDraw(false); //reset datatable
            });
        }
    })
});