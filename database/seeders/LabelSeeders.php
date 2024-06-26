<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\BudgetTracker\Models\Labels;

class LabelSeeders extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $lang = "it"; //env("LANG","it");
      $path = __DIR__.'/../sql/label.json';
      $data = (array) json_decode(file_get_contents($path));

      foreach ($data[$lang] as $key => $value) {
        $db = new Labels();
        $db->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        $db->name = strtolower($value);
        $db->color = 'colors';
        $db->workspace_id = 1;
        $db->save();
      }
    }
}
