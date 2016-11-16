<?php

namespace App\Http\Controllers;

use App\MSubTopik;
use App\MTopik;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use Input;
use App\MUser;
use App\MUniversitas;
use Illuminate\Support\Facades\Redirect;

class CAdministrator extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('administrator');

        /*$user = Auth::user();

        if($user->peran != 1){
            return "Anda tidak diizinkan mengakses halaman ini";
        }*/
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('layout.administrator.dashboard');
    }

    public function pengguna()
    {
        //
        $mahasiswa = DB::table('mahasiswa')
            ->select('*', 'users.id as id_user')
            ->join('users', 'users.id', '=', 'mahasiswa.id_users')
            ->get();

        return view('layout.administrator.pengguna.mahasiswa')
            ->with('mahasiswa', $mahasiswa);
    }

    public function tambah_universitas(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8'
        ]);

        //ke tabel user
        $user = new MUser();
        $user->peran = 5;//peran universitas
        $user->email = $request['email'];
        //$user->nim = $request['nim'];
        //$user->nama_depan = $request['nama_depan'];
        //$user->nama_belakang = $request['nama_belakang'];
        $user->username = $request['username'];
        $user->universitas = 0;
        //$user->fakultas = $request['fakultas'];
        $user->status_konfirmasi = 1;
        $user->password_asli = $request['password'];
        $user->password = bcrypt($request['password']);
        $user->save();

        //ke tabel universitas
        $id_users = DB::table("users")
            ->where('email', '=', $request['email'])
            ->get();

        $id_users_val = NULL;

        foreach ($id_users as $id_users) {
            $id_users_val = $id_users->id;
        }

        $universitas = new MUniversitas();
        $universitas->id_users = $id_users_val;
        $universitas->save();

        Session::flash("message", "Berhasil membuat akun universitas " . $request['username']);

        return Redirect::to('administrator/pengguna');
    }

    public function mahasiswa()
    {
        $mahasiswa = DB::table('mahasiswa')
            ->select('*', 'users.id as id_user')
            ->join('users', 'users.id', '=', 'mahasiswa.id_users')
            ->get();

        return view('layout.administrator.pengguna.mahasiswa')
            ->with('mahasiswa', $mahasiswa);
    }

    public function dosen()
    {
        $dosen = DB::table('dosen')
            ->select('*', 'users.id as id_user')
            ->join('users', 'users.id', '=', 'dosen.id_users')
            ->get();

        return view('layout.administrator.pengguna.dosen')
            ->with('dosen', $dosen);
    }

    public function universitas()
    {
        $universitas = DB::table('universitas')
            ->select('*', 'users.id as id_user')
            ->join('users', 'users.id', '=', 'universitas.id_users')
            ->get();

        return view('layout.administrator.pengguna.universitas')
            ->with('universitas', $universitas);
    }

    public function reset_password(Request $request)
    {
        DB::table('users')
            ->where('id', $request['reset-user-id'])
            ->update(['password' => bcrypt($request['password'])]);

        Session::flash("message", "Berhasil mereset password " . $request['field-reset-email'] . "");

        return Redirect::to('administrator/pengguna');
        //return $request['reset-user-id'].' - '.$request['password'];
    }

    public function materi()
    {
        //
        $materi = DB::table('topik')
            ->get();

        return view('layout.administrator.materi.materi')
            ->with('materi', $materi);
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

    public function tambah_materi(Request $request)
    {
        //
        $this->validate($request, [
            'judul' => 'required',
            //'deskripsi' => 'required',
            'pendahuluan' => 'required',
            'warna' => 'required',
            'thumbnail' => 'required|Max:500'
        ]);

        $materi = new MTopik();
        $materi->nama_topik = $request['judul'];
        //$materi->deskripsi_singkat = $request['deskripsi'];
        $materi->pendahuluan = $request['pendahuluan'];

        //Upload ke FTP
        $rename_berkas = $this->random_string(50) . '.' . Input::file('thumbnail')->getClientOriginalExtension();

        $ftp_server = "167.205.7.228";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

        $login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

        if (true === $login) {

            ftp_put($ftp_conn, "/Assets/PRD/Thumbnails/" . $rename_berkas, Input::file('thumbnail')->getPathName(), FTP_BINARY);
            ftp_close($ftp_conn);


        } else {
            ftp_close($ftp_conn);


        }
        //Akhir upload ke FTP
        $materi->thumbnail = 'http://167.205.7.228:8089/prd/Thumbnails/' . $rename_berkas;

        $materi->class_warna = $request['warna'];
        $materi->save();

        $material = DB::table('topik')
            ->get();

        /*return view('layout.administrator.materi.materi')
                ->with('materi',$material);*/
        return Redirect::to('administrator/materi');
    }

    public function tambah_sub_materi(Request $request)
    {
        switch ($request["tipe"]) {
            case 1://teks
                $this->validate($request,[
                    "topik" => "required",
                    "judul" => "required",
                    "deskripsi" => "required",
                    "tipe" => "required",
                    "isi-sub-materi-teks" => "required"
                ]);

                $sub_topik = new MSubTopik();
                $sub_topik->id_topik = $request["topik"];
                $sub_topik->nama_sub_topik = $request["judul"];
                $sub_topik->deskripsi = $request["deskripsi"];
                $sub_topik->isi_sub_topik = $request["isi-sub-materi-teks"];
                $sub_topik->tipe = 1;
                $sub_topik->save();

                Session::flash('message', 'Sub materi berhasil dibuat');
                return Redirect::to('administrator/sub_materi');
                break;
            case 2://file
                ;break;
            case 3://video
                $this->validate($request,[
                    "topik" => "required",
                    "judul" => "required",
                    "deskripsi" => "required",
                    "tipe" => "required",
                    "isi-sub-materi-video" => "required"
                ]);

                $sub_topik = new MSubTopik();
                $sub_topik->id_topik = $request["topik"];
                $sub_topik->nama_sub_topik = $request["judul"];
                $sub_topik->deskripsi = $request["deskripsi"];
                $sub_topik->isi_sub_topik = $request["isi-sub-materi-video"];
                $sub_topik->tipe = 3;
                $sub_topik->save();

                Session::flash('message', 'Sub materi berhasil dibuat');
                return Redirect::to('administrator/sub_materi');
                ;break;
        }
    }

    public function ubah_materi(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            //'deskripsi' => 'required',
            'pendahuluan' => 'required',
            'warna' => 'required'
        ]);


        //Upload ke FTP
        if ($request['thumbnail'] != NULL) {
            $rename_berkas = $this->random_string(50) . '.' . Input::file('thumbnail')->getClientOriginalExtension();

            $ftp_server = "167.205.7.228";
            $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

            $login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

            if (true === $login) {
                ftp_put($ftp_conn, "/Assets/PRD/Thumbnails/" . $rename_berkas, Input::file('thumbnail')->getPathName(), FTP_BINARY);
                ftp_close($ftp_conn);
            } else {
                ftp_close($ftp_conn);
            }

            $update = DB::table('topik')
                ->where('id', $request['id'])
                ->update(['nama_topik' => $request['judul'], 'pendahuluan' => $request['pendahuluan']
                    , 'class_warna' => $request['warna'], 'thumbnail' => 'http://167.205.7.228:8089/prd/Thumbnails/' . $rename_berkas]);

            if ($update) {
                Session::flash('message', 'Materi berhasil di ubah');
                return Redirect::to('administrator/materi');
            } else {
                Session::flash('message', 'Terjadi kesalahan');
                return Redirect::to('administrator/materi');
            }

        } //Akhir upload ke FTP
        else {//Tanpa upload file ke FTP
            $update = DB::table('topik')
                ->where('id', $request['id'])
                ->update(['nama_topik' => $request['judul'], 'pendahuluan' => $request['pendahuluan']
                    , 'class_warna' => $request['warna']]);

            if ($update) {
                Session::flash('message', 'Materi berhasil di ubah');
                return Redirect::to('administrator/materi');
            } else {
                Session::flash('message', 'Terjadi kesalahan');
                return Redirect::to('administrator/materi');
            }
        }

    }

    public function hapus_materi($id)
    {
        //topik
        $delete = DB::table('topik')
            ->where('id', '=', $id)
            ->delete();

        if ($delete) {
            //sub topik
            DB::table('sub_topik')
                ->where('id_topik', '=', $id)
                ->delete();

            //resume topik
            DB::table('resume_topik')
                ->where('id_topik', '=', $id)
                ->delete();

            //bimbingan
            DB::table('bimbingan')
                ->where('topik', '=', $id)
                ->delete();

            Session::flash('message', 'Materi berhasil di hapus');
            return Redirect::to('administrator/materi');
        } else {
            Session::flash('message', 'Terjadi kesalahan');
            return Redirect::to('administrator/materi');
        }
    }

    public function hapus_sub_materi($id)
    {
        //topik
        $delete = DB::table('sub_topik')
            ->where('id', '=', $id)
            ->delete();

        if ($delete) {
            //sub topik
            DB::table('sub_topik')
                ->where('id', '=', $id)
                ->delete();

            Session::flash('message', 'Sub materi berhasil di hapus');
            return Redirect::to('administrator/sub_materi');
        } else {
            Session::flash('message', 'Terjadi kesalahan');
            return Redirect::to('administrator/sub_materi');
        }
    }

    public function sub_materi()
    {
        $materi = DB::table('topik')
            ->get();

        $sub_materi = DB::table('sub_topik')
            ->select('*', 'sub_topik.id as id_sub_topik')
            ->join('topik', 'topik.id', '=', 'sub_topik.id_topik')
            ->orderBy('topik.id', 'asc')
            ->get();

        return view('layout.administrator.materi.sub_materi')
            ->with('materies', $materi)
            ->with('sub_materi', $sub_materi);
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
