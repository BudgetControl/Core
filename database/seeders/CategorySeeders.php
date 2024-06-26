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
        $lang = "it"; //env("LANG","it");
        $path = __DIR__.'/../sql/categories.json';
        $data = (array) json_decode(file_get_contents($path));
        foreach ($data[$lang] as $key => $cat) {

          $db = new Category();
          $db->uuid = $cat->category->uuid;
          $db->name = strtolower($cat->category->label);
          $db->slug = strtolower(str_replace(" ", "_", $cat->category->label));
          $db->icon = $cat->category->icon;
          $db->type = $cat->category->type;
          $db->save();
          foreach ($cat->subCateogy as $key => $value) {

            $dbSubCat = new SubCategory();
            $dbSubCat->uuid = $value->uuid;
            $dbSubCat->name = $value->name;
            $dbSubCat->name = strtolower(str_replace(" ", "_", $value->name));
            $dbSubCat->category_id = $db->id;
            $dbSubCat->exclude_from_stats = (empty($value->exclude_from_stats)) ? 0 : $value->exclude_from_stats;
            $dbSubCat->save();
          }

        }
    }
}
