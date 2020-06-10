<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 6/2/20
 * Time: 11:42 PM
 */

namespace App\Patterns\FactoryMethod\Factory;

use App\Patterns\FactoryMethod\Cars\Car;
use App\Patterns\FactoryMethod\Cars\MercidesCar;

class MercidesFactory extends FactoryCar
{
    public function createCar(): Car {
        return new MercidesCar();
    }
}
