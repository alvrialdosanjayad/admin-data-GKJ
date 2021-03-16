<!DOCTYPE html>
<html>

<head>
    <title>GKJ Gondokusuman</title>
    <style>
        .judul,
        .tanggal {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 class="judul">Data Jemaat GKJ Gondokusuman</h1>
    <h4 class="tanggal">{{$tanggal}}</h4>
    <table cellspacing="0" width="100%">
        <tr>
            <td width="20%">Nama</td>
            <td width="80%">: {{$cek->nama_lengkap}}</td>
        </tr>
        <tr>
            <td width="20%">No. KK</td>
            <td width="80%">: {{$cek->no_kk}}</td>
        </tr>
        <tr>
            <td width="20%">Tempat Lahir</td>
            <td width="80%">: {{$cek->tempat_lahir}}</td>
        </tr>
        <tr>
            <td width="20%">Tanggal Lahir</td>
            <td width="80%">: {{date('d F Y', strtotime($cek->tanggal_lahir))}}</td>
        </tr>

        <tr>
            <td width="20%">Jenis Kelamin</td>
            <td width="80%">: {{$cek->jenis_kelamin}}</td>
        </tr>
        <tr>
            <td width="20%">Gol. Darah</td>
            <td width="80%">: {{$cek->golangan_darah}}</td>
        </tr>
        <tr>
            <td width="20%">No. HP</td>
            @if ($cek->no_hp === null)
            <td width="80%">: -</td>
            @else
            <td width="80%">: {{$cek->no_hp}}</td>
            @endif
        </tr>
        <tr>
            <td width="20%">No. Telp</td>
            @if ($cek->no_tlpn === null)
            <td width="80%">: -</td>
            @else
            <td width="80%">: {{$cek->no_tlpn}}</td>
            @endif
        </tr>
        <tr>
            <td width="20%">Nama Ayah</td>
            @if ($cek->nama_ayah === null)
            <td width="80%">: -</td>
            @else
            <td width="80%">: {{$cek->nama_ayah}}</td>
            @endif
        </tr>
        <tr>
            <td width="20%">Nama Ibu</td>
            @if ($cek->nama_ibu === null)
            <td width="80%">: -</td>
            @else
            <td width="80%">: {{$cek->nama_ibu}}</td>
            @endif
        </tr>
        <tr>
            <td width="20%">Pendidikan</td>
            <td width="80%">: {{$cek->pendidikan}}</td>
        </tr>
        <tr>
            <td width="20%">Alamat</td>
            <td width="80%">: {{$cek->alamat}}</td>
        </tr>
        <tr>
            <td width="20%">Hub. Keluarga</td>
            <td width="80%">: {{$cek->hub_keluarga}}</td>
        </tr>
        <tr>
            <td width="20%">Pekerjaan</td>
            <td width="80%">: {{$cek->pekerjaan}}</td>
        </tr>
        <tr>
            <td width="20%">Status Nikah</td>
            <td width="80%">: {{$cek->status_nikah}}</td>
        </tr>
        <tr>
            <td width="20%">Tanggal Nikah</td>
            @if ($cek->tgl_nikah === null)
            <td width="80%">: -</td>
            @else
            <td width="80%">: {{date('d F Y', strtotime($cek->tgl_nikah))}}</td>
            @endif
        </tr>
        <tr>
            <td width="20%">Pendeta Nikah</td>
            @if ($cek->pendeta_nikah === null)
            <td width="80%">: -</td>
            @else
            <td width="80%">: {{$cek->pendeta_nikah}}</td>
            @endif
        </tr>
        <tr>
            <td width="20%">Nama Suami/Istri</td>
            @if ($cek->nama_suamiistri === null)
            <td width="80%">: -</td>
            @else
            <td width="80%">: {{$cek->nama_suamiistri}}</td>
            @endif
        </tr>
        <tr>
            <td width="20%">Keadaan</td>
            <td width="80%">: {{$cek->status_keadaan}}</td>
        </tr>
        <tr>
            <td width="20%">Tanggal Meninggal</td>
            @if ($cek->tgl_meninggal === null)
            <td width="80%">: -</td>
            @else
            <td width="80%">: {{date('d F Y', strtotime($cek->tgl_meninggal))}}</td>
            @endif
        </tr>
        <tr>
            <td width="20%">Tempat Meninggal</td>
            @if ($cek->tempat_meninggal === null)
            <td width="80%">: -</td>
            @else
            <td width="80%">: {{$cek->tempat_meninggal}}</td>
            @endif
        </tr>
    </table>
</body>

</html>