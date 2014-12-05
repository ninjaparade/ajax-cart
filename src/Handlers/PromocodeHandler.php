<?php  namespace Ninjaparade\Cart\Handlers;

use Cartalyst\Conditions\Condition;

class PromocodeHandler {

    protected $cart;

    function __construct()
    {
        $this->cart = app('cart');
    }


    public function appplyPromocode($promocode)
    {

        switch ($promocode->type) {
            case 'amount_off':
                $this->amountOff($promocode);
            break;
            
            case 'percent_off':
                $this->percentOff($promocode);
                break;
        }
    }

    protected function amountOff($promocode)
    {
        $this->cart->removeConditionByName('discount');

        $condition = new Condition(array(
            'name'           => 'Discount ($' .$promocode->value. ') OFF', 
            'type'           => 'discount',
            'target'         => 'subtotal',
            'id'             => $promocode->id,
            'promocode_type' => $promocode->type
        ));

        $condition->setActions([
            [ 'value' => -number_format($promocode->value , 2)]
        ]);


        $this->cart->condition([ $condition ]);

        $this->setCartOrder();
    }


    protected function percentOff($promocode)
    {
        $this->cart->removeConditionByName('discount');

        $condition = new Condition(array(
            'name'           => 'Discount (' .$promocode->value. '%) OFF' ,
            'type'           => 'discount',
            'target'         => 'subtotal',
            'id'             => $promocode->id,
            'promocode_type' => $promocode->type
        ));

        $condition->setActions([
            [ 'value' => -number_format( $promocode->value , 2). '%'  ]
        ]);
    
        if($promocode->max_value > 0)
        {
            $condition['max'] = -intval($promocode->max_value);
        }
    
        $this->cart->condition([ $condition ]);

        $this->setCartOrder();
    }

    public function setCartOrder()
    {
        $this->cart->setItemsConditionsOrder(
            [
                'discount',
                'referal',
                'tax',
                'shipping',
            ]
        );
    }


    public function subscribe($events)
    {
        $events->listen('valide.promocode.apply', 'Ninjaparade\Cart\Handlers\PromocodeHandler@appplyPromocode');
    }
}

