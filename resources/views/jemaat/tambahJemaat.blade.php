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

    <form id="regForm" method="POST" action="/jemaat" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <h5 class="card-header bg-dark text-white">Formulir 1</h5>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="namaLengkap">Nama Lengkap</label>
                            <input type="text" class="form-control wajib" id="namaLengkap" name="namaLengkap" value="{{ old('namaLengkap') }}" oninput="this.className = 'form-control wajib'">
                        </div>
                        <div class="form-group">
                            <label for="noKk">No. KK</label>
                            <input type="text" class="form-control wajib" id="noKk" name="noKk" value="{{ old('noKk') }}" oninput="this.className = 'form-control wajib'">
                            @error('noKk')
                            <p class="text-danger">
                                <strong>{{ $message }}</strong>
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hubKeluarga">Hub. Keluarga</label>
                            <select class="form-control wajib" id="hubKeluarga" name="hubKeluarga" oninput="this.className = 'form-control wajib'">
                                <option value="">-- Pilih Hub Keluarga --</option>
                                @foreach($hubKeluarga as $hubKeluarga)
                                <option value="{{$hubKeluarga['id']}}">{{$hubKeluarga['hub_keluarga']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="statusjemaat">Status Jemaat</label>
                            <select class="form-control wajib" id="statusjemaat" name="statusjemaat" oninput="this.className = 'form-control wajib'">
                                <option value="">-- Pilih Status Jemaat --</option>
                                @foreach($status_jemaat as $status_jemaat)
                                <option value="{{$status_jemaat['id']}}">{{$status_jemaat['status_jemaat']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="wilGereja">Wilayah Gereja</label>
                            <select class="form-control wajib" id="wilGereja" name="wilGereja" oninput="this.className = 'form-control wajib'">
                                <option value="">-- Pilih Wilayah --</option>
                                @foreach($wilayah as $wilayah)
                                <option value="{{$wilayah['id']}}">{{$wilayah['wilayah']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tempatLahir">Tempat Lahir</label>
                            <input type="text" class="form-control wajib" id="tempatLahir" name="tempatLahir" value="{{ old('tempatLahir') }}" oninput="this.className = 'form-control wajib'">
                        </div>
                        <div class="form-group">
                            <label for="tglLahir">Tanggal Lahir</label>
                            <input type="date" class="form-control wajib" id="tglLahir" name="tglLahir" value="{{ old('tglLahir') }}" oninput="this.className = 'form-control wajib'">
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jnsKelamin">Jenis kelamin</label>
                            <select class="form-control wajib" id="jnsKelamin" name="jnsKelamin" oninput="this.className = 'form-control wajib'">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                @foreach($jnsKelamin as $jnsKelamin)
                                <option value="{{$jnsKelamin['id']}}">{{$jnsKelamin['jenis_kelamin']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="golDarah">Gol. Darah</label>
                            <select class="form-control wajib" id="golDarah" name="golDarah" oninput="this.className = 'form-control wajib'">
                                <option value="">-- Pilih Gol Darah --</option>
                                @foreach($golDarah as $golDarah)
                                <option value="{{$golDarah['id']}}">{{$golDarah['golangan_darah']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="noTelp">No. Telp</label>
                            <input type="text" class="form-control" id="noTelp" name="noTelp" value="{{ old('noTelp') }}">
                        </div>
                        <div class="form-group">
                            <label for="noHp">No. Hp</label>
                            <input type="text" class="form-control" id="noHp" name="noHp" value="{{ old('noHp') }}">

                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control wajib" id="alamat" rows="5" name="alamat" value="{{ old('alamat') }}" oninput="this.className = 'form-control wajib'"></textarea>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="card tab">
            <h5 class="card-header bg-dark text-white">Formulir 2</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pendidikan">Pendidikan</label>
                            <select class="form-control wajib" id="pendidikan" name="pendidikan" oninput="this.className = 'form-control wajib'">
                                <option value="">-- Pilih Pendidikan --</option>
                                @foreach($pendidikan as $pendidikan)
                                <option value="{{$pendidikan['id']}}">{{$pendidikan['pendidikan']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}">

                        </div>
                        <div class="form-group">
                            <label for="namaAyah">Nama Ayah</label>
                            <input type="text" class="form-control" id="namaAyah" name="namaAyah" value="{{ old('namaAyah') }}">
                        </div>
                        <div class="form-group">
                            <label for="namaIbu">Nama Ibu</label>
                            <input type="text" class="form-control" id="namaIbu" name="namaIbu" value="{{ old('namaIbu') }}">
                        </div>
                        <div class="form-group">
                            <label for="statusNikah">Status Nikah</label>
                            <select class="form-control" id="statusNikah" name="statusNikah">
                                @foreach($statusNikah as $statusNikah)
                                <option value="{{$statusNikah['id']}}">{{$statusNikah['status_nikah']}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tglNikah">Tanggal Nikah</label>
                            <input type="date" class="form-control" id="tglNikah" name="tglNikah" value="{{ old('tglNikah') }}">
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
                            <input type="text" class="form-control" id="grjNikah" name="grjNikah" value="{{ old('grjNikah') }}">
                        </div>
                        <div class="form-group">
                            <label for="pdtNikah">Pendeta Nikah</label>
                            <input type="text" class="form-control" id="pdtNikah" name="pdtNikah" value="{{ old('pdtNikah') }}">
                        </div>
                        <div class="form-group">
                            <label for="namaSuamiIstri">Nama Suami/Istri</label>
                            <input type="text" class="form-control" id="namaSuamiIstri" name="namaSuamiIstri" value="{{ old('namaSuamiIstri') }}">
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
                            <input type="date" class="form-control" id="tglMeninggal" name="tglMeninggal" value="{{ old('tglMeninggal') }}">
                        </div>
                        <div class="form-group">
                            <label for="tmptMeninggal">Tempat Meninggal</label>
                            <input type="text" class="form-control" id="tmptMeninggal" name="tmptMeninggal" value="{{ old('tmptMeninggal') }}">
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="d-flex justify-content-end my-2">
            <button type="button" class="btn btn-primary pertama mr-2" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
        </div>
    </form>

</div>
<!-- /.container-fluid -->

@endsection

@section('tambahanJS')
<!-- Page level plugins -->
<script src="{{asset('js/formulir.js')}}"></script>

@endsection