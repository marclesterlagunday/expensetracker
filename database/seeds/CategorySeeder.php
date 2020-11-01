<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();
        
        Category::create([
                'category_name' => 'Food',
                'category_description' => 'breakfast, lunch and dinner'
        ]);

        Category::create([
            'category_name' => 'Transportation',
            'category_description' => 'breakfast, lunch and dinner'
        ]);

        Category::create([
            'category_name' => 'Household',
            'category_description' => 'water and electric bill'
        ]);

        Category::create([
            'category_name' => 'Communication',
            'category_description' => 'cellular network and internet'
        ]);
    }
}
