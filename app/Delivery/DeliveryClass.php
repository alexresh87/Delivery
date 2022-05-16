<?php

namespace App\Delivery;

class DeliveryClass extends DeliveryAbstract
{
    private $deliverys;
    private $deliveryName;

    public function __construct()
    {
        $this->deliverys = [];
        $this->deliveryName = "";
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
        return ($this->deliverys[$this->deliveryName])->calculate();
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
            $ret[$deliveryName] = $delivery->calculate();
        }

        return $ret;
    }
}
