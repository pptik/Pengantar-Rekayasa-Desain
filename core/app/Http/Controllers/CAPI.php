<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

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
}
