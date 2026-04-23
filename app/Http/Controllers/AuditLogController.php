<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function userActivityLog()
    {
        if(!session('siswa_nis')) {
            return redirect('/login');
        }

        $nis = session('siswa_nis');
        
        // Get all reports and their updates/activities
        $activities = Aspirasi::where('nis', $nis)
            ->orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($aspirasi) {
                return [
                    'type' => 'report',
                    'aspirasi_id' => $aspirasi->id_pelaporan,
                    'title' => $aspirasi->ket,
                    'status' => $aspirasi->status,
                    'category' => $aspirasi->kategori->ket_kategori ?? '-',
                    'created_at' => $aspirasi->created_at,
                    'updated_at' => $aspirasi->updated_at,
                    'feedback' => $aspirasi->feedback,
                ];
            });

        return view('user_audit_log', compact('activities'));
    }
}
