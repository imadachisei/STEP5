<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use App\Models\Product;
use App\Models\Company;
use App\Models\Section;

class Account extends Model
{

    public function requestLoginAccount($data) {

        //入力したパスワード,emailをUserテーブルで検索してカウント
        $countUser = User::where('password', $data -> password)
                    -> where('email', $data -> email)
                    -> count();

        //カウントした値によって条件分岐
        switch($countUser) {

            //0の場合
            case 0:

                break;
            
            //1の場合
            case 1:

                //入力したパスワード,emailをUserテーブルで検索して1レコード取得
                $loginUser = User::where('password', $data -> password)
                            -> where('email', $data -> email)
                            -> first();
    
                return $loginUser;

            //2以上の場合
            case $countUser >= 2:

                break;
        }
    }

    public function registNewAccount($data) {

        // 登録処理
        User::create([
            'password' => $data['password'],
            'email' => $data['email'],
        ]);

    }

    public function registNewProduct($data, $image_path) {

        // 登録処理
        Product::create([
            'company_id' => $data['manufacturer'],
            'product_name' => $data['product'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'comment' => $data['comment'],
            'img_path' => $image_path,
        ]);

    }

    public function updateProduct($data, $image_path, $products) {

        // 編集処理
        $result = $products -> fill([
            'company_id' => $data->manufacturer,
            'product_name' => $data->product,
            'price' => $data->price,
            'stock' => $data->stock,
            'comment' => $data->comment,
            'img_path' => $image_path,
        ]) -> save();

        return $result;
        
    }


    public function Company() {

        //Companiesテーブルの値を全て取得
        $Company = Company::all();
        return $Company;

    }
}
