<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" href="#" data-toggle="dropdown">
        <i class="ficon feather icon-bell"></i>
        <span class="badge badge-pill badge-primary badge-up">{{ $notifications->count() }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
        <li class="dropdown-menu-header">
            <div class="dropdown-header m-0 p-2">
                <h3 class="white">{{ $notifications->count() }} New</h3>
                <span class="notification-title">App Notifications</span>
            </div>
        </li>
        <li class="scrollable-container media-list">
            @foreach ($notifications as $notification)
                <a class="d-flex justify-content-between" href="javascript:void(0)">
                    <div class="media d-flex align-items-start">
                        <div class="media-left">
                            <i class="feather icon-plus-square font-medium-5 primary"></i>
                        </div>
                        <div class="media-body">
                            <h6 class="primary media-heading">{{ $notification->data['title'] }}</h6>
                            <small class="notification-text">{{ $notification->data['content'] }}</small>
                        </div>
                        <small>
                            <time class="media-meta" datetime="{{ $notification->created_at->toIso8601String() }}">
                                {{ $notification->created_at->diffForHumans() }}
                            </time>
                        </small>
                    </div>
                </a>
            @endforeach
        </li>
        <li class="dropdown-menu-footer">
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item w-100 p-1 text-center" href="javascript:void(0)">Read all notifications</button>
                {{-- <button  class="btn btn-primary mt-3">Read All</button> --}}
            </form>

        </li>
    </ul>
</li>
