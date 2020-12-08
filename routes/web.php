<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    /**
     * Role super-admin
     */
    Route::group(['middleware' => ['auth']], function () {
        /**
         * Master Roles
         */
        Route::prefix('master-roles')->namespace('MasterRole')->name('master-role.')->group(function () {
            // Role
            Route::resource('role', 'RoleController');
            Route::prefix('role')->name('role.')->group(function () {
                Route::post('api', 'RoleController@api')->name('api');
                Route::get('{id}/addPermissions', 'RoleController@permission')->name('addPermissions');
                Route::post('storePermissions', 'RoleController@storePermission')->name('storePermissions');
                Route::get('{id}/getPermissions', 'RoleController@getPermissions')->name('getPermissions');
                Route::delete('{name}/destroyPermission', 'RoleController@destroyPermission')->name('destroyPermission');
            });
            // Permission
            Route::resource('permission', 'PermissionController');
            Route::post('permission/api', 'PermissionController@api')->name('permission.api');
            // Pegawai
            Route::resource('pengguna', 'PenggunaController');
            Route::post('pengguna/api', 'PenggunaController@api')->name('pengguna.api');
            Route::get('pengguna/{id}/editPassword', 'PenggunaController@editPassword')->name('pengguna.editPassword');
            Route::post('pengguna/{id}/updatePassword', 'PenggunaController@updatePassword')->name('pengguna.updatePassword');
        });

        /**
         * Config Template
         */
        Route::prefix('config-templates')->namespace('ConfigTemplate')->name('config-template.')->group(function () {
            // Template
            Route::resource('template', 'TemplateController');
            Route::post('template/api', 'TemplateController@api')->name('template.api');
        });
    });

    /**
     * Page Not Found
     */
    Route::get('blank-page', 'BlankPageController@index')->name('blank-page');


    /**
     * Profile
     */
    Route::prefix('profile')->namespace('Profile')->name('master-profile.')->group(function () {
        // Profile
        Route::resource('profile', 'ProfileController');
        Route::get('profile/{id}/edtiPasswrod', 'ProfileController@editPassword')->name('profile.editPassword');
        Route::post('profile/{id}/updatePassword', 'ProfileController@updatePassword')->name('profile.updatePassword');
    });

    /**
     * Master Jenis
     */
    Route::prefix('Master-Jenis')->namespace('MasterJenis')->name('master-jenis.')->group(function () {
        // Jenis Lapak
        Route::resource('jenisLapak', 'JenisLapakController');
        Route::post('jenisLapak/api', 'JenisLapakController@api')->name('jenisLapak.api');
        // Jenis Usaha
        Route::resource('jenisUsaha', 'JenisUsahaController');
        Route::post('jenisUsaha/api', 'JenisUsahaController@api')->name('jenisUsaha.api');
    });

    /**
     * Master Pedagang
     */
    Route::prefix('Master-Pedagang')->namespace('MasterPedagang')->name('master-pedagang.')->group(function () {
        // Pedagang
        Route::resource('pedagang', 'PedagangController');
        Route::post('pedagang/api', 'PedagangController@api')->name('pedagang.api');
        // Pedagang Alamat
        Route::resource('pedagangAlamat', 'PedagangAlamatController');
        Route::post('pedagangAlamat/api', 'PedagangAlamatController@api')->name('pedagangAlamat.api');
    });

    Route::prefix('Master-Transaksi')->namespace('MasterTransaksi')->name('master-transaksi.')->group(function () {
        // Transaksi
        Route::resource('transaksi', 'TransaksiController');
        Route::post('transaksi/api', 'TransaksiController@api')->name('transaksi.api');
    });

    /**
     * Master Pasar
     */
    Route::prefix('Master-Pasar')->namespace('MasterPasar')->name('master-pasar.')->group(function () {
        // Pasar
        Route::resource('pasar', 'PasarController');
        Route::post('pasar/api', 'PasarController@api')->name('pasar.api');
        // Pasar Kategori
        Route::resource('pasarKategori', 'PasarKategoriController');
        Route::post('pasarKategori/api', 'PasarKategoriController@api')->name('pasarKategori.api');
    });

    /**
     * Master Penduduk
     */
    Route::prefix('Master-Penduduk')->namespace('MasterPenduduk')->name('master-penduduk.')->group(function () {
        // Penduduk
       Route::resource('penduduk', 'PendudukController');
       Route::post('penduduk/api', 'PendudukController@api')->name('penduduk.api');
    });

    /**
     * Master Privy
     */
    Route::prefix('Master-Privy')->namespace('MasterPrivy')->name('master-privy.')->group(function () {
        // Pimpinan
       Route::resource('pimpinan', 'PimpinanController');
       Route::post('pimpinan/api', 'PimpinanController@api')->name('pimpinan.api');
        // Penghargaan
       Route::resource('penghargaan', 'PenghargaanController');
       Route::post('penghargaan/api', 'PenghargaanController@api')->name('penghargaan.api');
       // keuntungan
       Route::resource('keuntungan', 'KeuntunganController');
       Route::post('keuntungan/api', 'KeuntunganController@api')->name('keuntungan.api');
       //enterprise
       Route::resource('enterprise', 'EnterpriseController');
       Route::post('enterprise/api', 'EnterpriseController@api')->name('enterprise.api');
       //klien
       Route::resource('klien', 'KlienController');
       Route::post('klien/api', 'KlienController@api')->name('klien.api');
       //liputan
       Route::resource('liputan', 'LiputanController');
       Route::post('liputan/api', 'LiputanController@api')->name('liputan.api');
       //sertifikat
       Route::resource('sertifikat', 'SertifikatController');
       Route::post('sertifikat/api', 'SertifikatController@api')->name('sertifikat.api');
       //dokumentasi
       Route::resource('dokumentasi', 'DokumentasiController');
       Route::post('dokumentasi/api', 'DokumentasiController@api')->name('dokumentasi.api');
       //Frequently Question
       Route::resource('faq', 'FaqController');
       Route::post('faq/api', 'FaqController@api')->name('faq.api');
       //Kontak Question
       Route::resource('kontakBisnis', 'KontakController');
       Route::post('kontakBisnis/api', 'KontakController@api')->name('kontakBisnis.api');
    });

});