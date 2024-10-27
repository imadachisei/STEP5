<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/ProductEditForm.css') }}" rel="stylesheet">
    <title>商品情報編集画面</title>
</head>
<body>
<main>
    <div class="container">
        <div class="row">
            <h1>商品情報編集画面</h1>

            <form action="{{ route('ProductEditSubmit',['id' => $products -> id]) }}" method="post" enctype='multipart/form-data'>
            @csrf
            <table>
                <tbody>
                    <tr>
                        <th class="caption-td">ID</th>
                        <td class="input-td"><span class="td-margin"></span>{{ $products -> id }}</td>
                    </tr>
                    <tr>
                        <th>商品名<span class="kome">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="product" name="product" value="{{ old('product') }}">
                            @if ($errors -> has('product'))
                            <p>{{ $errors -> first('product') }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>メーカー名<span class="kome">*</span></th>
                        <td>
                        <select class="form-control" id="manufacturer" name="manufacturer">
                        <option value=""></option>
                            @foreach ($manufacturers as $manufacturer)
                                <option value="{{ $manufacturer -> id }}">{{ $manufacturer -> company_name }}</option>
                            @endforeach
                        </select>
                            @if ($errors -> has('manufacturer'))
                            <p>{{ $errors -> first('manufacturer') }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>価格<span class="kome">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
                            @if ($errors -> has('price'))
                            <p>{{ $errors -> first('price') }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>在庫数<span class="kome">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
                            @if ($errors -> has('stock'))
                            <p>{{ $errors -> first('stock') }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>コメント</th>
                        <td>
                            <textarea class="form-control" rows="4" name="comment" value="{{ old('comment') }}"></textarea>
                            @if ($errors -> has('comment'))
                            <p>{{ $errors -> first('comment') }}</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>商品画像</th>
                        <td>
                            <input type="file" class="form-control" id="img" name="img" >
                        </td>
                    </tr>
                </tbody>
                </table>
                <div class="btn">
                <button type="submit" class="btn-update" name="update" value="update">更新</button>
                <button type="submit" class="btn-back" name="back" value="back">戻る</button>
                </div>   
            </form>
            </div>
        </div>
    </main>
    </body>
</html>
