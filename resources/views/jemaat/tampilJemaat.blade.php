@extends('layouts.appUtama')

@section('jemaat','active')

@section('content')
<div class="container-fluid">
    @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('status') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="card shadow mb-4 ">
        <div class="card-header py-3">
            <span class="h4 m-0 font-weight-bold text-primary">
                {{$jemaat->nama_lengkap}}
            </span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-borderless" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <th width="15%">No. KK</th>
                            <td width="35%">: {{$jemaat->no_kk}}</td>
                            <th width="15%">Hub. Keluarga</th>
                            <td width="35%">: {{$jemaat->hub_keluarga}}</td>
                        </tr>
                        <tr>
                            <th width="15%">Tempat lahir</th>
                            <td width="35%">: {{$jemaat->tempat_lahir}}</td>
                            <th width="15%">Pekerjaan</th>
                            @if ($jemaat->pekerjaan === null || $jemaat->pekerjaan === '')
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{$jemaat->pekerjaan}}</td>
                            @endif
                        </tr>
                        <tr>
                            <th width="15%">Tanggal Lahir</th>
                            <td width="35%">: {{date('d F Y', strtotime($jemaat->tanggal_lahir))}}</td>
                            <th width="15%">Status Nikah</th>
                            <td width="35%">: {{$jemaat->status_nikah}}</td>
                        </tr>
                        <tr>
                            <th width="15%">Jenis Kelamin</th>
                            <td width="35%">: {{$jemaat->jenis_kelamin}}</td>
                            <th width="15%">Tanggal Nikah</th>
                            @if ($jemaat->tgl_nikah === null || $jemaat->tgl_nikah === '' || $jemaat->tgl_nikah === '0000-00-00')
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{date('d F Y', strtotime($jemaat->tgl_nikah))}}</td>
                            @endif
                        </tr>
                        <tr>
                            <th width="15%">Gol. Darah</th>
                            <td width="35%">: {{$jemaat->golangan_darah}}</td>
                            <th width="15%">Pendeta Nikah</th>
                            @if ($jemaat->pendeta_nikah === null || $jemaat->pendeta_nikah === '')
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{$jemaat->pendeta_nikah}}</td>
                            @endif
                        </tr>
                        <tr>
                            <th width="15%">No. HP</th>
                            @if ($jemaat->no_hp === null)
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{$jemaat->no_hp}}</td>
                            @endif
                            <th width="15%">Nama Suami/Istri</th>
                            @if ($jemaat->nama_suamiistri === null || $jemaat->nama_suamiistri === '')
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{$jemaat->nama_suamiistri}}</td>
                            @endif
                        </tr>
                        <tr>
                            <th width="15%">No. Telp</th>
                            @if ($jemaat->no_tlpn === null || $jemaat->no_tlpn === '')
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{$jemaat->no_tlpn}}</td>
                            @endif
                            <th width="15%">Keadaan</th>
                            <td width="35%">: {{$jemaat->status_keadaan}}</td>

                        </tr>
                        <tr>
                            <th width="15%">Nama Ayah</th>
                            @if ($jemaat->nama_ayah === null || $jemaat->nama_ayah === '')
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{$jemaat->nama_ayah}}</td>
                            @endif
                            <th width="15%">Tanggal Meninggal</th>
                            @if ($jemaat->tgl_meninggal === null || $jemaat->tgl_meninggal === '')
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{date('d F Y', strtotime($jemaat->tgl_meninggal))}}</td>
                            @endif
                        </tr>
                        <tr>
                            <th width="2%">Nama Ibu</th>
                            @if ($jemaat->nama_ibu === null || $jemaat->nama_ibu === '')
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{$jemaat->nama_ibu}}</td>
                            @endif
                            <th width="15%">Tempat Meninggal</th>
                            @if ($jemaat->tempat_meninggal === null || $jemaat->tempat_meninggal === '')
                            <td width="35%">: -</td>
                            @else
                            <td width="35%">: {{$jemaat->tempat_meninggal}}</td>
                            @endif
                        </tr>
                        <tr>
                            <th width="15%">Pendidikan</th>
                            <td width="35%">: {{$jemaat->pendidikan}}</td>
                            <th width="15%">Status Jemaat</th>
                            <td width="35%">: {{$jemaat->status_jemaat}}</td>
                        </tr>
                        <tr>
                            <th width="15%">Alamat</th>
                            <td width="35%">: {{$jemaat->alamat}}</td>
                            <th width="15%">Wilayah</th>
                            <td width="35%">: {{$jemaat->wilayah}}</td>
                        </tr>

                    </tbody>

                </table>

            </div>
            <a href="{{url('/jemaat/' . Crypt::encryptString($id) . '/edit')}}" class="btn btn-primary btn-sm edit-post"><i class="far fa-edit"></i> Ubah Data</a>
            <a href="{{route('cetak.cetakJemaat', Crypt::encryptString($id))}}" class="btn btn-primary btn-sm edit-post"><i class="fa fa-print"></i> Cetak Data</a>
            @if ($jemaat->foto_surat_baptis != null || $jemaat->foto_surat_baptis != '')
            <a href="{{route('jemaat.baptis', $jemaat->foto_surat_baptis)}}" class="btn btn-primary btn-sm edit-post"><i class="fa fa-download"></i> Unduh Surat Baptis</a>
            @endif

        </div>

    </div>

</div>
@endsection