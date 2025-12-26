@extends('surat.print.layout')

@section('surat_content')
    <h3 class="title">SURAT KETERANGAN KELAHIRAN</h3>
    <p class="nomor-surat">Nomor: {{ $surat->nomor_surat }}</p>

    <p>Yang bertanda tangan di bawah ini Kepala Desa Naisau, Kecamatan Fatukopa, Kabupaten Timor Tengah Selatan, dengan ini menerangkan bahwa telah lahir seorang anak:</p>

    <table class="table-data">
        <tr>
            <td>Hari / Tanggal Lahir</td>
            <td>:</td>
            <td>........................................................</td>
        </tr>
        <tr>
            <td>Pukul</td>
            <td>:</td>
            <td>........................................................</td>
        </tr>
        <tr>
            <td>Tempat Lahir</td>
            <td>:</td>
            <td>........................................................</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>Laki-laki / Perempuan</td>
        </tr>
        <tr>
            <td>Nama Anak</td>
            <td>:</td>
            <td><strong>........................................................</strong></td>
        </tr>
    </table>

    <p>Anak dari orang tua:</p>

    <table class="table-data">
        <tr>
            <td colspan="3"><strong>AYAH</strong></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>........................................................</td>
        </tr>
        <tr>
            <td colspan="3"><strong>IBU</strong></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><strong>{{ strtoupper($surat->penduduk->nama_lengkap) }}</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->penduduk->nik }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>Dusun {{ $surat->penduduk->dusun ? $surat->penduduk->dusun->nama_dusun : '-' }}, Desa Naisau</td>
        </tr>
    </table>

    <p>Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk keperluan: <strong>{{ $surat->keperluan }}</strong>.</p>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
@endsection
