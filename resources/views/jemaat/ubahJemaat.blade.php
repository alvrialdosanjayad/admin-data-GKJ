@extends('layouts.appUtama')

@section('tambahanCSS')
<style>
    .tab {
        display: none;
    }

    .pertama {
        display: none;
    }
</style>

@endsection

@section('jemaat','active')

@section('content')
<div class="container-fluid">
    <form id="regForm" method="POST" action="{{url('/jemaat/' . $jemaat->kode_jemaat . '')}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card">
            <h5 class="card-header bg-dark text-white">Ubah Data 1</h5>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="namaLengkap">Nama Lengkap</label>
                            <input type="text" class="form-control" id="namaLengkap" name="namaLengkap" value="{{$jemaat['nama_lengkap']}}">
                        </div>
                        <div class="form-group">
                            <label for="noKk">No. KK</label>
                            <input type="text" class="form-control wajib" id="noKk" name="noKk" value="{{$jemaat['no_kk']}}" oninput=" this.className='form-control'">
                            @error('noKk')
                            <p class=" text-danger">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hubKeluarga">Hub. Keluarga</label>
                            <select class="form-control" id="hubKeluarga" name="hubKeluarga">
                                @foreach($hubKeluarga as $hubKeluarga)
                                @if ($jemaat['hub_keluarga'] === $hubKeluarga['id'])
                                <option value="{{$hubKeluarga['id']}}" selected>{{$hubKeluarga['hub_keluarga']}}</option>
                                @else
                                <option value="{{$hubKeluarga['id']}}">{{$hubKeluarga['hub_keluarga']}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="statusJemaat">Status Jemaat</label>
                            <select class="form-control" id="statusJemaat" name="statusJemaat">
                                @foreach($statusJemaat as $status)
                                @if ($jemaat['status_jemaat'] === $status['id'])
                                <option value="{{$status['id']}}" selected>{{$status['status_jemaat']}}</option>
                                @else
                                <option value="{{$status['id']}}">{{$status['status_jemaat']}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="wilGereja">Wilayah Gereja</label>
                            <select class="form-control" id="wilGereja" name="wilGereja">
                                @foreach($wilayah as $wilayah)
                                @if ($jemaat['wilayah_gereja'] === $wilayah['id'])
                                <option value="{{$wilayah['id']}}" selected>{{$wilayah['wilayah']}}</option>
                                @else
                                <option value="{{$wilayah['id']}}">{{$wilayah['wilayah']}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tempatLahir">Tempat Lahir</label>
                            <input type="text" class="form-control wajib" id="tempatLahir" name="tempatLahir" value="{{$jemaat['tempat_lahir']}}" oninput="this.className = 'form-control'">
                        </div>
                        <div class="form-group">
                            <label for="tglLahir">Tanggal Lahir</label>
                            <input type="date" class="form-control wajib" id="tglLahir" name="tglLahir" value="{{$jemaat['tanggal_lahir']}}" oninput="this.className = 'form-control'">
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jnsKelamin">Jenis kelamin</label>
                            <select class="form-control" id="jnsKelamin" name="jnsKelamin">
                                @foreach($jnsKelamin as $jnsKelamin)
                                @if ($jemaat['jenis_kelamin'] === $jnsKelamin['id'])
                                <option value="{{$jnsKelamin['id']}}" selected>{{$jnsKelamin['jenis_kelamin']}}</option>
                                @else
                                <option value="{{$jnsKelamin['id']}}">{{$jnsKelamin['jenis_kelamin']}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="golDarah">Gol. Darah</label>
                            <select class="form-control" id="golDarah" name="golDarah">
                                @foreach($golDarah as $golDarah)
                                @if ($jemaat['golongan_darah'] === $golDarah['id'])
                                <option value="{{$golDarah['id']}}" selected>{{$golDarah['golangan_darah']}}</option>
                                @else
                                <option value="{{$golDarah['id']}}">{{$golDarah['golangan_darah']}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="noTelp">No. Telp</label>
                            <input type="text" class="form-control" id="noTelp" name="noTelp" value="{{$jemaat['no_tlpn']}}">
                        </div>
                        <div class="form-group">
                            <label for="noHp">No. Hp</label>
                            <input type="text" class="form-control" id="noHp" name="noHp" value="{{$jemaat['no_hp']}}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control wajib" id="alamat" rows="5" name="alamat" oninput="this.className = 'form-control'">{{$jemaat['alamat']}}</textarea>
                        </div>

                    </div>
                </div>

            </div>
        </div>


        <div class="card tab">
            <h5 class="card-header bg-dark text-white">Ubah Data 2</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pendidikan">Pendidikan</label>
                            <select class="form-control" id="pendidikan" name="pendidikan">
                                @foreach($pendidikan as $pendidikan)
                                @if ($jemaat['pendidikan'] === $pendidikan['id'])
                                <option value="{{$pendidikan['id']}}" selected>{{$pendidikan['pendidikan']}}</option>
                                @else
                                <option value="{{$pendidikan['id']}}">{{$pendidikan['pendidikan']}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{$jemaat['pekerjaan']}}">
                        </div>
                        <div class="form-group">
                            <label for="namaAyah">Nama Ayah</label>
                            <input type="text" class="form-control" id="namaAyah" name="namaAyah" value="{{$jemaat['nama_ayah']}}">
                        </div>
                        <div class="form-group">
                            <label for="namaIbu">Nama Ibu</label>
                            <input type="text" class="form-control" id="namaIbu" name="namaIbu" value="{{$jemaat['nama_ibu']}}">
                        </div>
                        <div class="form-group">
                            <label for="statusNikah">Status Nikah</label>
                            <select class="form-control" id="statusNikah" name="statusNikah">
                                @foreach($statusNikah as $statusNikah)
                                @if ($jemaat['status_nikah'] === $statusNikah['id'])
                                <option value="{{$statusNikah['id']}}" selected>{{$statusNikah['status_nikah']}}</option>
                                @else
                                <option value="{{$statusNikah['id']}}">{{$statusNikah['status_nikah']}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tglNikah">Tanggal Nikah</label>
                            <input type="date" class="form-control" id="tglNikah" name="tglNikah" value="{{$jemaat['tgl_nikah']}}">
                        </div>
                        <div class="form-group">
                            <label for="suratBaptis">Upload Surat Baptis (JPG/PNG)</label>
                            <input type="file" class="form-control-file" name="suratBaptis">
                            @error('suratBaptis')
                            <p class="text-danger">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="grjNikah">Gereja Nikah</label>
                            <input type="text" class="form-control" id="grjNikah" name="grjNikah" value="{{$jemaat['gereja_nikah']}}">
                        </div>
                        <div class="form-group">
                            <label for="pdtNikah">Pendeta Nikah</label>
                            <input type="text" class="form-control" id="pdtNikah" name="pdtNikah" value="{{$jemaat['gereja_nikah']}}">
                        </div>
                        <div class="form-group">
                            <label for="namaSuamiIstri">Nama Suami/Istri</label>
                            <input type="text" class="form-control" id="namaSuamiIstri" name="namaSuamiIstri" value="{{$jemaat['nama_suamiistri']}}">
                        </div>
                        <div class="form-group">
                            <label for="keadaan">Keadaan</label>
                            <select class="form-control" id="keadaan" name="keadaan">
                                @foreach($keadaan as $keadaan)
                                <option value="{{$keadaan['id']}}">{{$keadaan['status_keadaan']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tglMeninggal">Tanggal Meninggal</label>
                            <input type="date" class="form-control" id="tglMeninggal" name="tglMeninggal" value="{{$jemaat['tgl_meninggal']}}">
                        </div>
                        <div class="form-group">
                            <label for="tmptMeninggal">Tempat Meninggal</label>
                            <input type="text" class="form-control" id="tmptMeninggal" name="tmptMeninggal" value="{{$jemaat['tempat_meninggal']}}">
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="d-flex justify-content-end my-2">
            <button type="button" class="btn btn-primary pertama mr-2" id="prevBtn" onclick="nextPrev(-1)">Sebelumnya</button>
            <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Lanjut</button>
        </div>
        <div></div>

    </form>

</div>
<!-- /.container-fluid -->

@endsection

@section('tambahanJS')
<!-- Page level plugins -->
<script src="{{asset('js/formulir.js')}}"></script>
@endsection