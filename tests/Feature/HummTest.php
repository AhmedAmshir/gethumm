<?php

namespace Tests\Feature;

use App\Managers\HummManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use App\Ingredient;

class HummTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('data:seed');


    }

    public function tearDown(): void
    {
        $config = app('config');
        parent::tearDown();
        app()->instance('config', $config);
        Artisan::call('migrate:status');
    }

    public function testGetAllIngredients()
    {
        $response = $this->withHeaders(['x-api-key'=>'Jw8tk5OBtP'])->json('GET', 'ingredients');
        $response->assertJsonStructure(['status_code', 'Message', 'data']);
        $response->assertStatus(200);
    }

    public function testGetAllIngredientsWithoutApiKey()
    {
        $response = $this->json('GET', 'ingredients');
        $response->assertStatus(401);
    }

    public function testCreateIngredient() {
        $response = $this->withHeaders(['x-api-key'=>'Jw8tk5OBtP'])->json('POST', 'create-ingredient', [
            'name' => 'tomato',
            'supplier' => 'baladi',
            'measure' => 'g',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $response->assertStatus(200);
        $this->assertEquals(200, $response->status());
    }

    public function testCreateIngredientSuccess() {

        $input = [
            'name' => 'rice',
            'supplier' => 'do7a',
            'measure' => 'kg'
        ];
        $h = (new HummManager())->createIngredient($input);
        $this->assertNotNull($h['name']);
        $this->assertEquals('kg', $h['measure']);
    }

}
