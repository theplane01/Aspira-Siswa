<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Notification;
use Illuminate\Http\Request;

class AspirasiDetailController extends Controller
{
    public function show($id_pelaporan)
    {
        $aspirasi = Aspirasi::with(['kategori', 'comments.siswa', 'likes'])->findOrFail($id_pelaporan);
        
        $likesCount = $aspirasi->likes()->count();
        $commentsCount = $aspirasi->comments()->count();
        $isLikedByUser = $aspirasi->isLikedBy(session('siswa_nis'));

        return view('aspirasi_detail', compact('aspirasi', 'likesCount', 'commentsCount', 'isLikedByUser'));
    }

    public function addComment(Request $request, $id_pelaporan)
    {
        if (!session('siswa_nis')) {
            return response()->json(['error' => 'Anda harus login terlebih dahulu.'], 401);
        }

        $request->validate([
            'komentar' => 'required|min:3|max:500',
        ], [
            'komentar.required' => 'Komentar tidak boleh kosong.',
            'komentar.min' => 'Komentar minimal 3 karakter.',
            'komentar.max' => 'Komentar maksimal 500 karakter.',
        ]);

        $aspirasi = Aspirasi::findOrFail($id_pelaporan);

        $comment = Comment::create([
            'id_pelaporan' => $id_pelaporan,
            'nis' => session('siswa_nis'),
            'komentar' => $request->komentar,
        ]);

        // Kirim notifikasi ke pemilik laporan saat ada komentar baru
        if ((string) $aspirasi->nis !== (string) session('siswa_nis')) {
            Notification::create([
                'user_id' => $aspirasi->nis,
                'type' => 'new_comment',
                'title' => 'Komentar Baru pada Laporan Anda',
                'message' => 'Laporan Anda mendapatkan komentar baru dari ' . (session('siswa_nama') ?? 'siswa lain') . '.',
                'data' => [
                    'aspirasi_id' => $aspirasi->id_pelaporan,
                    'comment_id' => $comment->id_komentar,
                    'comment_by_nis' => session('siswa_nis'),
                    'comment_preview' => mb_substr($request->komentar, 0, 100),
                ],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan.',
            'commentsCount' => $aspirasi->comments()->count(),
        ]);
    }

    public function toggleLike($id_pelaporan)
    {
        if (!session('siswa_nis')) {
            return response()->json(['error' => 'Anda harus login terlebih dahulu.'], 401);
        }

        $aspirasi = Aspirasi::findOrFail($id_pelaporan);
        $nis = session('siswa_nis');

        $existingLike = Like::where('id_pelaporan', $id_pelaporan)
                            ->where('nis', $nis)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $action = 'unliked';
        } else {
            $like = Like::create([
                'id_pelaporan' => $id_pelaporan,
                'nis' => $nis,
            ]);
            $action = 'liked';

            // Kirim notifikasi ke pemilik laporan saat ada like baru
            if ((string) $aspirasi->nis !== (string) $nis) {
                Notification::create([
                    'user_id' => $aspirasi->nis,
                    'type' => 'new_like',
                    'title' => 'Like Baru pada Laporan Anda',
                    'message' => 'Laporan Anda disukai oleh ' . (session('siswa_nama') ?? 'siswa lain') . '.',
                    'data' => [
                        'aspirasi_id' => $aspirasi->id_pelaporan,
                        'like_id' => $like->id_like,
                        'liked_by_nis' => $nis,
                    ],
                ]);
            }
        }

        $likesCount = $aspirasi->likes()->count();

        return response()->json([
            'success' => true,
            'action' => $action,
            'likesCount' => $likesCount,
            'message' => $action === 'liked' ? 'Berhasil memberikan like.' : 'Like berhasil dihapus.',
        ]);
    }

    public function deleteComment($id_komentar)
    {
        $comment = Comment::findOrFail($id_komentar);

        if ($comment->nis !== session('siswa_nis') && session('admin_id') === null) {
            return response()->json(['error' => 'Anda tidak berhak menghapus komentar ini.'], 403);
        }

        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dihapus.',
        ]);
    }
}

