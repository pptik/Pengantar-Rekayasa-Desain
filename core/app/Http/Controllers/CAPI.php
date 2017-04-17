<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Redirect;
use Auth;
use \Firebase\JWT\JWT;

class CAPI extends Controller
{
    public function submitted_task(){
        //$users = DB::select('select * from users where active = ?', [1]);
        $users = DB::select("SELECT U.id,U.email,U.username,T.nama_topik,RT.created_at
                    FROM users U
                    JOIN resume_topik RT
                    ON U.id = RT.id_pengguna
                    JOIN topik T
                    ON RT.id_topik = T.id
                    ORDER BY U.id ASC");

        return response()->json($users);
    }

    public function universities_list(){
        $universities = DB::select("SELECT UN.id,US.nama_depan, US.nama_belakang
                                    FROM universitas UN
                                    JOIN users US
                                    ON UN.id_users = US.id
                                    ORDER BY US.id ASC");

        return response()->json($universities);
    }

    public function submitted_task_user($id_universitas){
        $users = DB::select("SELECT U.id,U.email,U.username,T.nama_topik,RT.created_at
                            FROM users U
                            JOIN resume_topik RT
                            ON U.id = RT.id_pengguna
                            JOIN topik T
                            ON RT.id_topik = T.id
                            WHERE U.universitas = '".$id_universitas."'
                            ORDER BY U.id ASC");

        return response()->json($users);
    }

    public function show($id)
    {
        //
    }

    public function hasbrain(){
        //Ambil data pengguna menggunakan session
        $user = Auth::user();

        $email = DB::table('users')->where('id','=',$user->id)->value('email');
        $username = DB::table('users')->where('id','=',$user->id)->value('username');
        $firstname = DB::table('users')->where('id','=',$user->id)->value('nama_depan');
        $lastname = DB::table('users')->where('id','=',$user->id)->value('nama_belakang');
        $nim = DB::table('users')->where('id','=',$user->id)->value('nim');

        //Ambil universitas

        $university_namaDepan = DB::table('universitas')
                        ->join('users','users.id','=','universitas.id_users')
                        ->where('universitas.id','=',$user->universitas)
                        ->value('nama_depan');

        $university_namaBelakang = DB::table('universitas')
                        ->join('users','users.id','=','universitas.id_users')
                        ->where('universitas.id','=',$user->universitas)
                        ->value('nama_belakang');

        $key = "hasBrainPRD";
        $token = array(
            "email" => $email,
            "username" => $username,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "nim" => $nim,
            "university" => $university_namaDepan.' '.$university_namaBelakang

        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        $jwt = JWT::encode($token, $key);
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        //print_r($decoded);

        /*
         NOTE: This will now be an object instead of an associative array. To get
         an associative array, you will need to cast it as such:
        */

        $decoded_array = (array) $decoded;

        /**
         * You can add a leeway to account for when there is a clock skew times between
         * the signing and verifying servers. It is recommended that this leeway should
         * not be bigger than a few minutes.
         *
         * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
         */
        JWT::$leeway = 60; // $leeway in seconds
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        //print_r($jwt);
        return Redirect::to("http://hasbrain.com/signup?jwt=".$jwt."");
    }
}
