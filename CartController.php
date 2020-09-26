<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\facades\Auth;
use App\Cart;
use App\Item;

class CartController extends Controller {
	public function index() {
		$user_id = Auth::id();
		$carts = Cart::where('user_id', $user_id)->get();
		$total = 0;
		foreach ($carts as $cart) {
			$total += $cart->item->price * $cart->quantity;
		}
		return view('cart.index', compact('carts', 'total'));
	}
	public function add($item_id, Request $request) {
		DB::transaction(function () use ($item_id, $request) {
			$cart = new Cart;
			$item = (new Item)->find($item_id);
			$stocks = $item->stocks;
			if (0 >= $stocks) {
				return redirect(route('item.index'));
			}
			$user_id = Auth::id();
			$exesting_cart = Cart::where('item_id', $item_id)->first();
			if ($exesting_cart) {
				$exesting_cart->increment('quantity');
				$item->decrement('stocks');
			} else {
				$cart->user_id = $user_id;
				$cart->item_id = $item_id;
				$cart->quantity = 1;
				$cart->save();
				$item->decrement('stocks');
			}
		});
		return redirect(route('cart.index'));
	}
	public function delete($cart_id, Request $request) {
		DB::transaction(function () use ($cart_id, $request) {
			$cart = Cart::find($cart_id);
			if ($cart->user_id == Auth::id()) {
				$item_id = $cart->item_id;
				$stock_return = $cart->quantity;
				$cart->delete();
				$item = (new Item)->find($item_id);
				$item->increment('stocks', $stock_return);
			}
		});
		return redirect(route('cart.index'));
	}
}
?>