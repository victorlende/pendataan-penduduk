@extends('surat.print.layout')

@section('surat_content')
    <h3 class="title">SURAT KETERANGAN DOMISILI</h3>
    <p class="nomor-surat">Nomor: {{ $surat->nomor_surat }}</p>

    <p>Yang bertanda tangan di bawah ini Kepala Desa Naisau, Kecamatan Fatukopa, Kabupaten Timor Tengah Selatan, dengan ini menerangkan bahwa:</p>

    <table class="table-data">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td><strong>{{ strtoupper($surat->penduduk->nama_lengkap) }}</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->penduduk->nik }}</td>
        </tr>
        <tr>
            <td>Tempat/Tgl Lahir</td>
            <td>:</td>
            <td>{{ $surat->penduduk->tempat_lahir }}, {{ \Carbon\Carbon::parse($surat->penduduk->tanggal_lahir)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{ $surat->penduduk->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $surat->penduduk->pekerjaan }}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{ $surat->penduduk->agama }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>Dusun {{ $surat->penduduk->dusun ? $surat->penduduk->dusun->nama_dusun : '-' }}, Desa Naisau</td>
        </tr>
    </table>

    <p>Benar bahwa nama tersebut di atas adalah penduduk yang berdomisili di Desa Naisau, Kecamatan Fatukopa, Kabupaten Timor Tengah Selatan.</p>

    <p>Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk keperluan: <strong>{{ $surat->keperluan }}</strong>.</p>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
