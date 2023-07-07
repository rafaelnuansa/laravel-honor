@extends('components.layout-pegawai')

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Notifications</h4>
                    </div>
                    <div class="card-body">
                        @if ($notifications->isEmpty())
                            <p class="card-text">No notifications.</p>
                        @else
                            <div class="list-group">
                                @foreach ($notifications as $notification)
                                    <div class="list-group-item list-group-item-action @if (!$notification->read_at) list-group-item-info @endif">
                                        <h5 class="mb-1">{{ $notification->data['title'] }}</h5>
                                        <p class="mb-1">{{ $notification->data['content'] }}</p>
                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                        @if (!$notification->read_at)
                                            <div class="float-right">
                                                <form action="{{ route('notifications.markAsRead', $notification->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm">Read</button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary mt-3">Tandai semua telah dibaca</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
