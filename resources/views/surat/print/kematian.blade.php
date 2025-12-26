@extends('surat.print.layout')

@section('surat_content')
    <h3 class="title">SURAT KETERANGAN KEMATIAN</h3>
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
            <td>Alamat Terakhir</td>
            <td>:</td>
            <td>Dusun {{ $surat->penduduk->dusun ? $surat->penduduk->dusun->nama_dusun : '-' }}, Desa Naisau</td>
        </tr>
    </table>

    <p>Telah meninggal dunia pada:</p>

    <table class="table-data">
        <tr>
            <td>Hari / Tanggal</td>
            <td>:</td>
            <td>........................................................</td>
        </tr>
        <tr>
            <td>Pukul</td>
            <td>:</td>
            <td>........................................................</td>
        </tr>
        <tr>
            <td>Tempat Meninggal</td>
            <td>:</td>
            <td>........................................................</td>
        </tr>
        <tr>
            <td>Penyebab Kematian</td>
            <td>:</td>
            <td>........................................................</td>
        </tr>
    </table>

    <p>Surat keterangan ini dibuat atas permintaan keluarga untuk keperluan: <strong>{{ $surat->keperluan }}</strong>.</p>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
