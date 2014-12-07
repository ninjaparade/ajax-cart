<?php  namespace Ninjaparade\Cart\Handlers;

use Cartalyst\Conditions\Condition;
use  Ninjaparade\Platformcheckout\Repositories\Promocode\PromocodeRepositoryInterface;

class PromocodeHandler {

    //PromocodeRepositoryInterface
    protected $promocode;

    protected $cart;

    protected $dispatcher;


    function __construct(PromocodeRepositoryInterface $promocode )
    {
        $this->cart = app('cart');

        $this->dispatcher = app('events');

        $this->promocode = $promocode;
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

    public function usedPromocode($discount, $value)
    {
        $promocode = $this->promocode->find($discount->get('id'));

        $promocode->increment('redeem_amount');

        $promocode->increment('redeem_value', abs($value) );

        $promocode->save();

        return true;
    }

    protected function amountOff($promocode)
    {
        $this->cart->removeConditionByType('discount');
        
        $condition = new Condition(array(
            'name'           => 'Discount ($' .$promocode->value. ') OFF', 
            'type'           => 'discount',
            'target'         => 'subtotal',
            'id'             => $promocode->id,
            'promocode_type' => $promocode->type
        ));
  
        $condition->setActions([
            [
                'value' => -number_format($promocode->value , 2)
            ]
        ]);

  
        $this->cart->condition([ $condition ]);

        $this->setCartOrder();
    }


    protected function percentOff($promocode)
    {
        $this->cart->removeConditionByType('discount');
        
        $condition = new Condition(array(
            'name'           => 'Discount (' .$promocode->value. '%) OFF' ,
            'type'           => 'discount',
            'target'         => 'subtotal',
            'id'             => $promocode->id,
            'promocode_type' => $promocode->type
        ));

        if($promocode->max_value > 0)
        {
            $value = -number_format( $promocode->value , 2);
            
            $condition->setActions([
                [
                    'value' => "{$value}%",
                    'max'   => -intval($promocode->max_value)
                ]
            ]);

        }else{
            $value = -number_format( $promocode->value , 2);
            $condition->setActions([
                [
                    'value' => "{$value}%"
                ]
            ]);
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

        $events->listen('valide.promocode.used', 'Ninjaparade\Cart\Handlers\PromocodeHandler@usedPromocode');
    }
}

