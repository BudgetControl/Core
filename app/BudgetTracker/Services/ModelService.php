<?php 
namespace App\BudgetTracker\Services;

use App\User\Services\UserService;
use App\BudgetTracker\Models\Models;

class ModelService {

    private Models $model;

    public function __construct(string $id = null)
    {
        if(is_null($id)) {
            $this->model = new Models();
        } else {
            $this->model = Models::where("uuid",$id)->first();
        }
    }

    public function save(array $data): void
    {
        $model = $this->model;
		$model->uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();;
		$model->amount = $data['amount'];
		$model->note = $data['note'];
		$model->type = $data['type'];
		$model->category_id = $data['category_id'];
		$model->account_id = $data['account_id'];
		$model->currency_id = $data['currency_id'];
		$model->payment_type = $data['payment_type'];
		$model->name = $data['name'];
        $model->save();

        EntryService::attachLabels($data['label'], $model);

    }

}
