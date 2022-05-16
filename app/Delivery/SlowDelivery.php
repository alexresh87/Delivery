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
    public function calculate($orders)
    {
        //Получаем данные от сервера ТК
        $data = $this->exec($orders);
        $ret_data = [];

        foreach ($data as $k => $item) {

            //Если по одной из перевозок была ошибка
            if ($item['status'] == "error") {
                $ret_data[$k] = $item;
                $ret_data[$k] += $orders[$k];
                continue;
            }

            $ret_data[$k] = [
                'status' => "success",
                'price' => ($this->base_cost * $data[$k]['coefficient']),
                'date' => $data[$k]['date']
            ];
            $ret_data[$k] += $orders[$k];
        }

        return $ret_data;
    }

    /**
     * exec
     *
     * @param  mixed $orders
     * @return array
     */
    public function exec($orders): array
    {
        //Отправляем данные на сервер ТК и получаем ответ
        //Эмуляция ответа, задаем произвольные данные
        foreach ($orders as $key => $item) {
            //Эмулируем ошибку
            if (rand(1, 4) == 3) {
                $response[$key] = [
                    'status' => "error",
                    'error_msg' => "не найден город отправителя",
                ];
            } else {
                $response[$key] = [
                    'status' => "success",
                    'coefficient' => rand(1, 10),
                    'date' => date('Y-m-d', strtotime("+" . rand(1, 10) . " days", time()))
                ];
            }
        }

        return $response;
    }
}
