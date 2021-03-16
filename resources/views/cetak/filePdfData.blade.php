<!DOCTYPE html>
<html>

<head>
    <title>GKJ Gondokusuman</title>
    <style>
        html {
            margin: 0px;
        }

        .judul {
            text-align: center;
        }

        .table1 {
            font-family: sans-serif;
            color: #444;
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #f2f5f7;
        }

        .table1 tr th {
            background: #35A9DB;
            color: #fff;
            font-weight: bold;
        }

        .table1,
        th,
        td,
        .jumlah-data {
            padding: 0px 10px;
            text-align: left;
            font-size: 13px;
        }

        .table1 tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1 class="judul">GKJ Gondokusuman</h1>
    <h4 class="judul">{{$tanggal}}</h4>
    <h4 class="jumlah-data">Total Data : {{$jumlah_data}}</h4>
    <table class="table1">
        <tr>
            <th>No. KK</th>
            <th>Nama Lengkap</th>
            <th>No. Telp</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Pendidikan</th>
            <th>Pekerjaan</th>
            <th>Wilayah</th>
            <th>Jenis Kelamin</th>
            @if ($dataUmur === 'ada')
            <th>Umur</th>
            @endif
        </tr>

        @for ($i = 0; $i < $jumlah_data; $i++) <tr>
            <td>{{ $cek[$i]->no_kk }}</td>
            <td>{{ $cek[$i]->nama_lengkap }}</td>
            <td>{{ $cek[$i]->no_hp }}</td>
            <td>{{ $cek[$i]->alamat }}</td>
            <td>{{ date('d F Y', strtotime($cek[$i]->tanggal_lahir)) }}</td>
            <td>{{ $cek[$i]->pendidikan }}</td>
            <td>{{ $cek[$i]->pekerjaan }}</td>
            <td>{{ $cek[$i]->wilayah }}</td>
            <td>{{ $cek[$i]->jenis_kelamin }}</td>
            @if ($dataUmur === 'ada')
            <td>{{ $cek[$i]->umur }}</td>
            @endif
            </tr>
            @endfor


    </table>
</body>

</html>