<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Requests\NewAccountRequest;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\Product;


class UserController extends Controller
{
    public function __construct()
    {
        //インスタンス生成
        $this -> User = new User();
        $this -> Account = new Account();

    }

//ユーザーログイン画面----------------------------------------------
    //ユーザーログイン画面表示
    public function showLoginForm() {
        return view('loginform');
    }

    //ユーザーログイン画面からボタンを押した場合
    public function loginFormSubmitRequest(Request $request) {

        //ログインボタンを押した場合
        if ($request -> login) {

            //パスワード必須,emailはemail形式で必須
            $request -> validate([
                'password' => ['required'],
                'email' => ['required', 'email'],
            ]);

            //登録されているユーザーかチェック,ユニークかチェック
            $loginUser = $this -> User -> requestLoginAccount($request);

            //認証
            Auth::login($loginUser);

            //セッションIDを再発行
            $request -> session() -> regenerate();

            //商品一覧画面用のweb.phpにリダイレクト
            return redirect() -> route('ProductlistForm');

        // //新規登録ボタンを押した場合
        } elseif ($request -> register) {

            //新規登録用のWeb.phpにリダイレクト
            return redirect() -> route('NewAccountForm');

        }
    }

//----------------------------------------------------------------

//ユーザー新規登録画面----------------------------------------------

    //ユーザー新規登録画面表示
    public function showNewAccountForm() {

        //Web.phpのNewAccountFormにリダイレクト
        return view('newaccountform');

    }

    //ユーザー新規登録画面からボタンを押した場合
    public function newAccountFormSubmitRequest(Request $request) {

        //新規登録ボタンを押した場合
        if ($request -> register) {

            //パスワード必須,emailはemail形式で必須
            $request -> validate([
                'password' => ['required'],
                'email' => ['required', 'email'],
            ]);


            // トランザクション開始
            DB::beginTransaction();
        
            try {
                // 登録処理呼び出し
                $this -> User -> registNewAccount($request);

                //登録確定
                DB::commit();

                //エラー時、元に戻す
            } catch (\Exception $e) {
                DB::rollback();
                return back();
            }
        
            // 処理が完了したらWeb.phpのLoginformにリダイレクト
            return redirect() -> route('LoginForm');

        //戻るボタンを押した場合
        } elseif ($request -> back) {
            //Web.phpのLoginformにリダイレクト
            return redirect() -> route('LoginForm');
        }
    }

//----------------------------------------------------------------

//商品一覧画面----------------------------------------------------

    //商品一覧画面表示
    public function showProductlistForm() {

        //productsテーブルのcompany_idとcompaniesテーブルのidでリレーション
        //productsテーブルのcompany_idをグループ化(重複なし)してcompany_idを取得
        $companies = Product::with('company')
        -> groupby('company_id')
        -> get('company_id');

        //productsテーブルのcompany_idとcompaniesテーブルのidでリレーションして全て取得
        $products = Product::with('company')
        -> get();

        //商品一覧画面に取得した値渡して表示
        return view('productlistform',
        ['products' => $products, 'companies' => $companies]);

    }

    //商品一覧画面から検索ボタンを押した場合
    public function productlistFormSearchSubmitRequest(Request $request) {

        //検索ボックスとメーカー、両方入力した場合
        if ($request -> keyword && $request -> manufacturer) {

            //productsテーブルのcompany_idとcompaniesテーブルのidでリレーション
            //入力された値でproductsテーブルのproduct_nameを部分一致かつ
            //選択されたメーカーで検索して全て取得
            $products = Product::with('company')
            -> where('product_name', "LIKE", "%{$request -> keyword}%")
            -> where('company_id', $request -> manufacturer)
            -> get();

            //productsテーブルのcompany_idとcompaniesテーブルのidでリレーション
            //入力された値でproductsテーブルのproduct_nameを部分一致かつ
            //選択されたメーカーで検索して
            //company_idをグループ化(重複なし)してcompany_idを取得
            $companies = Product::with('company')
            -> where('product_name', "LIKE", "%{$request -> keyword}%")
            -> where('company_id', $request -> manufacturer)
            -> groupby('company_id')
            -> get('company_id');

            //商品一覧画面に取得した値渡して表示
            return view('productlistform',
            ['products' => $products, 'companies' => $companies]);
            
        //検索ボックスのみ入力があった場合
        } elseif ($request -> keyword) {

            //productsテーブルのcompany_idとcompaniesテーブルのidでリレーション
            //入力された値でproductsテーブルのproduct_nameを部分一致検索して全て取得
            $products = Product::with('company')
            -> where('product_name', "LIKE", "%{$request -> keyword}%")
            -> get();

            //productsテーブルのcompany_idとcompaniesテーブルのidでリレーション
            //入力された値でproductsテーブルのproduct_nameを部分一致検索して
            //company_idをグループ化(重複なし)してcompany_idを取得
            $companies = Product::with('company')
            -> where('product_name', "LIKE", "%{$request -> keyword}%")
            -> groupby('company_id')
            -> get('company_id');

            //商品一覧画面に取得した値渡して表示
            return view('productlistform',
            ['products' => $products, 'companies' => $companies]);
        
        //メーカのみを選択した場合
        } elseif ($request -> manufacturer) {

            //productsテーブルのcompany_idとcompaniesテーブルのidでリレーション
            //選択されたメーカーでproductsテーブルのproduct_nameを部分一致検索して全て取得
            $products = Product::with('company')
            -> where('company_id', $request -> manufacturer)
            -> get();

            //productsテーブルのcompany_idとcompaniesテーブルのidでリレーション
            //選択されたメーカーでproductsテーブルのcompany_idをグループ化(重複なし)してcompany_idを取得
            $companies = Product::with('company')
            -> where('company_id', $request -> manufacturer)
            -> groupby('company_id')
            -> get('company_id');

            //商品一覧画面に取得した値渡して表示
            return view('productlistform',
            ['products' => $products ,'companies' => $companies]);

        }
          
        //検索ボックスとメーカーがnullの場合
        //Web.phpのProductlistFormにリダイレクト
        return redirect() -> route('ProductlistForm');

    }

    //商品一覧画面から新規登録ボタンを押した場合
    public function productlistFormRegistSubmitRequest() {

        //Web.phpのNewProductFormにリダイレクト
        return redirect() -> route('NewProductForm');

    }

    //商品一覧画面から詳細ボタンを押した場合
    public function productlistFormDetailSubmitRequest($id) {

        //Web.phpのProductDetailFormにリダイレクト,該当のidを渡す
        return redirect() -> route('ProductDetailForm', [$id]);

    }

    //商品一覧画面から削除ボタンを押した場合
    public function productlistFormDeleteSubmitRequest($id) {

        //productsテーブルで該当のidを検索して1レコード取得
        $product = Product::find($id);

        // 該当のレコードを削除
        $product -> delete();

        // Web.phpのProductlistFormにリダイレクト
        return redirect() -> route('ProductlistForm');
    
    }

//----------------------------------------------------------------

//商品新規登録画面----------------------------------------------------

    //商品新規登録画面表示
    public function showNewProductForm() {

        //AccountモデルのCompanyメソッドを実行
        $Company = $this -> Account -> Company();

        //CompaniesテーブルのレコードをProductRegistFormで扱えるようにする
        return view('productregistform', ['manufacturers' => $Company]);

    }

    //商品新規登録画面のボタンを押した場合
    public function productRegistSubmitRequest(Request $request) {

        //新規登録を押した場合
        if ($request -> register) {

            //フィルター
            $credentials = $request -> validate([
                'manufacturer' => ['required'],
                'product' => ['required'],
                'price' => ['required' , 'integer'],
                'stock' => ['required' , 'integer'],
            ]);

            //imgがある場合
            if ($request -> img) {
            
                //画像ファイルの取得
                $image = $request -> file('img');

                //画像ファイルのファイル名を取得
                $file_name = $image -> getClientOriginalName();

                //storage/app/public/imagesフォルダ内に、取得したファイル名で保存
                $image -> storeAs('public/images', $file_name);

                //データベース登録用に、ファイルパスを作成
                $image_path = 'storage/images/' . $file_name;

            //imgがない場合
            } else {

                //null値にする
                $image_path = null;
            }

            // トランザクション開始
            DB::beginTransaction();

            try {

                // 登録処理呼び出し
                $this -> Account -> registNewProduct($request, $image_path);
                DB::commit();

                //エラー時
            } catch (\Exception $e) {
                DB::rollback();
                return back();

            }
        
            // Web.phpのNewProductFormにリダイレクト
            return redirect() -> route('NewProductForm');

        //戻るボタンを押した場合
        } elseif ($request -> back) {
                
            // Web.phpのProductlistFormにリダイレクト
            return redirect() -> route('ProductlistForm');

        }
    }

//----------------------------------------------------------------

//商品情報詳細画面----------------------------------------------------

    //商品情報詳細画面表示
    public function showProductDetailForm($id) {

        // productsテーブルのcompany_idとcompaniesテーブルのidでリレーション
        // 渡されたidでproductsテーブルのidを取得
        $products = Product::with('company') -> find($id);

        //商品情報詳細画面に取得した値を渡して表示
        return view('productdetailform', ['products' => $products ]);

    }

    //商品情報詳細画面でボタンを押した場合
    public function productDetailSubmitRequest(Request $request, $id) {

        //編集ボタンを押した場合
        if ($request -> edit) {

            // Web.phpのProductEditFormにリダイレクト,該当のidを渡す
            return redirect() -> route('ProductEditForm', [$id]);
        
        //戻るボタンを押した場合
        } elseif ($request -> back) {

            // Web.phpのProductlistFormにリダイレクト
            return redirect() -> route('ProductlistForm');

        }
    }

//----------------------------------------------------------------

//商品情報編集画面----------------------------------------------------

    //商品情報編集画面表示
    public function showProductEditForm($id) {

        //渡されたidでproductsテーブルのidを取得
        $products = Product::find($id);

        //AccountモデルのCompanyメソッドを実行
        $Company = $this -> Account -> Company();

        //Companiesテーブルのレコードとproductsテーブルの該当のidのレコードを
        //ProductEditFormで扱えるようにする
        return view('producteditform', ['products' => $products, 'manufacturers' => $Company]);

    }

    //商品情報編集画面でボタンを押した場合
    public function productEditSubmitRequest(Request $request, $id) {

        //更新ボタンを押した場合
        if ($request -> update) {
            
            //フィルター
            $credentials = $request->validate([
                'manufacturer' => ['required'],
                'product' => ['required'],
                'price' => ['required' , 'integer'],
                'stock' => ['required' , 'integer'],
            ]);

            //imgがある場合
            if ($request -> img) {

                //画像ファイルの取得
                $image = $request -> file('img');

                //画像ファイルのファイル名を取得
                $file_name = $image -> getClientOriginalName();

                //storage/app/public/imagesフォルダ内に、取得したファイル名で保存
                $image -> storeAs('public/images', $file_name);

                //データベース登録用に、ファイルパスを作成
                $image_path = 'storage/images/' . $file_name;

                //imgがない場合
                } else {

                    //null値にする
                    $image_path = null;
            }   

            //渡されたidでproductsテーブルのidを取得
            $products = Product::find($id);

            // トランザクション開始
            DB::beginTransaction();

            try {
                // 編集処理呼び出し
                $this -> Account -> updateProduct($request, $image_path, $products);
                DB::commit();

                //エラー時
            } catch (\Exception $e) {
                DB::rollback();
                return back();

            }

            // Web.phpのProductEditFormにリダイレクト,該当のidを渡す
            return redirect() -> route('ProductEditForm', [$id]);

        //戻るボタンを押した場合
        } elseif ($request -> back){

            // Web.phpのProductDetailFormにリダイレクト,該当のidを渡す
            return redirect() -> route('ProductDetailForm', [$id]);
        }
    }
    //----------------------------------------------------------------
}
