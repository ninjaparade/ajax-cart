@extends('layouts/default')

@section('content')


<div id="content-wrapper">
    <div id="page-background"></div>
    <div class="inner-page-wrapper">
        <h1>your shopping cart</h1>
        <div class="form-wrapper" id="cart-form-wrapper">
            @include('ninjaparade/cart::cart-form')
        </div>
        <div class="page-sidebar">
            @include('ninjaparade/cart::cart-summary')
        </div>
    </div>
</div>

@stop



@section('scripts')
<script>

    $("#update-cart").hide();

    $( ".qty" ).click(function() {
        $("#update-cart").show();
    });

    var url = "{{URL::route('cart.remove_get')}}";


    $('#cart-form-wrapper').on('click', '.remove-item', function(event){
        event.preventDefault();
        var rowId = $(this).data('row-id');

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {rowId : rowId, _token: "{{csrf_token()}}"}
        })
        .done(function(response) {
            
            $.ajax({
                url: "{{URL::route('cart.get_cart')}}",
                type: 'POST',
                dataType: 'html',
                data: {_token: "{{csrf_token()}}"},
            })
            .done(function(response) {
                $('#cart-form-wrapper').html(response);
            })
            .fail(function() {
                
            })
            .always(function() {
                
            });
        })
        .fail(function() {
            console.log("error");
        })
        .always(function(response) {
            $('.cart-nav').next('span').html(" (" + response.quantity + " ) ");
        });
        
    });
</script>
@stop