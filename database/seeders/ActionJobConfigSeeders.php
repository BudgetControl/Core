<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\BudgetTracker\Models\ActionJobConfiguration;

class ActionJobConfigSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $lang = env("LANG","it");
      $path = __DIR__.'/../sql/ActionJobsConfigurations.json';
      $data = (array) json_decode(file_get_contents($path));

      foreach ($data[$lang] as $key => $value) {
        
        foreach($value->items as $item) {
          $db = new ActionJobConfiguration();
          $db->action = $value->action;
          $db->config = json_encode($item);
          $db->save();
        }
      }
    }
}
