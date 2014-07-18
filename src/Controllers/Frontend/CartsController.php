<?php namespace Ninjaparade\Cart\Controllers\Frontend;

use Platform\Foundation\Controllers\BaseController;
use View;

class CartsController extends BaseController {

	/**
	 * Return the main view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		return View::make('ninjaparade/cart::index');
	}

}
