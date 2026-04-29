<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Siswa;
use App\Models\Notification;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request) {
        // INI DIA GEMBOKNYA, LEK!
        // Jika tidak ada 'admin_id' di session (artinya belum login)
        if (!session('admin_id')) {
            // Maka tendang dia ke halaman login dengan pesan error
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu untuk mengakses halaman ini.');
        }

        $query = Aspirasi::with(['kategori', 'siswa']);
        $this->applyDashboardFilters($query, $request);

        $aspirasis = $query->orderBy('created_at', 'desc')->paginate(15);
        $kategoris = Kategori::orderBy('ket_kategori')->get();
        return view('admin_dashboard', compact('aspirasis', 'kategoris'));
    }

    public function update(Request $request, $id) {
        // Di sini juga kasih gembok biar orang nggak bisa 'nembak' kirim data
        if (!session('admin_id')) {
            return redirect('/login');
        }

        $request->validate([
            'status' => 'required',
            'feedback' => 'required|max:50'
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $oldStatus = $aspirasi->status;

        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback
        ]);

        // Buat notifikasi jika status berubah ATAU feedback diberikan
        if (($oldStatus !== $request->status || !empty($request->feedback)) && $aspirasi->nis) {
            $statusText = match($request->status) {
                'Selesai' => 'Selesai',
                'Proses' => 'Sedang Diproses',
                'Menunggu' => 'Menunggu',
                default => 'Status Diperbarui'
            };

            Notification::create([
                'user_id' => $aspirasi->nis,
                'type' => 'status_update',
                'title' => "Status Laporan Diperbarui: {$statusText}",
                'message' => "Status laporan Anda dengan kategori '" . ($aspirasi->kategori ? $aspirasi->kategori->ket_kategori : 'Tidak diketahui') . "' telah diperbarui menjadi {$statusText}. Feedback: {$request->feedback}",
                'data' => [
                    'aspirasi_id' => $aspirasi->id_pelaporan,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status,
                    'feedback' => $request->feedback
                ]
            ]);
        }

        return redirect()->back()->with('success', 'Feedback telah berhasil disimpan dan dikirim kepada siswa.');
    }

    public function destroy($id) {
        if (!session('admin_id')) return redirect('/login');
    
        $aspirasi = Aspirasi::findOrFail($id);
        if ($aspirasi->foto && file_exists(public_path($aspirasi->foto))) {
            @unlink(public_path($aspirasi->foto));
        }
        $aspirasi->delete();
    
        return redirect()->back()->with('success', 'Laporan telah berhasil dihapus dari sistem.');
    }

    public function stats() {
        if (!session('admin_id')) return response()->json(['error' => 'Unauthorized'], 401);

        $total = Aspirasi::count();
        $menunggu = Aspirasi::where('status', 'Menunggu')->count();
        $proses = Aspirasi::where('status', 'Proses')->count();
        $selesai = Aspirasi::where('status', 'Selesai')->count();

        return response()->json([
            'total' => $total,
            'menunggu' => $menunggu,
            'proses' => $proses,
            'selesai' => $selesai
        ]);
    }

    public function bulkDelete(Request $request) {
        if (!session('admin_id')) return response()->json(['error' => 'Unauthorized'], 401);

        $request->validate(['ids' => 'required|array']);
        $ids = $request->ids;

        // Delete associated photos
        $aspirasis = Aspirasi::whereIn('id_pelaporan', $ids)->get();
        foreach ($aspirasis as $aspirasi) {
            if ($aspirasi->foto && file_exists(public_path($aspirasi->foto))) {
                @unlink(public_path($aspirasi->foto));
            }
        }

        Aspirasi::whereIn('id_pelaporan', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sebanyak ' . count($ids) . ' laporan telah berhasil dihapus dari sistem.'
        ]);
    }

    public function bulkStatus(Request $request) {
        if (!session('admin_id')) return response()->json(['error' => 'Unauthorized'], 401);

        $request->validate([
            'ids' => 'required|array',
            'status' => 'required|in:Menunggu,Proses,Selesai'
        ]);

        $ids = $request->ids;
        $status = $request->status;

        Aspirasi::whereIn('id_pelaporan', $ids)->update(['status' => $status]);

        // Create notifications for affected aspirasis
        $aspirasis = Aspirasi::whereIn('id_pelaporan', $ids)->with('kategori')->get();
        foreach ($aspirasis as $aspirasi) {
            if ($aspirasi->nis) {
                $statusText = match($status) {
                    'Selesai' => 'Selesai',
                    'Proses' => 'Sedang Diproses',
                    'Menunggu' => 'Menunggu',
                    default => 'Status Diperbarui'
                };

                Notification::create([
                    'user_id' => $aspirasi->nis,
                    'type' => 'bulk_status_update',
                    'title' => "Status Laporan Diperbarui: {$statusText}",
                    'message' => "Status laporan Anda dengan kategori '" . ($aspirasi->kategori ? $aspirasi->kategori->ket_kategori : 'Tidak diketahui') . "' telah diperbarui menjadi {$statusText}. Silakan periksa detail laporan Anda.",
                    'data' => [
                        'aspirasi_id' => $aspirasi->id_pelaporan,
                        'new_status' => $status
                    ]
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Status ' . count($ids) . ' laporan telah berhasil diperbarui.'
        ]);
    }

    public function exportCsv(Request $request) {
        if (!session('admin_id')) return redirect('/login');

        $query = Aspirasi::with(['kategori', 'siswa']);
        $this->applyDashboardFilters($query, $request);

        $aspirasis = $query->orderBy('created_at', 'desc')->get();

        $filename = 'laporan_aspirasi_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($aspirasis) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['NIS', 'Kategori', 'Isi Laporan', 'Status', 'Feedback', 'Tanggal Dibuat']);

            foreach ($aspirasis as $aspi) {
                fputcsv($file, [
                    $aspi->nis,
                    $aspi->kategori->ket_kategori ?? '-',
                    $aspi->ket,
                    $aspi->status,
                    $aspi->feedback ?? '-',
                    $aspi->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request) {
        if (!session('admin_id')) return redirect('/login');

        // For PDF export, we'll use a simple HTML to PDF approach
        // In a real app, you'd use libraries like DomPDF or TCPDF

        $query = Aspirasi::with(['kategori', 'siswa']);
        $this->applyDashboardFilters($query, $request);

        $aspirasis = $query->orderBy('created_at', 'desc')->get();

        $html = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
                h1 { text-align: center; }
            </style>
        </head>
        <body>
            <h1>Laporan Aspirasi Siswa</h1>
            <p>Diekspor pada: ' . date('Y-m-d H:i:s') . '</p>
            <table>
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Kategori</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Feedback</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>';

        foreach ($aspirasis as $aspi) {
            $html .= '<tr>
                <td>' . $aspi->nis . '</td>
                <td>' . ($aspi->kategori->ket_kategori ?? '-') . '</td>
                <td>' . $aspi->ket . '</td>
                <td>' . $aspi->status . '</td>
                <td>' . ($aspi->feedback ?? '-') . '</td>
                <td>' . $aspi->created_at->format('Y-m-d H:i:s') . '</td>
            </tr>';
        }

        $html .= '</tbody></table></body></html>';

        $filename = 'laporan_aspirasi_' . date('Y-m-d_H-i-s') . '.html';
        $headers = [
            'Content-Type' => 'text/html',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response($html, 200, $headers);
    }

    // ========== SISTEM APPROVAL REGISTRASI SISWA ==========
    
    public function approveRegistrations() {
        if (!session('admin_id')) {
            return redirect('/login')->with('error', 'Login dulu lah kau, Wak!');
        }

        $pendingStudents = Siswa::where('status', 'pending')->orderBy('created_at', 'desc')->get();
        $approvedStudents = Siswa::where('status', 'approved')->count();
        $rejectedStudents = Siswa::where('status', 'rejected')->count();

        return view('admin_approvals', compact('pendingStudents', 'approvedStudents', 'rejectedStudents'));
    }

    public function approveSiswa($nis) {
        if (!session('admin_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $siswa = Siswa::where('nis', $nis)->first();
        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $siswa->update(['status' => 'approved']);
        
        return response()->json([
            'success' => true,
            'message' => "Akun {$siswa->nama} telah berhasil disetujui dan dapat melakukan login."
        ]);
    }

    public function rejectSiswa($nis) {
        if (!session('admin_id')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $siswa = Siswa::where('nis', $nis)->first();
        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        $siswa->update(['status' => 'rejected']);
        
        return response()->json([
            'success' => true,
            'message' => "Akun {$siswa->nama} telah ditolak dan tidak dapat melakukan login."
        ]);
    }

    private function applyDashboardFilters($query, Request $request): void
    {
        // Filter per judul aspirasi (mengandung kata kunci)
        if ($request->filled('judul')) {
            $query->where('ket', 'like', '%' . $request->judul . '%');
        }

        // Filter tanggal spesifik
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Filter per bulan + tahun (format YYYY-MM)
        if ($request->filled('bulan') && preg_match('/^\d{4}\-\d{2}$/', $request->bulan)) {
            [$year, $month] = explode('-', $request->bulan);
            $query->whereYear('created_at', (int) $year)
                ->whereMonth('created_at', (int) $month);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter siswa berdasarkan nama atau NIS
        if ($request->filled('siswa')) {
            $siswaKeyword = $request->siswa;
            $query->where(function ($q) use ($siswaKeyword) {
                $q->where('nis', 'like', '%' . $siswaKeyword . '%')
                    ->orWhereHas('siswa', function ($sq) use ($siswaKeyword) {
                        $sq->where('nama', 'like', '%' . $siswaKeyword . '%');
                    });
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }
    }

}