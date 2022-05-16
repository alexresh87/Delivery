<?php

namespace App\Delivery;

class FastDelivery extends DeliveryAbstract
{

    /**
     * calculate
     *
     * @return void
     */
    public function calculate()
    {
        //Получаем данные от сервера ТК
        $data = $this->exec();

        $current_hour = date("H");

        if ($data['status'] == "error") {
            return $data;
        }

        //Если сейчас уже больше 18 часов, то срок доставки увеличиваем на 1 день
        if ($current_hour > 18) {
            $data['period']++;
        }

        //Формируем результирующий массив
        $ret_data = [
            'status' => "success",
            'price' => $data['price'],
            'date' => date('Y-m-d', strtotime("+" . $data['period'] . " days", time()))
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
            'price' => rand(100, 1000),
            'period' => rand(1, 10)
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
            'price' => $response['price'],
            'period' => $response['period']
        ];
    }
}
