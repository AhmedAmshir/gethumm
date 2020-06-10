<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 6/2/20
 * Time: 11:46 PM
 */

namespace App\Patterns\FactoryMethod\Cars;

interface Car
{
    public function name(): string;
    public function model(): string;
}
