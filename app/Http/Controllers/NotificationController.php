<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        if (!session('siswa_nis')) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu untuk mengakses halaman ini.');
        }

        $notifications = Notification::forUser(session('siswa_nis'))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications', compact('notifications'));
    }

    public function markAsRead(Request $request, $id)
    {
        if (!session('siswa_nis')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification = Notification::where('id', $id)
            ->where('user_id', session('siswa_nis'))
            ->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        if (!session('siswa_nis')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        Notification::forUser(session('siswa_nis'))->unread()->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}
