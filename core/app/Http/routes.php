<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'CCourse@index');



Route::get('dashboard', [
    'middleware' => 'auth',
    'uses' => 'CPengguna@index'
]);


Route::get('user/{nama}','CPengguna@profile_pengguna');

Route::get('bimbingan','CBimbingan@index');

Route::group(['prefix' => 'bimbingan','middleware' => 'auth'],function(){
    Route::post('lakukan_bimbingan','CBimbingan@lakukan_bimbingan');
});

Route::get('bimbingan/materi/{id_materi}','CBimbingan@materi');

Route::get('bimbingan/tambah_bimbingan/{id_materi}','CBimbingan@tambah_bimbingan');

Route::get('lupa_password','CPengguna@lupa_password');

Route::post('lupa_password_send','CPengguna@lupa_password_send');

Route::group(['prefix' => 'user/{nama}','middleware' => 'auth'],function(){
    Route::get('profil','CPengguna@profile_pengguna_auth');
    Route::get('ubah_profil','CPengguna@ubah_profil');
    Route::get('keamanan','CPengguna@keamanan');
});

Route::get('login', 'CPengguna@login');

Route::get('register', 'CPengguna@register');

Route::group(['prefix' => 'konfirmasi','middleware' => 'auth'],function(){
    Route::get('mahasiswa/{id_user}','CPengguna@konfirmasi_mahasiswa');
    Route::get('dosen/{id_user}','CPengguna@konfirmasi_dosen');
});
//Route::get('konfirmasi_mahasiswa/{id_user}', 'CPengguna@konfirmasi_mahasiswa');

Route::get('daftar_topik', 'CTopik@lihat_selengkapnya');

Route::get('logout', 'CPengguna@keluar');

Route::group(['prefix' => 'resume','middleware' => 'auth'],function(){
    Route::post('resume','CResume@resume');
    Route::post('video','CResume@video');
    Route::post('berkas','CResume@berkas');
});

Route::group(['prefix' => 'pengguna','middleware' => 'auth'],function(){
    Route::get('mahasiswa','CPengguna@admin_pengguna_mahasiswa');
    Route::get('dosen','CPengguna@admin_pengguna_dosen');
    Route::get('universitas','CPengguna@admin_pengguna_universitas');
});

Route::group(['prefix' => 'universitas','middleware' => 'auth'],function(){
    Route::get('mahasiswa','CPengguna@universitas_pengguna_mahasiswa');
    Route::get('dosen','CPengguna@universitas_pengguna_dosen');
});

//Validasi untuk AJAX
Route::group(['prefix' => 'validasi'],function(){
    Route::post('username','CPengguna@validasi_username');
    Route::post('email','CPengguna@validasi_email');
});

Route::group(['prefix' => 'topik','middleware' => 'auth'], function () {
    Route::get('/{nama_topik}','CTopik@detail_topik');

    Route::get('sub_topik/{nama_topik}', function ($nama_topik)    {
        //Ambil id topik berdasarkan judul dari url
        $id_topik = NULL;
        $query_id_topik = DB::table('topik')
            ->select('id')
            ->where('nama_topik','=',str_replace('-',' ',$nama_topik))
            ->get();

        if(count($query_id_topik) != 0){
            foreach ( $query_id_topik as $query_id_topik1) {
                $id_topik = $query_id_topik1->id;
            }

            $topik = DB::table('topik')
                ->select('*')
                ->where('id', '=', $id_topik)
                ->get();

            return view('layout.sub_topik')
                ->with('topik', $topik);
        }else{
            return view('errors.404');
        }

    });

    Route::get('laporan/{nama_topik}', function ($nama_topik)    {
        //Ambil id topik berdasarkan judul dari url
        $id_topik = NULL;
        $query_id_topik = DB::table('topik')
            ->select('id')
            ->where('nama_topik','=',str_replace('-',' ',$nama_topik))
            ->get();
        if(count($query_id_topik) != 0){
            foreach ( $query_id_topik as $query_id_topik1) {
                $id_topik = $query_id_topik1->id;
            }

            $topik = DB::table('topik')
                ->select('*')
                ->where('id', '=', $id_topik)
                ->get();

            return view('layout.laporan_topik')
                ->with('topik', $topik);
        }else{
            return view('errors.404');
        }

    });

    Route::get('laporan/ubah/{nama_topik}', function ($nama_topik)    {
        //Ambil id topik berdasarkan judul dari url
        $id_topik = NULL;
        $query_id_topik = DB::table('topik')
            ->select('id')
            ->where('nama_topik','=',str_replace('-',' ',$nama_topik))
            ->get();
        if(count($query_id_topik) != 0){
            foreach ( $query_id_topik as $query_id_topik1) {
                $id_topik = $query_id_topik1->id;
            }

            $topik = DB::table('topik')
                ->select('*')
                ->where('id', '=', $id_topik)
                ->get();

            $resume_topik = DB::table('resume_topik')
                            ->where('id_topik', '=', $id_topik)
                            ->where('id_pengguna', '=', Session::get('id_pengguna'))
                            ->get();

            return view('layout.ubah_laporan')
                ->with('topik', $topik)
                ->with('resume_topik', $resume_topik);
            
        }else{
            return view('errors.404');
        }

    });

});

Route::get('administrator','CAdministrator@index');

Route::group(['prefix' => 'administrator'],function(){
    Route::get('pengguna','CAdministrator@pengguna');
    Route::get('pengguna/mahasiswa','CAdministrator@mahasiswa');
    Route::get('pengguna/dosen','CAdministrator@dosen');
    Route::get('pengguna/universitas','CAdministrator@universitas');
    Route::get('materi','CAdministrator@materi');
    Route::get('sub_materi','CAdministrator@sub_materi');
    Route::get('pendahuluan','CAdministrator@pendahuluan');

    Route::post('tambah/universitas','CAdministrator@tambah_universitas');
    Route::post('reset_password','CAdministrator@reset_password');
    Route::post('tambah_materi','CAdministrator@tambah_materi');
    Route::post('tambah_sub_materi','CAdministrator@tambah_sub_materi');
    Route::post('ubah_materi','CAdministrator@ubah_materi');
    Route::get('hapus_materi/{id}','CAdministrator@hapus_materi');
    Route::get('hapus_sub_materi/{id}','CAdministrator@hapus_sub_materi');

});

Route::post('registration_process', 'CPengguna@daftar_process');

Route::post('registration_universitas_process', 'CPengguna@daftar_universitas_process');

Route::post('login_process', 'CPengguna@login_process');

Route::post('ubah_profile', 'CPengguna@ubah_profile');

Route::post('ubah_photo', 'CPengguna@ubah_photo');

Route::post('ktm', 'CPengguna@ktm');

Route::post('keamanan', 'CPengguna@ubah_keamanan');

