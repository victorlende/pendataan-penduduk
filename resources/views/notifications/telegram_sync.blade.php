@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Hubungkan Telegram</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-paper-plane me-1"></i>
            Daftar Pesan Masuk (Telegram Bot)
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                Silakan kirim pesan apa saja ke bot Telegram kami, lalu refresh halaman ini. ID Anda akan muncul di bawah.
                <br>
                Jika Anda melihat nama Anda/username Anda, klik tombol <strong>"Hubungkan"</strong>.
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Nama Pengirim</th>
                            <th>Username</th>
                            <th>Pesan</th>
                            <th>Chat ID</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($updates as $update)
                            @if(isset($update['message']))
                                <tr>
                                    <td>{{ date('Y-m-d H:i:s', $update['message']['date']) }}</td>
                                    <td>{{ $update['message']['from']['first_name'] ?? '-' }} {{ $update['message']['from']['last_name'] ?? '' }}</td>
                                    <td>{{ $update['message']['from']['username'] ?? '-' }}</td>
                                    <td>{{ $update['message']['text'] ?? '-' }}</td>
                                    <td>{{ $update['message']['chat']['id'] }}</td>
                                    <td>
                                        <form action="{{ route('notifications.updateTelegramId') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="telegram_chat_id" value="{{ $update['message']['chat']['id'] }}">
                                            <button type="submit" class="btn btn-primary btn-sm">Hubungkan ke Akun Saya</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada pesan baru. Coba kirim pesan ke bot sekarang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <hr>
            
            <h5>Debug Info:</h5>
            <p>ID Akun Anda saat ini: <strong>{{ auth()->user()->telegram_chat_id ?? 'Belum terhubung' }}</strong></p>
        </div>
    </div>
</div>
@endsection
