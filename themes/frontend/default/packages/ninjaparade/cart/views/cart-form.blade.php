{{ Form::open(array('url' => URL::route('cart.cart_update'), 'method' => 'post', 'class'=>'form-inline', 'id' => 'cart-form'))}}
    <table class="table">
            <thead>
              <tr>
                <th class="hidden-xs">Item</th>
                <th class=""></th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Remove</th>
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
              		<td class="hidden-xs">
          			    <?php $image_id = $item->get('product')->image; ?>
                          <img src="@media($image_id)" alt="{{$item->get('product')->name}}" class="thumbnail image-small">
              		</td>
              		  <td><b>{{{ $item->get('name') }}}</b><br/>{{{ $item->get('product')->description }}}</td>
              		<td>
              		<input class="form-control qty" type="text" name="update[{{{ $item->get('rowId') }}}][quantity]" value="{{{ $item->get('quantity') }}}" />
              		</td>

              		<td>{{{ Converter::value(  $item->get('product')->price )->to('currency.usd')->format() }}}</td>
              		<td> <button class="btn btn-xs btn-danger remove-item" data-row-id="{{{ $item->get('rowId') }}}"><i class="fa fa-times"></i></button></td>
               	</tr>
                @endforeach
              <tr>
	         @endif

  </tbody>
</table>
    <td colspan="3">
        <button type="submit" class="btn btn-default" id="update-cart">Update</button>
      </td>
      <td class="right">
        {{--Total {{{ Converter::value( $total )->to('currency.usd')->format() }}} --}}
      </td>
    </tr>

<div class="clearfix">
	<a class="white" href="{{URL::route('store.index')}}" title="Back To Store"><i class="fa fa-arrow-circle-o-left"></i> Continue Shopping</a>
  
</div>
{{Form::close()}}