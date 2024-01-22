<?php
namespace App\Budget\Controllers;

use Illuminate\Http\JsonResponse;
use App\Budget\Domain\Model\Budget;
use App\Budget\Services\BudgetMamangerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BudgetController {

    public function index(): JsonResponse
    {
        $budgets = Budget::get();
        return response()->json($budgets);
    }

    public function show(int $id): JsonResponse
    {
        $budgets = Budget::findOrFail($id);
        return response()->json($budgets);
    }

    public function create(Request $request): Response
    {
        $service = new BudgetMamangerService();
        $service->save($request->toArray());

        return response('success');
    }

    public function update(Request $request, int $id): Response
    {
        $service = new BudgetMamangerService($id);
        $service->save($request->toArray());

        return response('success');
    }

    public function delete(int $id): Response
    {
        $budgets = Budget::findOrFail($id);
        $budgets->delete();

        return response('success');
    }

    public function stats(int|null $id = null): JsonResponse
    {
        $service = new BudgetMamangerService();
        if(is_null($id)) {
           $budget = $service->retriveBudgetsAmount();
        } else {
           $budget = $service->retriveBudgetAmount($id);
        }

        return response()->json($budget);
    }

    public function expired(int $id): JsonResponse
    {
        $service = new BudgetMamangerService();
        $expired = $service->isExpired($id);
        return response()->json([
            "expired" => $expired
        ]);
    }
}