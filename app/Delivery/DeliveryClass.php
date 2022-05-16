<?php

namespace App\Delivery;

class DeliveryClass
{
    private $deliverys;
    private $deliveryName;
    private $orders;

    public function __construct()
    {
        $this->deliverys = [];
        $this->deliveryName = "";
        $this->orders = [];
    }

    public function setOrders($orders)
    {
        $this->orders = $orders;
        return $this;
    }

    /**
     * addDelivery
     *
     * @param  mixed $delivery
     * @param  mixed $deliveryName
     * @return DeliveryClass
     */
    public function addDelivery(DeliveryAbstract $delivery, string $deliveryName): DeliveryClass
    {
        $this->deliverys[$deliveryName] = $delivery;
        return $this;
    }

    /**
     * setDelivery
     *
     * @param  mixed $deliveryName
     * @return DeliveryClass
     */
    public function setDelivery(string $deliveryName): DeliveryClass
    {
        $this->deliveryName = $deliveryName;
        return $this;
    }

    /**
     * calculace
     *
     * @return array
     */
    public function calculate(): array
    {
        if (!isset($this->deliverys[$this->deliveryName])) {
            //Вызываем ошибку
            return ["error" => "NONE"];
        }
        return [
            $this->deliveryName => $this->deliverys[$this->deliveryName]->calculate($this->orders)
        ];
    }

    /**
     * calculateAll
     *
     * @return array
     */
    public function calculateAll(): array
    {
        $ret = [];
        foreach ($this->deliverys as $deliveryName => $delivery) {
            $ret[$deliveryName] = $delivery->calculate($this->orders);
        }

        return $ret;
    }
}
