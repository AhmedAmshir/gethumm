<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 6/2/20
 * Time: 11:46 PM
 */

namespace App\Patterns\FactoryMethod\Cars;

class BMWCar implements Car
{
    public function name(): string {
        return 'Woooooww, BMW Car';
    }

    public function model(): string {
        return 'version 2020';
    }
}
