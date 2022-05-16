<?php

namespace App\Delivery;

class SlowDelivery extends DeliveryAbstract
{
    private $base_cost = 150;

    /**
     * calculate
     *
     * @return void
     */
    public function calculate()
    {
        //Получаем данные от сервера ТК
        $data = $this->exec();

        if ($data['status'] == "error") {
            return $data;
        }

        //Формируем результирующий массив
        $ret_data = [
            'status' => "success",
            'price' => ($this->base_cost * $data['coefficient']),
            'date' => $data['date']
        ];

        return $ret_data;
    }

    /**
     * exec
     *
     * @return array
     */
    public function exec(): array
    {
        //Подготавливаем данные для отправки на удаленный сервер
        $data = [
            'sourceKladr' => $this->getSource(),
            'targetKladr' => $this->getTarget(),
            'weight ' => $this->getWeight()
        ];

        //Отправляем данные на сервер ТК и получаем ответ
        $response = [
            'error' => "",
            'coefficient' => rand(1, 10),
            'date' => date('Y-m-d', strtotime("+" . rand(1, 10) . " days", time())),
        ];

        //Если вернулась ошибка
        if ($response['error']) {
            return [
                'status' => "error",
                'error_msg' => $response['error_msg']
            ];
        }

        return [
            'status' => "success",
            'coefficient' => $response['coefficient'],
            'date' => $response['date']
        ];
    }
}
