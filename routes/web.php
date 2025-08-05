<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\CsdmController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JadwalKontrakController;
use App\Http\Controllers\JerseyController;
use App\Http\Controllers\KarirController;
use App\Http\Controllers\KelasDiklatController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\ModulDiklatController;
use App\Http\Controllers\NilaiDiklatController;
use App\Http\Controllers\PalestineDayController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PosisiLamaranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileSekolahController;
use App\Http\Controllers\QurbanController;
use App\Http\Controllers\SeragamController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TugasDiklatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitorController;
use App\Models\JadwalKontrak;
use App\Models\Merchandise;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/humas', function () {
    return view('humas.index');
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

//login google
Route::controller(GoogleController::class)->group(function () {
    Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('/auth/google/callback', 'handleGoogleCallback');
});

Route::group(['middleware' =>['auth', 'admin']], function () {
    Route::prefix('master')->group(function () {
        Route::get('list-user', [UserController::class, 'list_user'])->name('list-user');
        Route::post('list-user/create', [UserController::class, 'add_user'])->name('add-user');
        Route::get('get-user', [UserController::class, 'get_user_api'])->name('get-user.api');
        Route::get('get-guru', [UserController::class, 'get_guru_api'])->name('get-guru.api');

        Route::get('seragam', [SeragamController::class, 'list_seragam'])->name('list-seragam');
        Route::post('seragam', [SeragamController::class, 'create_seragam'])->name('create-seragam');
        Route::get('export-seragam', [SeragamController::class, 'export_seragam'])->name('export-seragam');
        Route::get('seragam/{id}', [SeragamController::class, 'detail_seragam'])->name('detail-seragam');
        Route::put('seragam/{id}', [SeragamController::class, 'update_seragam'])->name('update-seragam');

        Route::get('artikel', [ArtikelController::class, 'index'])->name('artikel.index');
        Route::get('artikel/{id}', [ArtikelController::class, 'edit'])->name('artikel.edit');

        Route::get('palestine-day', [PalestineDayController::class, 'master_materi'])->name('master.palestine');
        Route::get('palestine-day/{id}', [PalestineDayController::class, 'master_materi_by_id'])->name('master.materi-by-id');
        Route::put('palestine-day/{id}', [PalestineDayController::class, 'update_materi'])->name('master.update-materi');
        Route::post('palestine-day/create', [PalestineDayController::class, 'store'])->name('materi.store');
        Route::get('sudah-baca', [PalestineDayController::class, 'list_sudah_baca'])->name('master.sudah-baca');
        Route::get('sudah-baca/export', [PalestineDayController::class, 'export_have_read'])->name('master.export-sudahbaca');

        Route::get('menu', [MenuController::class, 'list_menu'])->name('master.menu');
        Route::post('menu/create', [MenuController::class, 'create_menu'])->name('master.create_menu');
        Route::post('root', [MenuController::class, 'create_root'])->name('master.create_root');

        Route::get('merchandise', [MerchandiseController::class, 'index'])->name('master.merchandise');
        Route::post('merchandise', [MerchandiseController::class, 'store'])->name('store_merchandise');
        Route::post('jenis', [MerchandiseController::class, 'create_jenis'])->name('master.create_jenis');

        Route::get('kumpul-desain', [MerchandiseController::class, 'kumpul_desain'])->name('master.kumpul_desain');
        Route::post('/get-kelas', [MerchandiseController::class, 'get_kelas'])->name('get_kelas_master');
        Route::post('/get-siswa', [MerchandiseController::class, 'get_siswa'])->name('get_siswa_master');
        Route::post('kumpul-desain', [MerchandiseController::class, 'store_desain'])->name('master.store_desain');
        Route::get('kumpul-desain/{id}', [MerchandiseController::class, 'desain_by_id'])->name('master.desain_by_id');
        Route::get('desain/download/{id}', [MerchandiseController::class, 'download_desain'])->name('download_desain');

        Route::get('template-desain', [TemplateController::class, 'index'])->name('template-desain');
        Route::post('template-desain', [TemplateController::class, 'store'])->name('store_template');

        Route::get('jersey', [JerseyController::class, 'index_master'])->name('master.jersey');
        Route::post('jersey', [JerseyController::class, 'store'])->name('store_jersey');
        Route::post('jenis-ekskul', [JerseyController::class, 'create_jenis_ekskul'])->name('master.create_jenis_ekskul');

        Route::get('qurban', [QurbanController::class, 'master_materi_qurban'])->name('master.qurban');
        Route::get('qurban/{id}', [QurbanController::class, 'master_materi_by_id'])->name('materi-qurban-by-id');
        Route::post('qurban/create', [QurbanController::class, 'store'])->name('materi-qurban.store');
        Route::put('qurban/{id}', [QurbanController::class, 'update_materi'])->name('master.update-materi-qurban');
        Route::get('sudah-nonton', [QurbanController::class, 'list_sudah_nonton'])->name('master.sudah-nonton-qurban');
        Route::get('sudah-nonton/export', [QurbanController::class, 'export_have_read'])->name('export-sudahnonton-qurban');

    });

    Route::prefix('laporan')->group(function () {
        Route::get('merchandise', [MerchandiseController::class, 'list_order'])->name('list-order-merchandise');
        Route::get('resume', [MerchandiseController::class, 'resume_order'])->name('resume_merchandise');
        Route::get('resume/all', [MerchandiseController::class, 'resume_detail'])->name('resume_merchandise_detail');
        Route::get('merchandise/{id}', [MerchandiseController::class, 'order_detail'])->name('get_pesanan_merchandise_by_invoice');
        Route::get('download-invoice/{id}', [MerchandiseController::class, 'download_invoice'])->name('download.invoice-merchandise');
        Route::get('list-order/export', [MerchandiseController::class, 'export_list_order'])->name('list-order.export');
        Route::get('seragam', [SeragamController::class, 'resume_seragam'])->name('resume_seragam');
        Route::get('seragam/all', [SeragamController::class, 'resume_detail'])->name('resume_seragam_detail');
        Route::get('jersey', [JerseyController::class, 'list_order_jersey'])->name('list_order_jersey');
        Route::get('jersey/{id}', [JerseyController::class, 'order_jersey_detail'])->name('order_jersey_detail');
        Route::get('jersey/edit/{id}/{jersey_id}/{no_punggung}', [JerseyController::class, 'detail_order'])->name('detail_order_edit');
        Route::put('jersey/{id}', [JerseyController::class, 'update_jersey'])->name('update-jersey');

        Route::get('invoice-jersey/{id}', [JerseyController::class, 'download_invoice'])->name('download.invoice-jersey');
        Route::get('order-jersey/export', [JerseyController::class, 'export_list_order'])->name('order-jersey.export');
        Route::get('resume-jersey', [JerseyController::class, 'resume_order'])->name('resume_jersey');
        Route::get('wishlist', [SeragamController::class, 'wishlist_seragam'])->name('wishlist_seragam');
        Route::get('export-wishlist', [SeragamController::class, 'export_wishlist'])->name('export_wishlist');

        Route::get('visitors', [VisitorController::class, 'index'])->name('visitor.index');

    });
});

Route::group(['middleware' =>['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('profile-diri', [ProfileController::class, 'index'])->name('profile-diri');
    Route::get('change-password', [ProfileController::class, 'change_password'])->name('change-password');
    Route::post('change-password', [ProfileController::class, 'update_password'])->name('update-password');
    Route::get('seragam', [SeragamController::class, 'index'])->name('seragam');
    Route::post('seragam/search', [SeragamController::class, 'search_produk'])->name('seragam.search');
    Route::post('seragam/filter', [SeragamController::class, 'filter_produk'])->name('seragam.filter');
    Route::get('seragam/{id}', [SeragamController::class, 'detail_produk'])->name('seragam.detail');
    Route::get('cart', [SeragamController::class, 'cart'])->name('seragam.cart');
    Route::post('cart', [SeragamController::class, 'add_to_cart'])->name('cart_post');
    Route::put('cart/{id}', [SeragamController::class, 'update_cart'])->name('cart.update');
    Route::put('cart-select/{id}', [SeragamController::class, 'update_select_cart'])->name('cart-select.update');
    Route::put('cart-select', [SeragamController::class, 'select_all_cart'])->name('select-all-cart');
    Route::delete('cart/{id}', [SeragamController::class, 'remove_cart'])->name('cart.delete');
    Route::post('payment', [SeragamController::class, 'buy_now'])->name('buy_now');
    Route::get('pembayaran', [SeragamController::class, 'pembayaran'])->name('seragam.bayar');
    Route::post('pembayaran', [SeragamController::class, 'store'])->name('seragam.store');
    Route::get('check-stok', [SeragamController::class, 'check_stok'])->name('check.stock');
    Route::get('checkout/success/', [SeragamController::class, 'success'])->name('checkout.success');

    Route::get('riwayat-transaksi', [SeragamController::class, 'history'])->name('seragam.history');
    Route::get('riwayat-transaksi/{id}', [SeragamController::class, 'rincian_pesanan'])->name('seragam.history.detail');
    Route::post('harga', [SeragamController::class, 'harga'])->name('harga_per_jenis');
    Route::post('stok', [SeragamController::class, 'stok'])->name('stok');

    Route::get('download-invoice/{id}', [SeragamController::class, 'download'])->name('download.invoice');

    
    Route::post('/terima-seragam/{no_pemesanan}/{tgl_terima_ortu}', [SeragamController::class, 'terimaSeragam'])->name('terima.seragam');

    Route::get('wishlist', [SeragamController::class, 'wishlist'])->name('seragam.wishlist');
    Route::post('wishlist', [SeragamController::class, 'add_to_wishlist'])->name('wishlist_post');
    Route::delete('wishlist/{id}', [SeragamController::class, 'remove_wishlist'])->name('wishlist.delete');


    
    Route::prefix('keuangan')->group(function () {
        Route::get('tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
        Route::get('bukti-bayar/{id}', [TagihanController::class, 'bukti_bayar'])->name('bukti_bayar');
    });

    Route::prefix('palestine-day')->group(function () {
        Route::get('/', [PalestineDayController::class, 'index'])->name('palestine.index');
        Route::get('/tk-sd', [PalestineDayController::class, 'materi_tk'])->name('palestine.tksd');
        Route::get('/tk-sd/{id}', [PalestineDayController::class, 'materi_tk_by_id'])->name('materi-tksd-by-id');
        Route::get('/tksd/{id}', [PalestineDayController::class, 'materi_tksd_by_id'])->name('materi-by-id');
        Route::get('/smp', [PalestineDayController::class, 'materi_smp'])->name('palestine.smp');
        Route::get('/smp/{id}', [PalestineDayController::class, 'materi_smp_by_id'])->name('materi-smp-by-id');
        Route::post('/sudahbaca', [PalestineDayController::class, 'sudah_baca'])->name('sudah_baca');
        Route::get('merchandise', [PalestineDayController::class, 'merchandise'])->name('palestine.merchandise');
        Route::get('merchandise/{id}', [PalestineDayController::class, 'detail_merchandise'])->name('detail.merchandise');
        Route::get('merchandise/design/{id}', [PalestineDayController::class, 'detail_merchandise_kaos'])->name('detail.merchandise_kaos');
        Route::get('cart', [PalestineDayController::class, 'cart'])->name('merchandise.cart');
        Route::post('cart', [PalestineDayController::class, 'add_to_cart'])->name('cart_post_merchandise');
        Route::put('cart/{id}', [PalestineDayController::class, 'update_cart'])->name('merchandise-cart.update');
        Route::put('cart-select/{id}', [PalestineDayController::class, 'update_select_cart'])->name('merchandise-cart-select.update');
        Route::put('cart-select', [PalestineDayController::class, 'select_all_cart'])->name('merchandise-select-all-cart');
        Route::delete('cart/{id}', [PalestineDayController::class, 'remove_cart'])->name('merchandise-cart.delete');
        Route::get('pembayaran', [PalestineDayController::class, 'pembayaran'])->name('merchandise.bayar');
        Route::post('payment', [PalestineDayController::class, 'pre_order'])->name('pre_order');
        Route::post('pembayaran', [PalestineDayController::class, 'store_order'])->name('merchandise.store');
        Route::get('riwayat-transaksi/{id}', [MerchandiseController::class, 'rincian_pesanan'])->name('merchandise.history.detail');
        Route::get('download-invoice/{id}', [MerchandiseController::class, 'download_invoice'])->name('invoice-merchandise');
        Route::post('harga', [MerchandiseController::class, 'harga_per_kategori'])->name('harga_per_kategori');
        Route::post('get-design', [MerchandiseController::class, 'get_design'])->name('get_design');
        Route::post('get-template', [MerchandiseController::class, 'get_template'])->name('get_template');
        Route::post('get-warna', [MerchandiseController::class, 'get_warna'])->name('get_warna');
        Route::get('export-karya', [PalestineDayController::class, 'export_karya'])->name('export.karya');

    });

    Route::prefix('edukasi-qurban')->group(function () {
        Route::get('/', [QurbanController::class, 'index'])->name('qurban.index');
        Route::get('/tk-sd', [QurbanController::class, 'materi_tksd'])->name('qurban.tksd');
        Route::get('/tk-sd/{id}', [QurbanController::class, 'materi_tksd_by_id'])->name('materi-qurban-tksd-by-id');
        Route::get('/tksd/{id}', [QurbanController::class, 'materi_tksd_by_id'])->name('materi_qurban_by_id');
        Route::get('/smp', [QurbanController::class, 'materi_smp'])->name('qurban.smp');
        Route::get('/smp/{id}', [QurbanController::class, 'materi_smp_by_id'])->name('materi-qurban-smp-by-id');
        Route::post('/sudahbaca', [QurbanController::class, 'sudah_baca'])->name('qurban_sudah_baca');
    });

    Route::prefix('jersey')->group(function () {
        Route::get('/', [JerseyController::class, 'index'])->name('jersey.index');
        Route::get('/cart', [JerseyController::class, 'cart'])->name('jersey.cart');
        Route::get('/detail/{id}', [JerseyController::class, 'detail_jersey'])->name('jersey.detail');
        Route::post('cart', [JerseyController::class, 'add_to_cart'])->name('cart_post_jersey');
        Route::put('/cart/{id}', [JerseyController::class, 'update_cart'])->name('jersey-cart.update');
        Route::put('cart-select-all', [JerseyController::class, 'select_all_cart'])->name('jersey-select-all-cart');
        Route::put('/cart-select/{id}', [JerseyController::class, 'update_select_cart'])->name('jersey-cart-select.update');
        Route::delete('cart/{id}', [JerseyController::class, 'remove_cart'])->name('jersey-cart.delete');
        Route::get('pembayaran', [JerseyController::class, 'pembayaran'])->name('jersey.bayar');
        Route::post('payment', [JerseyController::class, 'pre_order'])->name('pre_order.jersey');
        Route::post('pembayaran', [JerseyController::class, 'store_order'])->name('jersey.store');
        Route::get('riwayat-transaksi/{id}', [JerseyController::class, 'rincian_pesanan'])->name('jersey.history.detail');
        Route::get('download-invoice/{id}', [JerseyController::class, 'download_invoice'])->name('invoice-jersey');



    });
});

    Route::prefix('karir')->group(function () {
        Route::get('/', [KarirController::class, 'index'])->name('karir');
            Route::group(['middleware' =>['auth', 'csdm']], function () {
            Route::get('/profile', [KarirController::class, 'profile'])->name('karir.profile');
            Route::get('/profile/{id}', [KarirController::class, 'profile_by_id'])->name('karir.profile_by_id');
            Route::post('profile/{id}', [KarirController::class, 'store_profile'])->name('karir.store_profile');
            Route::put('/profile/{id}', [KarirController::class, 'edit_profile'])->name('karir.edit_profile');

            Route::get('/kelas', [KelasDiklatController::class, 'index'])->name('karir.kelas');
            Route::get('/kelas/pertemuan/{pertemuan}', [KelasDiklatController::class, 'get_kelas_by_pertemuan_id'])->name('karir.kelas_pertemuan');
            Route::get('/kelas/tugas/download/{id}', [KelasDiklatController::class, 'getDownloadTugas'])->name('download_tugas');
            Route::get('/kelas/tugas/download-upload/{id}', [KelasDiklatController::class, 'download_tugas_uploaded'])->name('download_tugas_uploaded');
            Route::post('/kelas/tugas/upload', [KelasDiklatController::class, 'upload_tugas'])->name('upload_tugas');
            Route::get('/kelas/modul/download/{id}', [KelasDiklatController::class, 'getDownloadModul'])->name('download_modul');

            Route::get('/nilai/{id}', [KarirController::class, 'get_nilai'])->name('karir.nilai');
            Route::get('/nilai/download/{id}', [KarirController::class, 'download_nilai'])->name('download_nilai');

            Route::get('/jadwal-kontrak', [KarirController::class, 'jadwal_kontrak'])->name('karir.jadwal');
            Route::get('/jadwal-kontrak/download', [KarirController::class, 'download_jadwal'])->name('download_jadwal');
        });
    });    

    Route::group(['middleware' =>['auth', 'admin']], function () {
        Route::prefix('admin')->group(function () {
            Route::get('/', [KarirController::class, 'admin'])->name('karir.admin');
            Route::get('/kelas', [KelasDiklatController::class, 'admin_kelas'])->name('karir.admin.kelas');
            Route::get('/kelas/create', [KelasDiklatController::class, 'admin_create_kelas'])->name('admin.create_kelas');
            Route::post('/kelas/create', [KelasDiklatController::class, 'admin_store_kelas'])->name('admin.store_kelas');
            Route::get('/kelas/{id}', [KelasDiklatController::class, 'admin_edit_kelas'])->name('admin.edit_kelas');
            Route::put('/kelas/{id}', [KelasDiklatController::class, 'admin_update_kelas'])->name('admin.update_kelas');
            Route::delete('/kelas/{id}', [KelasDiklatController::class, 'admin_delete_kelas'])->name('admin.delete_kelas');
    
            Route::get('/posisi', [PosisiLamaranController::class, 'index'])->name('karir.admin.posisi');
            Route::get('/posisi/create', [PosisiLamaranController::class, 'create'])->name('admin.create_posisi');
            Route::post('/posisi/create', [PosisiLamaranController::class, 'store'])->name('admin.store_posisi');
            Route::get('/posisi/{id}', [PosisiLamaranController::class, 'edit'])->name('admin.edit_posisi');
            Route::put('/posisi/{id}', [PosisiLamaranController::class, 'update'])->name('admin.update_posisi');
            Route::delete('/posisi/{id}', [PosisiLamaranController::class, 'destroy'])->name('admin.delete_posisi');
    
    
            Route::get('/modul', [ModulDiklatController::class, 'index'])->name('karir.admin.modul');
            Route::get('/modul/create', [ModulDiklatController::class, 'create'])->name('admin.create_modul');
            Route::post('/modul/create', [ModulDiklatController::class, 'store'])->name('admin.store_modul');
            Route::get('/modul/{id}', [ModulDiklatController::class, 'edit'])->name('admin.edit_modul');
            Route::put('/modul/{id}', [ModulDiklatController::class, 'update'])->name('admin.update_modul');
            Route::delete('/modul/{id}', [ModulDiklatController::class, 'destroy'])->name('admin.delete_modul');
            Route::get('/modul/download/{id}', [ModulDiklatController::class, 'download_modul_master'])->name('download_modul_master');
    
            Route::get('/tugas', [TugasDiklatController::class, 'index'])->name('karir.admin.tugas');
            Route::get('/tugas/create', [TugasDiklatController::class, 'create'])->name('admin.create_tugas');
            Route::post('/tugas/create', [TugasDiklatController::class, 'store'])->name('admin.store_tugas');
            Route::get('/tugas/{id}', [TugasDiklatController::class, 'edit'])->name('admin.edit_tugas');
            Route::put('/tugas/{id}', [TugasDiklatController::class, 'update'])->name('admin.update_tugas');
            Route::delete('/tugas/{id}', [TugasDiklatController::class, 'destroy'])->name('admin.delete_tugas');
            Route::get('/tugas/download/{id}', [TugasDiklatController::class, 'download_tugas_master'])->name('download_tugas_master');

    
            Route::get('/kumpul-tugas', [TugasDiklatController::class, 'kumpul_tugas'])->name('karir.admin.tugas_kumpul');
            Route::get('/kumpul-tugas/download/{id}', [TugasDiklatController::class, 'download_kumpulan_tugas'])->name('download_kumpulan_tugas');
            Route::get('/kumpul-tugas/download-all/', [TugasDiklatController::class, 'multiple_download_kumpulan_tugas'])->name('multiple_download');
    
    
            Route::get('/nilai', [NilaiDiklatController::class, 'index'])->name('karir.admin.nilai');
            Route::get('/nilai/create', [NilaiDiklatController::class, 'create'])->name('admin.create_nilai');
            Route::post('/nilai/create', [NilaiDiklatController::class, 'store'])->name('admin.store_nilai');
            Route::get('/nilai/{id}', [NilaiDiklatController::class, 'edit'])->name('admin.edit_nilai');
            Route::put('/nilai/{id}', [NilaiDiklatController::class, 'update'])->name('admin.update_nilai');
            Route::delete('/nilai/{id}', [NilaiDiklatController::class, 'destroy'])->name('admin.delete_nilai');
            Route::post('/nilai/upload', [NilaiDiklatController::class, 'upload_nilai'])->name('upload_nilai');
    
            Route::get('/jadwal-kontrak', [JadwalKontrakController::class, 'index'])->name('karir.admin.jadwal');
            Route::post('/jadwal-kontrak/upload', [JadwalKontrakController::class, 'upload_jadwal_kontrak'])->name('upload_jadwal_kontrak');

            Route::get('/csdm', [CsdmController::class, 'index'])->name('karir.admin.csdm');
            Route::get('/csdm/create', [CsdmController::class, 'create'])->name('admin.create_csdm');
            Route::post('/csdm/create', [CsdmController::class, 'store'])->name('admin.store_csdm');
            Route::post('/csdm/import', [CsdmController::class, 'import_excel'])->name('admin.import_csdm');
            Route::get('/csdm/{id}', [CsdmController::class, 'edit'])->name('admin.edit_csdm');
            Route::put('/csdm/{id}', [CsdmController::class, 'update'])->name('admin.update_csdm');
            Route::delete('/csdm/{id}', [CsdmController::class, 'destroy'])->name('admin.delete_csdm');
    
            Route::get('/kelas/pertemuan/{pertemuan}', [KelasDiklatController::class, 'admin_kelas_by_pertemuan_id'])->name('karir.admin.kelas_pertemuan');
            Route::get('/kelas/pertemuan/{pertemuan}/tugas', [KelasDiklatController::class, 'admin_kelas_tugas'])->name('karir.admin.kelas_tugas');
            Route::get('/kelas/pertemuan/{pertemuan}/tugas/{id}', [KelasDiklatController::class, 'admin_kelas_tugas_by_id'])->name('karir.admin.kelas_tugas_by_id');
            Route::get('/kelas/pertemuan/{pertemuan}/tugas/{id}/edit', [KelasDiklatController::class, 'admin_kelas_tugas_edit'])->name('karir.admin.kelas_tugas_edit');
            Route::put('/kelas/pertemuan/{pertemuan}/tugas/{id}', [KelasDiklatController::class, 'admin_kelas_tugas_update'])->name('karir.admin.kelas_tugas_update');
            Route::get('/kelas/pertemuan/{pertemuan}/tugas/{id}/delete', [KelasDiklatController::class, 'admin_kelas_tugas_delete'])->name('karir.admin.kelas_tugas_delete');
            Route::get('/kelas/pertemuan/{pertemuan}/tugas/create', [KelasDiklatController::class, 'admin_kelas_tugas_create'])->name('karir.admin.kelas_tugas_create');
        });
    });

Route::prefix('pendaftaran')->group(function () {
    Route::get('/', [PendaftaranController::class, 'index'])->name('pendaftaran');
    Route::get('/formulir', [PendaftaranController::class, 'form_pendaftaran'])->name('form.pendaftaran');
    Route::post('/formulir', [PendaftaranController::class, 'store'])->name('store.pendaftaran');
    Route::get('/formulir/find', [PendaftaranController::class, 'find'])->name('form.find');
    Route::get('/formulir/update', [PendaftaranController::class, 'edit'])->name('form.update');
    Route::post('/formulir/update', [PendaftaranController::class, 'forget_no_regis'])->name('forget_no_regis');
    Route::put('/formulir/update/{id}', [PendaftaranController::class, 'update'])->name('form.update.id');
    // Route::get('/formulir/update/{find}', [PendaftaranController::class, 'get_profile_by_no_regist'])->name('form.edit');
    Route::post('/get-jenjang', [PendaftaranController::class, 'get_jenjang'])->name('get_jenjang');
    Route::post('/get-jenjang-trial', [PendaftaranController::class, 'get_jenjang_trial'])->name('get_jenjang_trial');
    Route::post('/get-kelas', [PendaftaranController::class, 'get_kelas'])->name('get_kelas');
    Route::post('/get-kelas-smp', [PendaftaranController::class, 'get_kelas_smp'])->name('get_kelas_smp');
    Route::post('/get-kota', [PendaftaranController::class, 'get_kota'])->name('get_kota');
    Route::post('/get-kecamatan', [PendaftaranController::class, 'get_kecamatan'])->name('get_kecamatan');
    Route::post('/get-kelurahan', [PendaftaranController::class, 'get_kelurahan'])->name('get_kelurahan');
});

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/jenjang/{jenjang}', [HomeController::class, 'jenjang'])->name('jenjang.sekolah');
Route::get('/profile', [ProfileSekolahController::class, 'index'])->name('profile.sekolah');
Route::get('/kurikulum', [KurikulumController::class, 'index'])->name('kurikulum.sekolah');
Route::get('trial-class', [PendaftaranController::class, 'trial_class'])->name('trial.class');
Route::get('trial-class-success', [PendaftaranController::class, 'trial_class_success'])->name('trial-class.success');
Route::post('trial-class', [PendaftaranController::class, 'store_trial_class'])->name('store.trial.class');
