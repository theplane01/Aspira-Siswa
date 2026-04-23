<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Comment;
use App\Models\Like;
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

        Comment::create([
            'id_komentar' => uniqid(),
            'id_pelaporan' => $id_pelaporan,
            'nis' => session('siswa_nis'),
            'komentar' => $request->komentar,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil ditambahkan.',
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
            Like::create([
                'id_like' => uniqid(),
                'id_pelaporan' => $id_pelaporan,
                'nis' => $nis,
            ]);
            $action = 'liked';
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

