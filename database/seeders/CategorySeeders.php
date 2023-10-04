<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\BudgetTracker\Models\Category;
use App\BudgetTracker\Models\SubCategory;

class CategorySeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = env("LANG","it");
        $path = __DIR__.'/../sql/categories.json';
        $data = (array) json_decode(file_get_contents($path));
        foreach ($data[$lang] as $key => $cat) {

          $db = new Category();
          $db->uuid = $cat->category->uuid;
          $db->name = strtolower($cat->category->label);
          $db->icon = $cat->category->icon;
          $db->save();
          foreach ($cat->subCateogy as $key => $value) {

            $dbSubCat = new SubCategory();
            $dbSubCat->uuid = $value->uuid;
            $dbSubCat->name = $value->name;
            $dbSubCat->category_id = $db->id;
            $dbSubCat->type = $db->type;
            $dbSubCat->save();
          }

        }
    }
}
