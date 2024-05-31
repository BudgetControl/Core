<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\BudgetTracker\Models\PaymentsTypes;

class PaymentTypeSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $lang = "it"; //env("LANG","it");
      $path = __DIR__.'/../sql/payment_type.json';
      $data = (array) json_decode(file_get_contents($path));

      foreach ($data[$lang] as $key => $value) {
        $db = new PaymentsTypes();
        $db->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();;
        $db->name = strtolower($value);
        $db->name = strtolower(str_replace(" ", "_", $value));
        $db->save();
      }
    }
}
