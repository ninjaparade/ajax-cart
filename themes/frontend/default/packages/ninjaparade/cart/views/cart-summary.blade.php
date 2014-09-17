
<h4>SUMMARY</h4>
<ul class="summary">
  <li><span class="left">Sub-Total</span> <span class="right">{{{ Converter::value( $cart->subtotal() )->to('currency.usd')->format() }}}</span></li>
  @if( $cart->conditionsTotal('tax', false) )
    <li><span class="left">Tax</span> <span class="right">{{{ Converter::value( $cart->conditionsTotalSum('tax') )->to('currency.usd')->format() }}}</span></li>
  @endif

  @if( $cart->conditionsTotal('discount', false) )
    <li><span class="left">Discount</span> <span class="right">{{{ Converter::value( $cart->conditionsTotalSum('discount') )->to('currency.usd')->format() }}}</span></li>
  @endif

    
    <li class="last"><span class="left">Estimated Total</span> <span class="right">{{{ Converter::value( $cart->total() )->to('currency.usd')->format() }}}</span></li>
</ul>


@if( ! $items->isEmpty())
  <a class="blue btn-block" href="{{URL::route('checkout.index')}}" title="Checkout">Checkout</a>
@endif