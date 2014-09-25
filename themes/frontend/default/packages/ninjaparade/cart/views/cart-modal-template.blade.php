@foreach($items as $item)
<div class="cart-modal-item">
<img src="{{$item->get('image')}}" alt="{{$item->get('product')->name}}" class="img-responsive thumbnail"/>
    <div class="cart-modal-item-description">
        <h2>{{{ $item->get('name') }}}</h2>
        <p>{{{ $item->get('product')->description }}}<br/>
        Quantity: {{{ $item->get('quantity') }}}<br/>
        {{{ Converter::value(  $item->get('product')->price )->to('currency.usd')->format() }}}</p>
    </div>
</div>
@endforeach
 