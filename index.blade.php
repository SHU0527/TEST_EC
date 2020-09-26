@extends('layouts.app')

@section('content')
@if ($carts->count() > 0)
<h1>カート一覧</h1>
<table border="2" cellpadding="6" cellspacing="5">
<tr>
<th>商品名</th>
<th>購入数</th>
<th>価格</th>
<th>削除</th>
</tr>
@foreach ($carts as $cart)
<tr>
<td>{{ $cart->item->name }}</td>
<td>{{ $cart->quantity }}</td>
<td>{{ $cart->item->price }}</td>
<td>
<form action="{{ route('cart.delete', ['id' => $cart->id]) }}" method="post">
{{ csrf_field() }}
<input type="hidden" name="cart_id" value="{{ $cart->id }}">
<button type="submit">削除</button>
</form>
</td>
</tr>
@endforeach
</table>
合計金額{{ $total }}
@else
<h1>カートの中身は空です</h1>
@endif

@endsection