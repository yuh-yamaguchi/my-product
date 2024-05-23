@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報一覧</h1>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">商品新規登録</a>

    <div class="search mt-5">
    
    <h2>検索条件で絞り込み</h2>
    
    <form action="{{ route('products.search') }}" method="GET" class="row g-3">
        <input type="text" id="search-input" placeholder="検索キーワード">
        <div id = "company-input" class="col-sm-12 col-md-3">
            <select name="company_id" class="form-control">
                <option value="">全て</option>
                @foreach($company_lists as $key => $value)
                <option value="{{ $key }}" @if($company == $key) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div id = "priceMin-input" class="col-sm-12 col-md-3">
            <input type="number" name="price_min" class="form-control" placeholder="価格の下限" value="{{ request('price_min') }}">
        </div>
        <div id = "priceMax-input" class="col-sm-12 col-md-3">
            <input type="number" name="price_max" class="form-control" placeholder="価格の上限" value="{{ request('price_max') }}">
        </div>
        <div id = "stockMin-input" class="col-sm-12 col-md-3">
            <input type="number" name="stock_min" class="form-control" placeholder="在庫数の下限" value="{{ request('stock_min') }}">
        </div>
        <div id = "stockMax-input" class="col-sm-12 col-md-3">
            <input type="number" name="stock_max" class="form-control" placeholder="在庫数の上限" value="{{ request('stock_max') }}">
        </div>
        
        <!-- 検索条件の他の入力フォームも追加 -->
            <button id="search-button">検索</button>

           
    </form>
</div>

<div>
    <a href="{{ route('products.search') }}" class="btn btn-success mt-3">検索条件を元に戻す</a>
    <div id="search-results" class="products mt-5">
        <h2>商品情報</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>商品名</th>
                    <th>メーカー</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>コメント</th>
                    <th>商品画像</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
<tr>
    <td>{{ $product->product_name }}</td>
    <td>{{ $product->company->company_name }}</td>
    <td>{{ $product->price }}</td>
    <td>{{ $product->stock }}</td>
    <td>{{ $product->comment }}</td>
    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
    <td>
        <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm mx-1">編集</a>
        <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm mx-1">削除</button>
        </form>
    </td>
</tr>
@endforeach
            </tbody>
        </table>
    </div>
    
    {{ $products->appends(request()->query())->links() }} 
</div>
<sucript type="text/javascript">
    $('#search-input').on('keyup' function({
        $value =$(this).val();
        alert($value);
    }));
</script>
@endsection