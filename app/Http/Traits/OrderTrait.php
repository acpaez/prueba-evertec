<?php

namespace App\Http\Traits;

use App\Models\Order;

trait OrderTrait {

    /**
     * @method getOrder
     * method in charge of bringing the order by id
     * @return colelction order
     */
    public function getOrder($id) {
        return Order::find($id);
    }

}