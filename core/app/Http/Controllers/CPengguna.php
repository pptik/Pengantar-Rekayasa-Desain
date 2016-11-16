<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MUser;
use App\MUniversitas;
use App\MDosen;
use App\MMahasiswa;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use Hash;
use Session;
use Auth;
use Mail;

class CPengguna extends Controller
{
    public function index()
    {
        $user = Auth::user();

        //ambil data topik
        $topik = DB::table('topik')
            ->orderBy('id', 'asc')
            ->get();

        //menentukan topik mana yang bisa di ambil oleh siswa
        $topik_terakhir_yang_diambil = DB::table('mahasiswa_mengambil_topik')
            ->select('id_topik')
            ->where('id_pengguna', '=', $user->id)
            ->orderBy('id_topik', 'desc')
            ->take(1)
            ->get();
        if ($user->peran == 2 || $user->peran == 4) {//dosen atau mhs
            return view('layout.dashboard')
                ->with('topik', $topik)
                ->with('topik_terakhir_yang_diambil', $topik_terakhir_yang_diambil);
        } else if ($user->peran == 1) {//administrator
            return view('layout.administrator.dashboard');
        } else if ($user->peran == 5) {//universitas
            return view('layout.universitas.dashboard');
        }
    }

    public function login()
    {

        return view('layout.login');
    }

    public function register()
    {
        $universitas = DB::table('universitas')
                        ->select('universitas.id as id_universitas','users.nama_depan as universitas_nama_depan'
                            ,'users.nama_belakang as universitas_nama_belakang')
                        ->join('users','users.id','=','universitas.id_users')
            ->get();

        $fakultas = DB::table('fakultas')
            ->get();

        return view('layout.register')
            ->with('universitas', $universitas)
            ->with('fakultas', $fakultas);
    }

    public function lupa_password()
    {
        return view('layout.lupa_password');
    }

    public function lupa_password_send()
    {
        $user = DB::table('users')
            ->select('*')
            ->where('email', '=', $_POST['email'])
            ->get();


        $kirim = Mail::send('layout.send_email', ['user' => $user], function ($message) {
            $user = Auth::user();
            $message->from('emilhamep@gmail.com', 'PRD InsyaAllah bisa');

            //$message->to('emilhamep@icloud.com');
            $message->to($_POST['email']);

            $message->subject("PRD InsyaAllah bisa");
        });

        if($kirim){
            return "sent";
        }else{
            return "not send";
        }

    }


    public function ubah_profile(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'nim' => 'required',
        ]);

        //return $request['nama_depan'].$request['nama_belakang'].$request['nim'];
        $update = DB::table('users')
            ->where('id', $user->id)
            ->update(['nama_depan' => $request['nama_depan'], 'nama_belakang' => $request['nama_belakang']
                , 'nim' => $request['nim']]);

        if ($update) {
            Session::flash('berhasil', 'Data profil berhasil diperbarui');
            return Redirect::to('user/' . $user->username . '/ubah_profil');
        } else {
            Session::flash('message', 'Terjadi kesalahan');
            return Redirect::to('user/' . $user->username . '/ubah_profil');
        }
    }

    public function ubah_keamanan(Request $request)
    {

        $user = Auth::user();
        $this->validate($request, [
            'password_sekarang' => 'required|min:8',
            'password' => 'required|min:8|confirmed',
        ]);

        $userdata = array(
            'email' => $user->email,
            'password' => $request['password_sekarang']
        );

        if (Auth::attempt($userdata)) {//password sesuai
            $update = DB::table('users')
                ->where('id', $user->id)
                ->update(['password' => bcrypt($request['password'])]);

            if ($update) {
                Session::flash('berhasil', 'Password berhasil diperbarui');
                return Redirect::to('user/' . $user->username . '/keamanan');
            } else {
                return "Terjadi kesalahan ketika proses ubah";
            }
        } else {
            Session::flash('gagal', "Password sekarang tidak sesuai dengan yang diinputkan.");
            return Redirect::to('user/' . $user->username . '/keamanan');
        }

    }

    public function daftar_process(Request $request)
    {

        $this->validate($request, [
            'peran' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'universitas' => 'required'
        ]);


        //db SQL
        $user = new MUser();
        $user->peran = $request['peran'];
        $user->email = $request['email'];
        $user->nim = $request['nim'];
        $user->nama_depan = $request['nama_depan'];
        $user->nama_belakang = $request['nama_belakang'];
        $user->username = $request['username'];
        $user->universitas = $request['universitas'];
        $user->fakultas = $request['fakultas'];
        $user->status_konfirmasi = 0;
        $user->password = bcrypt($request['password']);
        $user->save();

        switch ($request['peran']){
            case 2:
                $id_users = DB::table("users")
                    ->where('email', '=', $request['email'])
                    ->get();

                $id_users_val = NULL;

                foreach ($id_users as $id_users) {
                    $id_users_val = $id_users->id;
                }

                $dosen = new MDosen();
                $dosen->id_users = $id_users_val;
                $dosen->save();
                ;break;//dosen
            case 4:
                $id_users = DB::table("users")
                    ->where('email', '=', $request['email'])
                    ->get();

                $id_users_val = NULL;

                foreach ($id_users as $id_users) {
                    $id_users_val = $id_users->id;
                }

                $mahasiswa = new MMahasiswa();
                $mahasiswa->id_users = $id_users_val;
                $mahasiswa->save();
                ;break;//mahasiswa
        }
        //akhir db SQL

        //Active Directory  Windows Server 2012

        /*$username = "emilhamep";


        $password = "Fadillah!24";


        $domain = "tadj.local";


        $domain_username = "$username" . "@" . $domain;


        $user_dir = "DC=tadj,DC=local";


        $ldap_server = "ta.tadj.local";


        $ldap_conn = ldap_connect($ldap_server);


        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3) or die ("Could not set LDAP Protocol version");


        if($ldapbind = ldap_bind($ldap_conn, $domain_username, $password) == true)
        {


            $adduserAD["cn"] = $_POST["username"];
            $adduserAD["givenname"] = $_POST["nama_depan"];
            $adduserAD["sn"] = $_POST["nama_belakang"];
            $adduserAD["sAMAccountName"] = $_POST['username'];
            //$adduserAD['userPrincipalName'] = $_POST["nama_depan"]."@tadj.local";
            $adduserAD['userPrincipalName'] = str_replace(' ', '', $_POST["username"])."@tadj.local";
            $adduserAD["mail"] = $_POST["email"];
            $adduserAD["objectClass"] = "User";
            $adduserAD["displayname"] = $_POST["username"];
            $adduserAD["userPassword"] = '123456!a';
            $adduserAD["userAccountControl"] = "544";

            $base_dn = "cn=".$_POST["username"].", OU=TADJUsers,DC=tadj,DC=local";


            if(ldap_add($ldap_conn, $base_dn, $adduserAD) == true)
            {


                echo "User added!<br>";

                $group_name = "CN=PRDDosen,OU=PRDUsers,DC=tadj,DC=local";
                $group_info['member'] = $base_dn;

                if(ldap_mod_add($ldap_conn,$group_name,$group_info) == true)
                {

                }else{

                }

            }else{


                echo "Sorry, the user was not added.<br>Error Number: ";
                echo ldap_errno($ldap_conn) . "<br />Error Description: ";
                echo ldap_error($ldap_conn) . "<br />";
            }
        }else{
            echo "Could not bind to the server. Check the username/password.<br />";
            echo "Server Response:"


                . "<br />Error Number: " . ldap_errno($ldap_conn)


                . "<br />Description: " . ldap_error($ldap_conn);
        }


        ldap_close($ldap_conn);*/
        //akhir ke Active Directory  Windows Server 2012

        $id_pengguna = NULL;
        $id_universitas = NULL;
        $peran = NULL;
        $username = NULL;

        $query_id_pengguna = DB::table('users')
            ->select('*')
            ->where('email', '=', $_POST['email'])
            ->get();

        foreach ($query_id_pengguna as $query_id_pengguna1) {
            $id_pengguna = $query_id_pengguna1->id;
            $id_universitas = $query_id_pengguna1->universitas;
            $peran = $query_id_pengguna1->peran;
            $username = $query_id_pengguna1->username;
        }

        Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'id' => $id_pengguna,
            'universitas' => $id_universitas, 'peran' => $peran, 'username' => $username]);

        return Redirect::to('dashboard');

    }

    public function daftar_universitas_process(Request $request)
    {
        $this->validate($request, [
            'nama_depan' => 'required',
            'nama_belakang' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = new MUser();
        $user->email = $request['email'];
        $user->nama_depan = $request['nama_depan'];
        $user->nama_belakang = $request['nama_belakang'];
        $user->username = $request['username'];
        $user->peran = 5;
        $user->password_asli = $request['password'];
        $user->password = bcrypt($request['password']);
        $user->save();

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

        return Redirect::to('pengguna/universitas');
    }

    public function login_process(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $userdata = array(
            'email' => $request['email'],
            'password' => $request['password']
        );

        if (Auth::attempt($userdata)) {//username dan password sesuai

            $id_pengguna = NULL;
            $id_universitas = NULL;
            $peran = NULL;
            $username = NULL;

            $query_id_pengguna = DB::table('users')
                ->select('*')
                ->where('email', '=', $request['email'])
                ->get();

            foreach ($query_id_pengguna as $query_id_pengguna1) {
                $id_pengguna = $query_id_pengguna1->id;
                $id_universitas = $query_id_pengguna1->universitas;
                $peran = $query_id_pengguna1->peran;
                $username = $query_id_pengguna1->username;
            }

            Auth::attempt(['email' => $request['email'], 'password' => $request['password'], 'id' => $id_pengguna,
                'universitas' => $id_universitas, 'peran' => $peran, 'username' => $username]);

            $user = Auth::user();
            //Pengaturan redirect sesuai dengan peran pengguna
            if($user->peran == 1){//administrator
                return Redirect::to('administrator');
            }else{//selain administrator
                return Redirect::to('dashboard');
            }
        } else {//tidak sesuai
            Session::flash('gagal_login', '');
            return Redirect::to('login');
        }
    }

    public function profile_pengguna($nama)
    {

        //Ambil nama
        $query_nama = DB::table('users')
            ->select('*', 'fakultas.nama as fakultas', 'universitas.nama as universitas')
            ->join('universitas', 'universitas.id', '=', 'users.universitas')
            ->join('fakultas', 'fakultas.id', '=', 'users.fakultas')
            ->where('username', '=', $nama)
            ->get();

        if (count($query_nama) != 0) {
            return view('layout.profile_pengguna')
                ->with('query_nama', $query_nama);
        } else {
            return view('errors.404');
        }


    }

    public function profile_pengguna_auth($nama)
    {

        //Ambil dari nama
        $query_nama = DB::table('users')
            ->where('username', '=', $nama)
            ->get();

        if (count($query_nama) != 0) {
            //Cek dulu apakah id user yg mengakses sesuai dengan id user tujuan

            $id_user_tujuan = NULL;
            foreach ($query_nama as $query_nama) {
                $id_user_tujuan = $query_nama->id;
            }

            $user = Auth::user();

            if ($id_user_tujuan == $user->id) {

                $query_nama = DB::table('users')
                    ->select('*', 'users.id as id_user')
                    ->join('universitas', 'universitas.id', '=', 'users.universitas')
                    ->where('username', '=', $nama)
                    ->get();

                $dosen_pengampu = DB::table('dosen_pengampu')
                                    ->join('dosen','dosen.id','=','dosen_pengampu.dosen')
                                    ->join('users','users.id','=','dosen.id_users')
                                    ->where('dosen_pengampu.users','=',$user->id)
                                    ->get();
                return view('layout.profile_pengguna_auth')
                    ->with('query_nama', $query_nama)
                    ->with('dosen_pengampu', $dosen_pengampu);
            } else {
                return Redirect::to('user/' . $nama . '');
            }

        } else {
            //return view('errors.404');
            return 'Anda tidak diizinkan';
        }


    }

    public function ubah_profil($nama)
    {

        //Ambil dari nama
        $query_nama = DB::table('users')
            ->where('username', '=', $nama)
            ->get();

        if (count($query_nama) != 0) {
            //Cek dulu apakah id user yg mengakses sesuai dengan id user tujuan

            $id_user_tujuan = NULL;
            foreach ($query_nama as $query_nama) {
                $id_user_tujuan = $query_nama->id;
            }

            $user = Auth::user();

            if ($id_user_tujuan == $user->id) {

                $query_nama = DB::table('users')
                    ->select('*', 'users.id as id_user')
                    ->join('universitas', 'universitas.id', '=', 'users.universitas')
                    ->where('username', '=', $nama)
                    ->get();

                return view('layout.profile_pengguna_ubah')
                    ->with('query_nama', $query_nama);
            } else {
                return Redirect::to('user/' . $nama . '');
            }

        } else {
            return view('errors.404');
        }


    }

    public function keamanan($nama)
    {

        //Ambil dari nama
        $query_nama = DB::table('users')
            ->select('*', 'users.id as id_user')
            ->join('universitas', 'universitas.id', '=', 'users.universitas')
            ->where('username', '=', $nama)
            ->get();

        if (count($query_nama) != 0) {
            //Cek dulu apakah id user yg mengakses sesuai dengan id user tujuan

            $id_user_tujuan = NULL;
            foreach ($query_nama as $query_nama) {
                $id_user_tujuan = $query_nama->id_user;
            }

            $user = Auth::user();

            if ($id_user_tujuan == $user->id) {

                $query_nama = DB::table('users')
                    ->select('*', 'users.id as id_user')
                    ->join('universitas', 'universitas.id', '=', 'users.universitas')
                    ->where('username', '=', $nama)
                    ->get();

                return view('layout.keamanan')
                    ->with('query_nama', $query_nama);
            } else {
                return Redirect::to('user/' . $nama . '');
            }

        } else {
            return view('errors.404');
        }


    }

    public function keluar()
    {
        Session::flush();
        Auth::logout();

        return Redirect::to('login');
    }

    public function ubah_photo(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png|Max:500',
        ]);

        $rename_berkas = $this->random_string(50) . '.' . Input::file('photo')->getClientOriginalExtension();

        $ftp_server = "167.205.7.228";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

        $login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

        if (true === $login) {

            ftp_put($ftp_conn, "/Assets/PRD/Photo_profil/" . $rename_berkas, Input::file('photo')->getPathName(), FTP_BINARY);
            ftp_close($ftp_conn);


        } else {
            ftp_close($ftp_conn);


        }
        $user = Auth::user();


        DB::table('users')
            ->where('id', $user->id)
            ->update(['url_foto' => 'http://167.205.7.228:8089/prd/photo_profil/' . $rename_berkas]);


        return Redirect::to('user/' . $user->username . '/profil');

    }

    public function ktm(Request $request)
    {
        $this->validate($request, [
            'ktm' => 'required|mimes:jpg,jpeg,png|Max:500',
        ]);

        $rename_berkas = $this->random_string(50) . '.' . Input::file('ktm')->getClientOriginalExtension();

        $ftp_server = "167.205.7.228";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");

        $login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

        if (true === $login) {

            ftp_put($ftp_conn, "/Assets/PRD/ktm/" . $rename_berkas, Input::file('ktm')->getPathName(), FTP_BINARY);
            ftp_close($ftp_conn);


        } else {
            ftp_close($ftp_conn);


        }
        $user = Auth::user();


        DB::table('users')
            ->where('id', $user->id)
            ->update(['url_kartu_pengenal' => 'http://167.205.7.228:8089/prd/ktm/' . $rename_berkas]);


        return Redirect::to('dashboard');

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

    public function admin_pengguna_mahasiswa()
    {
        $mahasiswa = DB::table('users')
            ->where('peran', '=', '4')
            ->get();

        return view('layout.administrator.pengguna.mahasiswa')
            ->with('mahasiswa', $mahasiswa);
    }

    public function admin_pengguna_dosen()
    {
        $dosen = DB::table('users')
            ->where('peran', '=', '2')
            ->get();

        return view('layout.administrator.pengguna.dosen')
            ->with('dosen', $dosen);
    }

    public function admin_pengguna_universitas()
    {
        $universitas = DB::table('users')
            ->where('peran', '=', '5')
            ->get();

        return view('layout.administrator.pengguna.universitas')
            ->with('universitas1', $universitas);
    }

    public function universitas_pengguna_mahasiswa()
    {
        $user = Auth::user();

        $id_universitas = DB::table('universitas')
                            ->where('id_users','=',$user->id)
                            ->get();

        $id_universitas_val = NULL;
        foreach ($id_universitas as $id_universitas) {
            $id_universitas_val = $id_universitas->id;
        }
        $mahasiswa = DB::table('users')
            ->select('*','users.id as id_user')
            ->join('universitas', 'users.universitas', '=', 'universitas.id')
            ->where('users.peran', '=', '4')
            ->where('users.universitas', '=', $id_universitas_val)
            ->get();

        return view('layout.universitas.pengguna.mahasiswa')
            ->with('mahasiswa', $mahasiswa);

    }

    public function universitas_pengguna_dosen()
    {
        $user = Auth::user();

        $id_universitas = DB::table('universitas')
            ->where('id_users','=',$user->id)
            ->get();

        $id_universitas_val = NULL;
        foreach ($id_universitas as $id_universitas) {
            $id_universitas_val = $id_universitas->id;
        }
        $dosen = DB::table('users')
            ->select('*','users.id as id_user')
            ->join('universitas', 'users.universitas', '=', 'universitas.id')
            ->where('users.peran', '=', '2')
            ->where('users.universitas', '=', $id_universitas_val)
            ->get();

        return view('layout.universitas.pengguna.dosen')
            ->with('dosen', $dosen);

    }

    public function konfirmasi_mahasiswa($id_user){
        $konfirmasi = DB::table('users')
            ->where('id', $id_user)
            ->update(['status_konfirmasi' => '1']);

        if($konfirmasi){
            Session::flash('berhasil', 'Berhasil konfirmasi mahasiswa');
            return Redirect::to('universitas/mahasiswa');
        }else{
            return "gagal konfirmasi";
        }


    }

    public function konfirmasi_dosen($id_user){
        $konfirmasi = DB::table('users')
            ->where('id', $id_user)
            ->update(['status_konfirmasi' => '1']);

        if($konfirmasi){
            Session::flash('berhasil', 'Berhasil konfirmasi dosen');
            return Redirect::to('universitas/dosen');
        }else{
            return "gagal konfirmasi";
        }


    }
}

?>