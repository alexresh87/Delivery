<?php

namespace App\Delivery;

interface DeliveryInterface
{
    public function calculate();
    public function exec();

    public function setSource($source);
    public function setTarget($target);
    public function setWeight($weight);

    public function getSource();
    public function getTarget();
    public function getWeight();
}
