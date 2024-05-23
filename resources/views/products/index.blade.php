@extends('layouts.app')


@section('content')
<div class="container">
    <h1 class="mb-4">商品情報一覧</h1>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">商品新規登録</a>

    <div class="search mt-5">
    
    <h2>検索条件で絞り込み</h2>
    
    <form action="{{ route('products.index') }}" method="GET" class="row g-3" id="search-form">
        <div class="col-sm-12 col-md-3">
            <input type="text" name="search" class="form-control" placeholder="商品名" value="{{ request('search') }}" id="search">
        </div>
        <div class="col-sm-12 col-md-3">
            <select name="company_id" class="form-control" id="company">
                <option value="">全て</option>
                @foreach($company_lists as $key => $value)
                <option value="{{ $key }}" @if($company == $key) selected="selected" @endif>{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-12 col-md-3">
            <input type="number" name="price_min" class="form-control" placeholder="価格の下限" value="{{ request('price_min') }}">
        </div>
        <div class="col-sm-12 col-md-3">
            <input type="number" name="price_max" class="form-control" placeholder="価格の上限" value="{{ request('price_max') }}">
        </div>
        <div class="col-sm-12 col-md-3">
            <input type="number" name="stock_min" class="form-control" placeholder="在庫数の下限" value="{{ request('stock_min') }}">
        </div>
        <div class="col-sm-12 col-md-3">
            <input type="number" name="stock_max" class="form-control" placeholder="在庫数の上限" value="{{ request('stock_max') }}">
        </div>
        <div class="col-sm-12 col-md-1">
            <button class="btn btn-outline-secondary" type="submit">絞り込み</button>
        </div>
    </form>
</div>

<a href="{{ route('products.index') }}" class="btn btn-success mt-3">検索条件を元に戻す</a>
    <div class="products mt-5" >
        <h2>商品情報</h2>
        <table class="table table-striped" >
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
            <tbody id="search-results">
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->company->company_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->comment }}</td>
                    <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
                    </td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm mx-1">編集</a>
                        <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button data-products_id="{{$product->id}}" type="submit" id="deletebtn" class="btn btn-danger btn-sm mx-1">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    
    {{ $products->appends(request()->query())->links() }} 
</div>
@endsection