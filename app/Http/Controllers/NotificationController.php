<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function syncTelegram()
    {
        $telegram = new \App\Services\TelegramService();
        $updates = $telegram->getUpdates();

        // Cari update terakhir dari user ini (bisa berdasarkan username atau logic sederhana ambil yang terakhir)
        // Disini kita tampilkan semua update agar user bisa pilih/lihat ID nya
        
        return view('notifications.telegram_sync', compact('updates'));
    }

    public function updateTelegramId(\Illuminate\Http\Request $request)
    {
        $request->validate(['telegram_chat_id' => 'required']);
        
        auth()->user()->update(['telegram_chat_id' => $request->telegram_chat_id]);
        
        return redirect()->route('notifications.index')->with('success', 'Telegram berhasil dihubungkan! ID: ' . $request->telegram_chat_id);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $notification->is_read = true;
        $notification->save();

        return back();
    }

    public function adminTelegramSetup()
    {
        $telegram = new \App\Services\TelegramService();
        $updates = $telegram->getUpdates();

        $currentChatId = env('TELEGRAM_ADMIN_CHAT_ID');

        return view('notifications.admin_telegram_setup', compact('updates', 'currentChatId'));
    }

    public function userTelegramSetup()
    {
        $telegram = new \App\Services\TelegramService();
        $updates = $telegram->getUpdates();

        $currentChatId = auth()->user()->telegram_chat_id;

        return view('notifications.user_telegram_setup', compact('updates', 'currentChatId'));
    }

    public function saveUserTelegramId(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'telegram_chat_id' => 'required|string'
        ]);

        auth()->user()->update([
            'telegram_chat_id' => $request->telegram_chat_id
        ]);

        return redirect()->route('notifications.userTelegramSetup')
            ->with('success', 'Chat ID Telegram berhasil disimpan! Anda akan menerima notifikasi saat status surat diperbarui.');
    }
}
