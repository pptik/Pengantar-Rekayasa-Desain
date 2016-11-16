<?php
/**
 * Created by PhpStorm.
 * User: Emilham
 * Date: 1/7/16
 * Time: 11:20 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class MUser extends Model
{

    protected $table = 'users';//tabel yang dituju
    //public $timestamps = false;//tidak menggunakan created_at dan updated_at

    
}