<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MMahasiswaMengambilTopik;
use App\MResume;

use DB;
use Illuminate\Support\Facades\Redirect;
use Input;
use Hash;
use Session;
use Auth;

class CTopik extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');


    }*/

    public function lihat_selengkapnya()
    {
        $topik = DB::table('topik')
            ->orderBy('id','asc')
            ->get();

        return view('layout.daftar_topik')
                ->with('topik',$topik);
    }

    public function detail_topik($nama_topik){
        $user = Auth::user();

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

        //bila belum tercatat di tabel mahasiswa mengambil topik maka catat ke tabel tsb
        $query_tercatat = DB::table('mahasiswa_mengambil_topik')
                        ->select('*')
                        ->where('id_pengguna','=',$user->id)
                        ->where('id','=',$id_topik)
                        ->get();
            
        if(count($query_tercatat) == 0){//dicatat di tabel mahasiswa_mengambil_topik dan resume_topik kalau belum ada
            //Mahasiswa mengambil topik
            $mahasiswa_mengambil_topik = new MMahasiswaMengambilTopik();
            $mahasiswa_mengambil_topik->id_topik = $id_topik;
            $mahasiswa_mengambil_topik->id_pengguna = $user->id;
            $mahasiswa_mengambil_topik->save();

            //Resume topik
            $resume_topik = new MResume();
            $resume_topik->id_topik = $id_topik;
            $resume_topik->id_pengguna = $user->id;
            $resume_topik->save();
        }

        return view('layout.topik')
            ->with('topik', $topik);

        }else{
            return view('errors.404');
        }
    }
}?>