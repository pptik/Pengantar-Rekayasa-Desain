<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 10:11 PM
 */


namespace App\Http\Controllers;

use App\MResume;

use DB;
use Illuminate\Support\Facades\Redirect;
use Input;
use Hash;
use Session;
use Auth;

class CResume extends Controller
{
    public function random_string($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }

        return $key;
    }

    /*public function video()
    {
        $rename_video = $this->random_string(50) . '.' . Input::file('video')->getClientOriginalExtension();

        $path = 'core/resources/assets/user_non_admin_assets/videos/';
        Input::file('video')->move($path, $rename_video);

        DB::table('resume_topik')
            ->where('id_topik', $_POST['id_topik'])
            ->where('id_pengguna', Session::get('id_pengguna'))
            ->update(['berkas_video' => $rename_video]);

        $nama_topik = NULL;

        //Mengambil nama topik dari id topik
        $query_id_topik = DB::table('topik')
            ->select('nama_topik')
            ->where('id_topik', '=', $_POST['id_topik'])
            ->get();

        foreach ($query_id_topik as $query_id_topik1) {
            $nama_topik = $query_id_topik1->nama_topik;
        }
        Session::flash('berhasil_upload_video', '');
        return Redirect::to('topik/laporan/' . str_replace(' ', '-', strtolower($nama_topik)) . '');
    }*/
    public function video()
    {
        $user = Auth::user();

        $nama_topik = NULL;

        //Mengambil nama topik dari id topik
        $query_id_topik = DB::table('topik')
            ->select('nama_topik')
            ->where('id', '=', $_POST['id_topik'])
            ->get();

        foreach ($query_id_topik as $query_id_topik1) {
            $nama_topik = $query_id_topik1->nama_topik;
        }


        $update = DB::table('resume_topik')
            ->where('id_topik', $_POST['id_topik'])
            ->where('id_pengguna', $user->id)
            ->update(['berkas_video' => $_POST['video']]);

        if($update){//berhasil
            Session::flash('message', 'Link embed video berhasil diperbaharui');
            return Redirect::to('topik/laporan/' . str_replace(' ', '-', strtolower($nama_topik)) . '');
        }//tdk berhasil
        else{
            Session::flash('message', 'Terjadi kesalahan');
            return Redirect::to('topik/laporan/' . str_replace(' ', '-', strtolower($nama_topik)) . '');
        }

    }

    public function berkas()
    {
        // connect and login to FTP server
        $rename_berkas = $this->random_string(50) . '.' . Input::file('berkas')->getClientOriginalExtension();

        $ftp_server = "ftp://167.205.7.228/assets/tadj/poster/";
        $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
        //$login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

        //$file = "localfile.txt";
        // cek koneksi
        $login = ftp_login($ftp_conn, "ftpmanager", "Sabuga@123");

        if (true === $login) {

           return 'Success!';

        } else {

            return 'Gagal';

        }
        // upload file
        /*if (ftp_put($ftp_conn, "tes.jpg", $rename_berkas, FTP_ASCII)) {
            return "Successfully uploaded";
            ftp_close($ftp_conn);
        } else {
            return "Error uploading";
            ftp_close($ftp_conn);
        }*/

        // close connection


        //$rename_berkas = $this->random_string(50) . '.' . Input::file('berkas')->getClientOriginalExtension();

        //$path = 'core/resources/assets/user_non_admin_assets/files/';
        /*$path = 'http://167.205.7.228:8089/tadj/poster/';
        Input::file('berkas')->move($path, $rename_berkas);

        DB::table('resume_topik')
            ->where('id_topik', $_POST['id_topik'])
            ->where('id_pengguna', Session::get('id_pengguna'))
            ->update(['berkas_file' => $rename_berkas]);

        $nama_topik = NULL;*/

        //Mengambil nama topik dari id topik
        /*$query_id_topik = DB::table('topik')
            ->select('nama_topik')
            ->where('id_topik', '=', $_POST['id_topik'])
            ->get();

        foreach ($query_id_topik as $query_id_topik1) {
            $nama_topik = $query_id_topik1->nama_topik;
        }
        Session::flash('berhasil_upload_berkas', '');
        return Redirect::to('topik/laporan/' . str_replace(' ', '-', strtolower($nama_topik)) . '');*/
    }

    public function resume()
    {
        DB::table('resume_topik')
            ->where('id_topik', $_POST['id_topik'])
            ->where('id_pengguna', Session::get('id_pengguna'))
            ->update(['resume' => $_POST['editor1']]);

        $nama_topik = NULL;

        //Mengambil nama topik dari id topik
        $query_id_topik = DB::table('topik')
            ->select('nama_topik')
            ->where('id_topik', '=', $_POST['id_topik'])
            ->get();

        foreach ($query_id_topik as $query_id_topik1) {
            $nama_topik = $query_id_topik1->nama_topik;
        }
        Session::flash('berhasil_resume', '');
        return Redirect::to('topik/laporan/' . str_replace(' ', '-', strtolower($nama_topik)) . '');
    }

}

?>