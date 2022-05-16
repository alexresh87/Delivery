<?php

use App\Delivery\DeliveryClass;
use App\Delivery\FastDelivery;
use App\Delivery\SlowDelivery;

spl_autoload_register();

$deliveryClass = new DeliveryClass;

$deliveryClass
    ->addDelivery(new FastDelivery, "FastDelivery")
    ->addDelivery(new SlowDelivery, "SlowDelivery");

echo "Рассчет доставки для 1 компании" . PHP_EOL;
$res = $deliveryClass
    ->setSource("source1")
    ->setTarget("target1")
    ->setWeight(12.0)
    ->setDelivery("SlowDelivery")
    ->calculate();

print_r($res);

echo "Рассчет доставки для всех компаний" . PHP_EOL;
$res = $deliveryClass
    ->setSource("source2")
    ->setTarget("target3")
    ->setWeight(12.0)
    ->calculateAll();

print_r($res);
