<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HonorController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LaporanHonorController;
use App\Http\Controllers\LaporanHonorMonthController;
use App\Http\Controllers\LaporanPembayaranController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OtherPaymentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusMengajarController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [LoginController::class, 'index'])->name('home');
    Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
});

Route::middleware(['auth:pegawai,users'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

});

Route::middleware(['auth:pegawai,users'])->group(function () {
    Route::get('history', [HistoryController::class, 'index'])->name('history.index');
    Route::get('pencairan', [HistoryController::class, 'pencairan'])->name('pencairan.index');
    Route::get('pencairan/{payment}', [HistoryController::class, 'pencairanshow'])->name('pencairan.show');
    Route::get('lainnya', [HistoryController::class, 'lainnya'])->name('lainnya.index');
    Route::get('lainnya/{otherPayment}', [HistoryController::class, 'lainnyashow'])->name('lainnya.show');
});

Route::get('logout', [DashboardController::class, 'logout'])->name('dashboard.logout');

Route::middleware(['auth:users'])->group(function () {
    Route::middleware(['checkOperatorOrAdmin'])->group(function () {
        Route::get('pegawai/export', [PegawaiController::class, 'export'])->name('pegawai.export');
        Route::post('/pegawai/{pegawai}/assign-mapel', [PegawaiController::class, 'assignMapel'])->name('pegawai.assign-mapel');
        Route::post('/pegawai/{pegawai}/assign-tugas', [PegawaiController::class, 'assignTugas'])->name('pegawai.assign-tugas');
        Route::post('/mapel/{mapel}/enroll', [MapelController::class, 'enroll'])->name('mapel.enroll');
        Route::post('/mapel/{mapel}/enroll-all', [MapelController::class, 'enrollAll'])->name('mapel.enrollAll');
        Route::get('/mapel/{mapel}/enrolled-pegawai', [MapelController::class, 'viewEnrolledPegawai'])->name('mapel.enrolledPegawai');
        Route::delete('/mapel/{mapel}/unenroll/{pegawaiMapel}', [MapelController::class, 'unenroll'])->name('mapel.unenroll');
        Route::delete('/mapel/{mapel}/unenroll-all', [MapelController::class, 'unenrollAll'])->name('mapel.unenrollAll');

        Route::resource('status-mengajar', StatusMengajarController::class)->names('status_mengajar');
        Route::resource('pegawai', PegawaiController::class)->names('pegawai');
        Route::resource('jabatan', JabatanController::class)->names('jabatan');
        Route::resource('mapel', MapelController::class)->names('mapel');
        Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas'])->names('kelas');
        Route::resource('channel', ChannelController::class)->names('channels');
        Route::resource('kegiatan', KegiatanController::class)->parameters(['kegiatan' => 'kegiatan'])->names('kegiatan');
        Route::resource('tugas', TugasController::class)->parameters(['tugas' => 'tugas'])->names('tugas');
        Route::resource('honor', HonorController::class)->names('honor');
    });

    // Admin Only
    Route::middleware(['checkAdministrator'])->group(function () {
        Route::resource('users', UserController::class)->names('users');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        // Progress Dev
        Route::resource('semesters', SemesterController::class);
        Route::post('semesters/{semester}/set-active', [SemesterController::class, 'setActiveSemester'])->name('semesters.setActive');
    });

    Route::middleware(['checkBendaharaOrAdmin'])->group(function () {
        // Other Payment
        Route::get('payment-other/create', [OtherPaymentController::class, 'create'])->name('otherpayment.create');
        Route::post('payment-other', [OtherPaymentController::class, 'store'])->name('otherpayment.store');
        Route::get('payment-other', [OtherPaymentController::class, 'index'])->name('otherpayment.index');
        Route::get('payment-other/{otherPayment}', [OtherPaymentController::class, 'show'])->name('otherpayment.show');
        Route::get('payment-other/{otherPayment}/edit', [OtherPaymentController::class, 'edit'])->name('otherpayment.edit');
        Route::put('payment-other/{otherPayment}', [OtherPaymentController::class, 'update'])->name('otherpayment.update');
        Route::delete('payment-other/{otherPayment}', [OtherPaymentController::class, 'destroy'])->name('otherpayment.destroy');

        Route::get('payment/getTotalHonor', [PaymentController::class, 'getTotalHonor'])->name('payment.getTotalHonor');
        Route::get('payment/getTugasHonor', [PaymentController::class, 'getTugasHonor'])->name('payment.getTugasHonor');
        Route::resource('payment', PaymentController::class)->names('payment');
    });
    Route::get('/laporan/honor', [LaporanHonorController::class, 'index'])->name('laporan.honor.index');
    Route::get('/laporan/honor/month', [LaporanHonorMonthController::class, 'index'])->name('laporan.honorMonth.index');
    Route::get('/laporan/payment', [LaporanPembayaranController::class, 'index'])->name('laporan.payment.index');
    Route::get('/laporan/other', [LaporanPembayaranController::class, 'other'])->name('laporan.payment.other');
});



