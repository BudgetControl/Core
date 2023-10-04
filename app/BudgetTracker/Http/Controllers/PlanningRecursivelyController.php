<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use App\BudgetTracker\Http\Trait\Paginate;
use Illuminate\Http\Request;
use App\BudgetTracker\Services\PlanningRecursivelyService;
use App\BudgetTracker\Services\ResponseService;
use App\BudgetTracker\Models\PlannedEntries;
use App\BudgetTracker\Services\EntryService;

class PlanningRecursivelyController extends EntryService
{
	use Paginate;

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

		$response = $incoming->toArray();

		return response()->json(["data" => $response]);
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
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, string $uuid): \Illuminate\Http\Response
	{
		try {
			$service = new PlanningRecursivelyService($uuid);
			$service->save($request->toArray());
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
		$incoming = $service->read($id)[0]; 

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
			$entry = PlannedEntries::where('uuid',$id)->firstOrFail();
			PlannedEntries::destroy($entry->id);
			return response("Resource is deleted");
		} catch (\Exception $e) {
			return response($e->getMessage());
		}
	}
}
