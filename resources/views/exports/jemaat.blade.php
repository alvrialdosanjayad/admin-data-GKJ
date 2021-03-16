<table>
    <thead>
        <tr>
            <th>kode</th>
            <th>nama_lengkap</th>
            <th>tanggal lahir</th>
        </tr>
    </thead>
    <tbody>
        @foreach($jemaat as $jemaat)
        {{$date=date_create($jemaat->tanggal_lahir)}}
        <tr>
            <td>{{ $jemaat->kode_jemaat }}</td>
            <td>{{ $jemaat->nama_lengkap }}</td>
            <td>{{ date_format($date,"Y/m/d H:i:s")}}</td>
        </tr>
        @endforeach
    </tbody>
</table>