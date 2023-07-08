<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use App\BudgetTracker\Services\PlanningRecursivelyService;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Models\PlannedEntries;

class PlanningRecursivelyController extends Controller implements ControllerResourcesInterface
{
	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(): \Illuminate\Http\JsonResponse
	{	
		$service = new PlanningRecursivelyService();
		$incoming = $service->read(); 
		return response()->json($incoming);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request): \Illuminate\Http\Response
	{
		try {
			$debitService = new PlanningRecursivelyService();
			$debitService->save($request->toArray());
			return response('All data stored');
		} catch (\Exception $e) {
			return response($e->getMessage(), 500);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(int $id): \Illuminate\Http\JsonResponse
	{
		$service = new PlanningRecursivelyService();
		$incoming = $service->read($id); 
		return response()->json(new ResponseService($incoming));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(int $id): \Illuminate\Http\Response
	{
		try {
			PlannedEntries::destroy($id);
			return response("Resource is deleted");
		} catch (\Exception $e) {
			return response($e->getMessage());
		}
	}
}
