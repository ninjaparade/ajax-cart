<?php namespace Ninjaparade\Cart\Controllers\Frontend;

use Platform\Foundation\Controllers\BaseController;
use View;
use Store;

class CartsController extends BaseController {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		
	}

	public function add($id)
	{
		$product = Store::find($id);
	}
	
}
