<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoginAccount extends Model
{
    // use HasFactory;

    public function registAccount($data) {
        // 登録処理
        DB::table('users') -> insert([
            'password' => $data -> password,
            'email' => $data -> email,
        ]);
    }
}
