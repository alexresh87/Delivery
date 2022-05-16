<?php

namespace App\Delivery;

abstract class DeliveryAbstract implements DeliveryInterface
{
    public function calculate($orders)
    {
        return true;
    }

    public function exec($orders)
    {
        return true;
    }
}
