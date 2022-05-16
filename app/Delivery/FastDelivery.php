<?php

namespace App\Delivery;

class FastDelivery extends DeliveryAbstract
{

    /**
     * calculate
     *
     * @return void
     */
    public function calculate($orders)
    {
        //Получаем данные от сервера ТК
        $data = $this->exec($orders);

        $current_hour = date("H");
        $ret_data = [];

        foreach($data as $k => $item){

            //Если по одной из перевозок была ошибка
            if($item['status'] == "error"){
                $ret_data[$k] = $item;
                $ret_data[$k] += $orders[$k];
                continue;
            }

            //Если сейчас уже больше 18 часов, то срок доставки увеличиваем на 1 день
            if ($current_hour > 18) {
                $data[$k]['period']++;
            }

            $ret_data[$k] = [
                'status' => "success",
                'price' => $data[$k]['price'],
                'date' => date('Y-m-d', strtotime("+" . $data[$k]['period'] . " days", time()))
            ];
            $ret_data[$k] += $orders[$k];
        }

        return $ret_data;
    }

    /**
     * exec
     *
     * @return array
     */
    public function exec($orders): array
    {
        //Отправляем данные на сервер ТК и получаем ответ
        //Эмуляция ответа, задаем произвольные данные
        foreach($orders as $key => $item){
            //Эмулируем ошибку
            if(rand(1,4) == 3){
                $response[$key] = [
                    'status' => "error",
                    'error_msg' => "не найден город получателя",
                ];
            }else{
                $response[$key] = [
                    'status' => "success",
                    'price' => rand(100, 1000),
                    'period' => rand(1, 10)    
                ];
            }
            
        }

        return $response;
    }
}
