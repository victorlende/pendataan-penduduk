<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LetterTemplate;

class LetterTemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            [
                'key' => 'domisili',
                'title' => 'Surat Keterangan Domisili',
                'content' => '
    <h3 class="title">SURAT KETERANGAN DOMISILI</h3>
    <p class="nomor-surat">Nomor: [NOMOR_SURAT]</p>

    <p>Yang bertanda tangan di bawah ini Kepala Desa Naisau, Kecamatan Fatukopa, Kabupaten Timor Tengah Selatan, dengan ini menerangkan bahwa:</p>

    <table class="table-data">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td><strong>[NAMA]</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>[NIK]</td>
        </tr>
        <tr>
            <td>Tempat/Tgl Lahir</td>
            <td>:</td>
            <td>[TTL]</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>[JK]</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>[PEKERJAAN]</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>[AGAMA]</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>[ALAMAT]</td>
        </tr>
    </table>

    <p>Benar bahwa nama tersebut di atas adalah penduduk yang berdomisili di Desa Naisau, Kecamatan Fatukopa, Kabupaten Timor Tengah Selatan.</p>

    <p>Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk keperluan: <strong>[KEPERLUAN]</strong>.</p>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
                ',
            ],
            [
                'key' => 'tidak_mampu',
                'title' => 'Surat Keterangan Tidak Mampu',
                'content' => '
    <h3 class="title">SURAT KETERANGAN TIDAK MAMPU</h3>
    <p class="nomor-surat">Nomor: [NOMOR_SURAT]</p>

    <p>Yang bertanda tangan di bawah ini Kepala Desa Naisau, Kecamatan Fatukopa, Kabupaten Timor Tengah Selatan, dengan ini menerangkan bahwa:</p>

    <table class="table-data">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td><strong>[NAMA]</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>[NIK]</td>
        </tr>
        <tr>
            <td>Tempat/Tgl Lahir</td>
            <td>:</td>
            <td>[TTL]</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>[JK]</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>[PEKERJAAN]</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>[ALAMAT]</td>
        </tr>
    </table>

    <p>Nama tersebut di atas adalah benar warga Desa Naisau yang tergolong dalam keluarga <strong>TIDAK MAMPU / MISKIN</strong>.</p>

    <p>Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk keperluan: <strong>[KEPERLUAN]</strong>.</p>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
                ',
            ],
            [
                'key' => 'usaha',
                'title' => 'Surat Keterangan Usaha',
                'content' => '
    <h3 class="title">SURAT KETERANGAN USAHA</h3>
    <p class="nomor-surat">Nomor: [NOMOR_SURAT]</p>

    <p>Yang bertanda tangan di bawah ini Kepala Desa Naisau, Kecamatan Fatukopa, Kabupaten Timor Tengah Selatan, dengan ini menerangkan bahwa:</p>

    <table class="table-data">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td><strong>[NAMA]</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>[NIK]</td>
        </tr>
        <tr>
            <td>Tempat/Tgl Lahir</td>
            <td>:</td>
            <td>[TTL]</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>[ALAMAT]</td>
        </tr>
    </table>

    <p>Benar bahwa nama tersebut di atas mempunyai usaha:</p>
    <div style="margin-left: 20px; font-weight: bold; font-size: 14pt; margin-bottom: 20px;">
        "..................................................................."
    </div>
    <p>Yang berlokasi di Desa Naisau, Kecamatan Fatukopa, Kabupaten Timor Tengah Selatan.</p>

    <p>Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk keperluan: <strong>[KEPERLUAN]</strong>.</p>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
                ',
            ],
            [
                'key' => 'kelahiran',
                'title' => 'Surat Keterangan Kelahiran',
                'content' => '
    <h3 class="title">SURAT KETERANGAN KELAHIRAN</h3>
    <p class="nomor-surat">Nomor: [NOMOR_SURAT]</p>

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
            <td><strong>[NAMA]</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>[NIK]</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>[ALAMAT]</td>
        </tr>
    </table>

    <p>Surat keterangan ini dibuat atas permintaan yang bersangkutan untuk keperluan: <strong>[KEPERLUAN]</strong>.</p>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
                ',
            ],
            [
                'key' => 'kematian',
                'title' => 'Surat Keterangan Kematian',
                'content' => '
    <h3 class="title">SURAT KETERANGAN KEMATIAN</h3>
    <p class="nomor-surat">Nomor: [NOMOR_SURAT]</p>

    <p>Yang bertanda tangan di bawah ini Kepala Desa Naisau, Kecamatan Fatukopa, Kabupaten Timor Tengah Selatan, dengan ini menerangkan bahwa:</p>

    <table class="table-data">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td><strong>[NAMA]</strong></td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>[NIK]</td>
        </tr>
        <tr>
            <td>Tempat/Tgl Lahir</td>
            <td>:</td>
            <td>[TTL]</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>[JK]</td>
        </tr>
        <tr>
            <td>Alamat Terakhir</td>
            <td>:</td>
            <td>[ALAMAT]</td>
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

    <p>Surat keterangan ini dibuat atas permintaan keluarga untuk keperluan: <strong>[KEPERLUAN]</strong>.</p>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
                ',
            ],
        ];

        foreach ($templates as $t) {
            LetterTemplate::updateOrCreate(
                ['key' => $t['key']],
                $t
            );
        }
    }
}
