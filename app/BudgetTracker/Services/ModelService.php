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
		$model->uuid = uniqid();
		$model->amount = $data['amount'];
		$model->note = $data['note'];
		$model->category_id = $data['category'];
		$model->account_id = $data['account'];
		$model->currency_id = $data['currency'];
		$model->payment_type = $data['payment_type'];
		$model->user_id = UserService::getCacheUserID();
		$model->name = $data['name'];
        $model->save();

        EntryService::attachLabels($data['label'], $model);

    }

}