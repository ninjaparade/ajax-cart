<?php namespace Ninjaparade\Cart\Controllers\Frontend;

use Platform\Foundation\Controllers\BaseController;
use View;
use Store;
use Input;
use Redirect;


class CartsController extends BaseController {


	protected $cart;


	public function __construct() {
		
		parent::__construct();

		$this->cart = app('cart');
	}
	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$cart = $this->cart;

		$items = $cart->items();

		$total = $cart->total();

		$coupon = $cart->conditions('coupon');

		return View::make('ninjaparade/cart::index', compact('cart', 'items', 'total', 'coupon'));
	}

	public function add($id)
	{
		
		if ( ! $product = Store::find($id))
		{
			return Redirect::to('/');
		}

		$quantity = Input::get('quantity');

		$this->addToCart($product, $quantity);

		return Redirect::route('cart.index')->withSuccess("{$product->name} was successfully added to the shopping cart.");

	}

	public function update()
	{
		

		$updates = Input::get('update');
		
		$this->cart->update($updates);

		return Redirect::route('cart.index')->withSuccess('Cart was successfully updated.');
	}


	public function update_cart($id)
	{

		if ( ! $product = Store::find($id))
		{
			return Redirect::back()->withErrors('No product found');
		}

		$quantity = Input::get('quantity');
		
		if( $update = $this->updateCart($product, $quantity) )
		{
			return Redirect::route('cart.index')->withSuccess("{$product->name} was successfully updated in your shopping cart.");
		}

	}

	public function remove($rowId)
	{
		$this->cart->remove($rowId);

		return Redirect::back()->withSuccess("successfully removed fromy your cart");
	}



	protected function addToCart($product, $quantity)
	{
		$item = $this->cart->add([
			'id'         => $product->id,
			'name'       => $product->name,
			'price'      => $product->price,
			'quantity'   => $quantity
		]);
	}

	protected function updateCart($product, $quantity)
	{
		

		if( ! $item = $this->cart->find( ['id' => $product->id] ))
		{
			return false;
		}

		$rowId = $item[0]->get('rowId');

		$this->cart->update($rowId, ['quantity' => $quantity]);

		return true;

	}
}
