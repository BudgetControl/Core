<?php

namespace App\BudgetTracker\Http\Controllers;

use App\BudgetTracker\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BudgetTracker\Interfaces\ControllerResourcesInterface;
use App\BudgetTracker\Models\Entry;
use App\BudgetTracker\Services\EntryService;
use League\Config\Exception\ValidationException;
use App\BudgetTracker\Services\ResponseService;

class EntryController extends Controller
{
	const PAGINATION = 30;

	//
	/**
	 * Display a listing of the resource.
	 * @return \Illuminate\Http\JsonResponse
	 * @throws \Exception
	 */
	public function index(Request $filter): \Illuminate\Http\JsonResponse
	{
		$page = $filter->query('page');

		$date = new \DateTime();
		$date->modify('last day of this month');

		$entry = Entry::withRelations()
			->where('date_Time', '<=', $date->format('Y-m-d H:i:s'))
			->get();

		$paginateController = new PaginatorController($entry->toArray(),self::PAGINATION);
		$paginator = $paginateController->paginate($page);

		return response()->json($paginator);
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
			$service = new EntryService();
			$service->save($request->toArray());
			return response('All data stored');
		} catch (\Exception $e) {
			return response($e->getMessage(), 500);
		}
	}

	/**
	 * get from specific account
	 * @param int $id
	 * 
	 * @return \Illuminate\Http\JsonResponse
	 */
	static public function getEntriesFromAccount(int $id): \Illuminate\Http\JsonResponse
	{
		$incoming = Entry::withRelations()->where("account_id", $id)->get();
		return response()->json(new ResponseService($incoming));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int $id
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(int $id): \Illuminate\Http\JsonResponse
	{
		$service = new EntryService();
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
			Entry::destroy($id);
			return response("Resource is deleted");
		} catch (\Exception $e) {
			return response($e->getMessage());
		}
	}

}
