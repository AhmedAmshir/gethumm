<?php

namespace App\Managers;

use App\Ingredient;
use App\Recipe;
use App\Box;

class HummManager {
    
    public function createIngredient($inputs = [])
    {
        $inputs['created_at'] = date('Y-m-d H:i:s');
        $created = Ingredient::create($inputs);
        if($created->id) {
            return [
                'name' => $created->name,
                'supplier' => $created->supplier,
                'measure' => $created->measure,
            ];
        }
        return false;
    }

    public function getAllIngredients($inputs = []) {
        
        $ingredients = Ingredient::select('name', 'supplier', 'measure', 'created_at');
        if(array_key_exists('after_id', $inputs)) $ingredients->where('id', '>', $inputs['after_id']);
        if(array_key_exists('before_id', $inputs)) $ingredients->where('id', '<', $inputs['before_id']);

        return $ingredients->get()->toArray();
    }

    public function createRecipe($inputs = []) {
        
        $inputs['created_at'] = date('Y-m-d H:i:s');
        $created = Recipe::create($inputs);
        if($created->id) {
            return [
                'id' => $created->id,
                'name' => $created->name,
                'description' => $created->description
            ];
        }
        return false;
    }

    public function createRecipeIngredients($inputs, $recipe_id) {
        $recipe = Recipe::find($recipe_id);
        foreach ($inputs['ingredients'] as $item) {
            $recipe->ingredients()->attach($item['id'], ['amount' => $item['amount']]);
        }
        
        $recipe_info = [];
        $recipe_info = $this->prepareRecipe($recipe_info, $recipe);
        return $this->prepareRecipeIngredients($recipe->ingredients, $recipe_info);
    }

    public function getAllRecipes($inputs = []) {

        $recipes = Recipe::with('ingredients');
        if(array_key_exists('after_id', $inputs)) $recipes->where('recipes.id', '>', $inputs['after_id']);
        if(array_key_exists('before_id', $inputs)) $recipes->where('recipes.id', '<', $inputs['before_id']);
        $recipes = $recipes->get();

        $recipe_info = [];
        $all_recipes_info = [];
        foreach ($recipes as $recipe) {

            $recipe_info = $this->prepareRecipe($recipe_info, $recipe);
            $recipe_info = $this->prepareRecipeIngredients($recipe->ingredients, $recipe_info);
            array_push($all_recipes_info, $recipe_info);
        }

        return $all_recipes_info;
    }

    private function prepareRecipeIngredients($ingredients, $recipe_info) {
        foreach ($ingredients as $value) {
            $ingredient['name'] = $value->name;
            $ingredient['measure'] = $value->measure;
            $ingredient['supplier'] = $value->supplier;
            array_push($recipe_info['ingredient'], $ingredient);
        }
        return $recipe_info;
    }

    public function prepareRecipe($recipe_info, $recipe) {
        $recipe_info['recipe_name'] = $recipe->name;
        $recipe_info['recipe_description'] = $recipe->description;
        $recipe_info['ingredient'] = [];
        return $recipe_info;
    }

    public function createUserBox($inputs = []) {
        $inputs['created_at'] = date('Y-m-d H:i:s');
        $created = Box::create($inputs);
        if($created->id) {
            return [
                'id' => $created->id,
                'fullname' => $created->fullname,
                'address' => $created->address,
                'delivery_date' => $created->delivery_date
            ];
        }
        return false;
    }

    public function createBoxRecipes($inputs, $box_id) {

        $box = Box::find($box_id);
        $box->recipes()->attach(explode(',', $inputs['recipes']));
        
        $box_content = [];
        $box_content = $this->prepareUserBoxInfo($box_content, $box);
        return $this->prepareBoxRecipes($box->recipes, $box_content);
    }

    public function prepareUserBoxInfo($box_content, $user_box) {
        $box_content['fullname'] = $user_box->fullname;
        $box_content['address'] = $user_box->address;
        $box_content['mobile'] = $user_box->mobile;
        $box_content['delivery_date'] = $user_box->delivery_date;
        $box_content['recipes'] = [];
        return $box_content;
    }

    private function prepareBoxRecipes($recipes, $box_content) {
        foreach ($recipes as $value) {
            $recipe['name'] = $value->name;
            $recipe['description'] = $value->description;
            array_push($box_content['recipes'], $recipe);
        }
        return $box_content;
    }

    public function getRequirdIngredient($inputs = [])
    {
        $order_data = date('Y-m-d', strtotime($inputs['order_date']));
        $last_order_date = date('Y-m-d', strtotime($order_data . " +7 days"));
        if(is_array($inputs) && !empty($inputs)) {
            
            $boxes = Box::where([['delivery_date', '>', $order_data], ['delivery_date', '<', $last_order_date]])->get();
            
            $ingredients = [];
            foreach ($boxes as $box) {
                foreach ($box->recipes as $recipe) {
                    foreach ($recipe->ingredients as $ingredient) {
                        if(!array_key_exists($ingredient->name, $ingredients)) {
                            $ingredients[$ingredient->name] = [
                                'amount' => $ingredient->pivot->amount,
                                'measure' => $ingredient->measure
                            ];
                        } else {
                            $ingredients[$ingredient->name]['amount'] += $ingredient->pivot->amount;
                        }
                    }
                }
            }
            return $ingredients;
        }
        return false;
    }
}
