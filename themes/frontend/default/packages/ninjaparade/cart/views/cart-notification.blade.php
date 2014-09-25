
<!-- Modal -->
<div class="modal fade" id="cart-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Your Cart</h4>
      </div>
      <div class="modal-body" id="cart-content">

      </div>
      <div class="modal-footer">
        <div class="cart-modal-footer-buttons">
            <button type="button" class="white-border" data-dismiss="modal">Keep Shopping</button>
            <a href="{{URL::route('checkout.index')}}" class="red">Secure Checkout <i class="fa fa-lock"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>