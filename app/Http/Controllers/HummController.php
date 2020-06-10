<?php

namespace App\Http\Controllers;

use App\Patterns\FactoryMethod\Factory\BMWFactory;
use App\Patterns\FactoryMethod\Factory\MercidesFactory;
use Illuminate\Http\Request;
use App\Handlers\RequestHandler;
use App\Handlers\ResponseHandler;
use App\Http\Requests\CreateIngredientRequest;
use App\Http\Requests\CreateRecipeRequest;
use App\Http\Requests\CreateBoxOrderRequest;
use Elasticsearch\ClientBuilder;

class HummController extends Controller {

    use RequestHandler, ResponseHandler;

    public function createIngredient(CreateIngredientRequest $request) : object {
        $_request = $this->extractRequestData($request);
        $data = App('HummManager')->createIngredient($_request);
        if(is_array($data)) {
            $this->AddParameter($data);
            return $this->OK('Data created successfully.');
        }
        $this->NotFound('Something wrong.');
    }

    public function listIngredients(Request $request) : object {
        $_request = $this->extractRequestData($request);
        $data = App('HummManager')->getAllIngredients($_request);
        if(is_array($data) && !empty($data)) {
//            if($request->hasHeader('x-api-key')) {
                $this->AddParameter($data);
                return $this->OK('Get data successfully.');
//            }
//            return view('humm.ingredients', ['ingredients' => $data]);
        }
        return $this->OK('There are no content for now.');
    }

    public function createRecipe(CreateRecipeRequest $request) : object {

        $_request = $this->extractRequestData($request);
        $recipe_data = App('HummManager')->createRecipe($_request);
        if(array_key_exists('id', $recipe_data)) {
            $data = App('HummManager')->createRecipeIngredients($_request, $recipe_data['id']);
            $this->AddParameter($data);
            return $this->OK('Data created successfully.');
        }
        $this->NotFound('Something wrong.');
    }

    public function listRecipes(Request $request) : object {
        $_request = $this->extractRequestData($request);
        $data = App('HummManager')->getAllRecipes($_request);
        if(is_array($data) && !empty($data)) {
            $this->AddParameter($data);
            return $this->OK('Get data successfully.');
        }
        return $this->OK('There are no content for now.');
    }

    public function createUserBoxOrder(CreateBoxOrderRequest $request) : object {
        $_request = $this->extractRequestData($request);
        if(count(explode(',', $_request['recipes'])) > 4) {
            return $this->BadRequest('Sorry, maximun 4 recipes');
        }

        $box_data = App('HummManager')->createUserBox($_request);
        if(array_key_exists('id', $box_data)) {
            $data = App('HummManager')->createBoxRecipes($_request, $box_data['id']);
            $this->AddParameter($data);
            return $this->OK('Data created successfully.');
        }
    }

    public function ingredientsRequiredToBeOrdered(Request $request) {
        
        $_request = $this->extractRequestData($request);
        if(!array_key_exists('order_date', $_request)) {
            return $this->BadRequest('Order date is required.');
        }

        $data = App('HummManager')->getRequirdIngredient($_request);
        if(is_array($data) && empty($data)) {
            return $this->NotFound('Something wrong.');
        }
        if(is_array($data) && !empty($data)) {
            $this->AddParameter($data);
            return $this->OK('Get data successfully.');
        }
        return $this->OK('There are no content for now.');
    }

    public function testElasticsearch($age, $name) {

        $bmw = new BMWFactory();
        $mercides = new MercidesFactory();
        var_dump($bmw->carInfo());
        var_dump($mercides->carInfo());die;

        $param['index'] = "test-elastic-index";
        $param['type'] = "test-elastic-type";
        $param['body'] = [
            'name' => $name,
            'age' => $age
        ];
        $client = ClientBuilder::create()
            ->setHosts(['elasticsearch'])->build();
        $results = $client->index($param);
        dd($results);
    }

    public function getElasticsearch($age) {
        $param['index'] = "test-elastic-index";
        $param['type'] = "test-elastic-type";
        $param['body']['query']['match']['age'] = $age;
        
        $client = ClientBuilder::create()
            ->setHosts(['elasticsearch'])->build();
        $results = $client->search($param);
        dd($results);
    }
}
