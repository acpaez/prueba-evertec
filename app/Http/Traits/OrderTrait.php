<?php

namespace App\Http\Traits;

use App\Models\Order;

trait OrderTrait {

    public function getOrder($id) {
        return Order::find($id);
    }

}