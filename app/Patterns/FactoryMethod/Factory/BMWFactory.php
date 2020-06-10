<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 6/2/20
 * Time: 11:42 PM
 */
namespace App\Patterns\FactoryMethod\Factory;

use App\Patterns\FactoryMethod\Cars\BMWCar;
use App\Patterns\FactoryMethod\Cars\Car;

class BMWFactory extends FactoryCar
{
    public function createCar(): Car {
        return new BMWCar();
    }
}
