<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\MBimbingan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Input;
use Session;

class CBimbingan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $user = Auth::user();

        switch ($user->peran) {
            case 2:
                $topik = DB::table('topik')
                    ->get();

                $id_dosen = DB::table('dosen')
                    ->where('id_users', '=', $user->id)
                    ->get();

                $id_dosen_val = NULL;
                foreach ($id_dosen as $id_dosen) {
                    $id_dosen_val = $id_dosen->id;
                }

                $bimbingan = DB::table('bimbingan')
                    ->where('dosen', '=', $id_dosen_val)
                    ->get();

                $dosen = DB::table('dosen')
                    ->select('*', 'dosen.id as id_dosen')
                    ->join('users', 'users.id', '=', 'dosen.id_users')
                    ->where('users.universitas', '=', $user->universitas)
                    ->get();

                return view('layout.dosen.bimbingan')
                    ->with('dosen', $dosen)
                    ->with('topik', $topik)
                    ->with('topik2', $topik)
                    ->with('topik3', $topik)
                    ->with('bimbingan', $bimbingan);;
                break;//dosen
            case 4:
                $topik = DB::table('topik')
                    ->get();

                $id_mahasiswa = DB::table('mahasiswa')
                    ->where('id_users', '=', $user->id)
                    ->get();

                $id_mahasiswa_val = NULL;
                foreach ($id_mahasiswa as $id_mahasiswa) {
                    $id_mahasiswa_val = $id_mahasiswa->id;
                }

                $bimbingan = DB::table('bimbingan')
                    ->where('mahasiswa', '=', $id_mahasiswa_val)
                    ->get();

                $dosen = DB::table('dosen')
                    ->select('*', 'dosen.id as id_dosen')
                    ->join('users', 'users.id', '=', 'dosen.id_users')
                    ->where('users.universitas', '=', $user->universitas)
                    ->get();


                return view('layout.mahasiswa.bimbingan')
                    ->with('dosen', $dosen)
                    ->with('topik', $topik)
                    ->with('topik2', $topik)
                    ->with('topik3', $topik)
                    ->with('bimbingan', $bimbingan);;
                break;//mahasiswa
        }
        $bimbingan = DB::table('bimbingan')
            ->get();
    }

    public function random_string($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    public function materi($id_materi)
    {
        $nama_materi = DB::table('topik')
            ->where('id', '=', $id_materi)
            ->get();
        $user = Auth::user();

        if (count($nama_materi) != 0) {
            switch ($user->peran) {
                case 2:

                    ;
                    break;
                case 4:
                    $topik = DB::table('topik')
                        ->get();

                    $topik_dipilih = DB::table('topik')
                        ->where('id', '=', $id_materi)
                        ->get();

                    $id_mahasiswa = DB::table('mahasiswa')
                        ->where('id_users', '=', $user->id)
                        ->get();

                    $id_mahasiswa_val = NULL;
                    foreach ($id_mahasiswa as $id_mahasiswa) {
                        $id_mahasiswa_val = $id_mahasiswa->id;
                    }

                    $bimbingan = DB::table('bimbingan')
                        ->where('mahasiswa', '=', $id_mahasiswa_val)
                        ->get();

                    $dosen = DB::table('dosen')
                        ->select('*', 'dosen.id as id_dosen')
                        ->join('users', 'users.id', '=', 'dosen.id_users')
                        ->where('users.universitas', '=', $user->universitas)
                        ->get();

                    return view('layout.mahasiswa.bimbingan_materi')
                        ->with('dosen', $dosen)
                        ->with('topik', $topik)
                        ->with('topik2', $topik)
                        ->with('topik3', $topik)
                        ->with('topik_dipilih', $topik_dipilih)
                        ->with('bimbingan_materi', $bimbingan);
                    break;//mahasiswa
            }


        } else {
            return view('errors.404');
        }

    }

    public function tambah_bimbingan($id_materi)
    {
        $nama_materi = DB::table('topik')
            ->where('id', '=', $id_materi)
            ->get();
        if (count($nama_materi) != 0) {
        $user = Auth::user();

        $topik = DB::table('topik')
            ->get();

        $topik_dipilih = DB::table('topik')
            ->where('id', '=', $id_materi)
            ->get();

        $id_mahasiswa = DB::table('mahasiswa')
            ->where('id_users', '=', $user->id)
            ->get();

        $id_mahasiswa_val = NULL;
        foreach ($id_mahasiswa as $id_mahasiswa) {
            $id_mahasiswa_val = $id_mahasiswa->id;
        }

        $bimbingan = DB::table('bimbingan')
            ->where('mahasiswa', '=', $id_mahasiswa_val)
            ->get();

        $dosen = DB::table('dosen')
            ->select('*', 'dosen.id as id_dosen','users.universitas as id_universitas')
            ->join('users', 'users.id', '=', 'dosen.id_users')
            ->where('users.universitas', '=', $user->universitas)
            ->orderBy('users.nama_depan','asc')
            ->get();

        return view('layout.mahasiswa.tambah_bimbingan')
            ->with('dosens', $dosen)
            ->with('topik', $topik)
            ->with('topik2', $topik)
            ->with('topik3', $topik)
            ->with('topik_dipilih', $topik_dipilih)
            ->with('bimbingan_materi', $bimbingan);
        }else{
            return view('errors.404');
        }
    }

    public function proses_tambah_bimbingan_dosen(Request $request){
        $this->validate($request,[

        ]);
    }
    public function proses_tambah_bimbingan_mahasiswa(Request $request){
        $this->validate($request,[
            "id" => "required",
            "universitas" => "required",
            "topik" => "required",
            "dosen" => "required",
            "judul" => "required",
            "permasalahan" => "required"
        ]);

        $bimbingan = new MBimbingan();
        $bimbingan->universitas = $request["universitas"];
        $bimbingan->topik = $request["topik"];

        //ambil id mahasiswa dari request id
        $idMahasiswa = NULL;
        $getIDMahasiswas = DB::table('mahasiswa')->where('id_users','=',$request["id"])->get();
        foreach ($getIDMahasiswas as $getIDMahasiswa) {
            $idMahasiswa = $getIDMahasiswa->id;
        }
        $bimbingan->mahasiswa = $idMahasiswa;

        $bimbingan->dosen= $request["dosen"];
        $bimbingan->judul= $request["judul"];
        $bimbingan->permasalahan= $request["permasalahan"];
        $bimbingan->save();

        Session::flash("message", "Bimbingan berhasil dilakukan.");
        return Redirect::to('bimbingan/materi/'.$request["topik"].'');
    }

    public function lakukan_bimbingan(Request $request)
    {
        $this->validate($request, [
            'topik' => 'required',
            'dosen' => 'required',
            'judul' => 'required',
            'permasalahan' => 'required',
        ]);

        $user = Auth::user();

        $bimbingan = new MBimbingan();
        $bimbingan->universitas = $user->universitas;
        $bimbingan->topik = $request['topik'];

        //ambil id mahasiswa
        $mahasiswa = DB::table('mahasiswa')
            ->where('id_users', '=', $user->id)
            ->get();

        $mahasiswa_val = NULL;

        foreach ($mahasiswa as $mahasiswa) {
            $mahasiswa_val = $mahasiswa->id;
        }

        $bimbingan->mahasiswa = $mahasiswa_val;
        $bimbingan->dosen = $request['dosen'];
        $bimbingan->judul = $request['judul'];
        $bimbingan->tanggal = date("Y-m-d");
        $bimbingan->tanggal = date("Y-m-d");
        $bimbingan->permasalahan = $request['permasalahan'];

        if ($request['berkas_permasalahan'] != NULL) {
            $rename_berkas = $this->random_string(50) . '.' . Input::file('berkas_permasalahan')->getClientOriginalExtension();

            $ftp_server = "167.205.7.228";
            $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

            $login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

            if (true === $login) {

                ftp_put($ftp_conn, "/Assets/PRD/berkas_bimbingan/" . $rename_berkas, Input::file('berkas_permasalahan')->getPathName(), FTP_BINARY);
                ftp_close($ftp_conn);


            } else {
                ftp_close($ftp_conn);


            }
            $bimbingan->url_berkas_permasalahan = 'http://167.205.7.228:8089/prd/berkas_bimbingan/' . $rename_berkas;

        }


        $bimbingan->save();

        return Redirect::to('bimbingan');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
