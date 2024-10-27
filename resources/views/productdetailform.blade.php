<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/ProductDetailForm.css') }}" rel="stylesheet">
    <title>商品情報詳細画面</title>
</head>
<body>
<main>
    <div class="container">
        <div class="row">
            <h1>商品情報詳細画面</h1>
            <form action="{{ route('ProductDetailSubmit',['id' => $products -> id]) }}" method="post">
            @csrf
            <table>
                <tbody>

                    <tr>
                        <th class="caption-td">ID</th>
                        <td class="input-td"><span class="td-margin"></span>{{ $products -> id }}</td>
                    </tr>
                    <tr>
                        <th>商品画像</th>
                        @if ($products -> img_path)
                        <td class="td-img"><span class="td-margin"></span><img src="{{ asset($products -> img_path) }}"></td>
                        @else
                        <td class="td-img"><span class="td-margin"></span>No image</td>
                        @endif
                    </tr>
                    <tr>
                        <th>商品名</th>
                        <td><span class="td-margin"></span>{{ $products -> product_name }}</td>
                    </tr>
                    <tr>
                        <th>メーカー</th>
                        <td><span class="td-margin"></span>{{ $products -> company -> company_name }}</td>
                    </tr>
                    <tr>
                        <th>価格</th>
                        <td><span class="td-margin"></span>￥{{ $products -> price }}</td>
                    </tr>
                    <tr>
                        <th>在庫数</th>
                        <td><span class="td-margin"></span>{{ $products -> stock }}</td>
                    </tr>
                    <tr>
                        <th>コメント</th>
                        <td><span class="td-margin"></span>{{ $products -> comment }}</td>
                    </tr>
                </tbody>
            </table>    
            <div class="btn">
            <button type="submit" class="btn-edit" name="edit" value="edit">編集</button>
            <button type="submit" class="btn-back" name="back" value="back">戻る</button>
            </div>
            </form>
        </div>
    </div>
    </main>
    </body>
</html>
