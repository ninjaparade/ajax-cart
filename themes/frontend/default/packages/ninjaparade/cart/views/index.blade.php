@extends('layouts/default')

@section('content')




{{ Form::open(array('url' => URL::route('cart.cart_update'), 'method' => 'post', 'class'=>'form-inline'))}}
<table>
  <thead>
    <tr>
      <th width="25%">Name</th>
      <th width="25%">Quantity</th>
      <th width="25%">Price</th>
      <th width="25%">Total</th>
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
			<td colspan="3">
				<button type="submit" class="contact-btn">Update</button>
			</td>
			<td class="right">
				Total {{{ Converter::value( $total )->to('currency.usd')->format() }}}
			</td>
		</tr>
	@endif

  
  </tbody>
</table>


<div>
	<a class="button success" href="{{URL::route('store.index')}}" title="Back To Store">Back To Store</a>
	<a class="button " href="{{URL::route('cart.destroy')}}" title="Empty Cart">Empty Cart</a>
	<a class="button success" href="{{URL::route('checkout.index')}}" title="Checkout">Checkout</a>
	
</div>
{{Form::close()}}
@stop
