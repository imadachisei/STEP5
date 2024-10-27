<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="{{ asset('css/ProductlistForm.css') }}" rel="stylesheet">
    <title>商品一覧画面</title>
</head>
<body>
<main>
<h1>商品一覧画面</h1>

<article>
<form action="{{ route('ProductSearchSubmit') }}" method="post">
    @csrf

    <div class="form-group">
        <input type="text" class="keyword" id="keyword" name="keyword" placeholder="検索キーワード" value="{{ old('keyword') }}">
        @if ($errors -> has('keyword'))
            <p>{{ $errors -> first('keyword') }}</p>
        @endif


        <select class="manufacturer" id="manufacturer" name="manufacturer" >
            <option value=null disabled selected>メーカー名</option>
                @foreach ($companies as $company)
                    <option  value="{{ $company -> company_id }}">{{ $company -> company -> company_name }}</option>
                @endforeach
        </select>
                @if ($errors -> has('manufacturer'))
                <p>{{ $errors -> first('manufacturer') }}</p>
                @endif

        <button type="submit" class="btn-search" name="search" value="search">検索</button>
    </div>
</form>
</article>

<section>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th class="img">商品画像</th>
                <th>商品名</th>
                <th>価格</th>
                <th>在庫数</th>
                <th>メーカー名</th>
                <form action="{{ route('ProductlistFormRegistSubmit') }}" method="post">
                @csrf
                <th class="form-btn" colspan="2">
                    <button type="submit" class="btn-register" name="register" value="register">新規登録</button>
                </th>
                </form>
            </tr>
        </thead>

        <tbody>
         @foreach ($products as $product)
        <tr>
            <td>{{ $product -> id }}</td>
            @if ($product -> img_path)
            <td class="td-img"><img src="{{ asset($product -> img_path) }}"></td>
            @else
            <td class="td-img">No image</td>
            @endif
            <td>{{ $product -> product_name }}</td>
            <td>￥{{ $product -> price }}</td>
            <td>{{ $product -> stock }}</td>
            <td>{{ $product -> company -> company_name }}</td>

            <form action="{{ route('ProductlistFormDetailSubmit',['id' => $product -> id]) }}" method="post">
            @csrf
            <td class="form-btn"><button type="submit" class="btn-detail" name="detail" value="detail">詳細</button></td>
            </form>

            <form action="{{ route('ProductlistFormDeleteSubmit',['id' => $product -> id]) }}" method="post">
            @csrf
            <td class="form-btn"><button type="submit" class="btn-delete" name="delete" value="delete">削除</button></td>
            </form>
        </tr>
        @endforeach
        </tbody>
    </table>
</section>
</main>
</body>
</html>
