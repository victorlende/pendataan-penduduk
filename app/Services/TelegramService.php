<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    protected $token;

    protected $adminChatId;

    public function __construct()
    {
        $this->token = env('TELEGRAM_BOT_TOKEN', '8383268460:AAG35fy090sQjtF_GaPHYmOU4DuvwksnrXQ');
        $this->adminChatId = env('TELEGRAM_ADMIN_CHAT_ID');
    }

    /**
     * Send text message to a chat ID
     */
    public function sendMessage($chatId, $message)
    {
        if (!$chatId) return;

        try {
            $response = Http::post("https://api.telegram.org/bot{$this->token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if (!$response->successful()) {
                Log::error('Telegram API Failed: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Telegram Service Error: ' . $e->getMessage());
        }
    }

    /**
     * Get updates from Telegram Bot API
     */
    public function getUpdates()
    {
        try {
            $response = Http::get("https://api.telegram.org/bot{$this->token}/getUpdates");
            
            if ($response->successful()) {
                return $response->json()['result'] ?? [];
            }
            
            Log::error('Telegram API Failed (getUpdates): ' . $response->body());
            return [];
        } catch (\Exception $e) {
            Log::error('Telegram Service Error (getUpdates): ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Send notification to admin
     */
    public function notifyAdmin($message)
    {
        if (!$this->adminChatId) {
            Log::warning('Telegram admin chat ID not configured. Skipping notification.');
            return false;
        }

        $this->sendMessage($this->adminChatId, $message);
        return true;
    }

    /**
     * Send notification to specific user by chat ID
     */
    public function notifyUser($chatId, $message)
    {
        if (!$chatId) {
            Log::warning('User chat ID is empty. Skipping notification.');
            return false;
        }

        $this->sendMessage($chatId, $message);
        return true;
    }

    /**
     * Broadcast message to all users who have a telegram_chat_id
     */
    public function broadcastToAll($message)
    {
        $users = User::whereNotNull('telegram_chat_id')->get();

        foreach ($users as $user) {
            $this->sendMessage($user->telegram_chat_id, $message);
        }
    }
}
