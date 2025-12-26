<?php
/**
 * Helper Script untuk Mendapatkan Telegram Chat ID
 *
 * Cara pakai:
 * 1. Chat dengan bot Telegram Anda (kirim pesan /start)
 * 2. Jalankan script ini: php get_telegram_chat_id.php
 * 3. Salin Chat ID yang ditampilkan
 * 4. Masukkan ke file .env pada TELEGRAM_ADMIN_CHAT_ID
 */

$botToken = '8383268460:AAG35fy090sQjtF_GaPHYmOU4DuvwksnrXQ';

echo "==============================================\n";
echo "  TELEGRAM CHAT ID FINDER\n";
echo "==============================================\n\n";

echo "Mengambil update dari bot Telegram...\n\n";

$url = "https://api.telegram.org/bot{$botToken}/getUpdates";
$response = file_get_contents($url);

if ($response === false) {
    die("ERROR: Tidak dapat terhubung ke Telegram API!\n");
}

$data = json_decode($response, true);

if (!isset($data['ok']) || !$data['ok']) {
    die("ERROR: Response dari Telegram tidak valid!\n");
}

$updates = $data['result'] ?? [];

if (empty($updates)) {
    echo "PERINGATAN: Tidak ada update ditemukan!\n\n";
    echo "Silakan:\n";
    echo "1. Buka Telegram\n";
    echo "2. Cari bot dengan token di atas\n";
    echo "3. Kirim pesan /start ke bot\n";
    echo "4. Jalankan script ini lagi\n\n";
    exit;
}

echo "Ditemukan " . count($updates) . " update(s):\n\n";
echo str_repeat("=", 80) . "\n";

foreach ($updates as $update) {
    if (isset($update['message'])) {
        $message = $update['message'];
        $chatId = $message['chat']['id'];
        $firstName = $message['from']['first_name'] ?? 'N/A';
        $lastName = $message['from']['last_name'] ?? '';
        $username = $message['from']['username'] ?? 'N/A';
        $text = $message['text'] ?? 'N/A';
        $date = date('Y-m-d H:i:s', $message['date']);

        echo "Chat ID      : " . $chatId . "\n";
        echo "Nama         : " . $firstName . " " . $lastName . "\n";
        echo "Username     : @" . $username . "\n";
        echo "Pesan        : " . $text . "\n";
        echo "Tanggal      : " . $date . "\n";
        echo str_repeat("-", 80) . "\n";
    }
}

echo "\n";
echo "==============================================\n";
echo "  LANGKAH SELANJUTNYA:\n";
echo "==============================================\n";
echo "1. Salin Chat ID yang sesuai dari list di atas\n";
echo "2. Buka file .env\n";
echo "3. Isi variabel: TELEGRAM_ADMIN_CHAT_ID=[Chat ID Anda]\n";
echo "4. Contoh: TELEGRAM_ADMIN_CHAT_ID=123456789\n";
echo "5. Simpan file .env\n";
echo "6. (Opsional) Jalankan: php artisan config:cache\n";
echo "==============================================\n\n";
