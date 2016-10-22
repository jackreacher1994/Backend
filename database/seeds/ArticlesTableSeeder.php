<?php

use Illuminate\Database\Seeder;
use Modules\Article\Entities\Article;

class ArticlesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();
        for($i = 0; $i < 20; $i++) {
            $article = new Article();
            $article->title = $faker->sentence(mt_rand(3, 10));
            $article->content = join("\n\n", $faker->paragraphs(mt_rand(3, 6)));
    		$article->save();
        }
    }
}
