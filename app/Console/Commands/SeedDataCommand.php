<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ingredient;
use App\Recipe;
use App\Box;
use Illuminate\Support\Facades\DB;

class SeedDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding fake humm data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        DB::disableQueryLog();
        
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->seedIngredients();
        $this->seedRecipes();
        $this->seedRecipeIngredients();
        $this->seedBoxes();
        $this->seedBoxRecipes();
    }

    public function __destruct()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function foreignKeyChecks() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }

    private function seedIngredients() {

        $this->info('Creating Ingredients');
        $this->foreignKeyChecks();
        
        Ingredient::truncate();
        $ingredient = factory(Ingredient::class, 20)->create();
    }

    private function seedRecipes($target = 1000)
    {
        $this->info('Creating Recipes');
        $this->output->progressStart($target);
        $this->foreignKeyChecks();
        Recipe::truncate();

        $recipes = factory(Recipe::class, 100)->create();

        $this->output->progressFinish();
    }

    private function seedRecipeIngredients()
    {
        $recipesCount = Recipe::count();
        DB::statement('Truncate ingredient_recipe');
        $this->info('linking Recipe with ingredients');
        $this->output->progressStart($recipesCount);
        Recipe::chunk(
            1000,
            function ($recipes) {
                $links = [];
                $ids = Ingredient::query()->limit(50)->get()->random(3)->pluck('id')->toArray();
                $recipes->each(
                    function ($recipe) use ($ids, &$links) {
                        foreach ($ids as $id) {
                            $links[] = [
                                'recipe_id' => $recipe->id,
                                'ingredient_id' => $id,
                                'amount' => rand(1, 100),
                            ];
                        }
                    }
                );
                DB::table('ingredient_recipe')->insert($links);
                $this->output->progressAdvance(1000);
            }
        );
        $this->output->progressFinish();
    }

    private function seedBoxes()
    {
        $this->info('Creating User Box Order');
        $this->foreignKeyChecks();
        Box::truncate();
        $boxes = factory(Box::class, 25)->create();
    }

    private function seedBoxRecipes()
    {
        $boxesCount = Box::count();
        DB::statement('Truncate box_recipe');
        $this->info('linking Box with Recipes');
        $this->output->progressStart($boxesCount);
        Box::chunk(
            1000,
            function ($boxes) {
                $links = [];
                $ids = Recipe::query()->limit(50)->get()->random(3)->pluck('id')->toArray();
                $boxes->each(
                    function ($box) use ($ids, &$links) {
                        foreach ($ids as $id) {
                            $links[] = [
                                'box_id' => $box->id,
                                'recipe_id' => $id,
                            ];
                        }
                    }
                );
                DB::table('box_recipe')->insert($links);
                $this->output->progressAdvance(1000);
            }
        );
        $this->output->progressFinish();
    }

}
