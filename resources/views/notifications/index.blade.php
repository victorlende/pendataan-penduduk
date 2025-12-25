@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Notifikasi</h3>

    <div class="card">
        <div class="card-body">
            @if($notifications->isEmpty())
                <p>Tidak ada notifikasi.</p>
            @endif

            <ul>
                @foreach($notifications as $n)
                    <li style="margin-bottom:10px;">
                        <strong>{{ $n->title }}</strong><br>
                        {{ $n->message }}<br>

                        @if(!$n->is_read)
                            <form method="POST" action="{{ route('notifications.read',$n->id) }}">
                                @csrf
                                <button type="submit">Tandai Dibaca</button>
                            </form>
                        @else
                            <small><i>Sudah dibaca</i></small>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
