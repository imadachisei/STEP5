<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //登録されているユーザーかチェック,ユニークかチェック
    public function requestLoginAccount($request) {

        //ユーザーログイン画面で入力した値をUserテーブルで検索して一致した数をカウント
        $countUser = User::where('password', $request -> password)
                    -> where('email', $request -> email)
                    -> count();

        //一致した数によって条件分岐
        switch($countUser) {
            case 0:
                break;
            
            case 1:

                //ユーザーログイン画面で入力した値をUserテーブルで検索して最初のレコードを取得
                $loginUser = User::where('password', $request -> password)
                            -> where('email', $request -> email)
                            -> first();
    
                return $loginUser;

            case $countUser >= 2:
                break;
        }
    }

    //新規アカウント登録処理
    public function registNewAccount($request) {

        // ユーザー新規登録画面で入力したデータをUserテーブルに登録
        User::create([
            'password' => $request['password'],
            'email' => $request['email'],
        ]);

    }
}
