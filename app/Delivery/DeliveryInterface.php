<?php

namespace App\Delivery;

interface DeliveryInterface
{
    public function calculate($orders);
    public function exec($orders);
}
