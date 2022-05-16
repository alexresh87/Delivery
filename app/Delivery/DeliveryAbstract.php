<?php

namespace App\Delivery;

abstract class DeliveryAbstract implements DeliveryInterface
{
    private $source;
    private $target;
    private $weight;

    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function calculate()
    {
        return true;
    }

    public function exec()
    {
        return true;
    }
}
