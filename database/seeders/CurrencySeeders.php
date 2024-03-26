<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\BudgetTracker\Models\Currency;

class CurrencySeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $lang = "it"; //env("LANG","it");
      $path = __DIR__.'/../sql/currency.json';
      $data = (array) json_decode(file_get_contents($path));

      foreach ($data[$lang] as $key => $value) {
        $db = new Currency();
        $db->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();;
        $db->name = $value->name;
        $db->icon = $value->icon;
        $db->label = $value->label;
        $db->save();
      }
    }
}
