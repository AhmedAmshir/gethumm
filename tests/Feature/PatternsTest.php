<?php

namespace Tests\Feature;

use App\Patterns\FactoryMethod\Factory\BMWFactory;
use App\Patterns\FactoryMethod\Factory\MercidesFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class PatternsTest extends TestCase
{

    public function testFactoryMethodPattern() {
        $bmw = new BMWFactory();
        $this->assertEquals('version 2020', $bmw->createCar()->model());
        $this->assertStringContainsString('BMW Car', $bmw->carInfo());

        $mercedes = new MercidesFactory();
        $this->assertEquals('version 2019', $mercedes->createCar()->model());
    }

}
