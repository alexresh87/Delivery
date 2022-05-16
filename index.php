<?php

use App\Delivery\DeliveryClass;
use App\Delivery\FastDelivery;
use App\Delivery\SlowDelivery;

spl_autoload_register();

function print_result($result){
    foreach ($result as $name => $delivery) {
        print "Транспортная компания $name:" . PHP_EOL. PHP_EOL;
        foreach ($delivery as $i => $item) {
            if ($item['status'] == "success") {
                printf(
                    "%d) Перевозка из %s в %s общим весом %.01fкг будет стоить %.02fруб. и будет доставлена %s" . PHP_EOL,
                    $i,
                    $item['sourceKladr'],
                    $item['targetKladr'],
                    $item['weight'],
                    $item['price'],
                    $item['date'],
                );
            }
            if ($item['status'] == "error") {
                printf("%d) Ошибка с перевозкой из %s в %s: %s" . PHP_EOL, $i, $item['sourceKladr'], $item['targetKladr'], $item['error_msg']);
            }
        }
        print PHP_EOL. PHP_EOL;
    }
}

$deliveryClass = new DeliveryClass;

$deliveryClass
    ->addDelivery(new FastDelivery, "FastDelivery")
    ->addDelivery(new SlowDelivery, "SlowDelivery");

$orders_one = [
    [
        'sourceKladr' => "source_one_1",
        'targetKladr' => "target_one_1",
        'weight' => 2.6
    ]
];
$orders_many = [
    [
        'sourceKladr' => "source1",
        'targetKladr' => "target1",
        'weight' => 12.5
    ],
    [
        'sourceKladr' => "source2",
        'targetKladr' => "target2",
        'weight' => 43.3
    ]
];

print "Рассчет доставки для 1 компании" . PHP_EOL. PHP_EOL;
$result = $deliveryClass
    ->setOrders($orders_one)
    ->setDelivery("SlowDelivery")
    ->calculate();

print_result($result);

print "Рассчет доставки для всех компаний" . PHP_EOL. PHP_EOL;
$result = $deliveryClass
    ->setOrders($orders_many)
    ->calculateAll();

print_result($result);