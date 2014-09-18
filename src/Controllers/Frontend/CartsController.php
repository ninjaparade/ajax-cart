<?php namespace Ninjaparade\Cart\Controllers\Frontend;

use Cartalyst\Conditions\Condition;
use Converter;
use Input;
use Platform\Foundation\Controllers\BaseController;
use Redirect;
use Request;
use Response;
use Store;
use View;

class CartsController extends BaseController {

    //cart instance

    protected $cart;

    public function __construct()
    {
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

        $coupon = $cart->conditions('discount');

  //       $condition = new Condition([
		//     'name'   => 'VAT (12.5%)',
		//     'type'   => 'discount',
		//     'target' => 'subtotal',
		// ]);

		// $condition->setActions([
		//     [
		//         'value' => '-5%',
		//     ],

		// ]);

		// $this->cart->condition($condition);


		// $this->cart->setItemsConditionsOrder([
		//     'discount',
		//     'tax',
		//     'shipping',
		// ]);

        return View::make('ninjaparade/cart::index', compact('cart', 'items', 'total', 'coupon'));
    }

    public function add($id)
    {
        if ( !$product = Store::find($id) )
        {
            return Redirect::to('/');
        }

        $quantity = Input::get('quantity');

        $item = $this->updateCart($product, $quantity);

        if ( Request::ajax() )
        {
            return $this->ajaxCartResponse("{$product->name} was successfully added to the shopping cart.", $item);
        }

        return Redirect::route('cart.index')
            ->withSuccess("{$product->name} was successfully added to the shopping cart.");
    }

    public function update()
    {

        $updates = Input::get('update');

        $this->cart->update($updates);

        if ( Request::ajax() )
        {
            return $this->ajaxCartResponse('Cart was successfully updated.');
        }


        return Redirect::route('cart.index')
            ->withSuccess('Cart was successfully updated.');

    }

    public function update_cart($id)
    {
        if ( !$product = Store::find($id) )
        {
            return Redirect::back()->withErrors('No product found');
        }

        $quantity = Input::get('quantity');

        if ( $update = $this->updateCart($product, $quantity) )
        {
            if ( Request::ajax() )
            {
                return $this->ajaxCartResponse("{$product->name} was successfully updated in your shopping cart.", $update);
            }

            return Redirect::route('cart.index')
                ->withSuccess("{$product->name} was successfully updated in your shopping cart.");
        }
    }

    public function remove($rowId)
    {
        if ( $remove = $this->cart->remove($rowId) )
        {
            if ( Request::ajax() )
            {
                return $this->ajaxCartResponse("successfully removed fromy your cart");

            }

            return Redirect::back()
                ->withSuccess("successfully removed fromy your cart");
        }
    }

    public function remove_get()
    {
    	$rowId = Input::get('rowId');
    	if( ! $this->cart->item($rowId))
    	{
    		 $items = $this->cart->items();

              return Response::json([ 
              		'status' => 0,
                	'message' => "Could not find item in cart"
              ]);
    	}

        if ( $remove = $this->cart->remove($rowId) )
        {
            if ( Request::ajax() )
            {
                return Response::json([
                	'quantity' => $this->cart->quantity(),
                	'message' => "Successfully Removed"
                ]);
            }

        }
    }

    public function getCart()
    {
    	$items = $this->cart->items();
    	
    	return View::make('ninjaparade/cart::cart-form', compact('items'));
    }

    public function destroy()
    {
        $this->cart->clear();

        return Redirect::to('store')->withSuccess("successfully removed fromy your cart");
    }

    protected function updateCart($product, $quantity, $ajax = true)
    {
        if ( $row = $this->cart->find(['id' => $product->id]) )
        {

            $rowId = $row[0]->get('rowId');

            $item = $this->cart->update($rowId, ['quantity' => $quantity]);

        } else
        {
            $item = $this->cart->add([
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $quantity,
                'product'  => $product
            ]);
        }

        if ( $ajax )
        {
            return $item->toArray();
        } else
        {
            return $item;
        }

    }

    protected function ajaxCartResponse($message = 'success', $meta = [])
    {
        return Response::json([
            'success' => true,
            'count'   => $this->cart->quantity(),
            'total'   => Converter::value($this->cart->total())->to('currency.usd')->format(),
            'message' => $message,
            'meta'    => $meta
        ]);
    }
}
