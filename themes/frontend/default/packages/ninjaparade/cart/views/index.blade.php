@extends('layouts/default')

@section('content')

@include('partials.notifications')

<div class="page-header">
	<h1>Shopping Cart</h1>
	<p class="lead">Powerfull and flexible our shopping cart allows you to modify your cart anyway your heart desires.</p>
</div>

<div class="row">
	<div class="col-lg-12">

		<div class="table-responsive">

			<!-- <form role="form" method="post"> -->

			{{ Form::open(array('url' => URL::route('cart.cart_update'), 'method' => 'post', 'class'=>'form-inline'))}}

				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<td class="col-md-6">Name</td>
							<td class="col-md-1">Quantity</td>
							<td class="col-md-1">Price</td>
							<td class="col-md-2" colspan="2">Total</td>
						</tr>
					</thead>
					<tbody>
						@if ($items->isEmpty())
						<tr>
							<td colspan="4">Your shopping cart is empty.</td>
						</tr>
						@else
						@foreach ($items as $item)
						<tr>
							<td>
								<div class="col-md-2">
									<img src="http://placehold.it/80x80" alt="..." class="img-thumbnail">
								</div>

								{{{ $item->get('name') }}}
							</td>
							<td>
								<input class="form-control" type="text" name="update[{{{ $item->get('rowId') }}}][quantity]" value="{{{ $item->get('quantity') }}}" />
							</td>
							<td>{{{ Converter::value($item->get('price'))->to('currency.usd')->format() }}}</td>
							<td>{{{ Converter::value($item->total())->to('currency.usd')->format() }}}</td>
							<td>
						
							</td>
						</tr>
						@endforeach
						<tr>
							<td colspan="4">
								<span class="pull-right">Items</span>
							</td>
							<td>{{{ Cart::quantity() }}}</td>
						</tr>
						<tr>
							<td colspan="4">
								<span class="pull-right">Subtotal</span>
							</td>
							<td>{{{ $cart->subtotal() }}}</td>
						</tr>
						<tr>
							<td colspan="4">
								<span class="pull-right">Subtotal (with discounts)</span>
							</td>
							<td>{{{ $cart->total('discount') }}}</td>
						</tr>

						{{-- Items Discounts --}}
						@foreach ($cart->itemsConditionsTotal('discount') as $name => $value)
						<tr>
							<td colspan="4">
								<span class="pull-right">{{{ $name }}}</span>
							</td>
							<td>{{{ $value }}}</td>
						</tr>
						@endforeach

						{{-- Items Taxes --}}
						@foreach ($cart->itemsConditionsTotal('tax') as $name => $value)
						<tr>
							<td colspan="4">
								<span class="pull-right">{{{ $name }}}</span>
							</td>
							<td>{{{ $value }}}</td>
						</tr>
						@endforeach

						{{-- Items Shipping --}}
						@foreach ($cart->itemsConditionsTotal('shipping') as $name => $value)
						<tr>
							<td colspan="4">
								<span class="pull-right">{{{ $name }}}</span>
							</td>
							<td>{{{ $value }}}</td>
						</tr>
						@endforeach

						{{-- Cart Discounts --}}
						@foreach ($cart->conditionsTotal('discount', false) as $name => $value)
						<tr>
							<td colspan="4">
								<span class="pull-right">{{{ $name }}}</span>
							</td>
							<td>{{{ $value }}}</td>
						</tr>
						@endforeach

						{{-- Cart Taxes --}}
						@foreach ($cart->conditionsTotal('tax', false) as $name => $value)
						<tr>
							<td colspan="4">
								<span class="pull-right">{{{ $name }}}</span>
							</td>
							<td>{{{ $value }}}</td>
						</tr>
						@endforeach

						{{-- Cart Coupons --}}
						@foreach ($cart->conditions('coupon') as $condition)
						<tr class="success">
							<td colspan="4">
								<a href="{{ URL::to('coupon/remove', $condition->get('name')) }}" class="pull-left label label-danger"><i class="fa fa-trash-o"></i></a>
								<span class="pull-right">{{{ $condition->get('name') }}} ({{{ $condition->get('code') }}})</span>
							</td>
							<td>{{{ $condition->result() }}}</td>
						</tr>
						@endforeach

						{{-- Cart Shipping --}}
						@foreach ($cart->conditionsTotal('shipping', false) as $name => $value)
						<tr>
							<td colspan="4">
								<span class="pull-right">{{{ $name }}}</span>
							</td>
							<td>{{{ $value }}}</td>
						</tr>
						@endforeach

						<tr>
							<td colspan="4">
								<span class="pull-right">Cart Weight</span>
							</td>
							<td>{{{ Converter::value($cart->weight())->from('weight.g')->to('weight.kg')->format() }}}</td>
						</tr>

						<tr>
							<td colspan="4">
								<span class="pull-right">Total Usd</span>
							</td>
							<td>{{{ $total }}}</td>
						</tr>
						<tr>
							<td colspan="4">
								<span class="pull-right">Total Eur</span>
							</td>
							<td>{{{ Converter::value($total)->from('currency.usd')->to('currency.eur')->convert()->format() }}}</td>
						</tr>
						@endif
					</tbody>
				</table>

				@if ( ! $items->isEmpty())
				<button type="submit" class="btn btn-info">Update</button>
				<a href="{{ URL::to('cart/destroy') }}" class="btn btn-danger">Empty Cart</a>
				<div class="pull-right">
					<a href="#" class="btn btn-warning">Checkout</a>
				</div>
				@endif

			</form>


			{{-- Apply a Coupon --}}
			@if ( ! $items->isEmpty() && ! $coupon)

			{{-- Form::open(array('route' => 'applyCoupon')) --}}

			<div class="row">

				<div class="col-md-4">

					<div class="form-group">
						<label for="coupon" class="control-label">Apply Coupon<i class="fa fa-info-circle"></i></label>

						<input type="text" class="form-control" name="coupon" id="coupon" placeholder="Coupon Code" value="" required>

						<span class="help-block">Valid Codes: PROMO14, DISC2014</span>
					</div>

				</div>

			</div>

			<div class="form-group">
				<button class="btn">Apply Coupon</button>
			</div>

			{{-- Form::close() --}}

		</div>

		@endif

	</div>

</div>

@stop
