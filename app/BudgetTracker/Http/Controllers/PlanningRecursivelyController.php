<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Services\PlanningRecursivelyService;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Models\PlannedEntries;

class PlanningRecursivelyController extends Controller
{
	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(request $request): \Illuminate\Http\JsonResponse
	{	
		$page = $request->query('page');
		$service = new PlanningRecursivelyService();
		$incoming = $service->read(); 

		$paginator = new PaginatorController($incoming->data,30);
		$response = $paginator->paginate($page);

		return response()->json($response);
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
	public function show(int|string $id): \Illuminate\Http\JsonResponse
	{
		$service = new PlanningRecursivelyService();
		$incoming = $service->read($id); 

		return response()->json($incoming);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(string $id): \Illuminate\Http\Response
	{
		try {
			$id = PlannedEntries::where('uuid',$id)->firstOrFail('id')['id'];
			PlannedEntries::destroy($id);
			return response("Resource is deleted");
		} catch (\Exception $e) {
			return response($e->getMessage());
		}
	}
}
