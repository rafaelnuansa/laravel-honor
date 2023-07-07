<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $guard = Auth::getDefaultDriver();
        $notifications = [];

        if ($guard === 'pegawai') {
            $notifications = Auth::guard('pegawai')->user()->notifications;
        } elseif ($guard === 'users') {
            $notifications = Auth::guard('users')->user()->notifications;
        }

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a notification as read.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        $guard = Auth::getDefaultDriver();
        if ($guard === 'pegawai') {
            $notification = Auth::guard('pegawai')->user()->notifications()->findOrFail($id);

        } elseif ($guard === 'users') {
            $notification = Auth::guard('users')->user()->notifications()->findOrFail($id);
        }

        $notification->markAsRead();

        return redirect()->back();
    }

    /**
     * Mark all notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        $guard = Auth::getDefaultDriver();

        if ($guard === 'pegawai') {
            Auth::guard('pegawai')->user()->unreadNotifications->markAsRead();
        } elseif ($guard === 'users') {
            Auth::guard('users')->user()->unreadNotifications->markAsRead();
        }

        return redirect()->back();
    }
}
