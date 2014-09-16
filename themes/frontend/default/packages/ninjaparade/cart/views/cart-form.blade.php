{{ Form::open(array('url' => URL::route('cart.cart_update'), 'method' => 'post', 'class'=>'form-inline', 'id' => 'cart-form'))}}
    <table class="table">
            <thead>
                        <tr>
                          <th width="10%">Item</th>
                          <th width="30%"></th>
                          <th width="30%">Quantity</th>
                          <th width="22%">Price</th>
                          <th width="8%">Remove</th>
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
                    			    <?php $image_id = $item->get('product')->image; ?>
                                    <img src="@media($image_id)" alt="{{$item->get('product')->name}}" class="thumbnail image-small">
                        		</td>
                        		<td>{{{ $item->get('name') }}}<br/>{{{ $item->get('product')->description }}}</td>
                        		<td>
                        		<input class="form-control qty" type="text" name="update[{{{ $item->get('rowId') }}}][quantity]" value="{{{ $item->get('quantity') }}}" />
                        		</td>

                        		<td>{{{ Converter::value(  $item->get('product')->price )->to('currency.usd')->format() }}}</td>
                        		<td> <button class="btn btn-xs btn-danger remove-item" data-row-id="{{{ $item->get('rowId') }}}"><i class="fa fa-times"></i></button></td>
                     	</tr>
		                @endforeach

		<tr>
			<td colspan="3">
				<button type="submit" class="btn btn-default" id="update-cart">Update</button>
			</td>
			<td class="right">
				{{--Total {{{ Converter::value( $total )->to('currency.usd')->format() }}} --}}
			</td>
		</tr>
	@endif


  </tbody>
</table>


<div class="clearfix">
	<a class="btn btn-primary" href="{{URL::route('store.index')}}" title="Back To Store">Back To Store</a>

	<a class="btn btn-success pull-right" href="{{URL::route('checkout.index')}}" title="Checkout">Checkout</a>

</div>
{{Form::close()}}