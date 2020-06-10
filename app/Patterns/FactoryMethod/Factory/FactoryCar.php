<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 6/2/20
 * Time: 11:42 PM
 */
namespace App\Patterns\FactoryMethod\Factory;

use App\Patterns\FactoryMethod\Cars\Car;

abstract class FactoryCar
{
    abstract public function createCar(): Car;

    public function carInfo(): string {
        $car = $this->createCar();
        return "============<br>
            Car name: ".$car->name()."<br> Car model: ".$car->model()."<br> ============";
    }
}
