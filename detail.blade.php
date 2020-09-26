@extends('layouts.app')

@section('content')
<h1>商品詳細</h1>
@if (Auth::check() && $detail->stocks > 0)
<form action="{{ route('cart.add', ['id' => $detail->id]) }}" method="post">
{{ csrf_field() }}
<input type="hidden" name="item_id" value="{{ $detail->id }}">
<input type="submit" value="カートに入れる">
</form>
@elseif (Auth::check() && 0 >= $detail->stocks)
在庫無し
@else
<a href="{{ url('/') }}">ログインしてください</a>
@endif
<table border="2" cellpadding="6" cellspacing="5">
<tr>
<th>商品名</th>
<th>商品説明</th>
<th>価格</th>
<th>在庫の有無</th>
<tr>
<td>{{$detail->name}}</td>
<td>{{$detail->description}}</td>
<td>{{$detail->price}}</td>
<td>{{$detail->stocks}}</td>
</tr>
</table>

@endsection