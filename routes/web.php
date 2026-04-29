<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AspirasiController; 
use App\Http\Controllers\AspirasiDetailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuditLogController;

// Halaman Utama (Landing Page)
Route::get('/', function () {
    return view('welcome'); 
});

// Halaman Form & List (Halaman yang baru kita buat)
Route::get('/aspirasi', [AspirasiController::class, 'index']);
Route::get('/aspirasi-publik', [AspirasiController::class, 'publicAspirations']);
Route::get('/aspirasi/{id_pelaporan}', [AspirasiDetailController::class, 'show']);
Route::get('/aspirasi/stats', [AspirasiController::class, 'stats']);
Route::post('/lapor', [AspirasiController::class, 'store']);

// Route Comments & Likes
Route::post('/aspirasi/{id_pelaporan}/comments', [AspirasiDetailController::class, 'addComment']);
Route::post('/aspirasi/{id_pelaporan}/like', [AspirasiDetailController::class, 'toggleLike']);
Route::delete('/comments/{id_komentar}', [AspirasiDetailController::class, 'deleteComment']);

// Route Admin 
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/stats', [AdminController::class, 'stats']);
Route::post('/admin/feedback/{id}', [AdminController::class, 'update']);
Route::delete('/admin/hapus/{id}', [AdminController::class, 'destroy']);
Route::post('/admin/bulk-delete', [AdminController::class, 'bulkDelete']);
Route::post('/admin/bulk-status', [AdminController::class, 'bulkStatus']);
Route::get('/admin/export/csv', [AdminController::class, 'exportCsv']);
Route::get('/admin/export/pdf', [AdminController::class, 'exportPdf']);

// Route Admin - Approval Registrasi
Route::get('/admin/approvals', [AdminController::class, 'approveRegistrations']);
Route::post('/admin/approve/{nis}', [AdminController::class, 'approveSiswa']);
Route::post('/admin/reject/{nis}', [AdminController::class, 'rejectSiswa']);

// Route Notifikasi
Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);

// Admin Routes - Kategori Management
Route::get('/admin/kategori', [KategoriController::class, 'index']);
Route::post('/admin/kategori', [KategoriController::class, 'store']);
Route::put('/admin/kategori/{id}', [KategoriController::class, 'update']);
Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy']);

// Admin Routes - Siswa Management
Route::get('/admin/siswa', [SiswaController::class, 'index']);
Route::get('/admin/siswa/{nis}', [SiswaController::class, 'show']);
Route::put('/admin/siswa/{nis}', [SiswaController::class, 'update']);
Route::delete('/admin/siswa/{nis}', [SiswaController::class, 'destroy']);

// Profile Routes
Route::get('/profile', [ProfileController::class, 'siswaProfile']); // User profile (existing route, now handled by controller)
Route::put('/profile', [ProfileController::class, 'updateSiswaProfile']);
Route::get('/laporan-saya', [ProfileController::class, 'laporanSaya']);
Route::get('/laporan-saya/{id_pelaporan}/edit', [ProfileController::class, 'editLaporanSaya']);
Route::put('/laporan-saya/{id_pelaporan}', [ProfileController::class, 'updateLaporanSaya']);
Route::delete('/laporan-saya/{id_pelaporan}', [ProfileController::class, 'deleteLaporanSaya']);
Route::get('/admin/profile', [ProfileController::class, 'adminProfile']);
Route::put('/admin/profile', [ProfileController::class, 'updateAdminProfile']);

// User Audit Log
Route::get('/audit-log', [AuditLogController::class, 'userActivityLog']);

// --- JALUR LOGIN/LOGOUT ---
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

// Proses Login Admin
Route::post('/login', [AuthController::class, 'login']);

// Proses Login Siswa (Fungsi yang kita buat tadi)
Route::post('/login-siswa', [AuthController::class, 'loginSiswa']);

// Halaman Registrasi Siswa
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'registerSiswa']);
