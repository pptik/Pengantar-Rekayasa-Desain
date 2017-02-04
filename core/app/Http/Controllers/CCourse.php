<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MRadio;

use DB;
use Illuminate\Support\Facades\Redirect;
use Input;
use Hash;
use Session;
use Auth;

class CCourse extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return Redirect::to('dashboard');
        }else{
            $topik = DB::table('topik')
                    ->orderBy('id','asc')
                    ->take(3)
                    ->get();

            $topik_all = DB::table('topik')
                ->orderBy('id','asc')
                ->get();

            $siswa = DB::table('users')
                ->where('peran','=',4)
                ->get();

            return view('layout.index')
                    ->with('topik',$topik)
                    ->with('topik_all',$topik_all)
                    ->with('siswa',$siswa);
        }
    }
    
}?>